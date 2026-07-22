<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed 100 dummy users with unique yopmail.com email addresses.
     */
    public function run(): void
    {
        $usedEmails = User::query()->pluck('email')->flip()->all();

        for ($i = 0; $i < 100; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $email = $this->uniqueYopmailEmail($firstName, $lastName, $usedEmails);

            User::factory()->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => "{$firstName} {$lastName}",
                'email' => $email,
            ]);
        }
    }

    /**
     * Build a realistic-looking, unique @yopmail.com email for the given name.
     *
     * @param  array<string, bool>  $usedEmails
     */
    private function uniqueYopmailEmail(string $firstName, string $lastName, array &$usedEmails): string
    {
        $base = Str::slug($firstName).'.'.Str::slug($lastName);
        $email = "{$base}@yopmail.com";
        $suffix = 1;

        while (isset($usedEmails[$email])) {
            $email = "{$base}{$suffix}@yopmail.com";
            $suffix++;
        }

        $usedEmails[$email] = true;

        return $email;
    }
}
