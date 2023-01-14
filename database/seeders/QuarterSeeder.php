<?php

namespace Database\Seeders;

use App\Models\Quarter;
use Illuminate\Database\Seeder;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path("database/seeders/quarters.csv"), "r");
        $firstLine = true;

        while (($data = fgetcsv($file, 2000, ",")) != false) {
            if (!$firstLine) {
                Quarter::create([
                    'name' => $data[1],
                    'commune_id' => $data[2],
                ]);
            }
            $firstLine = false;
        }
        fclose($file);
    }
}
