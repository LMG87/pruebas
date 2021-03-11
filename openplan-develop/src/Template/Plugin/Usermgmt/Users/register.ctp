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
<!--Grid row-->
<div class="row  pt-5 mt-5">

    <!--Grid column-->
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-body">
                
                <h2 class="feature-title text-center mb-5 mt-4 font-bold"><strong>REGISTER</strong></h2>
                <hr>
                
                <!--Grid row-->
                <div class="row mt-5">
                
                    <!--Grid column-->
                    <div class="col-md-6 ml-lg-5 ml-md-3 features-small">
            
                        <!--Grid row-->
                        <div class="row pb-4">
                            <div class="col-2 col-lg-1">
                                <i class="fa fa-bank indigo-text fa-lg"></i>
                            </div>
                            <div class="col-10">
                                <h4 class="feature-title"><strong>Safety</strong></h4>
                                <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti hic.</p>
                            </div>
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row pb-4">
                            <div class="col-2 col-lg-1">
                                <i class="fa fa-desktop deep-purple-text fa-lg"></i>
                            </div>
                            <div class="col-10">
                                <h4 class="feature-title"><strong>Technology</strong></h4>
                                <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti hic.</p>
                            </div>
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row pb-4">
                            <div class="col-2 col-lg-1">
                                <i class="fa fa-money purple-text fa-lg"></i>
                            </div>
                            <div class="col-10">
                                <h4 class="feature-title"><strong>Finance</strong></h4>
                                <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti hic.</p>
                            </div>
                        </div>
                        <!--Grid row-->
                
                    </div>
                    <!--Grid column-->
                
                    <!--Grid column-->
                    <div class="col-md-5">
                        
                        <!--Grid row-->
                        <div class="row pb-4 d-flex justify-content-center mb-4">
                        
                        <h4 class="mt-3 mr-4"><strong>Login with</strong></h4>
                                                    
                        </div>
                        <!--/Grid row-->
                    
                        <!--Body-->
                        <?php echo $this->element('Usermgmt.ajax_validation', ['formId'=>'registerForm', 'submitButtonId'=>'registerSubmitBtn']);?>
                        <?php //print_r($userEntity); ?>
                        <?php echo $this->Form->create(null, ['url' => ['controller' => 'users', 'action' => 'register','plugin' => false], 'id'=>'registerForm', 'novalidate'=>true]);?>
                          
                        <div class="md-form required">
                            <i class="fa fa-user prefix black-text"></i>
                            <?php echo $this->Form->text('Users.username', ['class' => 'form-control', 'id'=>'users-username']); ?>
                            <label for="users-username"><?php echo __('Username');?></label>
                        </div>


                        <div class="md-form required">
                            <i class="fa fa-user prefix black-text"></i>
                            <?php echo $this->Form->text('Users.first_name', ['class' => 'form-control', 'id'=>'users-first-name']); ?>
                            <label for="users-first-name"><?php echo __('First Name');?></label>
                        </div>


                        <div class="md-form required">
                            <i class="fa fa-user prefix black-text"></i>
                            <?php echo $this->Form->text('Users.last_name', ['class' => 'form-control', 'id'=>'users-last-name']); ?>
                            <label for="users-last-name"><?php echo __('Last Name');?></label>
                        </div>

                        <div class="md-form required">
                          <?php $readonly=false; if ($emailToken): $readonly=true; endif ?>
                            <i class="fa fa-envelope prefix black-text"></i>
                            <?php echo $this->Form->text('Users.email', ['class' => 'form-control', 'value'=>$emailToken, 'id'=>'users-email', 'readonly'=>$readonly]); ?>
                            <label for="users-email"><?php echo __('Email');?></label>
                        </div>


                        <div class="md-form required">
                            <i class="fa fa-lock prefix black-text"></i>
                            <?php echo $this->Form->password('Users.password', ['class' => 'form-control', 'id'=>'users-password']); ?>
                            <label for="users-password"><?php echo __('Password');?></label>
                        </div>

                        <div class="md-form required">
                            <i class="fa fa-lock prefix black-text"></i>
                            <?php echo $this->Form->password('Users.cpassword', ['class' => 'form-control', 'id'=>'users-cpassword']); ?>
                            <label for="users-cpassword"><?php echo __('Confirmar Password');?></label>
                        </div>

                        <?php
                        if($this->UserAuth->canUseRecaptha('registration')) {
                          $errors = $userEntity->getErrors();
                          $error = "";
                          if(isset($errors['captcha']['_empty'])) {
                            $error = $errors['captcha']['_empty'];
                          } else if(isset($errors['captcha']['mustMatch'])) {
                            $error = $errors['captcha']['mustMatch'];
                          }?>
                          <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <?php echo $this->UserAuth->showCaptcha($error);?>
                          </div>
                        <?php
                        }?>

                        <div class="text-center">
                          <?php echo $this->Form->Submit(__('Sign Up'), ['class'=>'btn btn-indigo btn-rounded mt-5', 'id'=>'registerSubmitBtn']);?>
                        </div>
                        <?php echo $this->Form->control('Users.user_group_id', ['type' => 'hidden','value'=>2]); ?>
                        <?php if ($realToken): echo $this->Form->control('Users.token', ['type' => 'hidden','value'=>$realToken]); endif ?>
                        <?php echo $this->Form->end();?>
                        <?php echo $this->element('Usermgmt.provider');?>
                
                    </div>
                    <!--Grid column-->
                
                </div>
                <!--Grid row-->

            </div>
        </div>

    </div>
    <!--Grid column-->

</div>