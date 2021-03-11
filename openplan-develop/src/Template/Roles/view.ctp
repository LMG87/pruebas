<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Collaborators'), ['controller' => 'Collaborators', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Collaborator'), ['controller' => 'Collaborators', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Relation Users'), ['controller' => 'RelationUsers', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Relation User'), ['controller' => 'RelationUsers', 'action' => 'add']) ?> </li>
                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="roles view large-9 medium-8 columns content">
            <h3><?= h($role->name) ?></h3>
            <table class="vertical-table table">
                                        <tr>
                    <th scope="row"><?= __('Name') ?></th>
                    <td><?= h($role->name) ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($role->id) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($role->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($role->modified) ?></td>
                </tr>
                                    </table>
                            <div class="">
                <h4><?= __('Description') ?></h4>
                <?= $this->Text->autoParagraph(h($role->description)); ?>
            </div>
                                                            <div class="related">
                <h4><?= __('Related Collaborators') ?></h4>
                <?php if (!empty($role->collaborators)): ?>
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('User Id') ?></th>
                                <th scope="col"><?= __('User Email') ?></th>
                                <th scope="col"><?= __('Model') ?></th>
                                <th scope="col"><?= __('Foreign Key') ?></th>
                                <th scope="col"><?= __('Role Id') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($role->collaborators as $collaborators): ?>
                    <tr>
                                <td><?= h($collaborators->id) ?></td>
                                <td><?= h($collaborators->user_id) ?></td>
                                <td><?= h($collaborators->user_email) ?></td>
                                <td><?= h($collaborators->model) ?></td>
                                <td><?= h($collaborators->foreign_key) ?></td>
                                <td><?= h($collaborators->role_id) ?></td>
                                <td><?= h($collaborators->created) ?></td>
                                <td><?= h($collaborators->modified) ?></td>
                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Collaborators', 'action' => 'view', $collaborators->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Collaborators', 'action' => 'edit', $collaborators->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Collaborators', 'action' => 'delete', $collaborators->id], ['confirm' => __('Are you sure you want to delete # {0}?', $collaborators->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                                    <div class="related">
                <h4><?= __('Related Relation Users') ?></h4>
                <?php if (!empty($role->relation_users)): ?>
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('User Id') ?></th>
                                <th scope="col"><?= __('Role Id') ?></th>
                                <th scope="col"><?= __('Model') ?></th>
                                <th scope="col"><?= __('Foreign Key') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($role->relation_users as $relationUsers): ?>
                    <tr>
                                <td><?= h($relationUsers->id) ?></td>
                                <td><?= h($relationUsers->user_id) ?></td>
                                <td><?= h($relationUsers->role_id) ?></td>
                                <td><?= h($relationUsers->model) ?></td>
                                <td><?= h($relationUsers->foreign_key) ?></td>
                                <td><?= h($relationUsers->created) ?></td>
                                <td><?= h($relationUsers->modified) ?></td>
                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'RelationUsers', 'action' => 'view', $relationUsers->user_id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'RelationUsers', 'action' => 'edit', $relationUsers->user_id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'RelationUsers', 'action' => 'delete', $relationUsers->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $relationUsers->user_id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                </div>
    </div>
</div>


