<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        Role::create([
            'name' => 'Super Administrador',
            'slug' => 'superadmin',
            'description' => 'Administracion y acceso total.',
            'special' => 'all-access'
        ]);

        Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'description' => 'Administracion del sistema.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Acceso a administracion y permiso para solo editar.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Ejecutivo',
            'slug' => 'ejecutivo',
            'description' => 'Ejecutivo telefonico, acceso a App.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Supervisor',
            'slug' => 'supervisor',
            'description' => 'Supervisores.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Calidad',
            'slug' => 'calidad',
            'description' => 'Equipo de calidad.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Reportes',
            'slug' => 'reportes',
            'description' => 'Acceso a reportes.',
            'special' => null
        ]);

        Role::create([
            'name' => 'Inactivo',
            'slug' => 'inactivo',
            'description' => 'Sin acceso al sistema.',
            'special' => 'no-access'
        ]);
    }
}
