<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Router;
use View\Helper\PaginatorHelper;
use Cake\I18n\Time;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
        ];
        $items = $this->paginate($this->Items);

        $this->set(compact('items'));
    }
   /* public function beforeRender() {
        $this->set('name', 'value');
    }*/
    public function allItems()
    {
        $company_id=null;
        if (count($this->companies)) {
            $company_id=$this->companies[0]->company_id;
        }else{
            $this->Flash->info(__('Lo sentimos pero no hay empresas asignadas a tu perfil, solicita una para poder utilizar el sistema.'));
            return $this->redirect(['plugin'=>'Usermgmt','controller'=>'users','action'=>'dashboard']);
        }
        
        if (!$this->checkCompany($company_id)) {
            throw new NotFoundException(__('Company not found'));
        }

        $this->loadModel('TypeItems');
        $this->loadModel('Roles');
        $this->loadModel('Rooms');
        $this->loadModel('Companies');

        $company= $this->Companies->get($company_id);
        $room= null;

        $type_items = $this->TypeItems->find('list')->toArray();
        $roles = $this->Roles->find('list')->toArray();

        $rooms= array();
        $R="getAllRoomsCompanyR".$this->checkTypeRelation($company_id);
        $roomsCompany = $this->Rooms->$R($company_id)->toArray();
        // print_r($typeRelation);
        $currentDateTime = new Time();

        $this->paginate = [
            'limit' => 5,
            'maxLimit' => 5,
            'order' => [
                'Items.id' => 'desc'
            ],
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
        ];

        $currentDate=$this->request->getQuery('date');//fecha de sicronizacion actual
        $checkNews=$this->request->getQuery('checkNews');//parametro para check si hay nuevos
        $getAllNews=$this->request->getQuery('getAllNews');//

        $countItemsNews=0;

        if ($checkNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $countItemsNews=$this->Items->getNewAllItemsUser($checkNews, $company_id)->count();
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($countItemsNews));
                return  $response;
            }
        }

        if ($getAllNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $this->paginate = [
                    'order' => [
                        'Items.id' => 'desc'
                    ],
                    'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
                ];  
                $itemsNews=$this->paginate($this->Items->getNewAllItemsUser($getAllNews, $company_id));
                //$itemsNews=$this->prepareItems($itemsNews);
                $currentDateTime = new Time();
                $itemsNews=array($currentDateTime->i18nFormat('yyyy-MM-dd HH:mm:ss'), $this->prepareItems($itemsNews));
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($itemsNews));
                return  $response;
            }
        }

        $items = $this->paginate($this->Items->getAllItemsUser($currentDate, $company_id));// traer items defect
        $optionsPaginator=$this->request->getParam('paging')['Items'];//trae opciones de paginador

        foreach ($roomsCompany as $key => $value){
            $rooms[$key]=$value;
        }

        $this->set(compact('items', 'type_items', 'roles', 'rooms', 'company', 'room', 'company_id','roomsCompany','currentDateTime'));

        if ($this->request->is('ajax') && $this->request->is('get') ){
            $this->autoRender = false;
            $res=$this->prepareItems($items,$optionsPaginator);
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }
    }
    
    
    public function allItemsCompany($company_id=null)
    {
        if (!$this->checkCompany($company_id)) {
            throw new NotFoundException(__('Company not found'));
        }        

        $this->loadModel('TypeItems');
        $this->loadModel('Roles');
        $this->loadModel('Rooms');
        $this->loadModel('Companies');

        $company= $this->Companies->get($company_id);
        $room= null;

        $type_items = $this->TypeItems->find('list')->toArray();
        $roles = $this->Roles->find('list')->toArray();
        $rooms= array();
        $R="getAllRoomsCompanyR".$this->checkTypeRelation($company_id);
        $roomsCompany = $this->Rooms->$R($company_id)->toArray();
        // print_r($typeRelation);
        $currentDateTime = new Time();

        $this->paginate = [
            'limit' => 5,
            'maxLimit' => 5,
            'order' => [
                'Items.id' => 'desc'
            ],
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
        ];

        $currentDate=$this->request->getQuery('date');//fecha de sicronizacion actual
        $checkNews=$this->request->getQuery('checkNews');//parametro para check si hay nuevos
        $getAllNews=$this->request->getQuery('getAllNews');//parametro para traer los nuevos

        $countItemsNews=0;

        if ($checkNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $countItemsNews=$this->Items->getNewAllItemsUser($checkNews, $company_id)->count();
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($countItemsNews));
                return  $response;
            }
        }

        if ($getAllNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $this->paginate = [
                    'order' => [
                        'Items.id' => 'desc'
                    ],
                    'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
                ];  
                $itemsNews=$this->paginate($this->Items->getNewAllItemsUser($getAllNews, $company_id));
                //$itemsNews=$this->prepareItems($itemsNews);
                $currentDateTime = new Time();
                $itemsNews=array($currentDateTime->i18nFormat('yyyy-MM-dd HH:mm:ss'), $this->prepareItems($itemsNews));
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($itemsNews));
                return  $response;
            }
        }

        $items = $this->paginate($this->Items->getAllItemsUser($currentDate, $company_id));// traer items defect
        $optionsPaginator=$this->request->getParam('paging')['Items'];//trae opciones de paginador

        foreach ($roomsCompany as $key => $value){
            $rooms[$key]=$value;
        }

        $this->set(compact('items', 'type_items', 'roles', 'rooms', 'company', 'room', 'company_id','roomsCompany','currentDateTime'));

        if ($this->request->is('ajax') && $this->request->is('get') ){
            $this->autoRender = false;
            $res=$this->prepareItems($items,$optionsPaginator);
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }

    }
    public function allItemsRoom($company_id=null,$room_id=null)
    {
        if (!$this->checkCompany($company_id)) {
            throw new NotFoundException(__('Company not found'));
        }
        $this->loadModel('TypeItems');
        $this->loadModel('Roles');
        $this->loadModel('Rooms');
        $this->loadModel('Companies');

        $company= $this->Companies->get($company_id);
        $room= $this->Rooms->get($room_id);
        if ($company->id!=$room->company_id) {
            throw new NotFoundException(__('Room not found'));
        }

        $type_items = $this->TypeItems->find('list')->toArray();
        $roles = $this->Roles->find('list')->toArray();
        $rooms= array();
        $R="getAllRoomsCompanyR".$this->checkTypeRelation($company_id);
        // print_r($typeRelation);
        $roomsCompany = $this->Rooms->$R($company_id)->toArray();
        if (!array_key_exists($room_id,$roomsCompany)){
            throw new NotFoundException(__('Room not found'));
        }

        $currentDateTime = new Time();
        
        $this->paginate = [
            'limit' => 5,
            'maxLimit' => 5,
            'order' => [
                'Items.id' => 'desc'
            ],
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
        ];       

        $currentDate=$this->request->getQuery('date');//fecha de sicronizacion actual
        $checkNews=$this->request->getQuery('checkNews');//parametro para check si hay nuevos
        $getAllNews=$this->request->getQuery('getAllNews');//parametro para traer los nuevos
        
        //debug($optionsPaginator);
        $countItemsNews=0;
        //check si hay nuevos
        if ($checkNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $countItemsNews=$this->Items->getNewAllItemsUser($checkNews, $company_id, $room_id)->count();
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($countItemsNews));
                return  $response;
            }
        }

        if ($getAllNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;
                $this->paginate = [
                    'order' => [
                        'Items.id' => 'desc'
                    ],
                    'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies']
                ];  
                $itemsNews=$this->paginate($this->Items->getNewAllItemsUser($getAllNews, $company_id, $room_id));
                //$itemsNews=$this->prepareItems($itemsNews);
                $currentDateTime = new Time();
                $itemsNews=array($currentDateTime->i18nFormat('yyyy-MM-dd HH:mm:ss'), $this->prepareItems($itemsNews));
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($itemsNews));
                return  $response;
            }
        }
        

        $items = $this->paginate($this->Items->getAllItemsUser($currentDate, $company_id, $room_id));// traer items defect
        $optionsPaginator=$this->request->getParam('paging')['Items'];//trae opciones de paginador
        //preparar items para la respuesta ajax
        foreach ($roomsCompany as $key => $value){
            $rooms[$key]=$value;
        }
        $this->set(compact('items', 'type_items', 'roles', 'rooms', 'company_id', 'room_id','roomsCompany','currentDateTime', 'company', 'room'));

        if ($this->request->is('ajax') && $this->request->is('get') ){
            $this->autoRender = false;
            $res=$this->prepareItems($items,$optionsPaginator);
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }
    }

    //chekea el tipo de relacion a la que pertence
    private function checkTypeRelation($company_id){
        $this->loadModel('RelationMembers');
        $relation=$this->RelationMembers->checkRelationC($this->UserAuth->getUserId(),$this->UserAuth->getGroupId(),$company_id)->toArray();

        if (!empty($relation)) {
            $type=1;
        }else{
            $type=2;
        }
        return $type;

    }

    private function prepareItems($items,$optionsPaginator=null){
        foreach ($items as $item) {
            $item->created=h($item->created);
            $item->user_link=$item->has('user') ? Router::url(['controller' => 'Users', 'action' => 'view', $item->user->id]) : '';
            $item->type_item_link=$item->has('type_item') ? Router::url(['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '';
            $item->room_link=$item->has('room') ? Router::url(['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : '';
            $item->company_link=$item->has('company') ? Router::url(['controller' => 'Company', 'action' => 'view', $item->company->id]) : '';
           // $item->nextButton=$this->Paginator->next('Next »');
            $item->nextButton=false;
           // debug($optionsPaginator);
            if ($optionsPaginator) {
                if ($optionsPaginator['nextPage']) {
                    $item->nextButton=$this->request->getAttribute("here")."?page=".($optionsPaginator['page']+1);
                } 
            }                       
            $itemsPage[] = $item;
        }
        return $itemsPage;
    }

    public function addFront() {
        $this->autoRender = false ;
        $item = $this->Items->newEntity();
        if ($this->request->is('ajax') && $this->request->is('post') ){
           //print_r($this->request->getData());
            $item = $this->Items->patchEntity($item, $this->request->getData());
            $item->user_id=$this->UserAuth->getUserId();
            $res = 'El item no pudo ser creado. Inténtalo de nuevo.';
            if (!$this->checkCompany($item->company_id)) {
                throw new NotFoundException(__('Empresa no encontrada'));
            }
            if ($saved_item=$this->Items->save($item)) {
                $res = $saved_item;
            }
        }
        $response = $this->response->withType('application/json')
          ->withStringBody(json_encode($res));
        return  $response;
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies', 'Actions']
        ]);
        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $users = $this->Items->Users->find('list', ['limit' => 200]);
        $rooms = $this->Items->Rooms->find('list', ['limit' => 200]);
        $typeItems = $this->Items->TypeItems->find('list', ['limit' => 200]);
        $companies = $this->Items->Companies->find('list', ['limit' => 200]);
        $actions = $this->Items->Actions->find('list', ['limit' => 200]);
        $this->set(compact('item', 'users', 'rooms', 'typeItems', 'companies', 'actions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Actions']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $users = $this->Items->Users->find('list', ['limit' => 200]);
        $rooms = $this->Items->Rooms->find('list', ['limit' => 200]);
        $typeItems = $this->Items->TypeItems->find('list', ['limit' => 200]);
        $companies = $this->Items->Companies->find('list', ['limit' => 200]);
        $actions = $this->Items->Actions->find('list', ['limit' => 200]);
        $this->set(compact('item', 'users', 'rooms', 'typeItems', 'companies', 'actions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
