<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;

class ModerationComponent extends Component
{
    /*public function doComplexOperation($amount1, $amount2)
    {
        return $amount1 + $amount2;
    }*/
    public function initialize(array $config) 
    {
    	parent::initialize($config);
    	$this->loadModel('RelationMembers');
    	$this->loadModel('Rooms');
    	$this->loadModel('Items');
    	$this->loadModel('Comments');
    	$this->loadModel('Files');
    }
    
    private function moderateItem($params, $logged_id){
    	//echo "string";
		$this->getRelation($params, $logged_id);
		
		//relacion empresa
		if ($this->relationCompany) {
			//relacion interna
			if ($this->relationCompany->role_id==1 || $this->relationCompany->role_id==2 || $this->relationCompany->role_id==3) {
				//echo "permite crear item";
				if ($this->relationCompany->role_id==3 || $this->relationCompany->role_id==2) {

					if (isset($params->item_id)) {
						$item=$this->Items->findAllById($params->item_id)->first();
						if ($item->private && $item->user_id!=$logged_id && !$this->relationItem){
							$this->loadError();
						}
					}
				}
				/*if ($this->relationCompany->role_id==3 && isset($params->item_id)) {
					$item=$this->Items->findAllById($params->item_id)->first();
					echo "string";
					if ($item->user_id!=$logged_id) {
						
						$this->loadError();
					}
				}*/
			}else{
				//relacion externa
				$this->loadError();
			}
		}else if ($this->relationRoom) {
			//relacion interna
			if ($this->relationRoom->role_id==1 || $this->relationRoom->role_id==2 || $this->relationRoom->role_id==3) {
				//echo "permite crear en room";
				if ($this->relationRoom->role_id==3 || $this->relationRoom->role_id==2) {
					$item=$this->Items->findAllById($params->item_id)->first();
					if ($item->private && $item->user_id!=$logged_id && !$this->relationItem){
						$this->loadError();
					}
				}
			}else{
				//relacion externa
				$this->loadError();
			}
		}else{
			$action=$this->request->getParam('action');
			$controller=$this->request->getParam('controller');
			if (($action=='editFront' || $action=='deleteFront' || $action=='item') && $controller=='Items' && $this->relationItem) {
				if ($this->relationItem->role_id==1 || $this->relationItem->role_id==2 || $this->relationItem->role_id==3) {
					//echo "permite  item ";
				}else{
					//relacion externa
					$this->loadError();
				}
				
			}else{
				$this->loadError();
			}
		}
    }
    
    private function moderateRoom($params, $logged_id){
    	$this->getRelation($params, $logged_id);
		if ($this->relationCompany) {
			if ($this->relationCompany->role_id==1 || $this->relationCompany->role_id==2 || $this->relationCompany->role_id==3) {
				//echo "permite crear sala";
			}else{
				//relacion externa
				$this->loadError();
			}
		}else if ($this->relationRoom) {
			//relacion con sala
			if ($this->relationRoom->role_id==1 || $this->relationRoom->role_id==2 || $this->relationRoom->role_id==3) {
				//echo "permite crear sala";
			}else{
				//relacion externa
				$this->loadError();
			}
		}else{
			$this->loadError();
		}
    }
    private function moderateCollaborator($params, $logged_id){

    	$this->getRelation($params, $logged_id);

    	if ($this->relationCompany) {
    		if ($this->relationCompany->role_id==1 || $this->relationCompany->role_id==2 || $this->relationCompany->role_id==3) {
    			//echo "permite crear usuario en empresa";
    		}else{
    			//relacion externa
    			$this->loadError();
    		}
    	}else if ($this->relationRoom) {
    		if ($this->relationRoom->role_id==1 || $this->relationRoom->role_id==2 || $this->relationRoom->role_id==3) {
    			//echo "permite crear usuario en room";
    		}else{
    			//relacion externa
    			$this->loadError();
    		}
    	}else if ($this->relationItem) {
    		if ($this->relationItem->role_id==1 || $this->relationItem->role_id==2 || $this->relationItem->role_id==3) {
    			//echo "permite crear usuario en item";
    		}else{
    			//relacion externa
    			$this->loadError();
    		}
    	}else{
    		$this->loadError();
    	}
    }

