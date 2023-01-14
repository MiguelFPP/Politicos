<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path("database/seeders/communes.csv"), "r");
        $firstLine = true;

        while (($data = fgetcsv($file, 2000, ",")) != false) {
            if (!$firstLine) {
                Commune::create([
                    'name' => $data[1],
                ]);
            }
            $firstLine = false;
        }
        fclose($file);
    }
}
