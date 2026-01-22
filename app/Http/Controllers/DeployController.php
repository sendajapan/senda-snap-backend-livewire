<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeployController extends Controller
{
    //path for production server
    public function github(Request $request)
    {
        $secret = config('app.github_webhook_secret');

        $signature = $request->header('X-Hub-Signature-256');
        $payload = $request->getContent();

        $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($hash, $signature)) {
            return response('Invalid signature', Response::HTTP_FORBIDDEN);
        }

        if ($request->input('ref') !== 'refs/heads/master') {
            return response('Not master branch', 200);
        }

        exec('bash /var/www/deploy-senda.sh > /dev/null 2>&1 &');

        return response('Deployment started', 200);
    }
}
