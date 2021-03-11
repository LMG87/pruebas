<?php
use Migrations\AbstractSeed;

/**
 * Roles seed.
 */
class RolesSeed extends AbstractSeed
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
                'name' => 'SuperAdmin',
                'description' => 'Super administrador de una relacion o acceso 
puede:
-crear
-leer
-actualizar
-eliminar
-invitar

Todos los accesos donde se asigne (incluyendo items privados)',
                'created' => '2018-09-10 11:57:34',
                'modified' => '2018-11-09 06:57:17',
            ],
            [
                'id' => '2',
                'name' => 'Admin',
                'description' => 'Administrador de una relacion o acceso, puede:

-crear
-leer
-actualizar
-eliminar
-invitar

Todos los accesos donde se asigne (no items privados siempre y cuando el acceso asignado sea diferente a item )',
                'created' => '2018-09-10 11:58:13',
                'modified' => '2018-11-09 06:59:22',
            ],
            [
                'id' => '3',
                'name' => 'Colaborador',
                'description' => 'Colaborador de una relación o acceso, puede:

-crear 
-leer
-actualizar : solo propios (comentarios y adjuntos)
-eliminar : solo propios (comentarios y adjuntos)
-invitar

y todos los accesos donde se asigne (no items privados siempre y cuando el acceso asignado sea diferente a item )',
                'created' => '2018-09-10 11:58:59',
                'modified' => '2018-11-09 07:04:55',
            ],
        ];

        $table = $this->table('roles');
        $table->insert($data)->save();
    }
}
