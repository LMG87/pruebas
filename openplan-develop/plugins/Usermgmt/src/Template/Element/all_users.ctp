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
<div id="updateUsersIndex">
	<?php echo $this->Search->searchForm('Users', ['legend'=>false, 'updateDivId'=>'updateUsersIndex']);?>
	<?php echo $this->element('Usermgmt.paginator', ['updateDivId'=>'updateUsersIndex']);?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm table-hover">
			<thead>
				<tr>
					<th><?php echo __('#');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.id', __('User Id'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.first_name', __('Name'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.username', __('Username'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.email', __('Email'));?></th>
					<th><?php echo __('Groups(s)');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.email_verified', __('Email Verified'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.active', __('Status'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.created', __('Created'));?></th>
					<th><?php echo __('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($users)) {
					$params = $this->request->getParam('paging');
					$page = $params['Users']['page'];
					$limit = $params['Users']['perPage'];
					$i = ($page-1) * $limit;

					foreach($users as $row) {
						$i++;
						echo "<tr>";
							echo "<td>".$i."</td>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".h($row['first_name']).' '.h($row['last_name'])."</td>";
							echo "<td>".h($row['username'])."</td>";
							echo "<td>".h($row['email'])."</td>";
							echo "<td>".$row['user_group_name']."</td>";
							echo "<td>";
								if($row['email_verified']) {
									echo "<span class='badge badge-success'>".__('Yes')."</span>";
								} else {
									echo "<span class='badge badge-danger'>".__('No')."</span>";
								}
							echo"</td>";
							echo "<td>";
								if($row['active']) {
									echo "<span class='badge badge-success'>".__('Active')."</span>";
								} else {
									echo "<span class='badge badge-danger'>".__('Inactive')."</span>";
								}
							echo"</td>";
							echo "<td>".$row['created']->format('d-M-Y')."</td>";
							echo "<td>";
								echo "<div class='dropdown'>";
									echo "<button class='btn btn-primary btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".__('Action')."</button>";
									
									echo "<div class='dropdown-menu dropdown-menu-right'>";
										echo $this->Html->link(__('View User'), ['controller'=>'Users', 'action'=>'viewUser', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);

										echo $this->Html->link(__('Edit User'), ['controller'=>'Users', 'action'=>'editUser', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);

										echo $this->Html->link(__('Change Password'), ['controller'=>'Users', 'action'=>'changeUserPassword', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);

										if($row['id'] != 1 && strtolower($row['username']) != 'admin') {
											if($row['active']) {
												echo $this->Form->postLink(__('Inactivate'), ['controller'=>'Users', 'action'=>'setInactive', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item', 'confirm'=>__('Are you sure you want to inactivate this user?')]);
											} else {
												echo $this->Form->postLink(__('Activate'), ['controller'=>'Users', 'action'=>'setActive', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item', 'confirm'=>__('Are you sure you want to activate this user?')]);
											}
											if(!$row['email_verified']) {
												echo $this->Form->postLink(__('Verify Email'), ['action'=>'verifyEmail', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item', 'confirm'=>__('Are you sure you want to verify email of this user?')]);
											}
											echo $this->Form->postLink(__('Delete User'), ['controller'=>'Users', 'action'=>'deleteUser', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item', 'confirm'=>__('Are you sure you want to delete this user?')]);
										}
										echo $this->Html->link(__('View Permissions'), ['controller'=>'Users', 'action'=>'viewUserPermissions', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);
										
										echo $this->Html->link(__('Send Mail'), ['controller'=>'UserEmails', 'action'=>'sendToUser', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);
									echo "</div>";
								echo "</div>";
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=10><br/><br/>".__('No Records Available')."</td></tr>";
				}?>
			</tbody>
		</table>
	</div>
	<?php if(!empty($users)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Users')]);
	}?>
</div>