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
namespace Usermgmt\Model\Table;
use Usermgmt\Model\Table\UsermgmtAppTable;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\App;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validation;

class UsersTable extends UsermgmtAppTable {

	public $userAuth;
	public $multiUsers = array();

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		$this->hasOne('Usermgmt.UserDetails');
	}
	public function validationForLogin($validator) {
		$validator
			->notEmpty('email', __('Please enter email or username'))
			->notEmpty('password', __('Please enter password'))
			->notEmpty('captcha', __('Please select I\'m not a robot'))
			->add('captcha', [
				'mustMatch'=>[
					'rule'=>'recaptchaValidate',
					'provider'=>'table',
					'message'=>__('Prove you are not a robot')
				]
			]);
		return $validator;
	}
	public function validationForRegister($validator) {
		$validator
			->notEmpty('user_group_id', __('Please select group'))
			->notEmpty('username', __('Please enter username'))
			->notEmpty('first_name', __('Please enter first name'))
			->allowEmpty('last_name')
			->notEmpty('email', __('Please enter email'))
			->notEmpty('password', __('Please enter password'))
			->notEmpty('cpassword', __('Please enter password'))
			->notEmpty('captcha', __('Please select I\'m not a robot'))
			->add('username', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This username already exist'),
					'last'=>true
				],
				'mustBeLonger'=>[
					'rule'=>['minLength', 4],
					'message'=>__('Username must be greater than 3 characters'),
					'last'=>true
				],
				'mustNotBanned'=>[
					'rule'=>'isBanned',
					'provider'=>'table',
					'message'=>__('This Username is not available'),
					'last'=>true
				]
			])
			->add('first_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				]
			])
			->add('last_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				]
			])
			->add('email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This email already exist')
				]
			])
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			])
			->add('cpassword', [
				'mustMatch'=>[
					'rule'=>'checkForSamePassword',
					'provider'=>'table',
					'message'=>__('Both password must match')
				]
			])
			->add('captcha', [
				'mustMatch'=>[
					'rule'=>'recaptchaValidate',
					'provider'=>'table',
					'message'=>__('Prove you are not a robot')
				]
			]);
		return $validator;
	}
	public function validationForAddUser($validator) {
		$validator
			->notEmpty('user_group_id', __('Please select group'))
			->notEmpty('username', __('Please enter username'))
			->notEmpty('first_name', __('Please enter first name'))
			->allowEmpty('last_name')
			->notEmpty('email', __('Please enter email'))
			->notEmpty('password', __('Please enter password'))
			->notEmpty('cpassword', __('Please enter password'))
			->add('username', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This username already exist'),
					'last'=>true
				],
				'mustBeLonger'=>[
					'rule'=>['minLength', 4],
					'message'=>__('Username must be greater than 3 characters'),
					'last'=>true
				],
				'mustNotBanned'=>[
					'rule'=>'isBanned',
					'provider'=>'table',
					'message'=>__('This Username is not available'),
					'last'=>true
				]
			])
			->add('first_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				]
			])
			->add('last_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				]
			])
			->add('email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This email already exist')
				]
			])
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			])
			->add('cpassword', [
				'mustMatch'=>[
					'rule'=>'checkForSamePassword',
					'provider'=>'table',
					'message'=>__('Both password must match')
				]
			]);
		return $validator;
	}
	public function validationForEditUser($validator) {
		$validator
			->notEmpty('user_group_id', __('Please select group'))
			->notEmpty('username', __('Please enter username'))
			->notEmpty('first_name', __('Please enter first name'))
			->allowEmpty('last_name')
			->notEmpty('email', __('Please enter email'))
			->add('username', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This username already exist'),
					'last'=>true
				],
				'mustBeLonger'=>[
					'rule'=>['minLength', 4],
					'message'=>__('Username must be greater than 3 characters'),
					'last'=>true
				],
				'mustNotBanned'=>[
					'rule'=>'isBanned',
					'provider'=>'table',
					'message'=>__('This Username is not available'),
					'last'=>true
				]
			])
			->add('first_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				]
			])
			->add('last_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				]
			])
			->add('email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This email already exist')
				]
			])
			->allowEmpty('photo_file')
			->add('photo_file', [
				'validType'=>[
					'rule'=>['extension', ['gif', 'jpeg', 'png', 'jpg', '']],
					'message'=>__('Please upload a valid image')
				]
			])
			->allowEmpty('bday')
			->add('bday', [
				'validDate'=>[
					'rule'=>['date', 'ymd'],
					'message'=>__('Please select valid date')
				]
			]);
		return $validator;
	}
	public function validationForEditProfile($validator) {
		$validator
			->notEmpty('user_group_id', __('Please select group'))
			->notEmpty('username', __('Please enter username'))
			->notEmpty('first_name', __('Please enter first name'))
			->allowEmpty('last_name')
			->notEmpty('email', __('Please enter email'))
			->notEmpty('gender', __('Please select gender'))
			->add('username', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This username already exist'),
					'last'=>true
				],
				'mustBeLonger'=>[
					'rule'=>['minLength', 4],
					'message'=>__('Username must be greater than 3 characters'),
					'last'=>true
				],
				'mustNotBanned'=>[
					'rule'=>'isBanned',
					'provider'=>'table',
					'message'=>__('This Username is not available'),
					'last'=>true
				]
			])
			->add('first_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				]
			])
			->add('last_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				]
			])
			->add('email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This email already exist')
				]
			])
			->allowEmpty('photo_file')
			->add('photo_file', [
				'validType'=>[
					'rule'=>['extension', ['gif', 'jpeg', 'png', 'jpg', '']],
					'message'=>__('Please upload a valid image')
				]
			])
			->allowEmpty('bday')
			->add('bday', [
				'validDate'=>[
					'rule'=>['date', 'ymd'],
					'message'=>__('Please select valid date')
				]
			]);
		return $validator;
	}
	public function validationForChangePassword($validator) {
		$validator
			->notEmpty('oldpassword', __('Please enter old password'))
			->notEmpty('password', __('Please enter password'))
			->notEmpty('cpassword', __('Please enter password'))
			->add('oldpassword', [
				'mustMatch'=>[
					'rule'=>'verifyOldPass',
					'provider'=>'table',
					'message'=>__('Please enter correct old password'),
					'last'=>true
				]
			])
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			])
			->add('cpassword', [
				'mustMatch'=>[
					'rule'=>'checkForSamePassword',
					'provider'=>'table',
					'message'=>__('Both password must match')
				]
			]);
		return $validator;
	}
	public function validationForChangeUserPassword($validator) {
		$validator
			->notEmpty('password', __('Please enter password'))
			->notEmpty('cpassword', __('Please enter password'))
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			])
			->add('cpassword', [
				'mustMatch'=>[
					'rule'=>'checkForSamePassword',
					'provider'=>'table',
					'message'=>__('Both password must match')
				]
			]);
		return $validator;
	}
	public function validationForForgotPassword($validator) {
		$validator
			->notEmpty('email', __('Please enter email or username'))
			->notEmpty('captcha', __('Please select I\'m not a robot'))
			->add('captcha', [
				'mustMatch'=>[
					'rule'=>'recaptchaValidate',
					'provider'=>'table',
					'message'=>__('Prove you are not a robot')
				]
			]);
		return $validator;
	}
	public function validationForActivatePassword($validator) {
		$validator
			->notEmpty('password', __('Please enter password'))
			->notEmpty('cpassword', __('Please enter password'))
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			])
			->add('cpassword', [
				'mustMatch'=>[
					'rule'=>'checkForSamePassword',
					'provider'=>'table',
					'message'=>__('Both password must match')
				]
			]);
		return $validator;
	}
	public function validationForEmailVerification($validator) {
		$validator
			->notEmpty('email', __('Please enter email or username'))
			->notEmpty('captcha', __('Please select I\'m not a robot'))
			->add('captcha', [
				'mustMatch'=>[
					'rule'=>'recaptchaValidate',
					'provider'=>'table',
					'message'=>__('Prove you are not a robot')
				]
			]);
		return $validator;
	}
	public function validationForMultipleUsers($validator) {
		$validator
			->notEmpty('user_group_id', __('Please select group'))
			->notEmpty('username', __('Please enter username'))
			->notEmpty('first_name', __('Please enter first name'))
			->allowEmpty('last_name')
			->notEmpty('email', __('Please enter email'))
			->notEmpty('password', __('Please enter password'))
			->add('username', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscore',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid username'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This username already exist'),
					'last'=>true
				],
				'uniqueInList'=>[
					'rule'=>'checkExistUsernameInList',
					'provider'=>'table',
					'message'=>__('Duplicate in this list'),
					'last'=>true
				],
				'mustBeLonger'=>[
					'rule'=>['minLength', 4],
					'message'=>__('Username must be greater than 3 characters'),
					'last'=>true
				],
				'mustNotBanned'=>[
					'rule'=>'isBanned',
					'provider'=>'table',
					'message'=>__('This Username is not available'),
					'last'=>true
				]
			])
			->add('first_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid first name'),
					'last'=>true
				]
			])
			->add('last_name', [
				'mustBeValid'=>[
					'rule'=>'alphaNumericDashUnderscoreSpace',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				],
				'mustBeAlpha'=>[
					'rule'=>'alpha',
					'provider'=>'table',
					'message'=>__('Please enter a valid last name'),
					'last'=>true
				]
			])
			->add('email', [
				'validFormat'=>[
					'rule'=>'email',
					'message'=>__('Please enter valid email'),
					'last'=>true
				],
				'unique'=>[
					'rule'=>'validateUnique',
					'provider'=>'table',
					'message'=>__('This email already exist')
				],
				'uniqueInList'=>[
					'rule'=>'checkExistEmailInList',
					'provider'=>'table',
					'message'=>__('Duplicate in this list'),
					'last'=>true
				]
			])
			->add('password', [
				'mustBeLonger'=>[
					'rule'=>['minLength', 6],
					'message'=>__('Password must be greater than 5 characters'),
					'last'=>true
				]
			]);
		return $validator;
	}
	/**
	 * Used to check for password and confirm password
	 *
	 * @access public
	 * @return boolean
	 */
	public function checkForSamePassword($value, $context) {
		if(!empty($value) && $value != $context['data']['password']) {
			return false;
		}
		return true;
	}
	/**
	 * Used to match old password
	 *
	 * @access public
	 * @return boolean
	 */
	public function verifyOldPass($value, $context) {
		$userId = $this->userAuth->getUserId();
		$user = $this->find()->where(['Users.id'=>$userId])->first();
		return ($this->userAuth->checkPassword($value, $user->password));
	}
	/**
	 * Used to check duplicate username in list
	 *
	 * @access public
	 * @return boolean
	 */
	public function checkExistUsernameInList($value, $context) {
		$found = 0;
		foreach($this->multiUsers['Users'] as $key=>$row) {
			if(isset($row['usercheck']) && $row['usercheck']) {
				if(strtolower(trim($row['username'])) == strtolower(trim($value))) {
					$found++;
				}
			}
		}
		if($found > 1) {
			return false;
		}
		return true;
	}
	/**
	 * Used to check duplicate email in list
	 *
	 * @access public
	 * @return boolean
	 */
	public function checkExistEmailInList($value, $context) {
		$found = 0;
		foreach($this->multiUsers['Users'] as $key=>$row) {
			if(isset($row['usercheck']) && $row['usercheck']) {
				if(strtolower(trim($row['email'])) == strtolower(trim($value))) {
					$found++;
				}
			}
		}
		if($found > 1) {
			return false;
		}
		return true;
	}
	/**
	 * Used to validate banned usernames
	 *
	 * @access public
	 * @return boolean
	 */
	public function isBanned($value, $context=null) {
		if(strtolower($value) != 'admin') {
			$bannedUsernames = array_map('trim', explode(',', strtolower(BANNED_USERNAMES)));
			
			if(!empty($bannedUsernames)) {
				if(isset($context['data']['id'])) {
					$oldUsername = $this->getUsernameById($context['data']['id']);
				}
				if(!isset($oldUsername) || $oldUsername != $value) {
					if(in_array(strtolower($value), $bannedUsernames)) {
						return false;
					}
				}
			}

			$usernameTmp = strtolower(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
			
			$list = $this->getAllControllerAndPluginName();
			if(isset($list['Controller'][$usernameTmp])) {
				return false;
			}
			if(isset($list['Plugin'][$usernameTmp])) {
				return false;
			}
			
			$customRoutes = Router::routes();
			$usernameTmp = '/'.strtolower($value);
			
			foreach($customRoutes as $customRoute) {
				if(strpos(strtolower($customRoute->template), $usernameTmp) !== false) {
					return false;
				}
			}
		}
		return true;
	}
	/**
	 * Used to check valid username
	 *
	 * @access public
	 * @return boolean
	 */
	public function isBanned2($value=null) {
		$bannedUsernames = array_map('trim', explode(',', strtolower(BANNED_USERNAMES)));
		
		if(!empty($bannedUsernames)) {
			if(in_array(strtolower($value), $bannedUsernames)) {
				return true;
			}
		}
		
		$usernameTmp = strtolower(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
		
		$list = $this->getAllControllerAndPluginName();
		if(isset($list['Controller'][$usernameTmp])) {
			return true;
		}
		if(isset($list['Plugin'][$usernameTmp])) {
			return true;
		}
		
		$customRoutes = Router::routes();
		$usernameTmp = '/'.strtolower($value);
		
		foreach($customRoutes as $customRoute) {
			if(strpos(strtolower($customRoute->template), $usernameTmp) !== false) {
				return true;
			}
		}
		return false;
	}
	private function getAllControllerAndPluginName() {
		$path = App::path('Controller');
		$dir = new Folder($path[0]);
		$controllers = $dir->findRecursive('.*Controller\.php');
		
		$list = [];
		foreach($controllers as $controller) {
			$tmp = pathinfo($controller);
			$controller = strtolower(str_replace('Controller.php', '', $tmp['basename']));
			$list['Controller'][$controller] = $controller;
		}
		
		$plugins = Plugin::loaded();
		foreach($plugins as $plugin) {
			$path = App::path('Controller', $plugin);
			$dir = new Folder($path[0]);
			$controllers = $dir->findRecursive('.*Controller\.php');
			
			foreach($controllers as $controller) {
				$tmp = pathinfo($controller);
				$controller = strtolower(str_replace('Controller.php', '', $tmp['basename']));
				$list['Controller'][$controller] = $controller;
			}
			
			$plugin = strtolower($plugin);
			$list['Plugin'][$plugin] = $plugin;
		}
		return $list;
	}
	/**
	 * Used to mark cookie used
	 *
	 * @access public
	 * @param string $type
	 * @param string $credentials
	 * @return array
	 */
	public function authsomeLogin($type, $credentials = array()) {
		$loginTokenModel = TableRegistry::getTableLocator()->get('Usermgmt.LoginTokens');
		$loginToken = false;
		
		if(strpos($credentials['token'], ":") !== false) {
			list($token, $userId) = explode(':', $credentials['token']);
			
			$loginToken = $loginTokenModel->find()
				->where(['LoginTokens.user_id'=>$userId, 'LoginTokens.token'=>$token, 'LoginTokens.duration'=>$credentials['duration'], 'LoginTokens.used'=>0, 'LoginTokens.expires >='=>date('Y-m-d H:i:s')])
				->first();
		}
		if(!empty($loginToken)) {
			$loginTokenModel->updateAll(['used'=>1], ['id'=>$loginToken['id']]);
			$user = $this->getUserById($loginToken['user_id']);
			
			if(!empty($user)) {
				$user = $user->toArray();
			}
			return $user;
		}
		return false;
	}
	/**
	 * Used to generate cookie token
	 *
	 * @access public
	 * @param integer $userId user id
	 * @param string $duration cookie persist life time
	 * @return string
	 */
	public function authsomePersist($userId, $duration) {
		$token = md5(uniqid(mt_rand(), true));
		$loginTokenModel = TableRegistry::getTableLocator()->get('Usermgmt.LoginTokens');

		$loginToken = $loginTokenModel->newEntity();
		$loginToken['user_id'] = $userId;
		$loginToken['token'] = $token;
		$loginToken['duration'] = $duration;
		$loginToken['created'] = date('Y-m-d H:i:s');
		$loginToken['expires'] = date('Y-m-d H:i:s', strtotime($duration));

		$loginTokenModel->deleteAll(['user_id'=>$userId]);
		$loginTokenModel->save($loginToken);
		
		return "${token}:${userId}";
	}
	/**
	 * Used to get name by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getNameById($userId) {
		$result = $this->find()
				->select(['Users.first_name', 'Users.last_name'])
				->where(['Users.id'=>$userId])
				->first();
		
		$name = (!empty($result)) ? ($result['first_name'].' '.$result['last_name']) : '';
		return $name;
	}
	/**
	 * Used to get username by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getUsernameById($userId) {
		$result = $this->find()
				->select(['Users.username'])
				->where(['Users.id'=>$userId])
				->first();
		
		$username = (!empty($result)) ? ($result['username']) : '';
		return $username;
	}
	/**
	 * Used to get email by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getEmailById($userId) {
		$result = $this->find()
				->select(['Users.email'])
				->where(['Users.id'=>$userId])
				->first();
		
		$email = (!empty($result)) ? ($result['email']) : '';
		return $email;
	}
	/**
	 * Used to get user by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getUserById($userId) {
		$result = $this->find()
				->where(['Users.id'=>$userId])
				->contain(['UserDetails'])
				->first();
		
		return $result;
	}
	/**
	 * Used to get user by user email
	 *
	 * @access public
	 * @param string $email user email
	 * @return string
	 */
	public function getUserByEmail($email) {
		$result = $this->find()
				->where(['Users.email'=>$email])
				->contain(['UserDetails'])
				->first();
		
		return $result;
	}
	/**
	 * Used to get gender array
	 *
	 * @access public
	 * @param bool $sel true|false
	 * @return array
	 */
	public function getGenders($sel=true) {
		$genders = [];
		if($sel) {
			$genders[''] = __('Select Gender');
		}
		$genders['male'] = __('Male');
		$genders['female'] = __('Female');
		
		return $genders;
	}
	/**
	 * Used to check users by user group id
	 *
	 * @access public
	 * @param integer $userGroupId user group id
	 * @return boolean
	 */
	public function isUserAssociatedWithGroup($userGroupId) {
		$conditions = ['OR'=>[['Users.user_group_id'=>$userGroupId], ['Users.user_group_id like'=>$userGroupId.',%'], ['Users.user_group_id like'=>'%,'.$userGroupId.',%'], ['Users.user_group_id like'=>'%,'.$userGroupId]]];
		
		if($this->exists($conditions)) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get all users with user ids
	 *
	 * @access public
	 * @param array $userIds user ids
	 * @return boolean
	 */
	public function getAllUsersWithUserIds($userIds=null) {
		$users = $cond = [];
		$cond['Users.active'] = 1;
		if(!empty($userIds)) {
			$cond['Users.id IN'] = $userIds;
		}
		
		$result = $this->find()
				->select(['Users.id', 'Users.email', 'Users.first_name', 'Users.last_name'])
				->where($cond)
				->enableHydration(false)
				->toArray();
		
		foreach($result as $row) {
			$users[$row['id']] = $row['first_name'].' '.$row['last_name'].' ('.$row['email'].')';
		}
		return $users;
	}
	/**
	 * Used to generate activation key
	 *
	 * @access public
	 * @param string $string string
	 * @return hash
	 */
	public function getActivationKey($string) {
		return md5(md5($string).Security::getSalt());
	}
	/**
	 * Used to send registration mail to newly created user
	 *
	 * @access public
	 * @param array $userEntity user entity
	 * @return void
	 */
	public function sendRegistrationMail($userEntity) {
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;

		$emailObj = new Email('default');
		$emailObj->setEmailFormat('both');
		$emailObj->setFrom([$fromConfig=>$fromNameConfig]);
		$emailObj->setSender([$fromConfig=>$fromNameConfig]);
		$emailObj->setTo($userEntity['email']);
		$emailObj->setSubject(SITE_NAME.': '.__('Registration is Complete'));
		
		$body = __('Welcome {0},<br/><br/>Thank you for your registration on {1}.<br/><br/>Thanks,<br/>{2}',[$userEntity['first_name'], SITE_URL, SITE_NAME]);
		
		try{
			$emailObj->send($body);
		} catch (Exception $ex) {
		}
	}
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendVerificationMail($userEntity) {
		$userId = $userEntity['id'];
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;

		$emailObj = new Email('default');
		$emailObj->setEmailFormat('both');
		$emailObj->setFrom([$fromConfig=>$fromNameConfig]);
		$emailObj->setSender([$fromConfig=>$fromNameConfig]);
		$emailObj->setTo($userEntity['email']);
		$emailObj->setSubject(SITE_NAME.': '.__('Contact Email Confirmation'));
		
		$activate_key = $this->getActivationKey($userEntity['email'].$userEntity['password']);
		$link = Router::url("/userVerification?ident=$userId&activate=$activate_key", true);
		$link = '<a href="'.$link.'">'.$link.'</a>';
		
		$body = __('Hey {0}, <br/><br/>You recently entered a contact email address. To confirm your contact email, follow the link below: <br/><br/>{1}<br/><br/>If clicking on the link doesn\'t work, try copying and pasting it into your browser.<br/><br/>Thanks,<br/>{2}', [$userEntity['first_name'], $link, SITE_NAME]);
		
		try {
			$emailObj->send($body);
		} catch (Exception $ex) {
		}
	}
	/**
	 * Used to send forgot password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function sendForgotPasswordMail($userEntity) {
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;

		$userId = $userEntity['id'];
		$emailObj = new Email('default');
		$emailObj->setEmailFormat('both');
		$emailObj->setFrom([$fromConfig=>$fromNameConfig]);
		$emailObj->setSender([$fromConfig=>$fromNameConfig]);
		$emailObj->setTo($userEntity['email']);
		$emailObj->setSubject(SITE_NAME.': '.__('Request to Reset Your Password'));
		
		$activate_key = $this->getActivationKey($userEntity['email'].$userEntity['password']);
		$link = Router::url("/activatePassword?ident=$userId&activate=$activate_key", true);
		$link = '<a href="'.$link.'">'.$link.'</a>';
		
		$body =__('Welcome {0},<br/><br/>You have requested to have your password reset on {1}. Please click the link below to reset your password now: <br/><br/>{2}<br/><br/>If clicking on the link doesn\'t work, try copying and pasting it into your browser.<br/><br/>Thanks,<br/>{3}', [$userEntity['first_name'], SITE_NAME, $link, SITE_NAME]);
		
		try {
			$emailObj->send($body);
		} catch (Exception $ex) {

		}
	}
	/**
	 * Used to send change password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function sendChangePasswordMail($userEntity) {
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;

		$emailObj = new Email('default');
		$emailObj->setEmailFormat('both');
		$emailObj->setFrom([$fromConfig=>$fromNameConfig]);
		$emailObj->setSender([$fromConfig=>$fromNameConfig]);
		$emailObj->setTo($userEntity['email']);
		$emailObj->setSubject(SITE_NAME.': '.__('Change Password Confirmation'));
		
		$datetime = date('Y M d h:i:s', time());
		
		$body = __('Hey {0},<br/><br/>You recently changed your password on {1}.<br/><br/>As a security precaution, this notification has been sent to your email addresse associated with your account.<br/><br/>Thanks,<br/>{2}', [$userEntity['first_name'], $datetime, SITE_NAME]);
		
		try{
			$emailObj->send($body);
		} catch (Exception $ex){
		}
	}
}