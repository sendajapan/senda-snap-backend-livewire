<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use App\Services\ExternalVehicleService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class VehicleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Vehicle::with(['creator', 'photos', 'consignee', 'tasks']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('chassis_model', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by make
        if ($request->has('make')) {
            $query->where('make', 'like', "%{$request->get('make')}%");
        }

        // Filter by year
        if ($request->has('year')) {
            $query->where('year', $request->get('year'));
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return $this->successResponse('Vehicles retrieved successfully', [
            'vehicles' => $vehicles->items(),
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
        $vehicle = Vehicle::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $this->successResponse('Vehicle created successfully', [
            'vehicle' => $vehicle,
        ], 201);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $this->successResponse('Vehicle retrieved successfully', [
            'vehicle' => $vehicle,
        ]);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($request->validated());

        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $this->successResponse('Vehicle updated successfully', [
            'vehicle' => $vehicle,
        ]);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

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

        // Get the user infor
        $user = $request->user();

        $service = new ExternalVehicleService;

        try {
            $results = $service->getVehicleDetails(
                (string)$input['search_type'],
                (string)$input['search_query']
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

        $user = $request->user();

        $service = new ExternalVehicleService;

        try {
            $results = $service->getVehicleDetails('vehicle_id', (string)$request->vehicle_id);

            if (empty($results)) {
                return $this->errorResponse('Vehicle not found', [], 404);
            }

            $vehicle = $results[0];

            $uploadedImages = [];
            $uploadedFiles = $request->file('images', []);

            foreach ($uploadedFiles as $index => $file) {
                $dummyFileName = 'uploaded_' . $request->vehicle_id . '_' . time() . '_' . ($index + 1) . '.' . $file->getClientOriginalExtension();
                $dummyUrl = 'https://senda.us/autocraft/avisnew/images/veh_images/uploaded/' . $dummyFileName;
                $uploadedImages[] = $dummyUrl;
            }

            $existingImages = $vehicle['images'] ?? [];
            $vehicle['images'] = array_merge($existingImages, $uploadedImages);

            return $this->successResponse('Images uploaded successfully', [
                'vehicle' => $vehicle,
            ]);

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