    private function moderateCommentAndFile($params, $logged_id){

    	$this->getRelation($params, $logged_id);

		if ($this->relationCompany) {
			if ($this->relationCompany->role_id==1 || $this->relationCompany->role_id==2 || $this->relationCompany->role_id==3) {

				if ($this->relationCompany->role_id==3) {

					if (isset($params->comment_id)) {
						$comment=$this->Comments->findAllById($params->comment_id)->first();
						if ($comment->user_id!=$logged_id) {
							$this->loadError();
						}
					}else if (isset($params->file_id)) {
						$file=$this->Files->findAllById($params->file_id)->first();
						if ($file->user_id!=$logged_id) {
							$this->loadError();
						}
					}
					
				}

			}else{
				//relacion externa
				$this->loadError();
			}
		}else if ($this->relationRoom) {
			if ($this->relationRoom->role_id==1 || $this->relationRoom->role_id==2 || $this->relationRoom->role_id==3) {
				
				if ($this->relationRoom->role_id==3) {
					//echo "string";
					if (isset($params->comment_id)) {
						$comment=$this->Comments->findAllById($params->comment_id)->first();
						if ($comment->user_id!=$logged_id) {
							$this->loadError();
						}
					}else if (isset($params->file_id)) {
						$file=$this->Files->findAllById($params->file_id)->first();
						if ($file->user_id!=$logged_id) {
							$this->loadError();
						}
					}
				}

			}else{
				//relacion externa
				$this->loadError();
			}
		}else if ($this->relationItem) {
			if ($this->relationItem->role_id==1 || $this->relationItem->role_id==2 || $this->relationItem->role_id==3) {
				
				if ($this->relationItem->role_id==3) {
					if (isset($params->comment_id)) {
						$comment=$this->Comments->findAllById($params->comment_id)->first();
						if ($comment->user_id!=$logged_id) {
							$this->loadError();
						}
					}else if (isset($params->file_id)) {
						$file=$this->Files->findAllById($params->file_id)->first();
						if ($file->user_id!=$logged_id) {
							$this->loadError();
						}
					}
				}

			}else{
				//relacion externa
				$this->loadError();
			}
		}else{
			$this->loadError();
		}

    }
    private function getRelation($params, $logged_id){

    	if (isset($params->itemId) or isset($params->item_id)) {
    		isset($params->itemId) ? $params->item_id=$params->itemId : false;

    		$item=$this->Items->findAllById($params->item_id)->first();
    		isset($item) ? $params->company_id=$item->company_id : false ;
    		isset($item) ? $params->room_id=$item->room_id : false ;

    	}

    	if (isset($params->foreign_key)) {
    		if ($params->model=='company') {
    			$params->company_id=$params->foreign_key;
    		}else if ($params->model=='room') {
    			$params->room_id=$params->foreign_key;
    			$room=$this->Rooms->findAllById($params->room_id)->first();
    			isset($room) ? $params->company_id=$room->company_id : false ;
    			//debug($params->company_id);
    		}else if ($params->model=='item') {
    			$params->item_id=$params->foreign_key;
    			$item=$this->Items->findAllById($params->item_id)->first();
    			isset($item) ? $params->company_id=$item->company_id : false ;
    			isset($item) ? $params->room_id=$item->room_id : false ;
    		}else{
    			$this->loadError();
    		}
    	}

    	isset($params->company_id) ? $company_id=$params->company_id : $company_id=false;
    	isset($params->room_id) ? $room_id=$params->room_id : $room_id=false;
    	isset($params->item_id) ? $item_id=$params->item_id : $item_id=false;

    	if ($room_id) {
    		$room=$this->Rooms->findAllByIdAndCompanyId($room_id,$company_id)->first();
    		if (!$room) {
    			//echo $room_id;
    			//echo $company_id;
    			$this->loadError();
    		}
    	}


    	$this->relationCompany = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($logged_id,'companies',$company_id)->first();
    	$this->relationRoom = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($logged_id,'rooms',$room_id)->first();
    	$this->relationItem = $this->RelationMembers->findAllByUserIdAndModelAndForeignKey($logged_id,'items',$item_id)->first();
    	//print_r($this->relationItem);

    }

    public function startModeration($logged_id)
    {
    	$this->loadModel('RelationMembers');
        $action=$this->request->getParam('action');
        $controller=$this->request->getParam('controller');
        if ($action=='addFront' || $action=='addFiles') {
        	if ($controller=='Items') {
        		$params=(object )$this->request->getData('Items');
        		$this->moderateItem($params,$logged_id);
        		//debug($params);  
        	}else if ($controller=='Rooms') {
        		$params=(object )$this->request->getData('Rooms');
        		$this->moderateRoom($params,$logged_id);        		
        		//debug($params);
        	}else if ($controller=='Collaborators') {
        		$params=(object )$this->request->getData('Collaborators');
        		$this->moderateCollaborator($params,$logged_id);
        		
        	}else if ($controller=='Comments' or $controller=='Files') {
        		$params=(object )$this->request->getData();
        		$this->moderateCommentAndFile($params,$logged_id);
        		//debug($params);
        	}
        }else if ($action=='editFront') {
        	if ($controller=='Items') {
        		//$params=object;
        		$params = new \StdClass();
        		$params->item_id=$this->request->getParam('id');
        		$this->moderateItem($params,$logged_id);
        	}else if ($controller=='Comments') {
        		$params = new \StdClass();
        		$params->comment_id=$this->request->getParam('id');
        		if ($comment=$this->Comments->findAllById($params->comment_id)->first()) {
        			$params->item_id=$comment->item_id;
        		}
        		$this->moderateCommentAndFile($params,$logged_id);
        		//debug($this->request);
        	}
        	# code...
        }else if ($action=='deleteFront') {
        	if ($controller=='Items') {
        		$params = new \StdClass();
        		$params->item_id=$this->request->getParam('id');
        		$this->moderateItem($params,$logged_id);
        	}else if ($controller=='Comments') {
        		$params = new \StdClass();
        		$params->comment_id=$this->request->getParam('id');
        		//debug($params);
        		if ($comment=$this->Comments->findAllById($params->comment_id)->first()) {
        			$params->item_id=$comment->item_id;
        		}
        		$this->moderateCommentAndFile($params,$logged_id);
        		# code...
        	}else if ($controller=='Files') {
        		$params = new \StdClass();
        		$params->file_id=$this->request->getParam('id');
        		//debug($params);
        		if ($file=$this->Files->findAllById($params->file_id)->first()) {
        			$params->item_id=$file->item_id;
        		}
        		$this->moderateCommentAndFile($params,$logged_id);
        		# code...
        	}
        }else if ($action=='item') {
        	if ($controller=='Items') {
        		$params = new \StdClass();
        		$params->item_id=$this->request->getParam('id');
        		$this->moderateItem($params,$logged_id);
        	}
        }
       // exit();
    }
    private function loadError() 
    {
    	throw new NotFoundException(__('Acción no permitida'));    	
    }
    private function loadModel($model) 
    {
    	$this->$model = TableRegistry::get($model);
    }
}
