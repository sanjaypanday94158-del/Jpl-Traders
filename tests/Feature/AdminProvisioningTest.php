<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProvisioningTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_command_creates_account_with_confirmed_hashed_password(): void
    {
        $password = 'production-safe-password';

        $this->artisan('admin:create')
            ->expectsQuestion('Admin username', 'site-admin')
            ->expectsQuestion('Admin password (minimum 12 characters)', $password)
            ->expectsQuestion('Confirm admin password', $password)
            ->expectsOutputToContain('Admin account created.')
            ->assertExitCode(0);

        $admin = AdminUser::where('username', 'site-admin')->firstOrFail();

        $this->assertNotSame($password, $admin->password);
        $this->assertTrue(Hash::check($password, $admin->password));
    }

    public function test_admin_create_command_rejects_password_confirmation_mismatch(): void
    {
        $this->artisan('admin:create')
            ->expectsQuestion('Admin username', 'site-admin')
            ->expectsQuestion('Admin password (minimum 12 characters)', 'production-safe-password')
            ->expectsQuestion('Confirm admin password', 'different-secure-password')
            ->expectsOutputToContain('The password confirmation does not match.')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('admin_users', ['username' => 'site-admin']);
    }
}
