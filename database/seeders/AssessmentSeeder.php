<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Bars_Assessment';
       //$apiUrl ='https://apieirs.blouzatech.ng/SupplierData/CTC_Hotels_Assessment';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Guest_Houses_Assessment';
        //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Motels_Assessment';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Event_Centers_Assessment';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Restaurants_Assessment';
         //$apiUrl = 'https://apieirs.blouzatech.ng/SupplierData/CTC_Online_Drink_Trading_Assessment';


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
                        'assessment_id' => $record['AssessmentID'] ?? null,
                        'taxpayer_id' => $record['TaxPayerID'] ?? null,
                        'profile_id' => $record['ProfileID'] ?? null,
                        'asset_id' => $record['AssetID'] ?? null,
                        "category_id" => 1,
                        'assessment_ref_no' => $record['AssessmentRefNo'] ?? null,
                        'assessment_date' => $record['AssessmentDate'] ?? null,
                        'assessment_amount' => $record['AssessmentAmount'] ?? 0.00,
                        'settlement_due_date' => $record['SettlementDueDate'] ?? null,
                        'settlement_status_id' => $record['SettlementStatusID'] ?? null,
                        'settlement_status_name' => $record['SettlementStatusName'] ?? null,
                        'settlement_date' => $record['SettlementDate'] ?? null,
                        'assessment_notes' => $record['AssessmentNotes'] ?? null,
                        'assessment_rule_id' => $record['AssessmentRuleID'] ?? null,
                        'assessment_rule_code' => $record['AssessmentRuleCode'] ?? null,
                        'assessment_rule_name' => $record['AssessmentRuleName'] ?? null,
                        'assessment_rule_amount' => $record['AssessmentRuleAmount'] ?? 0.00,
                        'assessment_item_id' => $record['AssessmentItemID'] ?? 0,
                        'assessment_item_reference_no' => $record['AssessmentItemReferenceNo'] ?? null,
                        'assessment_item_name' => $record['AssessmentItemName'] ?? null,
                        'tax_base_amount' => $record['TaxBaseAmount'] ?? 0.00,
                        'percentage' => $record['Percentage'] ?? 0.00,
                        'tax_amount' => $record['TaxAmount'] ?? 0.00,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                // Insert in batches for better performance
                DB::table('assessments')->insert($batch);
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
