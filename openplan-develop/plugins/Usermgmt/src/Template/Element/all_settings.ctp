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
<div id="updateUserSettingsIndex">
	<?php echo $this->Search->searchForm('UserSettings', ['legend'=>false, 'updateDivId'=>'updateUserSettingsIndex']);?>
	<?php echo $this->element('Usermgmt.paginator', ['useAjax'=>true, 'updateDivId'=>'updateUserSettingsIndex']);?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm table-hover">
			<thead>
				<tr>
					<th><?php echo __('#');?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('UserSettings.category', __('Category'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('UserSettings.name', __('Name/Key'));?></th>
					<th class="psorting"><?php echo $this->Paginator->sort('UserSettings.display_name', __('Setting Name'));?></th>
					<th><?php echo __('Setting Value');?></th>
					<th><?php echo __('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($userSettings)) {
					$params = $this->request->getParam('paging');
					$page = $params['UserSettings']['page'];
					$limit = $params['UserSettings']['perPage'];
					$i = ($page-1) * $limit;

					foreach($userSettings as $row) {
						$i++;
						echo "<tr id='rowId".$row['id']."'>";
							echo "<td>".$i."</td>";
							echo "<td>".ucwords(strtolower($row['category']))."</td>";
							echo "<td>".$row['name']."</td>";
							echo "<td>".nl2br($row['display_name'])."</td>";
							echo "<td>";
								if($row['type'] == 'input' || $row['type'] == 'dropdown' || $row['type'] == 'radio') {
									echo h($row['value']);
								} else if($row['type'] == 'checkbox') {
									if(!empty($row['value'])) {
										echo "<span class='badge badge-success'>".__('Yes')."</span>";
									} else {
										echo "<span class='badge badge-danger'>".__('No')."</span>";
									}
								} else if($row['type'] == 'textarea') {
									echo nl2br($row['value']);
								} else if($row['type'] == 'tinymce' || $row['type'] == 'ckeditor') {
									echo $row['value'];
								}
							echo"</td>";
							echo "<td>";
								echo "<div class='dropdown'>";
									echo "<button class='btn btn-primary btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".__('Action')."</button>";
									
									echo "<div class='dropdown-menu dropdown-menu-right'>";
										echo $this->Html->link(__('Edit Setting'), ['controller'=>'UserSettings', 'action'=>'editSetting', $row['id'], 'page'=>$page], ['escape'=>false, 'class'=>'dropdown-item']);
									echo "</div>";
								echo "</div>";
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=6><br/><br/>".__('No Records Available')."</td></tr>";
				}?>
			</tbody>
		</table>
	</div>
	<?php if(!empty($userSettings)) {
		echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of Settings')]);
	}?>
</div>