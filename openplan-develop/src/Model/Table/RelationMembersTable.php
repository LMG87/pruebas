<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RelationMembers Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\RelationMember get($primaryKey, $options = [])
 * @method \App\Model\Entity\RelationMember newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RelationMember[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RelationMember|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelationMember|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelationMember patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RelationMember[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RelationMember findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RelationMembersTable extends Table
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

        $this->setTable('relation_members');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
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
            ->scalar('model')
            ->maxLength('model', 10)
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
    public function getAllCompaniesUser($user_id,$group_user_id)
    {
       // print_r($user_id);
        $queryC=$this->find();
        $queryC->select(['company_id' => 'Companies.id',
                        'company_name' => 'Companies.name'/*,
                        'room_name' => 'Rooms.name'/*,
                        'role_id' => 'Roles.id'*/
                    ]);
        $queryC->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = RelationMembers.foreign_key']);
       /* $query->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);*/
        if ($group_user_id==1) {
            $queryC->where(['RelationMembers.model' => 'companies']);
        }else{
            $queryC->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'companies']);
        }
        //$queryC->group(['Companies.id']);
        //consulta por relacion de salas (rooms)
        $queryR=$this->find();
        $queryR->select(['company_id' => 'Companies.id',
                        'company_name' => 'Companies.name'/*,
                        'room_name' => 'Rooms.name'/*,
                        'role_id' => 'Roles.id'*/
                    ]);
        $queryR->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);

        $queryR->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = Rooms.company_id']);
       /* $query->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);*/
        if ($group_user_id==1) {
            $queryR->where(['RelationMembers.model' => 'rooms']);
        }else{
            $queryR->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'rooms']);
        }
        //ghu////////////////////////////////

         $queryI=$this->find();
         $queryI->select(['company_id' => 'Companies.id',
                         'company_name' => 'Companies.name'/*,
                         'room_name' => 'Rooms.name'/*,
                         'role_id' => 'Roles.id'*/
                     ]);
         $queryI->innerJoin(
             ['Items' => 'items'],
             ['Items.id = RelationMembers.foreign_key']);

         $queryI->innerJoin(
             ['Companies' => 'companies'],
             ['Companies.id = Items.company_id']);

         if ($group_user_id==1) {
             $queryI->where(['RelationMembers.model' => 'items']);
         }else{
             $queryI->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'items']);
         }

        //$queryR->group(['Rooms.id']);
       // debug($queryI->toArray());

       //debug($query->toArray());
        $queryC->union($queryR);
        $queryC->union($queryI);
       // $query->order(['title' => 'DESC']);
        $queryC->epilog('ORDER BY company_name ASC');
        //debug($queryC);
        //exit();
        return $queryC;
    }
    public function checkCompany($user_id,$group_user_id,$company_id)
    {
       // print_r($user_id);
        $queryC=$this->find();
        $queryC->select(['company_id' => 'Companies.id',
                        'company_name' => 'Companies.name'/*,
                        'room_name' => 'Rooms.name'/*,
                        'role_id' => 'Roles.id'*/
                    ]);
        $queryC->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = RelationMembers.foreign_key']);
       /* $query->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);*/
        if ($group_user_id==1) {
            $queryC->where(['RelationMembers.model' => 'companies']);
        }else{
            $queryC->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'companies', 'Companies.id' => $company_id]);
        }
        //$queryC->group(['Companies.id']);
        //consulta por relacion de salas (rooms)
        $queryR=$this->find();
        $queryR->select(['company_id' => 'Companies.id',
                        'company_name' => 'Companies.name'/*,
                        'room_name' => 'Rooms.name'/*,
                        'role_id' => 'Roles.id'*/
                    ]);
        $queryR->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);

        $queryR->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = Rooms.company_id']);
       /* $query->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);*/
        if ($group_user_id==1) {
            $queryR->where(['RelationMembers.model' => 'rooms']);
        }else{
            $queryR->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'rooms', 'Companies.id' => $company_id]);
        }

        $queryI=$this->find();
        $queryI->select(['company_id' => 'Companies.id',
                        'company_name' => 'Companies.name'/*,
                        'room_name' => 'Rooms.name'/*,
                        'role_id' => 'Roles.id'*/
                    ]);
        $queryI->innerJoin(
            ['Items' => 'items'],
            ['Items.id = RelationMembers.foreign_key']);

        $queryI->innerJoin(
            ['Companies' => 'companies'],
            ['Companies.id = Items.company_id']);
       /* $query->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);*/
        if ($group_user_id==1) {
            $queryI->where(['RelationMembers.model' => 'items']);
        }else{
            $queryI->where(['RelationMembers.user_id' => $user_id, 'RelationMembers.model' => 'items', 'Companies.id' => $company_id]);
        }
        //$queryR->group(['Rooms.id']);

       //debug($query->toArray());
        $queryC->union($queryR);
        $queryC->union($queryI);
       // $query->order(['title' => 'DESC']);
        $queryC->epilog('ORDER BY company_name ASC');
        //debug($queryC);
        //exit();
        return $queryC;
    }
    public function checkRelationC($user_id,$group_user_id,$company_id)
    {
       // print_r($user_id);
        $queryC=$this->find();
        
        if ($group_user_id==1) {
            $queryC->where(['RelationMembers.model' => 'companies', 'RelationMembers.foreign_key' => $company_id]);
        }else{
           // print_r($user_id);
            $queryC->where(['RelationMembers.model' => 'companies', 'RelationMembers.foreign_key' => $company_id, 'RelationMembers.user_id' => $user_id]);
        }
        
        return $queryC;
    }

    public function checkRelationR($user_id,$group_user_id,$company_id)
    {
       // print_r($user_id);
        $queryC=$this->find();
        $queryC->innerJoin(
            ['Rooms' => 'rooms'],
            ['Rooms.id = RelationMembers.foreign_key']);
        if ($group_user_id==1) {
            $queryC->where(['RelationMembers.model' => 'rooms']);
        }else{
            $queryC->where(['RelationMembers.model' => 'rooms', 'RelationMembers.user_id' => $user_id]);
        }
        $queryC->where(['Rooms.company_id' => $company_id]);
        
        return $queryC;
    }
}
