<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ApiSeamles;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api = new ApiSeamles();
        $api->agentcode = 'E681';
        $api->secretkey = 'SCpQ3x';
        $api->url = 'https://swmd.6633663.com/';
        $api->save();
    }
}
