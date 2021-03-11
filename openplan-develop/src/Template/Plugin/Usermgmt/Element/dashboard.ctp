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
use Cake\Utility\Inflector;
$actionUrl = Inflector::camelize($this->request->getParam('controller')).'/'.$this->request->getParam('action');
$activeClass = 'active';
$inactiveClass = '';
?>
<div class="dashboard-menu">
	<nav class="navbar navbar-expand-lg navbar-dark ">
		<?php echo $this->Html->link(__('Dashboard'), ['controller'=>'Users', 'action'=>'dashboard', 'plugin'=>'Usermgmt'], ['class'=>'navbar-brand']);?>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class='navbar-nav'>
				<?php
				if($this->UserAuth->isLogged()) {
					if($this->UserAuth->isAdmin()) {
						echo "<li class='nav-item dropdown'>";
							echo $this->Html->link(__('Users'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
							
							echo "<div class='dropdown-menu'>";
								if($this->UserAuth->HP('Users', 'addUser', 'Usermgmt')) {
									$activecls = ($actionUrl == 'Users/addUser') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Add User'), ['controller'=>'Users', 'action'=>'addUser', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('Users', 'addMultipleUsers', 'Usermgmt')) {
									$activecls = ($actionUrl == 'Users/addMultipleUsers') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Add Multiple Users'), ['controller'=>'Users', 'action'=>'addMultipleUsers', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('Users', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'Users/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('All Users'), ['controller'=>'Users', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('Users', 'online', 'Usermgmt')) {
									$activecls = ($actionUrl == 'Users/online') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Online Users'), ['controller'=>'Users', 'action'=>'online', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
							echo "</div>";
						echo "</li>";

						echo "<li class='nav-item dropdown'>";
							echo $this->Html->link(__('Groups'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
							
							echo "<div class='dropdown-menu'>";
								if($this->UserAuth->HP('UserGroups', 'add', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserGroups/add') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Add Group'), ['controller'=>'UserGroups', 'action'=>'add', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserGroups', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserGroups/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('All Groups'), ['controller'=>'UserGroups', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
							echo "</div>";
						echo "</li>";

						echo "<li class='nav-item dropdown'>";
							echo $this->Html->link(__('Admin'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
							
							echo "<div class='dropdown-menu'>";
								if($this->UserAuth->HP('UserGroupPermissions', 'permissionGroupMatrix', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserGroupPermissions/permissionGroupMatrix') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Group Permissions'), ['controller'=>'UserGroupPermissions', 'action'=>'permissionGroupMatrix', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserGroupPermissions', 'permissionSubGroupMatrix', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserGroupPermissions/permissionSubGroupMatrix') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Subgroup Permissions'), ['controller'=>'UserGroupPermissions', 'action'=>'permissionSubGroupMatrix', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserSettings', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserSettings/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('All Settings'), ['controller'=>'UserSettings', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserSettings', 'cakelog', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserSettings/cakelog') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Cake Logs'), ['controller'=>'UserSettings', 'action'=>'cakelog', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('Users', 'deleteCache', 'Usermgmt')) {
									echo $this->Html->link(__('Delete Cache'), ['controller'=>'Users', 'action'=>'deleteCache', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item']);
								}
							echo "</div>";
						echo "</li>";

						echo "<li class='nav-item dropdown'>";
							echo $this->Html->link(__('Email'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
							
							echo "<div class='dropdown-menu'>";
								if($this->UserAuth->HP('UserEmails', 'send', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserEmails/send') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Send Email'), ['controller'=>'UserEmails', 'action'=>'send', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserEmails', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserEmails/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('View Sent Emails'), ['controller'=>'UserEmails', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('ScheduledEmails', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'ScheduledEmails/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Scheduled Emails'), ['controller'=>'ScheduledEmails', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserContacts', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserContacts/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Contact Enquiries'), ['controller'=>'UserContacts', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserEmailTemplates', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserEmailTemplates/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Email Templates'), ['controller'=>'UserEmailTemplates', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('UserEmailSignatures', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'UserEmailSignatures/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Email Signatures'), ['controller'=>'UserEmailSignatures', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
							echo "</div>";
						echo "</li>";

						echo "<li class='nav-item dropdown'>";
							echo $this->Html->link(__('Pages'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
							
							echo "<div class='dropdown-menu'>";
								if($this->UserAuth->HP('StaticPages', 'add', 'Usermgmt')) {
									$activecls = ($actionUrl == 'StaticPages/add') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('Add Page'), ['controller'=>'StaticPages', 'action'=>'add', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
								if($this->UserAuth->HP('StaticPages', 'index', 'Usermgmt')) {
									$activecls = ($actionUrl == 'StaticPages/index') ? $activeClass : $inactiveClass;

									echo $this->Html->link(__('All Pages'), ['controller'=>'StaticPages', 'action'=>'index', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
								}
							echo "</div>";
						echo "</li>";
					}

					echo "<li class='nav-item dropdown'>";
						echo $this->Html->link(__('My Account'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle text-white', 'data-toggle'=>'dropdown']);
						
						echo "<div class='dropdown-menu'>";
							if($this->UserAuth->HP('Users', 'myprofile', 'Usermgmt')) {
								$activecls = ($actionUrl == 'Users/myprofile') ? $activeClass : $inactiveClass;

								echo $this->Html->link(__('My Profile'), ['controller'=>'Users', 'action'=>'myprofile', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
							}
							if($this->UserAuth->HP('Users', 'editProfile', 'Usermgmt')) {
								$activecls = ($actionUrl == 'Users/editProfile') ? $activeClass : $inactiveClass;

								echo $this->Html->link(__('Edit Profile'), ['controller'=>'Users', 'action'=>'editProfile', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
							}
							if($this->UserAuth->HP('Users', 'changePassword', 'Usermgmt')) {
								$activecls = ($actionUrl == 'Users/changePassword') ? $activeClass : $inactiveClass;

								echo $this->Html->link(__('Change Password'), ['controller'=>'Users', 'action'=>'changePassword', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
							}
							if($this->UserAuth->HP('Users', 'deleteAccount', 'Usermgmt') && ALLOW_DELETE_ACCOUNT && !$this->UserAuth->isAdmin()) {
								echo $this->Form->postLink(__('Delete Account'), ['controller'=>'Users', 'action'=>'deleteAccount', 'plugin'=>'Usermgmt'], ['escape'=>false, 'confirm'=>__('Are you sure you want to delete your account?')]);
							}
						echo "</div>";
					echo "</li>";
				}

				$activecls = ($actionUrl == 'UserContacts/contactUs') ? $activeClass : $inactiveClass;
				echo "<li class='nav-item ".$activecls."'>".$this->Html->link(__('Contact Us'), '/contactUs', ['class'=>'nav-link text-white'])."</li>";

				if($this->UserAuth->isLogged()) {
					echo "<li class='nav-item'>".$this->Html->link(__('Sign Out'), ['controller'=>'Users', 'action'=>'logout', 'plugin'=>'Usermgmt'], ['class'=>'nav-link text-white'])."</li>";
				} else {
					$activecls = ($actionUrl == 'Users/login') ? $activeClass : $inactiveClass;
					echo "<li class='nav-item ".$activecls."'>".$this->Html->link(__('Sign In'), ['controller'=>'Users', 'action'=>'login', 'plugin'=>'Usermgmt'], ['class'=>'nav-link text-white'])."</li>";
				}?>
			</ul>
		</div>
	</nav>
</div>