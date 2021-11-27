<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\admin;

class adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
            admin::factory()->times(1)->create();
       
    }
}
