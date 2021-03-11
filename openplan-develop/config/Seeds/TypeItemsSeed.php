<?php
use Migrations\AbstractSeed;

/**
 * TypeItems seed.
 */
class TypeItemsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Acta de reunion',
                'description' => 'es para crear actas de reunion',
                'created' => '2018-09-10 11:56:05',
                'modified' => '2018-11-13 06:16:27',
            ],
            [
                'id' => '2',
                'name' => 'Tarea',
                'description' => 'sirve para crear items tipo tarea',
                'created' => '2018-09-10 11:56:34',
                'modified' => '2018-09-10 11:56:34',
            ],
            [
                'id' => '3',
                'name' => 'Nota Informativa',
                'description' => 'items para informar a los usuarios de alguna novedad, actividad entre otros',
                'created' => '2018-11-13 06:17:22',
                'modified' => '2018-11-13 06:17:37',
            ],
        ];

        $table = $this->table('type_items');
        $table->insert($data)->save();
    }
}
