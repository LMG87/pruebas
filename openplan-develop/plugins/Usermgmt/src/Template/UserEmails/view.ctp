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
			<?php echo __('Email Details');?>
		</span>
		<span class="card-title float-right">
			<?php $page = ($this->request->getQuery('page')) ? $this->request->getQuery('page') : 1;?>
			<?php echo $this->Html->link(__('Back', true), ['action'=>'index', 'page'=>$page], ['class'=>'btn btn-secondary btn-sm']);?>
		</span>
	</div>
	<div class="card-body p-0">
		<table class="table table-striped table-bordered table-sm table-hover">
			<tbody>
				<tr>
					<th style="width:200px;"><?php echo __('Email Type');?></th>
					<td>
						<?php if($userEmail['type'] == 'USERS') {
							echo __('Selected Users');
						} else if($userEmail['type'] == 'GROUPS') {
							echo __('Group Users');
						} else {
							echo __('Manual Emails');
						}?>
					</td>
				</tr>
				<?php if($userEmail['type'] == 'GROUPS') {?>
					<tr><th><?php echo __('Group(s)');?></th><td><?php echo $userEmail['group_name'];?></td></tr>
				<?php }?>
				<tr><th><?php echo __('CC Email(s)');?></th><td><?php echo $userEmail['cc_to'];?></td></tr>
				<tr><th><?php echo __('From Name');?></th><td><?php echo $userEmail['from_name'];?></td></tr>
				<tr><th><?php echo __('From Email');?></th><td><?php echo $userEmail['from_email'];?></td></tr>
				<tr><th><?php echo __('Email Subject');?></th><td><?php echo $userEmail['subject'];?></td></tr>
				<tr><th><?php echo __('Email Message');?></th><td><?php echo $userEmail['message'];?></td></tr>
				<tr><th><?php echo __('Sent By');?></th><td><?php echo $userEmail['user']['first_name'].' '.$userEmail['user']['last_name'];?></td></tr>
				<tr>
					<th><?php echo __('Sent?');?></th>
					<td>
						<?php if(!empty($userEmail['total_sent_emails'])) {
							echo "<span class='badge badge-success'>".__('Yes')."</span>";
						} else {
							echo "<span class='badge badge-danger'>".__('No')."</span>";
						}?>
					</td>
				</tr>
				<tr><th><?php echo __('Date Sent');?></th><td><?php echo $userEmail['created']->format('d-M-Y h:i:s A');?></td></tr>
			</tbody>
		</table>
	</div>
</div>
<br/>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Email Recipients');?>
		</span>
	</div>
	<div class="card-body p-0">
		<table class="table table-striped table-bordered table-sm table-hover">
			<thead>
				<tr>
					<th><?php echo __('Id');?></th>
					<th><?php echo __('Name');?></th>
					<th><?php echo __('Email');?></th>
					<th><?php echo __('Sent?');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($userEmailRecipients)) {
					foreach($userEmailRecipients as $row) {
						echo "<tr>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".$row['user']['first_name'].' '.$row['user']['last_name']."</td>";
							echo "<td>".$row['email_address']."</td>";
							echo "<td>";
								if($row['is_email_sent']) {
									echo "<span class='badge badge-success'>".__('Yes')."</span>";
								} else {
									echo "<span class='badge badge-danger'>".__('No')."</span>";
								}
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=4><br/><br/>".__('No Records Available')."</td></tr>";
				}?>
			</tbody>
		</table>
	</div>
</div>