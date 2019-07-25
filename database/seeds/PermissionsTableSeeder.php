<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Boton menu
        Permission::create([
            'name' => 'Navegar administracion',
            'slug' => 'administration.index',
            'description' => 'Navegar panel de administracion',
        ]);

        # Usuarios
        Permission::create([
            'name' => 'Navegar usuarios',
            'slug' => 'users.index',
            'description' => 'Lista todos los usuarios del sistema',
        ]);

        Permission::create([
            'name' => 'Formulario crear usuarios',
            'slug' => 'users.create',
            'description' => 'Ver formulario de crear usuarios',
        ]);

        Permission::create([
            'name' => 'Crear usuarios',
            'slug' => 'users.store',
            'description' => 'Crear un usuario dentro del sistema',
        ]);

        Permission::create([
            'name' => 'Ver detalle de usuario',
            'slug' => 'users.show',
            'description' => 'Ver detalle de un usuario en particular',
        ]);

        Permission::create([
            'name' => 'Formulario editar usuarios',
            'slug' => 'users.edit',
            'description' => 'Ver formulario de editar usuario',
        ]);

        Permission::create([
            'name' => 'Editar usuarios',
            'slug' => 'users.update',
            'description' => 'Editar datos de un usuario en particular',
        ]);

        Permission::create([
            'name' => 'Eliminar usuario',
            'slug' => 'users.destroy',
            'description' => 'Elimina un usuario del sistema',
        ]);

        # Roles
        Permission::create([
            'name' => 'Navegar roles',
            'slug' => 'roles.index',
            'description' => 'Lista todos los roles del sistema',
        ]);

        Permission::create([
            'name' => 'Formulario crear rol',
            'slug' => 'roles.create',
            'description' => 'Ver formulario para crear roles',
        ]);

        Permission::create([
            'name' => 'Crear rol',
            'slug' => 'roles.store',
            'description' => 'Crear un rol dentro del sistema',
        ]);

        Permission::create([
            'name' => 'Ver detalle de un rol',
            'slug' => 'roles.show',
            'description' => 'Ver detalle de un rol en particular',
        ]);

        Permission::create([
            'name' => 'Formulario editar roles',
            'slug' => 'roles.edit',
            'description' => 'Ver formulario de editar roles',
        ]);

        Permission::create([
            'name' => 'Editar roles',
            'slug' => 'roles.update',
            'description' => 'Editar datos de un rol en particular',
        ]);

        Permission::create([
            'name' => 'Eliminar rol',
            'slug' => 'roles.destroy',
            'description' => 'Elimina un rol del sistema',
        ]);

        # Permissions
        Permission::create([
            'name' => 'Navegar permisos',
            'slug' => 'permissions.index',
            'description' => 'Lista todos los permisos del sistema',
        ]);

        Permission::create([
            'name' => 'Formulario crear permiso',
            'slug' => 'permissions.create',
            'description' => 'Ver formulario para crear un permiso',
        ]);

        Permission::create([
            'name' => 'Crear permiso',
            'slug' => 'permissions.store',
            'description' => 'Crear un permiso dentro del sistema',
        ]);

        Permission::create([
            'name' => 'Ver detalle de un permiso',
            'slug' => 'permissions.show',
            'description' => 'Ver detalle de un permiso en particular',
        ]);

        Permission::create([
            'name' => 'Formulario editar permisos',
            'slug' => 'permissions.edit',
            'description' => 'Ver formulario para editar un permiso',
        ]);

        Permission::create([
            'name' => 'Editar permisos',
            'slug' => 'permissions.update',
            'description' => 'Editar datos de un permiso en particular',
        ]);

        Permission::create([
            'name' => 'Eliminar permiso',
            'slug' => 'permissions.destroy',
            'description' => 'Elimina un permiso del sistema',
        ]);

        # Otros
        Permission::create([
            'name' => 'Navegar campañas',
            'slug' => 'campaings.index',
            'description' => 'Listar campañas',
        ]);

        Permission::create([
            'name' => 'Navegar reportes',
            'slug' => 'reports.index',
            'description' => 'Listar reportes',
        ]);

        Permission::create([
            'name' => 'Navegar grabaciones',
            'slug' => 'recordings.index',
            'description' => 'Listar grabaciones',
        ]);

        Permission::create([
            'name' => 'Navegar monitores',
            'slug' => 'minitors.index',
            'description' => 'Listar monitoreo',
        ]);

        Permission::create([
            'name' => 'Navegar App',
            'slug' => 'app.index',
            'description' => 'Listar App.',
        ]);
    }
}
