<?php
/* Cakephp 3.x User Management Premium Version (a product of Ektanjali Softwares Pvt Ltd)
Website- http://ektanjali.com
Plugin Demo- http://cakephp3-user-management.ektanjali.com/
Author- Chetan Varshney (The Director of Ektanjali Softwares Pvt Ltd)
Plugin Copyright No- 11498/2012-CO/L

UMPremium is a copyrighted work of authorship. Chetan Varshney retains ownership of the product and any copies of it, regardless of the form in which the copies may exist. This license is not a sale of the original product or any copies.

By installing and using UMPremium on your server, you agree to the following terms and conditions. Such agreement is either on your own behalf or on behalf of any corporate entity which employs you or which you represent ('Corporate Licensee'). In this Agreement, 'you' includes both the reader and any Corporate Licensee and Chetan Varshney.

The Product is licensed only to you. You may not rent, lease, sublicense, sell, assign, pledge, transfer or otherwise dispose of the Product in any form, on a temporary or permanent basis, without the prior written consent of Chetan Varshney.

The Product source code may be altered (at your risk)

All Product copyright notices within the scripts must remain unchanged (and visible).

If any of the terms of this Agreement are violated, Chetan Varshney reserves the right to action against you.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Product.

THE PRODUCT IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE PRODUCT OR THE USE OR OTHER DEALINGS IN THE PRODUCT. */
?>
<?php
namespace Usermgmt\Controller;
use Usermgmt\Controller\UsermgmtAppController;
use Cake\Event\Event;

