<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\VehicleService;
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
        // just take the query params only, no body needed here
        $input = [
            'search_type' => $request->query('search_type'),
            'search_query' => $request->query('search_query'),
        ];

        $validator = Validator::make($input, [
            'search_type' => 'required|string|in:vehicle_id,veh_chassis_number',
            'search_query' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $results = $this->vehicleService->search(
                (string) $input['search_type'],
                (string) $input['search_query']
            );

            return $this->successResponse('Search completed', [
                'vehicles' => $results,
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

    public function uploadImages(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'required|file|image|max:2048', // each image can be max 2MB la
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $vehicle = $this->vehicleService->uploadImages(
                $request->vehicle_id,
                $request->file('images', [])
            );

            return $this->successResponse('Images uploaded successfully', [
                'vehicle' => $vehicle,
            ]);

        } catch (\RuntimeException $e) {

            return $this->errorResponse($e->getMessage(), [], 404);

        } catch (QueryException $e) {

            return $this->errorResponse('External database query failed', [
                'error' => $e->getMessage(),
            ], 502);

        } catch (Throwable $e) {

            return $this->errorResponse('Failed to upload images', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
