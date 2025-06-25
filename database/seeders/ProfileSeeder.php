<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // $url = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
        $apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_Profile';
       //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_Profile';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_Profile';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_Profile';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_Profile';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_Profile';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_Profile';


        $bearerToken = env('API_EIRS_TOKEN');
        $pageNumber = 1;
        $pageSize = 50;
        $totalProcessed = 0;

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

                $batch = [];
                foreach ($records as $record) {
                    $batch[] = [
                        'profile_id' => $record['ProfileID'] ?? null,
                        "category_id" => 1,
                        'asset_id' => $record['AssetID'] ?? null,
                        'asset_type' => $record['AssetTypeName'] ?? null,
                        'asset_rin' => $record['AssetRIN'] ?? 'not added',
                        'reference_no' => $record['ProfileReferenceNo'] ?? null,
                        'description' => $record['ProfileDescription'] ?? null,
                        'taxplayer_role_id' => $record['TaxPayerRoleID'] ?? null,
                        'taxplayer_role_name' => $record['TaxPayerRIN'] ?? 'not added',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                // Insert in batches for better performance
                DB::table('profiles')->insert($batch);
                $totalProcessed += count($batch);
                $pageNumber++;

                Log::info("Processed batch. Total records: {$totalProcessed}");
            }
            else {
                if ($response->status() === 401) {
                    // Token might be expired, try to re-authenticate
                    // if (!$this->authenticate()) {
                    //     Log::error('Failed to re-authenticate');
                    //     break;
                    // }
                    continue;
                }
                Log::error("API request failed: " . $response->status());
                break;
            }

            // Rate limiting
            sleep(1);

        } while (true);

        Log::info("Completed seeding. Total records: {$totalProcessed}");
    }
}
