<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Api::updateOrCreate(
            ['id' => 1],
            [
                'nx_agent_code' => env('GGR_AGENT_CODE'),
                'nx_token' => env('GGR_AGENT_TOKEN'),
                'nx_endpoint' => env('GGR_API_URL', 'https://api.nexusggr.com'),
                'nx_status' => 1,
                'sg_status' => 0,
                'wsg_status' => 0,
                'ng_status' => 0,
            ]
        );
    }
}
