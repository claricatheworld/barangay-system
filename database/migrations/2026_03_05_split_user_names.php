<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new name fields
            $table->string('first_name')->nullable()->after('email');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('surname')->nullable()->after('middle_name');
        });

        // Migrate existing data from 'name' to new fields
        try {
            $users = DB::table('users')->whereNotNull('name')->get();
            
            foreach ($users as $user) {
                $nameParts = explode(' ', $user->name, 3);
                $firstName = $nameParts[0] ?? '';
                $middleName = $nameParts[1] ?? '';
                $surname = $nameParts[2] ?? '';

                DB::table('users')->where('id', $user->id)->update([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'surname' => $surname,
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't fail migration
            \Illuminate\Support\Facades\Log::error('Name migration error: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_name', 'surname']);
        });
    }
};
