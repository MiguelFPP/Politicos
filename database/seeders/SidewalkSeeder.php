<?php

namespace Database\Seeders;

use App\Models\Sidewalk;
use Illuminate\Database\Seeder;

class SidewalkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file=fopen(base_path("database/seeders/sidewalks.csv"),"r");
        $firstLine = true;

        while(($data = fgetcsv($file, 2000, ","))!=false){
            if (!$firstLine) {
                Sidewalk::create([
                    'name' => $data[1],
                    'township_id' => $data[2],
                ]);
            }
            $firstLine = false;
        }
        fclose($file);
    }
}
