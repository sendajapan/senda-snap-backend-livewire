<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
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

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'make' => $request->get('make'),
            'year' => $request->get('year'),
        ];

        $vehicles = $this->vehicleService->list($filters, $request->get('per_page', 15));

        return $this->successResponse('Vehicles retrieved successfully', [
            'vehicles' => VehicleResource::collection($vehicles->items()),
            'pagination' => [
                'current_page' => $vehicles->currentPage(),
                'last_page' => $vehicles->lastPage(),
                'per_page' => $vehicles->perPage(),
                'total' => $vehicles->total(),
            ],
        ]);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = $this->vehicleService->create($request->validated(), auth()->id());

        return $this->successResponse('Vehicle created successfully', [
            'vehicle' => new VehicleResource($vehicle),
        ], 201);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $this->successResponse('Vehicle retrieved successfully', [
            'vehicle' => new VehicleResource($vehicle),
        ]);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle = $this->vehicleService->update($vehicle, $request->validated());

        return $this->successResponse('Vehicle updated successfully', [
            'vehicle' => new VehicleResource($vehicle),
        ]);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $this->vehicleService->delete($vehicle);

        return $this->successResponse('Vehicle deleted successfully');
    }

    public function search(Request $request): JsonResponse
    {
        // Accept only query parameters for input
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
            'images.*' => 'required|file|image|max:2048', // max 2MB per image
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
