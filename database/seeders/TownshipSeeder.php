<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Seeder;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file=fopen(base_path("database/seeders/townships.csv"),"r");
        $firstLine = true;

        while(($data = fgetcsv($file, 2000, ","))!=false){
            if (!$firstLine) {
                Township::create([
                    'name' => $data[1],
                ]);
            }
            $firstLine = false;
        }
        fclose($file);
    }
}
