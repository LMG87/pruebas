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
$(document).ready(function(e) {
	if($.fn.chosen) {
		$("#users-user-group-id").chosen();
	}
});
</script>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Edit User');?>
		</span>
		<span class="card-title float-right">
			<?php $page = ($this->request->getQuery('page')) ? $this->request->getQuery('page') : 1;?>
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index', 'page'=>$page], ['class'=>'btn btn-secondary btn-sm']);?>
		</span>
	</div>
	<div class="card-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'editUserForm', 'submitButtonId'=>'editUserSubmitBtn']);?>
		<?php echo $this->Form->create($userEntity, ['id'=>'editUserForm', 'type'=>'file']);?>

		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Group');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.user_group_id', ['type'=>'select', 'label'=>false, 'multiple'=>true, 'class'=>'form-control', 'data-placeholder'=>'Select Group(s)']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Username');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.username', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('First Name');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.first_name', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Last Name');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.last_name', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Email');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.email', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Gender');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.gender', ['type'=>'radio', 'label'=>false, 'options'=>$genders, 'class'=>'mx-2']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Birthday');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.bday', ['type'=>'text', 'label'=>false, 'class'=>'form-control datepicker']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Photo');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.photo_file', ['type'=>'file', 'label'=>false]);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Location');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.user_detail.location', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Cellphone');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('Users.user_detail.cellphone', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Edit User'), ['class'=>'btn btn-primary', 'id'=>'editUserSubmitBtn']);?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>