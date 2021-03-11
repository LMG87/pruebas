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
<div id="updateScheduledEmailIndex">
	<?php echo $this->Search->searchForm('ScheduledEmails', ['legend'=>false, 'updateDivId'=>'updateScheduledEmailIndex']);?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateScheduledEmailIndex']);?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm table-hover">
			<thead>
				<tr>
					<th><?php echo __('#');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.type', __('Type'));?></th>
					<th><?php echo __('Groups(s)');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.from_name', __('From Name'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.from_email', __('From Email'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.subject', __('Subject'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('Users.first_name', __('Scheduled By'));?></th>
					<th><?php echo __('Status');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.schedule_date', __('Scheduled Date'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('ScheduledEmails.created', __('Created'));?></th>
					<th><?php echo __('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($scheduledEmails)) {
					$params = $this->request->getParam('paging');
					$page = $params['ScheduledEmails']['page'];
					$limit = $params['ScheduledEmails']['perPage'];
					$i = ($page-1) * $limit;

					foreach($scheduledEmails as $row) {
						$i++;
						echo "<tr>";
							echo "<td>".$i."</td>";
							echo "<td>";
								if($row['type'] == 'USERS') {
									echo __('Selected Users');
								} else if($row['type'] == 'GROUPS') {
									echo __('Group Users');
								} else {
									echo __('Manual Emails');
								}
							echo "</td>";
							echo "<td>";
								if(!empty($row['user_group_id'])) {
									echo $row['group_name'];
								} else {
									echo __('N/A');
								}
							echo "</td>";
							echo "<td>".$row['from_name']."</td>";
							echo "<td>".$row['from_email']."</td>";
							echo "<td>".$row['subject']."</td>";
							echo "<td>".$row['user']['first_name'].' '.$row['user']['last_name']."</td>";
							echo "<td>";
								if($row['is_sent']) {
									echo "<span class='badge badge-success'>".__('Sent')."</span>";
								} else if($row['total_sent_emails'] > 0) {
									echo "<span class='badge badge-info'>".__('Sending')."</span>";
								} else {
									echo "<span class='badge badge-danger'>".__('Not Sent')."</span>";
								}
							echo"</td>";
							echo "<td>".$row['schedule_date']->format('d-M-Y h:i A')."</td>";
							echo "<td>".$row['created']->format('d-M-Y')."</td>";
							echo "<td>";
								echo "<div class='dropdown'>";
									echo "<button class='btn btn-primary btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".__('Action')."</button>";
									
									echo "<div class='dropdown-menu dropdown-menu-right'>";
										echo $this->Html->link(__('View Full Email & Recipients'), ['action'=>'view', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);

										if(!$row['is_sent'] && !$row['total_sent_emails']) {
											echo $this->Html->link(__('Edit Email'), ['action'=>'edit', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);
										}
										if(!$row['is_sent']) {
											echo $this->Form->postLink(__('Delete Email & Recipients'), ['action'=>'delete', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item', 'confirm'=>__('Are you sure, you want to delete this scheduled email along with all recipients?')]);
										}
									echo "</div>";
								echo "</div>";
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=11><br/><br/>".__('No Records Available')."</td></tr>";
				}?>
			</tbody>
		</table>
	</div>
	<?php if(!empty($scheduledEmails)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Emails')]);
	}?>
</div>