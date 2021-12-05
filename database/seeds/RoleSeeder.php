<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role = new Role();
       $role->name = 'Administrador';
       $role->description = 'Encargado de administrar la seguridad del sistema';

       $role->save();

    }
}
