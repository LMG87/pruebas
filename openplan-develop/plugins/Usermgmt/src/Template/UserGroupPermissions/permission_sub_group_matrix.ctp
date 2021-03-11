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
<script type="text/javascript">
	$(function(){
		$('.contcheckall').change(function() {
			if($(this).is(':checked')) {
				$(".contcheck").prop("checked", true);
			} else {
				$(".contcheck").prop("checked", false);
			}
		});
		$('.grpcheckall').change(function() {
			if($(this).is(':checked')) {
				$(".grpcheck").prop("checked", true);
			} else {
				$(".grpcheck").prop("checked", false);
			}
		});
		$('#perOptions').click(function() {
			$('#perOptionsDetails').slideToggle();
		});
	});
	function validateForm() {
		if(!$(".contcheck").is(':checked')) {
			alert("<?php echo __('Please select atleast one controller to get permissions');?>");
			return false;
		} else {
		}
		return true;
	}
</script>
<style type="text/css">
	.input.checkbox {
		margin:0;
	}
	.input.checkbox input {
		margin:0;
		position:relative;
	}
</style>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Sub Group Permissions Matrix');?>
		</span>
		<span class="card-title float-right">
			<?php echo "<a id='perOptions' href='javascript:void(0)' class='btn btn-secondary btn-sm'>Choose Options</a>";?>
		</span>
		<span class="card-title float-right mr-2">
			<div id='per_loading_text' style='color:red;text-decoration: blink;'><?php echo __('Please wait while page is loading...');?></div>
		</span>
	</div>
	<div class="card-body p-0">
		<div style='padding:10px'>
			<?php echo $this->Html->image(SITE_URL.'usermgmt/img/approve.png', ['alt'=>__('Yes')]);?> = <?php echo __("The sub group has permission of controller's action");?><br/><?php echo $this->Html->image(SITE_URL.'usermgmt/img/remove.png', ['alt'=>__('No')]);?> = <?php echo __("The sub group has not permission of controller's action");?><br/><span style='color:green'>(<?php echo __('inherit');?>)</span> = <?php echo __('Permission inherited from parent group');?>
		</div>
		<div style="padding:10px; display:<?php if(!empty($selectedControllers)) { echo 'none'; } ?>" id="perOptionsDetails">
			<?php echo $this->Form->create($userGroupPermissionEntity, ['onSubmit'=>'return validateForm()']);?>
			<div style="float:left">
				<table class="table table-striped table-bordered table-sm table-hover">
					<thead>
						<tr>
							<th><?php
								$checked = false;
								if(!empty($userGroupPermissionEntity['sel_cont_all'])) {
									$checked = true;
								}
								echo $this->Form->control('UserGroupPermissions.sel_cont_all', ['type'=>'checkbox', 'label'=>false, 'checked'=>$checked, 'class'=>'contcheckall']);?>
							</th>
							<th><?php echo __('Prefix');?></th>
							<th><?php echo __('Plugin');?></th>
							<th><?php echo __('Controller');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($allControllerClasses)) {
							foreach($allControllerClasses as $key=>$controllerClass) {
								$ppc = $controllerClass['prefix'].":".$controllerClass['plugin'].":".$controllerClass['controller'];
								$checked = false;
								if(!empty($selectedControllers[$ppc])) {
									$checked = true;
								}
								echo "<tr>";
									echo "<td>";
										echo $this->Form->control('UserGroupPermissions.ControllerList.'.$key.'.name', ['type'=>'checkbox', 'label'=>false, 'hiddenField'=>false, 'checked'=>$checked, 'class'=>'contcheck', 'value'=>$ppc]);
									echo "</td>";
									echo "<td>".str_replace('.', '/', $controllerClass['prefix'])."</td>";
									echo "<td>".$controllerClass['plugin']."</td>";
									echo "<td>".$controllerClass['controller']."</td>";
								echo "</tr>";
							}
						}?>
					</tbody>
				</table>
			</div>
			<div style="float:left">
				<table class="table table-striped table-bordered table-sm table-hover">
					<thead>
						<tr>
							<th><?php
								$checked = false;
								if(!empty($userGroupPermissionEntity['sel_grp_all']) || (count($userGroups) && count($userGroups) == count($selectedUserGroups))) {
									$checked = true;
								}
								echo $this->Form->control('UserGroupPermissions.sel_grp_all', ['type'=>'checkbox', 'label'=>false, 'checked'=>$checked, 'class'=>'grpcheckall']);?>
							</th>
							<th><?php echo __('Sub Group');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($userGroups)) {
							foreach($userGroups as $group) {
								$checked = false;
								if(!empty($selectedUserGroupIds[$group['id']])) {
									$checked = true;
								}
								echo "<tr>";
									echo "<td>";
										echo $this->Form->control('UserGroupPermissions.GroupList.'.$group['id'].'.grpcheck', ['type'=>'checkbox', 'label'=>false, 'hiddenField'=>false, 'checked'=>$checked, 'class'=>'grpcheck']);
									echo "</td>";
									echo "<td>".$group['name']."</td>";
								echo "</tr>";
							}
						}?>
					</tbody>
				</table>
			</div>
			<div style="float:left">
				<?php echo $this->Form->Submit(__('Get Permissions'), ['class'=>'btn btn-primary']);?>
			</div>
			<div class="clearfix"></div>
			<?php echo $this->Form->end();?>
		</div>
		<?php if(!empty($selectedControllers)) {?>
			<table class="table table-striped table-bordered table-sm table-hover groupMatrix" style='width:auto'>
				<thead>
					<tr id='per_float_header' style='background-color:#CACACA'>
						<th><div style='width:100px'><?php echo __('Prefix');?></div></th>
						<th><div style='width:100px'><?php echo __('Plugin');?></div></th>
						<th><div style='width:100px'><?php echo __('Controller');?></div></th>
						<th><div style='width:130px'><?php echo __('Action');?></div></th>
						<?php foreach($selectedUserGroups as $group) {
							echo "<th style='padding:0;text-align:center;'><div class='break-word' style='width:65px'>".$group['name']."</div></th>";
						}?>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($selectedControllers as $key=>$row) {
						$ppc = $row['prefix'].':'.$row['plugin'].':'.$row['controller'];
						$plugin = ($row['plugin']) ? $row['plugin'] : 'false';
						$prefix = ($row['prefix']) ? $row['prefix'] : 'false';

						if(!empty($row['actions'])) {
							foreach($row['actions'] as $action) {
								echo "<tr>";
									echo "<td><div class='break-word' style='width:100px'>".str_replace('.', '/', $row['prefix'])."</div></td>";
									echo "<td><div class='break-word' style='width:100px'>".$row['plugin']."</div></td>";
									echo "<td><div class='break-word' style='width:100px'>".$row['controller']."</div></td>";
									echo "<td><div class='break-word' style='width:130px'>".$action;
										if(!empty($funcDesc[$ppc][$action])) {
											echo "<br/><span style='color:red;font-size:10px;font-style:italic'>".$funcDesc[$ppc][$action]."</span>";
										}
									echo "</div></td>";
									foreach($selectedUserGroups as $group) {
										echo "<td style='text-align:center;padding:5px' class='permission'><div style='width:60px;height:35px'>";
											$inherit = '';
											if(isset($dbPermissions[$ppc][$action][$group['id']]) && $dbPermissions[$ppc][$action][$group['id']] == 1) {
												$img = $this->Html->image(SITE_URL.'usermgmt/img/approve.png', ['alt'=>__('Yes')]);
											} else if(isset($dbPermissions[$ppc][$action][$group['id']]) && $dbPermissions[$ppc][$action][$group['id']] == 0) {
												$img = $this->Html->image(SITE_URL.'usermgmt/img/remove.png', ['alt'=>__('No')]);
											} else {
												$inherit = '(Inherit)';
												if(isset($parentPermissions[$ppc][$action][$group['parent_id']]) && $parentPermissions[$ppc][$action][$group['parent_id']] == 1) {
													$img = $this->Html->image(SITE_URL.'usermgmt/img/approve.png', ['alt'=>__('Yes')]);
												} else {
													$img = $this->Html->image(SITE_URL.'usermgmt/img/remove.png', ['alt'=>__('No')]);
												}
											}
											echo $this->Html->link($img, ['action'=>'changePermission', $row['controller'], $action, $group['id'], $plugin, $prefix], ['escape'=>false, 'class'=>'changePermission', 'title'=>$group['name'].' (Click to change permission)']);
											echo " <span style='color:green' class='permissionType'>".$inherit."</span><br/>";
										echo "</div></td>";
									}
								echo "</tr>";
							}
						}
						if(!empty($actions)) {
							echo "<tr><td colspan='".(count($selectedUserGroups) + 3)."'><br/></td></tr>";
						}
					}?>
				</tbody>
			</table>
		<?php }?>
	</div>
</div>