<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentComments', 'Users', 'Items']
        ];
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['ParentComments', 'Users', 'Items', 'ChildComments']
        ]);

        $this->set('comment', $comment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            $comment->level;
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $parentComments = $this->Comments->ParentComments->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $items = $this->Comments->Items->find('list', ['limit' => 1000]);
        $this->set(compact('comment', 'parentComments', 'users', 'items'));
    }

    public function addFront()
    {
        $this->loadModel('Users');
        $response = $this->response->withType('application/json');
        $this->autoRender = false;
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $comment = $this->Comments->newEntity();
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            $comment->level;
            $comment->user_id=$this->UserAuth->getUserId();
            $comment->message=$this->request->getData('msg');
            $comment->item_id=$this->request->getData('itemId');
            //debug($comment);
            if ($comment=$this->Comments->save($comment)) {
                //$comment->user=$this->UserAuth;
               // new $U;
                $comment->total_comments=$this->Comments->findAllByItemId($comment->item_id)->count();
                $u = $this->Users->get($comment->user_id);
                $user= (object) array('first_name' => $u->first_name, 'last_name' => $u->last_name);
                $comment->user=$user;
                $response = $response->withStringBody(json_encode($comment));
                return  $response;
            }else{
                throw new NotFoundException(__('Item not found'));
            }
            //$this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }else{
            throw new NotFoundException(__('Item not found'));
        }
    }

    public function editFront($id = null)
    {
        $this->loadModel('Users');
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        $response = $this->response->withType('application/json');
        $this->autoRender = false;
        if ($this->request->is('ajax') && $this->request->is('post') ){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $comment = $this->Comments->patchEntity($comment, $this->request->getData());
                if ($comment=$this->Comments->save($comment)) {
                    $u = $this->Users->get($comment->user_id);
                    $user= (object) array('first_name' => $u->first_name, 'last_name' => $u->last_name);
                    $comment->user=$user;
                    $response = $response->withStringBody(json_encode($comment));
                    return  $response;
                }
                throw new NotFoundException(__('404 not found'));
            }
        }else{
            throw new NotFoundException(__('404 not found'));
        }
        /*$parentComments = $this->Comments->ParentComments->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $items = $this->Comments->Items->find('list', ['limit' => 1000]);
        $this->set(compact('comment', 'parentComments', 'users', 'items'));*/
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $parentComments = $this->Comments->ParentComments->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $items = $this->Comments->Items->find('list', ['limit' => 1000]);
        $this->set(compact('comment', 'parentComments', 'users', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteFront($id = null)
    {
        $this->autoRender = false; 
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $this->request->allowMethod(['post', 'delete']);
            $comment = $this->Comments->get($id);
            if ($this->Comments->delete($comment)) {
                $response = $this->response->withType('application/json');
                $response = $response->withStringBody(json_encode($comment));
                return  $response;
            } else {
                throw new NotFoundException(__('error: 404'));
            }
        }else{
            throw new NotFoundException(__('error: 404'));
        }
    }
}
