<?php

use App\Models\AdminUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create', function () {
    $username = trim((string) $this->ask('Admin username'));

    if ($username === '' || mb_strlen($username) > 255) {
        $this->error('Enter an admin username up to 255 characters long.');

        return 1;
    }

    if (AdminUser::where('username', $username)->exists()) {
        $this->error('That admin username already exists.');

        return 1;
    }

    $password = $this->secret('Admin password (minimum 12 characters)');

    if (! is_string($password) || mb_strlen($password) < 12) {
        $this->error('The admin password must be at least 12 characters long.');

        return 1;
    }

    $confirmation = $this->secret('Confirm admin password');

    if (! is_string($confirmation) || ! hash_equals($password, $confirmation)) {
        $this->error('The password confirmation does not match.');

        return 1;
    }

    AdminUser::create([
        'username' => $username,
        'password' => Hash::make($password),
    ]);

    $this->info('Admin account created.');

    return 0;
})->purpose('Create an admin account with a securely entered password');
