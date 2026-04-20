<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VehicleSearchLog;
use App\Services\VehicleService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class VehicleController extends Controller
{
    public function __construct(
        protected VehicleService $vehicleService
    ) {}

    public function search(Request $request): JsonResponse
    {
        $input = [
            'search_type' => $request->query('search_type'),
            'search_query' => $request->query('search_query'),
            'company' => $request->query('company'),
        ];

        $validator = Validator::make($input, [
            'search_type' => 'required|string|in:vehicle_id,veh_chassis_number',
            'search_query' => 'required|string',
            'company' => 'required|string|in:acjl,karmen',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $results = $this->vehicleService->search(
                (string) $input['search_type'],
                (string) $input['search_query'],
                (string) $input['company']
            );

            // Log the search
            try {
                VehicleSearchLog::create([
                    'user_id' => auth()->id(),
                    'vendor_id' => $results['vendor_id'] ?? null,
                    'search_type' => $input['search_type'],
                    'search_query' => $input['search_query'],
                    'vehicles_found' => count($results['vehicles'] ?? []),
                    'vehicle_ids' => array_column($results['vehicles'] ?? [], 'vehicle_id'),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                // Don't fail the request if logging fails
                \Log::warning('Failed to log vehicle search', [
                    'error' => $e->getMessage(),
                ]);
            }

            return $this->successResponse('Search completed', [
                'vehicles' => $results['vehicles'],
                'company' => $input['company'],
            ]);
        } catch (QueryException $e) {

            return $this->errorResponse('External database query failed', [
                'sql' => method_exists($e, 'getSql') ? $e->getSql() : null,
                'bindings' => method_exists($e, 'getBindings') ? $e->getBindings() : [],
                'error' => $e->getMessage(),
            ], 502);

        } catch (\Throwable $e) {

            return $this->errorResponse('External database error', [
                'error' => $e->getMessage(),
                'exception' => get_class($e),
            ], 502);
        }
    }

    public function yardVehicles(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'yard_id' => 'required|integer|min:1',
            'company' => 'required|string|in:acjl,karmen',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $results = $this->vehicleService->getYardVehicles(
                (int) $request->input('yard_id'),
                (string) $request->input('company')
            );

            return $this->successResponse('Yard vehicles retrieved', [
                'vehicles' => $results['vehicles'],
                'count'    => count($results['vehicles']),
            ]);

        } catch (QueryException $e) {
            return $this->errorResponse('External database query failed', [
                'sql'      => method_exists($e, 'getSql') ? $e->getSql() : null,
                'bindings' => method_exists($e, 'getBindings') ? $e->getBindings() : [],
                'error'    => $e->getMessage(),
            ], 502);

        } catch (\Throwable $e) {
            return $this->errorResponse('External database error', [
                'error'     => $e->getMessage(),
                'exception' => get_class($e),
            ], 502);
        }
    }

    public function uploadImages(Request $request): JsonResponse
    {
        $user = auth()->user();

        if ($user !== null && isset($user->email) && is_string($user->email) && str_contains(strtolower($user->email), 'test')) {
            return $this->successResponse('Images will not be uploaded by tester', [
                'vehicle' => null,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'required|file|image|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $createdBy = auth()->id() ?? 0;
            $vehicle = $this->vehicleService->uploadImages(
                $request->vehicle_id,
                $request->file('images', []),
                $createdBy
            );

            return $this->successResponse('Images uploaded successfully', [
                'vehicle' => $vehicle,
            ]);

        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage(), [
                'error' => $e->getMessage(),
            ], 404);

        } catch (Throwable $e) {

            return $this->errorResponse('Failed to upload images', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
