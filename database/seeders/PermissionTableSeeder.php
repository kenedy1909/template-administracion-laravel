<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'rol-listar',
            'rol-crear',
            'rol-editar',
            'rol-eliminar',
            'usuarios-listar',
            'usuarios-crear',
            'usuarios-editar',
            'usuarios-eliminar'
        ];

        $permissions4 = [
            'documento-list',
            'documento-create',
            'documento-edit',
            'documento-delete'
        ];

        $permissions5 = [
            'documentos-usuarios-list',
            'documentos-usuarios-create',
            'documentos-usuarios-edit',
            'documentos-usuarios-delete'
        ];

        $permissions6 = [
            'informacionusuario-list',
            'informacionusuario-create',
            'informacionusuario-edit',
            'informacionusuario-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
