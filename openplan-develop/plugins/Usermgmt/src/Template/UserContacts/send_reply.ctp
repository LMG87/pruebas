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
			<?php echo __('Send Reply to').' '.$name;?>
		</span>
		<span class="card-title float-right">
			<?php $page = ($this->request->getQuery('page')) ? $this->request->getQuery('page') : 1;?>
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index', 'page'=>$page], ['class'=>'btn btn-secondary btn-sm']);?>
		</span>
	</div>
	<div class="card-body">
		<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'sendMailForm', 'submitButtonId'=>'sendMailSubmitBtn']);?>
		<?php echo $this->Form->create($userEmailEntity, ['id'=>'sendMailForm']);?>

		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('To');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.to', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('CC To');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.cc_to', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
				<span class='tagline'><?php echo __('multiple emails comma separated');?></span>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('From Name');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.from_name', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('From Email');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.from_email', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Select Template');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.template', ['type'=>'select', 'options'=>$templates, 'label'=>false, 'autocomplete'=>'off', 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label"><?php echo __('Select Signature');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.signature', ['type'=>'select', 'options'=>$signatures, 'label'=>false, 'autocomplete'=>'off', 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Subject');?></label>
			<div class="col-md-5">
				<?php echo $this->Form->control('UserEmails.subject', ['type'=>'text', 'label'=>false, 'class'=>'form-control']);?>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-2 col-form-label required"><?php echo __('Message');?></label>
			<div class="col-md-8">
				<?php
				if(strtoupper(DEFAULT_HTML_EDITOR) == 'TINYMCE') {
					echo $this->Tinymce->textarea('UserEmails.message', ['type'=>'textarea', 'label'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en'], 'umcode');
				} else if(strtoupper(DEFAULT_HTML_EDITOR) == 'CKEDITOR') {
					echo $this->Ckeditor->textarea('UserEmails.message', ['type'=>'textarea', 'label'=>false, 'style'=>'height:400px', 'class'=>'form-control'], ['language'=>'en', 'uiColor'=>'#14B8C4'], 'full');
				}?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit(__('Next'), ['class'=>'btn btn-primary', 'id'=>'sendMailSubmitBtn']);?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>