class StaticPagesController extends UsermgmtAppController {
	/**
	 * This controller uses following default pagination values
	 *
	 * @var array
	 */
	public $paginate = [
		'limit'=>25
	];
	/**
	 * This controller uses search filters in following functions for ex index, online function
	 *
	 * @var array
	 */
	public $searchFields = [
		'index'=>[
			'Usermgmt.StaticPages'=>[
				'StaticPages'=>[
					'type'=>'text',
					'label'=>'Search',
					'tagline'=>'Search by page name, title, url name',
					'condition'=>'multiple',
					'searchFields'=>['StaticPages.page_name', 'StaticPages.page_title', 'StaticPages.url_name'],
					'inputOptions'=>['style'=>'width:300px;']
				]
			]
		]
	];
	/**
	 * Called before the controller action. You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->loadModel('Usermgmt.StaticPages');

		if(isset($this->Security) && $this->getRequest()->is('ajax')) {
			$this->Security->setConfig('unlockedActions', [$this->getRequest()->getParam('action')]);
		}
	}
	/**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();

        $this->loadComponent('Usermgmt.Search');
    }
	/**
	 * It displays all static pages
	 *
	 * @access public
	 * @return void
	 */
	public function index() {
		$cond = [];
		$cond = $this->Search->applySearch($cond);

		$this->paginate = ['limit'=>10, 'conditions'=>$cond, 'order'=>['StaticPages.id'=>'DESC']];
		$staticPages = $this->paginate($this->StaticPages)->toArray();

		$this->set(compact('staticPages'));

		if($this->getRequest()->is('ajax')) {
			$this->viewBuilder()->setLayout('ajax');
			$this->render('/Element/all_static_pages');
		}
	}
	/**
	 * It is used to create a new static page
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		$staticPageEntity = $this->StaticPages->newEntity($this->getRequest()->getData(), ['validate'=>'forAdd']);

		if($this->getRequest()->is('post')) {
			$errors = $staticPageEntity->getErrors();

			if($this->getRequest()->is('ajax')) {
				if(empty($errors)) {
					$response = ['error'=>0, 'message'=>'success'];
				} else {
					$response = ['error'=>1, 'message'=>'failure'];
					$response['data']['StaticPages'] = $errors;
				}
				echo json_encode($response);exit;
			} else {
				if(empty($errors)) {
					if($this->StaticPages->save($staticPageEntity, ['validate'=>false])) {
						$this->Flash->success(__('The static page is successfully added'));
						$this->redirect(['action'=>'index']);
					} else {
						$this->Flash->error(__('Unable to add page, please try again'));
					}
				}
			}
		}
		$this->set(compact('staticPageEntity'));
	}
	/**
	 * It is used to edit static page
	 *
	 * @access public
	 * @param integer $staticPageId static page id
	 * @return void
	 */
	public function edit($staticPageId=null) {
		$page = ($this->getRequest()->getQuery('page')) ? $this->getRequest()->getQuery('page') : 1;

		if(!empty($staticPageId)) {
			$staticPageEntity = $this->StaticPages->find()->where(['StaticPages.id'=>$staticPageId])->first();

			if(!empty($staticPageEntity)) {
				$this->StaticPages->patchEntity($staticPageEntity, $this->getRequest()->getData(), ['validate'=>'forAdd']);

				if($this->getRequest()->is(['put', 'post'])) {
					$errors = $staticPageEntity->getErrors();

					if($this->getRequest()->is('ajax')) {
						if(empty($errors)) {
							$response = ['error'=>0, 'message'=>'success'];
						} else {
							$response = ['error'=>1, 'message'=>'failure'];
							$response['data']['StaticPages'] = $errors;
						}
						echo json_encode($response);exit;
					} else {
						if(empty($errors)) {
							if($this->StaticPages->save($staticPageEntity, ['validate'=>false])) {
								$this->Flash->success(__('The static page has been updated successfully'));
								$this->redirect(['action'=>'index', 'page'=>$page]);
							} else {
								$this->Flash->error(__('Unable to save static page, please try again'));
							}
						}
					}
				}
				$this->set(compact('staticPageEntity'));
			} else {
				$this->Flash->error(__('Invalid Static Page Id'));
				$this->redirect(['action'=>'index']);
			}
		} else {
			$this->Flash->error(__('Missing Static Page Id'));
			$this->redirect(['action'=>'index']);
		}
	}
	/**
	 * It is used to view static page detail
	 *
	 * @access public
	 * @param integer $staticPageId static page id
	 * @return void
	 */
	public function view($staticPageId=null) {
		if(!empty($staticPageId)) {
			$staticPage = $this->StaticPages->find()->where(['StaticPages.id'=>$staticPageId])->first();

			if(!empty($staticPage)) {
				$this->set(compact('staticPage'));
			} else {
				$this->Flash->error(__('Invalid Static Page Id'));
				$this->redirect(['action'=>'index']);
			}
		} else {
			$this->Flash->error(__('Missing Static Page Id'));
			$this->redirect(['action'=>'index']);
		}
	}
	/**
	 * It is used to delete the static page
	 *
	 * @access public
	 * @param integer $staticPageId static page id
	 * @return void
	 */
	public function delete($staticPageId=null) {
		$page = ($this->getRequest()->getQuery('page')) ? $this->getRequest()->getQuery('page') : 1;

		if(!empty($staticPageId)) {
			if($this->getRequest()->is(['post'])) {
				$staticPageEntity = $this->StaticPages->find()->where(['StaticPages.id'=>$staticPageId])->first();

				if(!empty($staticPageEntity)) {
					if($this->StaticPages->delete($staticPageEntity)) {
						$this->Flash->success(__('Selected static page has been deleted successfully'));
					} else {
						$this->Flash->error(__('Selected static page can not be deleted, please try again'));
					}
				} else {
					$this->Flash->error(__('Invalid Static Page Id'));
				}
			}
		} else {
			$this->Flash->error(__('Missing Static Page Id'));
		}
		$this->redirect(['action'=>'index', 'page'=>$page]);
	}
	/**
	 * It is used to preview static page contents by url
	 *
	 * @access public
	 * @param string $urlName page url name
	 * @return void
	 */
	public function preview($urlName=null) {
		$invalidPage = true;

		if(!empty($urlName)) {
			$staticPage = $this->StaticPages->find()->where(['StaticPages.url_name'=>$urlName])->first();

			if(!empty($staticPage)) {
				$invalidPage = false;
				$this->set(compact('staticPage'));
			}
		}
		if($invalidPage) {
			$this->redirect('/');
		}
	}
}