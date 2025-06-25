<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TaxpayerSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_TaxPayer';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_TaxPayer';
       // $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_TaxPayer';
        // $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_TaxPayer';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_TaxPayer';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_TaxPayer';

        //private $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
        //private $authUrl = 'https://apieirs.blouzatech.ng/api/Authentication/Login';
        $bearerToken = env('API_EIRS_TOKEN');
        $pageNumber = 1;
        $pageSize = 50;
        $totalProcessed = 0;
        $usersCreated = 0;

        // do {
        //     $response = Http::withHeaders([
        //         'Authorization' => 'Bearer ' . $bearerToken,
        //         'Accept' => 'application/json'
        //     ])->get($apiUrl, [
        //         'pageNumber' => $pageNumber,
        //         'pageSize' => $pageSize
        //     ]);

        //     if ($response->successful()) {
        //         $data = $response->json();
        //         $records = $data['Result'] ?? [];

        //         if (empty($records)) {
        //             break;
        //         }

        //         $batch = [];
        //         foreach ($records as $record) {
        //             $batch[] = [
        //                 'taxpayer_id' => $record['TaxPayerID'] ?? null,
        //                 "category_id" => 7,
        //                 'typeid' => $record['TaxPayerTypeID'] ?? null,
        //                 'typename' => $record['TaxPayerTypeName'] ?? null,
        //                 'name' => $record['TaxPayerName'] ?? null,
        //                 'rin' => $record['TaxPayerRIN'] ?? null,
        //                 'phone' => $record['MobileNumber'] ?? null,
        //                 'address' => $record['ContactAddress'] ?? null,
        //                 'email' => $record['EmailAddress'] ?? null,
        //                 'tin' => $record['TIN'] ?? null,
        //                 'tax_office' => $record['TaxOffice'] ?? null,
        //                 'created_at' => now(),
        //                 'updated_at' => now()
        //             ];
        //         }

        //         // Insert in batches for better performance
        //         DB::table('taxpayers')->insert($batch);
        //         $totalProcessed += count($batch);
        //         $pageNumber++;

        //         Log::info("Processed batch. Total records: {$totalProcessed}");
        //     }
        //     else {
        //         if ($response->status() === 401) {
        //             // Token might be expired, try to re-authenticate
        //             // if (!$this->authenticate()) {
        //             //     Log::error('Failed to re-authenticate');
        //             //     break;
        //             // }
        //             continue;
        //         }
        //         Log::error("API request failed: " . $response->status());
        //         break;
        //     }

        //     // Rate limiting
        //     sleep(1);

        // } while (true);

        // Log::info("Completed seeding. Total records: {$totalProcessed}");

        do {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken,
            'Accept' => 'application/json'
        ])->get($apiUrl, [
            'pageNumber' => $pageNumber,
            'pageSize' => $pageSize
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $records = $data['Result'] ?? [];

            if (empty($records)) {
                break;
            }

            foreach ($records as $record) {
                // Generate email if not provided
                $email = $record['EmailAddress'] ?? null;
                if (empty($email)) {
                    $rin = $record['TaxPayerRIN'] ?? Str::random(8);
                    $email = "taxpayer_{$rin}@example.com";
                }

                // Create or get user
                $userId = DB::table('users')->where('email', $email)->value('id');

                if (!$userId) {
                    $userId = DB::table('users')->insertGetId([
                        'name' => $record['TaxPayerName'] ?? 'Tax Payer',
                        'email' => $email,
                        'password' => Hash::make(Str::random(12)),
                        'type' => 'user',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $usersCreated++;
                }

                // Create taxpayer record with user_id
                DB::table('taxpayers')->insert([
                    'user_id' => $userId,
                    'taxpayer_id' => $record['TaxPayerID'] ?? null,
                    "category_id" => 1,
                    'typeid' => $record['TaxPayerTypeID'] ?? null,
                    'typename' => $record['TaxPayerTypeName'] ?? null,
                    'name' => $record['TaxPayerName'] ?? null,
                    'rin' => $record['TaxPayerRIN'] ?? null,
                    'phone' => $record['MobileNumber'] ?? null,
                    'address' => $record['ContactAddress'] ?? null,
                    'email' => $email,
                    'tin' => $record['TIN'] ?? null,
                    'tax_office' => $record['TaxOffice'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $totalProcessed++;
            }

            $pageNumber++;
            Log::info("Processed batch. Total taxpayers: {$totalProcessed}, Users created: {$usersCreated}");
        }
        else {
            if ($response->status() === 401) {
                continue;
            }
            Log::error("API request failed: " . $response->status());
            break;
        }

        // Rate limiting
        sleep(1);

    } while (true);

    Log::info("Completed seeding. Total taxpayers: {$totalProcessed}, Users created: {$usersCreated}");
    }
}
