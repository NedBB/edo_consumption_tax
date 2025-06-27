<?php

namespace App\Services;

use App\Models\Assessmentrule;


class AssessmentRuleService{


    public function getAssessmentRuleId(int $profileId, int $assetId, int $taxpayerId): ?int{
        return AssessmentRule::where([
            ['profile_id', '=', $profileId],
            ['asset_id', '=', $assetId],
            ['taxpayer_id', '=', $taxpayerId]
        ])->value('assessment_rule_id');
    }

}
