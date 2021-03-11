<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $user_id
 * @property int $item_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $status
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Item $item
 */
class File extends Entity
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
        'path' => true,
        'user_id' => true,
        'item_id' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'user' => true,
        'item' => true
    ];
}
