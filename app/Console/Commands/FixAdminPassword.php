<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixAdminPassword extends Command
{
    protected $signature = 'admin:fix-password';
    protected $description = 'Fix admin password if hash verification fails';

    public function handle()
    {
        $admin = User::where('email', 'admin@barangay.gov')->first();

        if (!$admin) {
            $this->error('Admin user not found, creating new one...');
            User::create([
                'email' => 'admin@barangay.gov',
                'first_name' => 'System',
                'surname' => 'Administrator',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
                'status' => 'approved',
            ]);
            $this->info('Admin user created with email: admin@barangay.gov and password: Admin@1234');
            return;
        }

        // Update password hash
        $admin->password = Hash::make('Admin@1234');
        $admin->save();

        $this->info('✓ Admin password fixed!');
        $this->info('Email: ' . $admin->email);
        $this->info('Password: Admin@1234');
        $this->info('Role: ' . $admin->role);
        $this->info('Status: ' . $admin->status);
    }
}
