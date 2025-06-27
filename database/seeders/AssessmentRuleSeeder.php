<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssessmentRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_AssessmentRule';
       //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_AssessmentRule';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_AssessmentRule';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_AssessmentRule';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_AssessmentRule';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_AssessmentRule';
         $apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_AssessmentRule';

        $bearerToken = env('API_EIRS_TOKEN');
        $pageNumber = 1;
        $pageSize = 1000;
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
                foreach ($records as $apiData) {

                    $batch[] = [
                        'assessment_rule_id' => $apiData['AssessmentRuleID'],
                        'category_id' => 7, // set appropriately
                        'asset_id' => $apiData['AssetID'],
                        'taxpayer_id' => $apiData['TaxPayerID'],
                        'profile_id' => $apiData['ProfileID'],
                        'assessment_rule_code' => $apiData['AssessmentRuleCode'],
                        'assessment_rule_name' => $apiData['AssessmentRuleName'],
                        'rule_run_id' => $apiData['RuleRunID'],
                        'rule_run_name' => $apiData['RuleRunName'],
                        'payment_frequency_id' => $apiData['PaymentFrequencyID'],
                        'payment_frequency_name' => $apiData['PaymentFrequencyName'],
                        'payment_option_id' => $apiData['PaymentOptionID'],
                        'payment_option_name' => $apiData['PaymentOptionName'],
                        'assessment_amount' => $apiData['AssessmentAmount'],
                        'tax_year' => $apiData['TaxYear'],
                        'tax_month' => $apiData['TaxMonth'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                 // Insert in batches for better performance
                DB::table('assessmentrules')->insert($batch);
                $totalProcessed += count($batch);
                $pageNumber++;

                Log::info("Processed batch. Total records: {$totalProcessed}");
            }
            else{
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
            sleep(1);
        }while (true);

        Log::info("Completed seeding. Total records: {$totalProcessed}");
    }
}
