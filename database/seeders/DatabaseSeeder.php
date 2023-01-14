<?php

namespace Database\Seeders;

use App\Models\Sidewalk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'simple']);

        $user_a = User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('12345678'),
        ]);
        $user_a->assignRole('administrador');

        $user_s = User::create([
            'name' => 'simple',
            'email' => 'simple@app.com',
            'password' => Hash::make('12345678'),
        ]);
        $user_s->assignRole('simple');

        $this->call([
            TownshipSeeder::class,
            SidewalkSeeder::class,
            CommuneSeeder::class,
            QuarterSeeder::class,
        ]);
    }
}
