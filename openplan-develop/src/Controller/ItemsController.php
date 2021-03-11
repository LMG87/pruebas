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
    //var $helpers = array('Time');

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
    public function item($id=null)
    {
        //primero validar por item relation, luego por sal del item, y por ultimo por empresa
        $this->loadModel('Rooms');
        $this->loadModel('Comments');
        $this->loadModel('Files');
        $item = $this->Items->get($id, [
            'contain' => ['Users', 'Rooms', 'TypeItems', 'Companies', 'Files.Users', 'Comments.Users'=> 
            ['sort' => ['Comments.lft' => 'ASC']]
            , 'Actions']
        ]);

        if ($this->UserAuth->getGroupId()!=1) {
            $forRelationItem = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($this->UserAuth->getUserId(),'items',$item->id)->first();
            isset($item->room) ? $forRelationRoom = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($this->UserAuth->getUserId(),'rooms',$item->room->id)->first() : $forRelationRoom=false;

            $forRelationCompany = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($this->UserAuth->getUserId(),'companies',$item->company->id)->first();
        }else{
            $forRelationItem = $this->RelationMembers->findAllByModelAndForeignKey('items',$item->id)->first();

            isset($item->room) ? $forRelationRoom = $this->RelationMembers->findAllByModelAndForeignKey('rooms',$item->room->id)->first() : $forRelationRoom=false;

            $forRelationCompany = $this->RelationMembers->findAllByModelAndForeignKey('companies',$item->company->id)->first();
        }
        if (!$forRelationItem) {
            if (!$forRelationRoom) {
                if (!$forRelationCompany) {
                    throw new NotFoundException(__('Item not found'));
                }else{
                    $relationItem=$forRelationCompany;
                }
            }else{
                $relationItem=$forRelationRoom;
            }
        }else{
            $relationItem=$forRelationItem;
        }
        //debug($forRelationCompany);
        $userd=$this->UserAuth->getUser()['User'];
        $rest1 = substr($userd['first_name'], 0,1);
        $rest2 = substr($userd['last_name'], 0,1);
        $letterIcon=strtoupper($rest1.$rest2);

        //debug($relationItem);
        $this->set('item', $item);
        $this->set('relationItem', $relationItem);
        $this->set('letterIcon', $letterIcon);
        if ($this->request->is('ajax') && $this->request->is('get') ){
            $this->autoRender = false;
            /*prpareitem*/
            $created = Time::parse($item->created);
            $item->createdFormat=$created->i18nFormat('dd MMMM YYYY HH:mm');
            $item->created=h($item->created);
            
            $item->user_link=$item->has('user') ? Router::url(['controller' => 'Users', 'action' => 'view', $item->user->id]) : '';
            $item->type_item_link=$item->has('type_item') ? Router::url(['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '';
            $item->room_link=$item->has('room') ? Router::url(['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : '';
            $item->company_link=$item->has('company') ? Router::url(['controller' => 'Company', 'action' => 'view', $item->company->id]) : '';
            //fin prepare item
            $res = array('item' => $item, 'relationItem'=>$relationItem);
            //$res=$item;
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }
    }
    
    public function allItems()
    {
        $company_id=null;
        if (count($this->companies)) {
            $company_id=$this->companies[0]->company_id;
        }else{
            $this->Flash->info(__('Lo sentimos pero no hay empresas asignadas a tu perfil, solicita una para poder utilizar el sistema.'));
            return $this->redirect(['plugin'=>'Usermgmt','controller'=>'users','action'=>'dashboard']);
        }
        return $this->prepareApp($company_id);
    }
      
    public function allItemsCompany($company_id=null)
    {
        return $this->prepareApp($company_id);
    }

    public function allItemsRoom($company_id=null,$room_id=null)
    {
        return $this->prepareApp($company_id,$room_id);
    }

    //chekea el tipo de relacion a la que pertence
    private function checkTypeRelation($company_id){
        $this->loadModel('RelationMembers');
        $relation=$this->RelationMembers->checkRelationC($this->UserAuth->getUserId(),$this->UserAuth->getGroupId(),$company_id)->toArray();
        //debug($relation);
        if (!empty($relation)) {
            $type=1;
        }else{
            //es realcion por room
            $relation=$this->RelationMembers->checkRelationR($this->UserAuth->getUserId(),$this->UserAuth->getGroupId(),$company_id)->toArray();
            if (!empty($relation)) {
                $type=2;
            }else{
                $type=3;
            }
        }
        return $type;

    }
    //prepara lo que se va mostrar en la app para als tres vistas: inicio, company, room
    private function prepareApp($company_id=null,$room_id=null){
        if (!$this->checkCompany($company_id)) {
            throw new NotFoundException(__('Company not found'));
        }
        $this->loadModel('TypeItems');
        $this->loadModel('Roles');
        $this->loadModel('Rooms');
        $this->loadModel('Companies');
        $this->loadModel('RelationMembers');

        $company= $this->Companies->get($company_id);
        $room= null;
        if ($room_id) {
            $room= $this->Rooms->get($room_id);
            if ($company->id!=$room->company_id) {
                throw new NotFoundException(__('Room not found'));
            }
        }

        $type_items = $this->TypeItems->find('list')->toArray();
        $roles = $this->Roles->find('list')->toArray();
        $rooms= array();
        $R="getAllRoomsCompanyR".$this->checkTypeRelation($company_id);
        
       //debug($R);
        $roomsCompany = $this->Rooms->$R($company_id)->toArray();

        if ($room_id) {
            if (!array_key_exists($room_id,$roomsCompany)){
                throw new NotFoundException(__('Room not found'));
            }
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
        $countItemsNews=0;
        $typeRelation=$this->checkTypeRelation($company_id);
        $user_id=$this->UserAuth->getUserId();
        $userd=$this->UserAuth->getUser()['User'];
        $rest1 = substr($userd['first_name'], 0,1);
        $rest2 = substr($userd['last_name'], 0,1);
        $letterIcon=strtoupper($rest1.$rest2);

        //debug($typeRelation);
        if ($typeRelation==3) {
            $getNewItems="getNewAllItemsUserByItems";
        }else{
            $getNewItems="getNewAllItemsUser";
        }

        if ($checkNews) {
            if ($this->request->is('ajax') && $this->request->is('get') ){
                $this->autoRender = false;

                $consulItem=$this->Items->$getNewItems($checkNews, $company_id, $room_id, $user_id, $typeRelation);
                if ($typeRelation==1) {
                    $relationCompany = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'companies',$company_id)->first();
                    if ($relationCompany and $relationCompany->role_id!=1) {
                        $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                    }
                }else if ($typeRelation==2){
                    is_array($room_id) ? $room_id=$room_id[0] : $room_id;
                    $relationRoom = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'rooms',$room_id)->first();
                    if ($relationRoom and $relationRoom->role_id!=1) {
                        $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                    }
                }

                $countItemsNews=$consulItem->count();
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
                $consulItem=$this->Items->$getNewItems($getAllNews, $company_id, $room_id, $user_id, $typeRelation);
                if ($typeRelation==1) {
                    $relationCompany = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'companies',$company_id)->first();
                    if ($relationCompany and $relationCompany->role_id!=1) {
                        $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                    }
                }else if ($typeRelation==2){
                    is_array($room_id) ? $room_id=$room_id[0] : $room_id;
                    $relationRoom = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'rooms',$room_id)->first();
                    if ($relationRoom and $relationRoom->role_id!=1) {
                        $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                    }
                }
                $itemsNews=$this->paginate($consulItem);
                //$itemsNews=$this->prepareItems($itemsNews);
                $currentDateTime = new Time();
                $itemsNews=array($currentDateTime->i18nFormat('yyyy-MM-dd HH:mm:ss'), $this->prepareItems($itemsNews));
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($itemsNews));
                return  $response;
            }
        }
        //debug($typeRelation);
        
        
        if ($typeRelation==2 && $room_id==null) {
            $room_id=array();
            //debug($roomsCompany);
           // $room_id=$this->RelationMembers->findAllByModel('rooms')->first();
            foreach ($roomsCompany as $key => $value) {
                $room_id[]=$key;
            }
            
        }
        if ($typeRelation==3) {
            $consulItem=$this->Items->getAllItemsUserByItems($currentDate, $company_id, $room_id, $user_id);
            $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
            $items = $this->paginate($consulItem);// traer items defect
        }else{
            $consulItem=$this->Items->getAllItemsUser($currentDate, $company_id, $room_id, $user_id);
            if ($typeRelation==1) {
                $relationCompany = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'companies',$company_id)->first();
                if ($relationCompany and $relationCompany->role_id!=1) {
                    $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                }
            }else if ($typeRelation==2){
                is_array($room_id) ? $room_id=$room_id[0] : $room_id;
                $relationRoom = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($user_id,'rooms',$room_id)->first();
                if ($relationRoom and $relationRoom->role_id!=1) {
                    $consulItem->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
                }
            }
            $items = $this->paginate($consulItem);// traer items defect
        }
        
        //debug($consulItem);

        $optionsPaginator=$this->request->getParam('paging')['Items'];//trae opciones de paginador

        foreach ($roomsCompany as $key => $value){
            $rooms[$key]=$value;
        }


        $this->set(compact('items', 'type_items', 'roles', 'rooms', 'company', 'room', 'room_id', 'company_id','roomsCompany','currentDateTime','typeRelation', 'letterIcon'));

        if ($this->request->is('ajax') && $this->request->is('get') ){
            $this->autoRender = false;
            $res=$this->prepareItems($items,$optionsPaginator);
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }
    }

    private function prepareItems($items,$optionsPaginator=null){
        foreach ($items as $item) {
            $item->created=h($item->created);
            $created = Time::parse($item->created);
            $item->createdFormat=$created->i18nFormat('dd MMMM YYYY HH:mm');
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

            isset($this->request->getData('Items')['fecha_reunion']) ? $fecha_reunion=$this->request->getData('Items')['fecha_reunion'] : $fecha_reunion=null;
            isset($this->request->getData('Items')['fecha_vencimiento']) ? $fecha_vencimiento=$this->request->getData('Items')['fecha_vencimiento'] : $fecha_vencimiento=null;

            isset($this->request->getData('Items')['hora_reunion']) ? $hora_reunion=$this->request->getData('Items')['hora_reunion'] : $hora_reunion=null;
            isset($this->request->getData('Items')['hora_vencimiento']) ? $hora_vencimiento=$this->request->getData('Items')['hora_vencimiento'] : $hora_vencimiento=null;

            $item->additional_fields=array('fecha_reunion' => $fecha_reunion, 'hora_reunion' => $hora_reunion, 'fecha_vencimiento' => $fecha_vencimiento, 'hora_vencimiento' => $hora_vencimiento);
            
            $res = 'El item no pudo ser creado. Inténtalo de nuevo.';
            if (!$this->checkCompany($item->company_id)) {
                throw new NotFoundException(__('Empresa no encontrada'));
            }
            if ($saved_item=$this->Items->save($item)) {
                $res = $saved_item;
                if (isset($this->request->data['files'])) {
                    $files = (new FilesController())->addFiles($saved_item->id,$this->request->data['files']);
                }
            }
            $response = $this->response->withType('application/json')
              ->withStringBody(json_encode($res));
            return  $response;
        }else{
            throw new NotFoundException(__('Error: 404'));
        }
        
    }

    public function editFront($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Actions']
        ]);
        if ($this->request->is('ajax') && $this->request->is('post') ){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $item = $this->Items->patchEntity($item, $this->request->getData());
                if ($res=$this->Items->save($item)) {
                    $response = $this->response->withType('application/json')
                      ->withStringBody(json_encode($res));
                    return  $response;
                }
                throw new NotFoundException(__('no saved'));
            }
        }else{
            throw new NotFoundException(__('Error: 404'));
        }
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

    public function deleteFront($id = null)
    {
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $this->loadModel('Files');
            $this->request->allowMethod(['post', 'delete']);
            $item = $this->Items->get($id);

            $files = $this->Files->findAllByItemId($id)->toArray();
            foreach ($files as $file) {
                if(unlink(WWW_ROOT."uploads/files/".$file->filename)){
                }
            }

            if ($ite=$this->Items->delete($item)) {
                $response = $this->response->withType('application/json')
                  ->withStringBody(json_encode($id));
                return  $response;
            } else {
                throw new NotFoundException(__('The item could not be deleted. Please, try again.'));
            }
        }else{
            throw new NotFoundException(__('Error: 404'));
        }

        //return $this->redirect(['action' => 'index']);
    }
}
