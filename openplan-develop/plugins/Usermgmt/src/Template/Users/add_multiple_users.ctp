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
<style type="text/css">
	form {
		width:100%
	}
	input, textarea,select {
		font-size: 100%;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('.usercheckall').change(function() {
			if($(this).is(':checked')) {
				$(".usercheck").prop("checked", true);
			} else {
				$(".usercheck").prop("checked", false);
			}
		});
		if($.fn.chosen) {
			$(".ugroup").chosen();
		}
	});
	function validateForm() {
		if(!$(".usercheck").is(':checked')) {
			alert("<?php echo __('Please select atleast one user to add');?>");
			return false;
		}
		return true;
	}
</script>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Add Multiple Users' , true);?>
		</span>
		<span class="card-title float-right">
			<?php echo $this->Html->link(__('Back', true), ['action'=>'uploadCsv'], ['class'=>'btn btn-secondary btn-sm']);?>
		</span>
	</div>
	<div class="card-body p-0">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'addMultipleUserForm', 'submitButtonId'=>'addMultipleUserSubmitBtn']);?>
		<?php echo $this->Form->create($userEntities, ['id'=>'addMultipleUserForm', 'onSubmit'=>'return validateForm()']);?>

		<div style='padding:15px'><strong><?php echo __('Please Note: Unchecked rows will not be saved in database.');?></strong></div>

		<div class="table-responsive">
			<table class="table table-striped table-bordered table-sm table-hover">
				<thead>
					<tr>
						<th><?php echo $this->Form->control('Select.all', ['type'=>'checkbox', 'label'=>false, 'class'=>'usercheckall', 'autocomplete'=>'off', 'style'=>'margin-left:0px;position:relative;']);?></th>
						<th><?php echo __('User Group');?></th>
						<th><?php echo __('First Name');?></th>
						<th><?php echo __('Last Name');?></th>
						<th><?php echo __('Username');?></th>
						<th><?php echo __('Email');?></th>
						<th><?php echo __('Password');?></th>
						<th><?php echo __('Gender');?></th>
						<th><?php echo __('Birthday');?></th>
						<th><?php echo __('Location');?></th>
						<th><?php echo __('Cellphone');?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($users)) {
						foreach($users as $i=>$user) {?>
							<tr>
								<td style='text-align:left'>
									<?php echo $this->Form->control('Users.'.$i.'.usercheck', ['type'=>'checkbox', 'label'=>false, 'class'=>'usercheck', 'hiddenField'=>false, 'autocomplete'=>'off', 'style'=>'margin-left:0px']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.user_group_id', ['type'=>'select', 'options'=>$userGroups, 'multiple'=>true, 'label'=>false, 'data-placeholder'=>'Select Group(s)', 'class'=>'ugroup form-control', 'style'=>'width:100px']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.first_name', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.last_name', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.username', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.email', ['type'=>'text', 'label'=>false, 'style'=>'width:200px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.password', ['type'=>'text', 'label'=>false, 'type'=>'text', 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.gender', ['type'=>'select', 'options'=>$genders, 'label'=>false, 'style'=>'width:85px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.bday', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'datepicker form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.user_detail.location', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
								<td>
									<?php echo $this->Form->control('Users.'.$i.'.user_detail.cellphone', ['type'=>'text', 'label'=>false, 'style'=>'width:100px', 'class'=>'form-control']);?>
								</td>
							</tr>
						<?php
						}
					}?>
				</tbody>
			</table>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Add Users'), ['class'=>'btn btn-primary', 'id'=>'addMultipleUserSubmitBtn']);?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>