<?php
namespace Usermgmt\View\Cell;
use Cake\View\Cell;

class PermissionCell extends Cell {
	public $helpers = ['Usermgmt.UserAuth'];
	public $view = null;

	public function initialize() {
		$this->view = $this->createView();
    }

	public function getPermissions() {
		$this->loadModel('Usermgmt.UserGroups');
		if($this->view->UserAuth->isLogged()) {
			$permissions = $this->UserGroups->getPermissions($this->view->UserAuth->getGroupId());
		} else {
			$permissions = $this->UserGroups->getPermissions(GUEST_GROUP_ID);
		}
		return $permissions;
	}
}