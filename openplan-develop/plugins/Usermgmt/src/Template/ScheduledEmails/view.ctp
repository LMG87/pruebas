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
		$(".delete-recipient").click(function(e) {
			e.preventDefault();
			if(!confirm("<?php echo __('Are you sure, you want to delete this recipient?');?>")) {
				return false;
			}
			var url = $(this).attr('href');
			var pelem = $(this).closest('tr');
			$(this).html('<img src="'+urlForJs+'usermgmt/img/loading-circle.gif" alt="Delete"/>');
			var self = this;
			$.ajax({
				async : true,
				cache : false,
				data : null,
				dataType : 'html',
				success : function (data, textStatus) {
					try {
						var data = JSON.parse(data);
						if(data.error == 0) {
							$(pelem).hide('slow', function(){ $(this).remove(); });
						} else {
							$(self).html('Delete');
							alert(data.message);
						}
					} catch(e) {
						$(self).html('Delete');
						alert("<?php echo __('Something went wrong.. Please Try Again');?>");
					}
				},
				type : 'POST',
				url : url
			});
		});
	});
</script>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Scheduled Email Details');?>
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
						<?php if($scheduledEmail['type'] == 'USERS') {
							echo __('Selected Users');
						} else if($scheduledEmail['type'] == 'GROUPS') {
							echo __('Group Users');
						} else {
							echo __('Manual Emails');
						}?>
					</td>
				</tr>
				<?php if($scheduledEmail['type'] == 'GROUPS') { ?>
					<tr><th><?php echo __('Group(s)');?></th><td><?php echo $scheduledEmail['group_name'];?></td></tr>
				<?php }?>
				<tr><th><?php echo __('CC Email(s)');?></th><td><?php echo $scheduledEmail['cc_to'];?></td></tr>
				<tr><th><?php echo __('From Name');?></th><td><?php echo $scheduledEmail['from_name'];?></td></tr>
				<tr><th><?php echo __('From Email');?></th><td><?php echo $scheduledEmail['from_email'];?></td></tr>
				<tr><th><?php echo __('Email Subject');?></th><td><?php echo $scheduledEmail['subject'];?></td></tr>
				<tr><th><?php echo __('Email Message');?></th><td><?php echo $scheduledEmail['message'];?></td></tr>
				<tr><th><?php echo __('Scheduled By');?></th><td><?php echo $scheduledEmail['user']['first_name'].' '.$scheduledEmail['user']['last_name'];?></td></tr>
				<tr>
					<th><?php echo __('Status');?></th>
					<td>
						<?php if($scheduledEmail['is_sent']) {
							echo "<span class='badge badge-success'>".__('Sent')."</span>";
						} else if($scheduledEmail['total_sent_emails'] > 0) {
							echo "<span class='badge badge-info'>".__('Sending')."</span>";
						} else {
							echo "<span class='badge badge-danger'>".__('Not Sent')."</span>";
						}?>
					</td>
				</tr>
				<tr><th><?php echo __('Scheduled Date');?></th><td><?php echo $scheduledEmail['schedule_date']->format('d-M-Y h:i A');?></td></tr>
				<tr><th><?php echo __('Created');?></th><td><?php echo $scheduledEmail['created']->format('d-M-Y h:i A');?></td></tr>
			</tbody>
		</table>
	</div>
</div>
<br/>
<div class="card bg-light">
	<div class="card-header">
		<span class="card-title">
			<?php echo __('Scheduled Email Recipients');?>
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
					<th><?php echo __('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($scheduledEmailRecipients)) {
					foreach($scheduledEmailRecipients as $row) {
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
							echo "<td>";
								if(!$row['is_email_sent']) {
									echo $this->Html->link(__('Delete', true), ['action'=>'deleteRecipient', $row['id'], 'page'=>$page], ['class'=>'btn btn-primary btn-sm delete-recipient']);
								}
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=5><br/><br/>".__('No Records Available')."</td></tr>";
				}?>
			</tbody>
		</table>
	</div>
</div>