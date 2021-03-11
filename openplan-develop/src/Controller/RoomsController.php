<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 *
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentRooms', 'Companies']
        ];
        $rooms = $this->paginate($this->Rooms);

        $this->set(compact('rooms'));
    }

    public function addFront() {
        $this->autoRender = false ;
        $room = $this->Rooms->newEntity();
        if ($this->request->is('ajax') && $this->request->is('post') ){        

            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            $res = 'La habitación no pudo ser creada. Inténtalo de nuevo.';
            if (!$this->checkCompany($room->company_id)) {
                throw new NotFoundException(__('Empresa no encontrada'));
            }
            if ($saved_room=$this->Rooms->save($room)) {
                $res = $saved_room;
            }
        }
        $response = $this->response->withType('application/json')
          ->withStringBody(json_encode($res));
        return  $response;
    }

    /**
     * View method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $room = $this->Rooms->get($id, [
            'contain' => ['ParentRooms', 'Companies', 'Items', 'ChildRooms']
        ]);

        $this->set('room', $room);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $room = $this->Rooms->newEntity();
        if ($this->request->is('post')) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $parentRooms = $this->Rooms->ParentRooms->find('list', ['limit' => 200]);
        $companies = $this->Rooms->Companies->find('list', ['limit' => 200]);
        $this->set(compact('room', 'parentRooms', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $room = $this->Rooms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $parentRooms = $this->Rooms->ParentRooms->find('list', ['limit' => 200]);
        $companies = $this->Rooms->Companies->find('list', ['limit' => 200]);
        $this->set(compact('room', 'parentRooms', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
