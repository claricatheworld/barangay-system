<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixOfficialPassword extends Command
{
    protected $signature = 'official:fix-password';
    protected $description = 'Fix official password if hash verification fails';

    public function handle()
    {
        $official = User::where('email', 'official@barangay.gov')->first();

        if (!$official) {
            $this->error('Official user not found, creating new one...');
            User::create([
                'email' => 'official@barangay.gov',
                'first_name' => 'Juan',
                'surname' => 'Dela Cruz',
                'password' => Hash::make('Official@1234'),
                'role' => 'official',
                'status' => 'approved',
            ]);
            $this->info('Official user created with email: official@barangay.gov and password: Official@1234');
            return;
        }

        // Update password hash
        $official->password = Hash::make('Official@1234');
        $official->save();

        $this->info('✓ Official password fixed!');
        $this->info('Email: ' . $official->email);
        $this->info('Password: Official@1234');
        $this->info('Role: ' . $official->role);
        $this->info('Status: ' . $official->status);
    }
}
