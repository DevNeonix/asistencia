<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\RolEmpleado;
use App\Models\User;
use App\Models\UserMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        RolEmpleado::create(["detalle" => "Empleado"]);
        User::create([
            "name" => 'Administrador',
            "email" => "admin@polindustria.com.pe",
            "password" => "polimaster21",
            "tipo" => 1
        ]);


        Menu::create(["titulo" => "Home", "ruta" => "admin.home"]);
        Menu::create(["titulo" => "Marcacion", "ruta" => "admin.marcacion"]);
        Menu::create(["titulo" => "Ots", "ruta" => "admin.ots"]);
        Menu::create(["titulo" => "Personal por Ots", "ruta" => "admin.ots_personal"]);
        Menu::create(["titulo" => "Personal", "ruta" => "admin.personal"]);
        Menu::create(["titulo" => "Reporte Asistencia", "ruta" => "admin.reporte.asistencia"]);
        Menu::create(["titulo" => "Reporte Asistencia dia", "ruta" => "admin.marcacion.asistenciadia"]);
        Menu::create(["titulo" => "Reporte Tareo", "ruta" => "admin.tareo"]);
        Menu::create(["titulo" => "Usuarios", "ruta" => "admin.users"]);
        Menu::create(["titulo" => "Menu usuarios", "ruta" => "usuarios-menus.index"]);
        Menu::create(["titulo" => "Centro de Costos", "ruta" => "admin.cc"]);

        UserMenu::create(["user_id"=>1,"menu_id"=>1]);
        UserMenu::create(["user_id"=>1,"menu_id"=>2]);
        UserMenu::create(["user_id"=>1,"menu_id"=>3]);
        UserMenu::create(["user_id"=>1,"menu_id"=>4]);
        UserMenu::create(["user_id"=>1,"menu_id"=>5]);
        UserMenu::create(["user_id"=>1,"menu_id"=>6]);
        UserMenu::create(["user_id"=>1,"menu_id"=>7]);
        UserMenu::create(["user_id"=>1,"menu_id"=>8]);
        UserMenu::create(["user_id"=>1,"menu_id"=>9]);
        UserMenu::create(["user_id"=>1,"menu_id"=>10]);
        UserMenu::create(["user_id"=>1,"menu_id"=>11]);


    }
}
