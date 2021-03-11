<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Event\EventList;
/**
 * Collaborators Controller
 *
 * @property \App\Model\Table\CollaboratorsTable $Collaborators
 *
 * @method \App\Model\Entity\Collaborator[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CollaboratorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Roles']
        ];
        $collaborators = $this->paginate($this->Collaborators);

        $this->set(compact('collaborators'));
    }

    /**
     * View method
     *
     * @param string|null $id Collaborator id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $collaborator = $this->Collaborators->get($id, [
            'contain' => ['Users', 'Roles']
        ]);

        $this->set('collaborator', $collaborator);
    }

    private function getToken($rand){
        //debug($rand);
        $currentDateTime = new Time();
        $key = 'qpaklshdnodylejasjjdfekafkKrKAejkuydjhao';
        $result = Security::hash($currentDateTime->i18nFormat('yyyy-MM-dd/HH:mm:ss').$rand, 'sha1', $key);

        return $result;
    }

    public function addFront()
    {
        $this->loadModel('Users');
        $this->loadModel('Companies');
        $this->loadModel('Rooms');
        $this->loadModel('RelationMembers');
        $this->autoRender = false ;
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $process=$this->request->getData('process');          

            $res = 'El usuario no pudo ser invitado. Inténtalo de nuevo.';
            $getCollaborators=$this->request->getData('Collaborators');
            $user_emails=$getCollaborators['user_emails'];

            

            if ($user_emails) {
                foreach ($user_emails as $user_email) {

                    $collaborator = $this->Collaborators->newEntity();
                    $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());
                    $collaborator->user_id=$this->UserAuth->getUserId();
                    $collaborator->user_email=$user_email;
                    $UserFrom = $this->Users->findById($collaborator->user_id)->first();

                    //get compñia sala e item
                    if ($collaborator->model=='company') {
                        $model="companies";
                        $collaborator->company=$this->Companies->findById($collaborator->foreign_key)->first();
                    }else if ($collaborator->model=='room') {
                        $model="rooms";
                        $collaborator->room=$this->Rooms->findById($collaborator->foreign_key)->first();
                        $collaborator->company=$this->Companies->findById($collaborator->room->company_id)->first();
                    }else if ($collaborator->model=='item') {
                        $model="items";
                        /*$collaborator->room=$this->Rooms->findById($collaborator->foreign_key)->first();
                        $collaborator->company=$this->Companies->findById($collaborator->room->company_id)->first();*/
                    }
                    /*$collaborator = $this->Collaborators->newEntity();
                    $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());*/

                    $collaborator_exist = $this->Collaborators->findAllByUserEmailAndModelAndForeignKey($collaborator->user_email,$collaborator->model,$collaborator->foreign_key)->first();
                    if ($collaborator_exist) {
                        //si
                        //si token no se ha usado (no vacio)
                        if (!empty($collaborator_exist->token)) {
                            //si
                            $token=$collaborator_exist->token;
                            $this->sendEmailNotification($token,$UserFrom,$collaborator);
                            $res=1;
                        }
                    }else{
                        //no
                        $rand=rand(0,9999);
                        $token=$this->getToken($rand);
                        $collaborator->token=$token;
                        /*print_r($collaborator);
                        print_r('<br>----------------------<br>');*/
                       // debug($token);
                        $this->Collaborators->save($collaborator,['checkExisting' => false]);
                        //$collaborator->clean();

                        
                            $User = $this->Users->findByEmail($collaborator->user_email)->first();
                            if (isset($User)) {
                                # crear relation
                                $relationMember = $this->RelationMembers->newEntity();
                                $relationMember->user_id=$User->id;
                                $relationMember->role_id=$collaborator->role_id;
                                $relationMember->model=$model;
                                $relationMember->foreign_key=$collaborator->foreign_key;
                                $this->RelationMembers->save($relationMember);
                            }
                            $this->sendEmailNotification($token,$UserFrom,$collaborator);
                            $res=1;
                        
                    }

                }
            }
        }
        $response = $this->response->withType('application/json')
          ->withStringBody(json_encode($res));
        return  $response;
    }

    private function sendEmailNotification($token,$UserFrom,$collaborator){

        $url_mail=$this->request->host()."/cllbrts/".$token;
        $body_mail="<p>Hola,</p><p>".$UserFrom->first_name." ".$UserFrom->last_name." te ha invitado a colaborar en:</p>";
        if ($collaborator->company) {
            $body_mail.="<p><strong>Empresa:</strong> ".$collaborator->company->name."</p>";
        }
        if ($collaborator->room) {
            $body_mail.="<p><strong>Sala:</strong> ".$collaborator->room->name."</p>";
        }        
        $body_mail.="<p><strong>Mensaje</strong></p>"; 
        $body_mail.="<p>".$collaborator->menssage."</p>";            
        $body_mail.="<strong><a href='".$url_mail."'>Abrir</a></strong>";
        $email = new Email('default');
        $email->setTo($collaborator->user_email)
            ->setSubject('Colaboración en comunicatec.es')
            ->send($body_mail);

    }

    public function getCollaboration($token)
    {
        $this->loadModel('Users');
        $this->loadModel('Companies');
        $this->loadModel('Rooms');
        $this->autoRender = false;
        $collaborator=$this->Collaborators->findByToken($token)->first();

        if ($collaborator) {
            $User = $this->Users->findByEmail($collaborator->user_email)->first();
            if ($User) {
                if (!$this->UserAuth->isLogged()){
                    return $this->redirect('/login?redirect=/cllbrts/'.$token);
                }
                $pagee=$this->startRequest($collaborator);
                return $pagee;
            }else{
                $url='/register/?t='.$token;
            }
        }else{
            throw new NotFoundException(__('404 not found'));
        }
        return $this->redirect($url);
    }

    private function startRequest($collaborator){
       /* $users= TableRegistry::get('Users');
        $user = $users->get($id); // Return article with id = $id (primary_key of row which need to get updated)
        $user->is_active = true;*/
        // $user->email= abc@gmail.com; // other fields if necessary
        $collaborator->token="";
        if($this->Collaborators->save($collaborator)){
          // saved
        }

        if ($collaborator->model=='company') {
            $model="companies";
            $collaborator->company=$this->Companies->findById($collaborator->foreign_key)->first();
            $url='/company/'.$collaborator->company->id;
        }else if ($collaborator->model=='room') {
            $model="rooms";
            $collaborator->room=$this->Rooms->findById($collaborator->foreign_key)->first();
            $collaborator->company=$this->Companies->findById($collaborator->room->company_id)->first();
            $url='/company/'.$collaborator->company->id."/room/".$collaborator->room->id;
        }else if ($collaborator->model=='item') {
            $this->loadModel('Items');
            $model="items";
            //$collaborator->item=$this->Items->findById($collaborator->foreign_key)->first();
            /*$collaborator->room=$this->Rooms->findById($collaborator->foreign_key)->first();
            $collaborator->company=$this->Companies->findById($collaborator->room->company_id)->first();*/
           // $url='/company/'.$collaborator->company->id."/room/".$collaborator->room->id.;
            $url='/item/'.$collaborator->foreign_key;
        }
        $this->redirect($url);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $collaborator = $this->Collaborators->newEntity();
        if ($this->request->is('post')) {
            $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());
            if ($this->Collaborators->save($collaborator)) {
                $this->Flash->success(__('The collaborator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The collaborator could not be saved. Please, try again.'));
        }
        $users = $this->Collaborators->Users->find('list', ['limit' => 200]);
        $roles = $this->Collaborators->Roles->find('list', ['limit' => 200]);
        $this->set(compact('collaborator', 'users', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Collaborator id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $collaborator = $this->Collaborators->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());
            if ($this->Collaborators->save($collaborator)) {
                $this->Flash->success(__('The collaborator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The collaborator could not be saved. Please, try again.'));
        }
        $users = $this->Collaborators->Users->find('list', ['limit' => 200]);
        $roles = $this->Collaborators->Roles->find('list', ['limit' => 200]);
        $this->set(compact('collaborator', 'users', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Collaborator id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $collaborator = $this->Collaborators->get($id);
        if ($this->Collaborators->delete($collaborator)) {
            $this->Flash->success(__('The collaborator has been deleted.'));
        } else {
            $this->Flash->error(__('The collaborator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
}
