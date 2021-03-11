<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RelationMembers Controller
 *
 * @property \App\Model\Table\RelationMembersTable $RelationMembers
 *
 * @method \App\Model\Entity\RelationMember[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RelationMembersController extends AppController
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
        $relationMembers = $this->paginate($this->RelationMembers);

        $this->set(compact('relationMembers'));
    }

    /**
     * View method
     *
     * @param string|null $id Relation Member id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $relationMember = $this->RelationMembers->get($id, [
            'contain' => ['Users', 'Roles']
        ]);

        $this->set('relationMember', $relationMember);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $relationMember = $this->RelationMembers->newEntity();
        if ($this->request->is('post')) {
            $relationMember = $this->RelationMembers->patchEntity($relationMember, $this->request->getData());
            if ($this->RelationMembers->save($relationMember)) {
                $this->Flash->success(__('The relation member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The relation member could not be saved. Please, try again.'));
        }
        $users = $this->RelationMembers->Users->find('list', ['limit' => 200]);
        $roles = $this->RelationMembers->Roles->find('list', ['limit' => 200]);
        $this->set(compact('relationMember', 'users', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Relation Member id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $relationMember = $this->RelationMembers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $relationMember = $this->RelationMembers->patchEntity($relationMember, $this->request->getData());
            if ($this->RelationMembers->save($relationMember)) {
                $this->Flash->success(__('The relation member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The relation member could not be saved. Please, try again.'));
        }
        $users = $this->RelationMembers->Users->find('list', ['limit' => 200]);
        $roles = $this->RelationMembers->Roles->find('list', ['limit' => 200]);
        $this->set(compact('relationMember', 'users', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Relation Member id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $relationMember = $this->RelationMembers->get($id);
        if ($this->RelationMembers->delete($relationMember)) {
            $this->Flash->success(__('The relation member has been deleted.'));
        } else {
            $this->Flash->error(__('The relation member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
