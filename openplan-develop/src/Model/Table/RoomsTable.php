<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rooms Model
 *
 * @property \App\Model\Table\RoomsTable|\Cake\ORM\Association\BelongsTo $ParentRooms
 * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\RoomsTable|\Cake\ORM\Association\HasMany $ChildRooms
 *
 * @method \App\Model\Entity\Room get($primaryKey, $options = [])
 * @method \App\Model\Entity\Room newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Room[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Room|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Room[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Room findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class RoomsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('rooms');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentRooms', [
            'className' => 'Rooms',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'room_id'
        ]);
        $this->hasMany('ChildRooms', [
            'className' => 'Rooms',
            'foreignKey' => 'parent_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parent_id'], 'ParentRooms'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }

    public function getAllRoomsCompanyR1($company_id)
    {
        $query=$this->find('treeList', [
            'spacer' => ' - '
        ]);
        $query->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = Rooms.company_id']);

        $query->where(['Rooms.company_id' => $company_id]);
        return $query;
    }

    public function getAllRoomsCompanyR2($company_id)
    {
       // print_r($user_id);
        $query=$this->find('treeList', [
            'spacer' => ' - '
        ]);
        $query->innerJoin(
            ['RelationMembers' => 'relation_members'],
            ['RelationMembers.foreign_key = Rooms.id']);

        $query->where(['Rooms.company_id' => $company_id, 'RelationMembers.model' => 'rooms']);
        return $query;
    }
    public function getAllRoomsCompanyR3($company_id)
    {
       // print_r($user_id);
        $query=$this->find('treeList', [
            'spacer' => ' - '
        ]);
        $query->innerJoin(
            ['Items' => 'items'],
            ['Items.room_id = Rooms.id']);

        $query->innerJoin(
            ['RelationMembers' => 'relation_members'],
            ['RelationMembers.foreign_key = Items.id']);

        $query->where(['Rooms.company_id' => $company_id, 'RelationMembers.model' => 'items']);
        return $query;
    }
}
