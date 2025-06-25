<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $url = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_TaxPayer';
        //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_Asset';
        // $apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_Asset';
         //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_Asset';
         //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_Asset';
         //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_Asset';
         //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_Asset';
         $apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_Asset';

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
                        'asset_id' => $record['BusinessID'] ?? null,
                        'taxpayer_id' => $record['TaxPayerID'] ?? null,
                        "category_id" => 7,
                        'asset_type_id' => $record['AssetTypeID'] ?? null,
                        'asset_type_name' => $record['AssetTypeName'] ?? null,
                        'business_type_id' => $record['BusinessTypeID'] ?? null,
                        'business_type_name' => $record['BusinessTypeName'] ?? null,
                        'business_rin' => $record['BusinessRIN'] ?? null,
                        'business_name' => $record['BusinessName'] ?? null,
                        'lga_id' => $record['LGAID'] ?? null,
                        'lga_name' => $record['LGAName'] ?? null,
                        'business_category_id' => $record['BusinessCategoryID'] ?? null,
                        'business_category_name' => $record['BusinessCategoryName'] ?? null,
                        'business_sector_id' => $record['BusinessSectorID'] ?? null,
                        'business_sector_name' => $record['BusinessSectorName'] ?? null,
                        'business_sub_sector_id' => $record['BusinessSubSectorID'] ?? null,
                        'business_sub_sector_name' => $record['BusinessSubSectorName'] ?? null,
                        'business_structure_id' => $record['BusinessStructureID'] ?? null,
                        'business_structure_name' => $record['BusinessStructureName'] ?? null,
                        'business_operation_id' => $record['BusinessOperationID'] ?? null,
                        'business_operation_name' => $record['BusinessOperationName'] ?? null,
                        'size_id' => $record['SizeID'] ?? null,
                        'size_name' => $record['SizeName'] ?? null,
                        'contact_name' => $record['ContactName'] ?? null,
                        'business_number' => $record['BusinessNumber'] ?? null,
                        'business_address' => $record['BusinessAddress'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                // Insert in batches for better performance
                DB::table('assets')->insertOrIgnore($batch);
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
