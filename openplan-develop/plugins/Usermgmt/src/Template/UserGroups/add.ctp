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
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Add Group');?>
		</span>
		<span class="card-title float-right">
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index'], ['class'=>'btn btn-secondary btn-sm']);?>
		</span>
	</div>
	<div class="card-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'addUserGroupForm', 'submitButtonId'=>'addUserGroupSubmitBtn']);?>
		<?php echo $this->Form->create($userGroupEntity, ['id'=>'addUserGroupForm', 'novalidate'=>true]);?>

		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Group Name');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('UserGroups.name', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
				<span class='tagline'><?php echo __('for ex. Business User');?></span>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Parent Group');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('UserGroups.parent_id', ['type'=>'select', 'options'=>$parentGroups, 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Description');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('UserGroups.description', ['type'=>'textarea', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Allow Registration');?></label>
			<div class="col-md-4">
				<?php echo $this->Form->control('UserGroups.registration_allowed', ['type'=>'checkbox', 'label'=>false, 'autocomplete'=>'off', 'default'=>false, 'style'=>'margin-left:0px;']);?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Save'), ['class'=>'btn btn-primary', 'id'=>'addUserGroupSubmitBtn']);?>
		</div>
		<?php echo $this->Form->end();?>
		<div style='padding:5px'>
			<?php echo __('Note: If you add a new group then you should assign permissions to this newly created Group.');?>
		</div>
	</div>
</div>