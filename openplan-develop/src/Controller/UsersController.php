<?php
namespace App\Controller;

use App\Controller\AppController;
use Usermgmt\Controller\UsersController as uController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends uController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['UserGroups']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function addFront()
    {
        $this->autoRender = false ;
        $user = $this->Users->newEntity();
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $res = 'El usuario no pudo ser creado. Inténtalo de nuevo.';
        }
        if ($saved_user=$this->Users->save($user)) {
            $res = $saved_user;
        }
        $response = $this->response->withType('application/json')
          ->withStringBody(json_encode($res));
        return  $response;
    }

    public function register() {
        $userId = $this->UserAuth->getUserId();
        if($userId) {
            $this->redirect(['action'=>'dashboard']);
        }

        if(SITE_REGISTRATION) {
            $this->loadModel('Usermgmt.UserGroups');
            $userGroups = $this->UserGroups->getGroupsForRegistration();

            $formdata = $this->getRequest()->getData();

            if($this->getRequest()->is('post') && $this->UserAuth->canUseRecaptha('registration') && !$this->getRequest()->is('ajax')) {
                $formdata['Users']['captcha'] = (isset($formdata['g-recaptcha-response'])) ? $formdata['g-recaptcha-response'] : "";
            }

            $userEntity = $this->Users->newEntity($formdata, ['validate'=>'forRegister']);

            if($this->getRequest()->is('post')) {
                $errors = $userEntity->getErrors();

                if($this->getRequest()->is('ajax')) {
                    if(empty($errors)) {
                        $response = ['error'=>0, 'message'=>'success'];
                    } else {
                        $response = ['error'=>1, 'message'=>'failure'];
                        $response['data']['Users'] = $errors;
                    }
                    echo json_encode($response);exit;
                } else {
                    if(empty($errors)) {
                        if(!isset($formdata['Users']['user_group_id'])) {
                            $userEntity['user_group_id'] = DEFAULT_GROUP_ID;
                        }
                        if(!EMAIL_VERIFICATION) {
                            $userEntity['email_verified'] = 1;
                        }
                        $userEntity['active'] = 1;
                        $userEntity['ip_address'] = $this->getRequest()->clientIp();
                        $userEntity['password'] = $this->UserAuth->makeHashedPassword($userEntity['password']);

                        /*validar si token existe y coincide con el email ingresado*/
                        if($userEntity['token']){
                            $this->loadModel('Collaborators');
                            $collaboratorToken = $this->Collaborators->findByToken($userEntity['token'])->first();
                            if ($collaboratorToken) {
                                if ($collaboratorToken->user_email!=$userEntity['email']) {
                                    throw new NotFoundException(__('404 not found'));
                                }
                            }else{
                                throw new NotFoundException(__('404 not found'));
                            }
                        }
                        /*fin*/

                        if($this->Users->save($userEntity, ['validate'=>false])) {
                            $userId = $userEntity['id'];
                            if (isset($collaboratorToken)) {
                                /*eliminar el token de collaborators */
                                $collaboratorToken->token="";
                                $this->Collaborators->save($collaboratorToken);                                    

                                /*crear relacion*/
                                if ($collaboratorToken && $collaboratorToken->user_email==$userEntity['email']) {
                                    $this->loadModel('RelationMembers');
                                    if ($collaboratorToken->model=='company') {
                                        $model="companies";
                                    }else if ($collaboratorToken->model=='room') {
                                        $model="rooms";
                                    }
                                    $relationMember = $this->RelationMembers->newEntity();
                                    $relationMember->user_id=$userId;
                                    $relationMember->role_id=$collaboratorToken->role_id;
                                    $relationMember->model=$model;
                                    $relationMember->foreign_key=$collaboratorToken->foreign_key;
                                    $this->RelationMembers->save($relationMember);
                                }
                                /*fin*/
                            }
                            

                            $this->loadModel('Usermgmt.UserDetails');
                            $userDetailEntity = $this->UserDetails->newEntity();
                            $userDetailEntity['user_id'] = $userId;

                            $this->UserDetails->save($userDetailEntity, ['validate'=>false]);
                            if(EMAIL_VERIFICATION) {
                                $this->Users->sendVerificationMail($userEntity);
                            }
                            if(SEND_REGISTRATION_MAIL) {
                                $this->Users->sendRegistrationMail($userEntity);
                            }
                            if(isset($userEntity['active']) && $userEntity['active'] && !EMAIL_VERIFICATION) {
                                $user = $this->Users->getUserById($userId);
                                $user = $user->toArray();

                                $this->UserAuth->login($user);
                                $this->redirect($this->Auth->redirectUrl());
                            } else {
                                $this->Flash->success(__('We have sent an email to you, please confirm your registration'));
                                $this->redirect(['plugin'=>'Usermgmt','controller'=>'users','action'=>'login']);
                            }
                        } else {
                            $this->Flash->error(__('Unable to register user, please try again'));
                        }
                    }
                }
            }
            $this->set(compact('userGroups', 'userEntity'));
        } else {
            $this->Flash->info(__('Sorry new registration is currently disabled, please try again later'));
            $this->redirect(['plugin'=>'Usermgmt','controller'=>'users','action'=>'login']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['UserGroups', 'ActionsItems', 'Collaborators', 'Items', 'LoginTokens', 'RelationMembers', 'ScheduledEmailRecipients', 'UserActivities', 'UserContacts', 'UserDetails', 'UserEmailRecipients', 'UserEmailSignatures', 'UserEmailTemplates', 'UserSocials']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $userGroups = $this->Users->UserGroups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'userGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $userGroups = $this->Users->UserGroups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'userGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
