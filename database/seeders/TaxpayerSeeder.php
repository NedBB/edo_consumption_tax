<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaxpayerSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_TaxPayer';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_TaxPayer';
       // $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_TaxPayer';
        // $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_TaxPayer';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_TaxPayer';
         $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_TaxPayer';

        //private $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
        //private $authUrl = 'https://apieirs.blouzatech.ng/api/Authentication/Login';
        $bearerToken = env('API_EIRS_TOKEN');
        $pageNumber = 1;
        $pageSize = 200;
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
                        'taxpayer_id' => $record['TaxPayerID'] ?? null,
                        "category_id" => 7,
                        'typeid' => $record['TaxPayerTypeID'] ?? null,
                        'typename' => $record['TaxPayerTypeName'] ?? null,
                        'name' => $record['TaxPayerName'] ?? null,
                        'rin' => $record['TaxPayerRIN'] ?? null,
                        'phone' => $record['MobileNumber'] ?? null,
                        'address' => $record['ContactAddress'] ?? null,
                        'email' => $record['EmailAddress'] ?? null,
                        'tin' => $record['TIN'] ?? null,
                        'tax_office' => $record['TaxOffice'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                // Insert in batches for better performance
                DB::table('taxpayers')->insert($batch);
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
