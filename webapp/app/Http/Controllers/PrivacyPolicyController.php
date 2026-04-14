<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PrivacyPolicyController extends Controller
{
    public function index(): View
    {
        $policyData = json_decode(file_get_contents(base_path('privacy_policy_data.json')), true);

        return view('privacy-policy', [
            'policyData' => $policyData,
        ]);
    }
}
