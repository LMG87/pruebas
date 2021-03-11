<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeItems Controller
 *
 * @property \App\Model\Table\TypeItemsTable $TypeItems
 *
 * @method \App\Model\Entity\TypeItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $typeItems = $this->paginate($this->TypeItems);

        $this->set(compact('typeItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeItem = $this->TypeItems->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('typeItem', $typeItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeItem = $this->TypeItems->newEntity();
        if ($this->request->is('post')) {
            $typeItem = $this->TypeItems->patchEntity($typeItem, $this->request->getData());
            if ($this->TypeItems->save($typeItem)) {
                $this->Flash->success(__('The type item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type item could not be saved. Please, try again.'));
        }
        $this->set(compact('typeItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeItem = $this->TypeItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeItem = $this->TypeItems->patchEntity($typeItem, $this->request->getData());
            if ($this->TypeItems->save($typeItem)) {
                $this->Flash->success(__('The type item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type item could not be saved. Please, try again.'));
        }
        $this->set(compact('typeItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeItem = $this->TypeItems->get($id);
        if ($this->TypeItems->delete($typeItem)) {
            $this->Flash->success(__('The type item has been deleted.'));
        } else {
            $this->Flash->error(__('The type item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
