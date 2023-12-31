<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SeederFakeDataForTesting extends Seeder
{
    public function run(): void
    {
        $this->createDefaultUser();
    }

    private function createDefaultUser()
    {
        $uuid = Str::orderedUuid()->toString();
        $email = 'admin@recuperapp.com';

        return User::query()->firstOrCreate(
            compact('email'),
            User::factory()->raw(
                compact('uuid', 'email')
            )
        );
    }
}
