<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $user_id
 * @property int $room_id
 * @property int $type_item_id
 * @property int $company_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\TypeItem $type_item
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Action[] $actions
 */
class Item extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'description' => true,
        'user_id' => true,
        'room_id' => true,
        'type_item_id' => true,
        'company_id' => true,
        'additional_fields' => true,
        'private' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'room' => true,
        'type_item' => true,
        'company' => true,
        'actions' => true,
        'comments' => true
    ];
}
