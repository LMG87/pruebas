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
<div class="row">
	<div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">
		<div class="card wow fadeIn" data-wow-delay="0.3s">
			<?php /* ?>
			<div class="card-header">
				<span class="card-title">
					<?php echo __('Sign In');?>
				</span>
				<?php if(SITE_REGISTRATION) {?>
				<span class="card-title float-right">
					<?php echo $this->Html->link(__('Sign Up', true), ['controller'=>'Users', 'action'=>'register', 'plugin'=>'Usermgmt'], ['class'=>'btn btn-secondary btn-sm']);?>
				</span>
				<?php }?>
			</div>
			<?php */ ?>
			<div class="card-body">
				<?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'loginForm', 'submitButtonId'=>'loginSubmitBtn']);?>
				<?php echo $this->Form->create($userEntity, ['id'=>'loginForm']);?>
				<div class="form-header purple-gradient">
                    <h3><i class="fa fa-user mt-2 mb-2"></i> Iniciar sesión:</h3>
                </div>
                <div class="md-form required">
                    <i class="fa fa-user prefix white-text"></i>
                    <?php echo $this->Form->text('Users.email', ['class' => 'form-control', 'id'=>'users-email']); ?>
                    <label for="users-email"><?php echo __('Email / Username');?></label>
                </div>
                <div class="md-form required">
                    <i class="fa fa-lock prefix white-text"></i>
                    <?php echo $this->Form->password('Users.password', ['class' => 'form-control', 'id'=>'users-password']); ?>
                    <label for="users-password"><?php echo __('Password');?></label>
                </div>
                <?php if(USE_REMEMBER_ME) {?>
                <div class="md-form">
                	<?php if(!isset($userEntity['remember'])) {
                			$userEntity['remember'] = false;
                		}?>
                    <div class="form-check">
                        <?php echo $this->Form->checkbox('Users.remember', ['value' => '1','hiddenField' => true,'class' => 'form-check-input','id' => 'remember']); ?>
                        <label class="form-check-label" for="remember"><?php echo __('Remember me');?></label>
                    </div>
                </div>
                <?php }?>
				

				<?php
				if($this->UserAuth->canUseRecaptha('login')) {
					$errors = $userEntity->getErrors();
					$error = "";
					if(isset($errors['captcha']['_empty'])) {
						$error = $errors['captcha']['_empty'];
					} else if(isset($errors['captcha']['mustMatch'])) {
						$error = $errors['captcha']['mustMatch'];
					}?>
					<div class="row form-group">
						<label class="col-md-4 col-form-label required"><?php echo __('Prove you\'re not a robot');?></label>
						<div class="col-md-8">
							<?php echo $this->UserAuth->showCaptcha($error);?>
						</div>
					</div>
				<?php
				}?>
				<div class="text-center">
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->Submit(__('Sign In'), ['class'=>'btn blue-gradient btn-lg', 'id'=>'loginSubmitBtn']);?>
						</div>
						<div class="col-sm-6">
							<?php if(SITE_REGISTRATION) {
								echo $this->Html->link(__('Sign Up', true), ['controller'=>'Users', 'action'=>'register', 'plugin'=>'Usermgmt'], ['class'=>'btn purple-gradient btn-lg']);
							}?>							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Html->link(__('Forgot Password?'), '/forgotPassword', ['class'=>'btn btn-outline-warning btn-sm']);?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Html->link(__('Email Verification'), '/emailVerification', ['class'=>'btn btn-outline-warning btn-sm']);?>
						</div>
					</div>	
					<?php /* ?>		    
				    <hr>
				    <div class="inline-ul text-center d-flex justify-content-center">
				        <a class="icons-sm tw-ic"><i class="fa fa-twitter white-text"></i></a>
				        <a class="icons-sm li-ic"><i class="fa fa-linkedin white-text"> </i></a>
				        <a class="icons-sm ins-ic"><i class="fa fa-instagram white-text"> </i></a>
				    </div>
				    <?php */ ?>
				</div>
			</div>
				<?php echo $this->Form->end();?>
				<?php echo $this->element('Usermgmt.provider');?>
		</div>
	</div>
</div>