<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;

/**
 * Items Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RoomsTable|\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\TypeItemsTable|\Cake\ORM\Association\BelongsTo $TypeItems
 * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ActionsTable|\Cake\ORM\Association\BelongsToMany $Actions
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id'
        ]);
        $this->belongsTo('TypeItems', [
            'foreignKey' => 'type_item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Actions', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'action_id',
            'joinTable' => 'actions_items',
            'dependent' => true
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'item_id',
            'dependent' => true
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'item_id',
            'dependent' => true
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

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }

    protected function _initializeSchema(TableSchema $schema)
        {
            $schema->setColumnType('additional_fields', 'json');
            return $schema;
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['room_id'], 'Rooms'));
        $rules->add($rules->existsIn(['type_item_id'], 'TypeItems'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }

    public function getAllItemsUser($currentDate=null, $company_id=null, $room_id=null, $user_id=null)
    {
        $query=$this->find('all');
        $query->where(['Items.company_id' => $company_id]);
        if ($room_id) { $query->where(['Items.room_id IN' => $room_id]); }
        if (!$currentDate) {
            $query->where(['Items.created <=' => new \DateTime()]);
        }else{
            $query->where(['Items.created <=' => $currentDate]);
        }
        //$query->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);

        return $query;
    }

    public function getAllItemsUserByItems($currentDate=null, $company_id=null, $room_id=null, $user_id=null)
    {
        $query=$this->find('all');

        $query->innerJoin(
             ['RelationMembers' => 'relation_members'],
             ['RelationMembers.foreign_key = Items.id']);

        $query->where(['Items.company_id' => $company_id]);
        $query->where(['RelationMembers.user_id' => $user_id]);
        $query->where(['RelationMembers.model' => 'items']);


        if ($room_id) { $query->where(['Items.room_id IN' => $room_id]); }
        if (!$currentDate) {
            $query->where(['Items.created <=' => new \DateTime()]);
        }else{
            $query->where(['Items.created <=' => $currentDate]);
        }
        //$query->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
        return $query;
    }

    public function getNewAllItemsUser($currentDate=null, $company_id=null, $room_id=null, $user_id=null,$typeRelation)
    {
        if ($typeRelation==1) { $room_id=0; }
        $query=$this->find('all');
        $query->where(['Items.company_id' => $company_id]);
        if ($room_id) { $query->where(['Items.room_id' => $room_id]); }
        $query->where(['Items.created >' => $currentDate]);

        //$query->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);

       // $query->andWhere(['(Items.private' => 0, 'or', 'Items.user_id' => $user_id]);
        //debug($room_id);
       // debug($query);
        return $query;
    }

    public function getNewAllItemsUserByItems($currentDate=null, $company_id=null, $room_id=null, $user_id=null)
    {
        $query=$this->find('all');
        $query->innerJoin(
             ['RelationMembers' => 'relation_members'],
             ['RelationMembers.foreign_key = Items.id']);

        $query->where(['Items.company_id' => $company_id]);
        $query->where(['RelationMembers.user_id' => $user_id]);
        $query->where(['RelationMembers.model' => 'items']);

        $query->where(['Items.company_id' => $company_id]);
        if ($room_id) { $query->where(['Items.room_id' => $room_id]); }
        $query->where(['Items.created >' => $currentDate]);
        //$query->where(['OR' => [['Items.private' => 0], ['Items.user_id' => $user_id]]]);
        return $query;
    }
}
