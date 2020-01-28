<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = \Faker\Factory::create();

        $cont = 15;

        while($cont > 0)
        {
            DB::table('topics')->insert([
                'city_id' => 3374,
                'title' => $faker->name(['famale']),
                'cellphone' => $faker->phoneNumber,
                'active' => true,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:m:i'),
                'updated_at' => date('Y-m-d H:m:i')
            ]);

            $cont = $cont -1;
        }
        
        
    }
}
