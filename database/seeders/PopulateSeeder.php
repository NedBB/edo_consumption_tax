<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PopulateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxpayers = DB::table('taxpayers')
        ->whereNull('user_id')
        ->get();

        $usersCreated = 0;
        $taxpayersUpdated = 0;

        foreach ($taxpayers as $taxpayer) {
        // Generate email if not provided (use taxpayer email or create a default)
            $email = $taxpayer->email ?? "taxpayer_{$taxpayer->rin}@example.com";

            // Check if user already exists with this email
            $user = DB::table('users')
                ->where('email', $email)
                ->first();

            // Create user if doesn't exist
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                'name' => $taxpayer->name ?? 'Tax Payer',
                'email' => $email,
                'password' => Hash::make(Str::random(12)),
                "type"=>'user',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $usersCreated++;
        } else {
            $userId = $user->id;
        }

        // Update taxpayer with user_id
        DB::table('taxpayers')
            ->where('id', $taxpayer->id)
            ->update(['user_id' => $userId]);

        $taxpayersUpdated++;
    }
  }
}
