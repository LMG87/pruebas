<?php
use Migrations\AbstractSeed;

/**
 * Companies seed.
 */
class CompaniesSeed extends AbstractSeed
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
                'name' => 'Conectatec',
                'created' => '2018-09-10 11:54:57',
                'modified' => '2018-09-10 11:54:57',
            ],
            [
                'id' => '2',
                'name' => 'Hovima Hotels',
                'created' => '2018-09-14 06:38:48',
                'modified' => '2018-09-14 06:38:48',
            ],
            [
                'id' => '3',
                'name' => 'Paradise Park',
                'created' => NULL,
                'modified' => NULL,
            ],
        ];

        $table = $this->table('companies');
        $table->insert($data)->save();
    }
}
