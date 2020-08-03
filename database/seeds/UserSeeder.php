<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class, 1)->create();
        Log::info('api_token:' . $user->toArray()[0]['api_token']);
    }
}
