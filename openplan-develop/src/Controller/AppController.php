<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Http\Exception\NotFoundException;
use Cake\Event\EventManager;
use Cake\Event\EventList;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    protected $companies;
    public $helpers = ['CkEditor.Ck', 'Time'];
    public $components = ['Flash', 'Auth', 'Usermgmt.UserAuth'/*, 'Security', 'Csrf'*/];
    /*public $helpers = ['Usermgmt.UserAuth', 'Usermgmt.Image', 'Form' => ['templates' => 'form-templates'], 'Paginator' => ['templates' => 'paginator-templates']];*/

    /* Override functions */
    /*public function paginate($object = null, array $settings = []) {
        $sessionKey = sprintf('UserAuth.Search.%s.%s', $this->request['controller'], $this->request['action']);
        if($this->request->getSession()->check($sessionKey)) {
            $persistedData = $this->request->getSession()->read($sessionKey);
            if(!empty($persistedData['page_limit'])) {
                $this->paginate['limit'] = $persistedData['page_limit'];
            }
        }
        return parent::paginate($object, $settings);
    }*/
    public function paginate($object = null, array $settings = []) {
        $sessionKey = sprintf('UserAuth.Search.%s.%s', $this->getRequest()->getParam('controller'), $this->getRequest()->getParam('action'));
        if($this->getRequest()->getSession()->check($sessionKey)) {
            $persistedData = $this->getRequest()->getSession()->read($sessionKey);
            if(!empty($persistedData['page_limit'])) {
                $this->paginate['limit'] = $persistedData['page_limit'];
            }
        }
        return parent::paginate($object, $settings);
    }
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('Usermgmt.UserAuth');
        $this->loadComponent('Moderation');


        if (!$this->UserAuth->isLogged()) {
            //print_r();
            if ($this->request->getParam('action')=='login') {
                $this->viewBuilder()->setLayout('login');
            }else{

                $this->viewBuilder()->setLayout('register');
                $this->requestToken=true;
            }
            
        }else{
            //debug($this->UserAuth->getGroupId());
            if ($this->UserAuth->getGroupId()==1) {
                $this->viewBuilder()->setLayout('dashboard');
            }else if($this->UserAuth->getGroupId()==2){
                $this->viewBuilder()->setLayout('board');
            } 
        }
        $this->loadGlobal();
        
        //optional, User Management plugin is CSRF & security protection enabled and If you want to use CSRF & security in rest Application just uncomment following lines
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }
    private function loadGlobal(){
        $this->loadModel('RelationMembers');

        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $urlSiteSocket=$protocol.$_SERVER['SERVER_NAME'].":3000";

        $companies = $this->RelationMembers->getAllCompaniesUser($this->UserAuth->getUserId(),$this->UserAuth->getGroupId())->toArray();
        $this->companies=$companies;
        $currentDateTime = new Time();
        $token=$this->request->getQuery('t');//parametro para check si hay nuevos
        $realToken=false;
        $emailToken=false;
        if ($this->requestToken && $token) {
            $this->loadModel('Collaborators');
            $collaborator = $this->Collaborators->findByToken($token)->first();
            if (!$collaborator) { throw new NotFoundException(__('404 not found')); }
            $emailToken=$collaborator->user_email;
            $realToken=$collaborator->token;
        }
        $this->set(compact('companies','currentDateTime','emailToken','realToken', 'urlSiteSocket'));
    }
    //valida si puede entrar a la empresa o pertenece a ella
    protected function checkCompany($company_id){
        $this->loadModel('RelationMembers');
        $company = $this->RelationMembers->checkCompany($this->UserAuth->getUserId(),$this->UserAuth->getGroupId(),$company_id)->toArray();
        
        if (empty($company)) {
            return false;
        }else{
            return true;
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        if ($this->UserAuth->getGroupId()!=1) {
            $this->Moderation->startModeration($this->UserAuth->getUserId());
        }
        //debug($this->request);
        //$pru=$this->Moderation->doComplexOperation(1,5);
        //debug($pru);

       /* debug($action);
        debug($controller);*/

        //return false;
        //exit();
    }
    
    /*public function beforeFilter() {
        debug($this);
        exit();
        return false;
    }*/

    /*public function json($data){
        $this->response->getType('json');
        $this->response->withBody   (json_encode($data));
        return $this->response;
    }*/
    /*public function beforeRender(Event $event) {
        if(!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->getType(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
    }*/
}
