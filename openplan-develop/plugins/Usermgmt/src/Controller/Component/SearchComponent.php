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
namespace Usermgmt\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

class SearchComponent extends Component {
	public $registry;
	public $controller;
	public $request;
	public $response;
	public $session;

	public $settings = [];
	public $formData = [];
	public $config = [];
	public $orgSearchConditions = [];
	public $controllerName = '';
	public $actionName = '';

	public function __construct(ComponentRegistry $registry, array $config = []) {
		$this->registry = $registry;
		$this->controller = $registry->getController();
		$this->request = $registry->getController()->getRequest();
		$this->response = $registry->getController()->getResponse();
		$this->session = $registry->getController()->getRequest()->getSession();

		$this->controllerName = $this->controller->getName();
		$this->actionName = $this->request->getParam('action');

		parent::__construct($registry, $config);
	}

	public function initialize(array $config) {
		if(!empty($this->controller->searchFields)) {
			$this->settings[$this->controllerName] = $this->controller->searchFields;

			if(!empty($this->settings[$this->controllerName][$this->actionName])) {
				$settings = $this->settings[$this->controllerName][$this->actionName];

				foreach($settings as $model=>$search) {
					$loadingModel = $model;

					if(strpos($model, '.') !== false) {
						list($plugin, $model) = explode('.', $model);
					}
					if(!is_object($this->controller->{$model})) {
						$this->controller->$model = $this->controller->loadModel($loadingModel);
					}
					if(!is_object($this->controller->{$model})) {
						trigger_error(__('Search model not found: {0}', $model));
						continue;
					}
					$this->controller->$model->addBehavior('Usermgmt.Searching', $search);
				}
			}
		}
		parent::initialize($config);
	}
	public function startup() {
		if(!empty($this->settings[$this->controllerName][$this->actionName])) {
			$settings = $this->settings[$this->controllerName][$this->actionName];

			$sessionKey = sprintf('UserAuth.Search.%s.%s', $this->controllerName, $this->actionName);
			$formdata = $this->request->getData();

			if($this->request->is('get') && isset($_GET['Usermgmt']['searchFormId'])) {
				$this->formData = $_GET;
				$this->session->write($sessionKey, $this->formData);
			} else if($this->request->is('post') || isset($formdata['Usermgmt']['searchFormId'])) {
				$this->formData = $formdata;
				$this->session->write($sessionKey, $this->formData);
			} else {
				if($this->session->check($sessionKey)) {
					$this->formData = $this->session->read($sessionKey);
				}
			}

			if(isset($this->formData['search_clear']) && $this->formData['search_clear'] == 1) {
				$this->session->delete($sessionKey);
				$this->formData = [];
			}

			foreach($settings as $model=>$search) {
				if(strpos($model, '.') !== false) {
					list($plugin, $model) = explode('.', $model);
				}
				$this->controller->$model->setSearchValues($this->formData);
			}
		}
	}
	public function applySearch($originalConditions=array()) {
		$filteredConditions = $originalConditions;

		if(!empty($this->settings[$this->controllerName][$this->actionName])) {
			$settings = $this->settings[$this->controllerName][$this->actionName];

			foreach($settings as $model=>$search) {
				if(strpos($model, '.') !== false) {
					list($plugin, $model) = explode('.', $model);
				}
				$filteredConditions = $this->controller->$model->applySearchFilters($filteredConditions);
				$this->orgSearchConditions = $originalConditions;
			}
		}
		return $filteredConditions;
	}
	public function beforeRender() {
		if(isset($this->settings[$this->controllerName][$this->actionName])) {
			$settings = $this->settings[$this->controllerName][$this->actionName];
			$viewSearchParams = [];

			foreach($settings as $model=>$fields) {
				if(strpos($model, '.') !== false) {
					list($plugin, $model) = explode('.', $model);
				}

				$default = [
					'type'=>'text',
					'value'=>'',
					'default'=>null,
					'condition'=>'like',
					'label'=>'',
					'labelImage'=>'',
					'labelImageTitle'=>'',
					'tagline'=>'',
					'adminOnly'=>false,
					'model'=>false,
					'selector'=>false,
					'selectorArguments'=>[],
					'inputOptions'=>[],
					'searchField'=>null,
					'searchFields'=>[],
					'searchBreak'=>true,
					'matchAllWords'=>false,
					'searchFunc'=>[],
					'options'=>[],
					'textTransform'=>'none',
					'textTransformFields'=>[]
				];

				/*
					possible values are below, you can most of usage in users controller

					-- 'type' = 'text', 'select', 'checkbox'

					-- 'value' = you can pass value for any search field

					-- 'default' = you can pass default value for any search field

					-- 'condition' = 'like', 'contains', 'startswith', 'endswith', '=', '<', '>', '<=', '>=', 'comma', 'semicolon', 'multiple'

					-- 'label' = search filter field label name

					-- 'labelImage' = search filter field label image

					-- 'labelImageTitle' = search filter field label image title shown on mouse over

					-- 'tagline' = it's a text which comes below search filter field

					-- 'adminOnly' =  true or false

					-- 'model' = model name from you want to call action for select options

					-- 'selector' = it is action name in model, you want to call it for select options

					-- 'selectorArguments' = you can pass arguments for selector action of model

					-- 'inputOptions' = you can pass filter input html attributes like style, class etc 

					-- 'searchField' = it's database search field

					-- 'searchFields' = it's a array of database search fields

					-- 'searchBreak' = works with 'condition' = 'multiple',
						for e.g. if you type 'User Plugin' in search input
						if 'searchBreak' is false then 'User Plugin' text will be searched as single word in database fields

					-- 'matchAllWords' = works with 'condition' = 'multiple' and 'searchBreak' = true
						for e.g. if you type 'User Plugin' in search input
						'User' and 'Plugin' both text should be matched in database records

					-- 'searchFunc' = it's a array of url attributes to show custom suggestion when you type in search filter inputs

					-- 'options' = it's a array of options for select field, either use 'options' or combination of 'model' & 'selector' to set select input search field

					-- 'textTransform' = 'uppercase', 'lowercase', 'capitalize'

					-- 'textTransformFields' = you can specify fields to apply text transform of value
						this works with 'textTransform' option
						'textTransformFields' only applicable with 'condition' = 'multiple'
						for e.g. if you have multilple condition with more than 1 fields and you want to apply text transform of few fields
						...[
							'type'=>'text',
							'label'=>'Search',
							'tagline'=>'Search by name, username, email',
							'condition'=>'multiple',
							'searchFields'=>['Users.first_name', 'Users.last_name', 'Users.username', 'Users.email'],
							'textTransform'=>'uppercase',
							'textTransformFields'=>['Users.username']
							.....
						]
				*/

				foreach($fields as $field=>$settings) {
					$fields[$field] = array_merge($default, $settings);

					if(!is_array($fields[$field]['inputOptions'])) {
						$fields[$field]['inputOptions'] = [$fields[$field]['inputOptions']];
					}
				}

				foreach($fields as $field=>$settings) {
					$options = $settings;
					$fieldName = $field;
					$fieldModel = $model;

					if(strpos($field, '.') !== false) {
						list($fieldModel, $fieldName) = explode('.', $field);
					}

					$orgSearchConditions = $this->orgSearchConditions;
					if(isset($orgSearchConditions[$fieldModel.'.'.$fieldName]) && $orgSearchConditions[$fieldModel.'.'.$fieldName] != -1) {
						$options['value'] = $orgSearchConditions[$fieldModel.'.'.$fieldName];
					}

					if(!empty($this->formData) && isset($this->formData[$fieldModel][$fieldName])) {
						$options['value'] = $this->formData[$fieldModel][$fieldName];
					}

					if(!strlen($options['value']) && strlen($options['default'])) {
						$options['value'] = $options['default'];
					}

					switch($options['type']) {
						case 'select':
							if(!$options['model']) {
								$options['model'] = $fieldModel;
							}

							$workingModel = TableRegistry::getTableLocator()->get($options['model']);

							if($options['selector']) {
								if(!method_exists($workingModel, $options['selector'])) {
									trigger_error(__('Selector method {0} not found in model-table {1} for field {2}! and make sure you passed model-table name (if model-table belongs to any plugin then pass plugin-name-model-table) in search fields variable of respective controller', $options['selector'], $options['model'], $fieldName));
									return;
								}

								$selectorName = $options['selector'];
								if(count($options['selectorArguments'])) {
									$options['options'] = $workingModel->$selectorName($options['selectorArguments']);
								} else {
									$options['options'] = $workingModel->$selectorName();
								}
							}
							break;

						case 'checkbox':
							if(!empty($this->formData) && isset($this->formData[$fieldModel][$fieldName])) {
								$options['checked'] = !!$options['value'];
							} else if(isset($options['default'])) {
								$options['checked'] = !!$options['default'];
							}
							break;

						default:
							continue;
					}

					$options['field'] = $fieldName;
					$viewSearchParams[] = ['name'=>sprintf('%s.%s', $fieldModel, $fieldName), 'options'=>$options];
				}
			}
			$this->controller->set(compact('viewSearchParams'));
		}
	}
}