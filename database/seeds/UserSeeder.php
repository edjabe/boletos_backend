<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = factory(App\User::class)->create([
            'name' => 'Usuario',
            'last_name' => 'Prueba',
            'address' => 'Direccion 1',
            'phone_number' => '2343434343',
            'email' => 'prueba@prueba.com'
        ]);

        $user = factory(App\User::class,4)->create();
    }
}
