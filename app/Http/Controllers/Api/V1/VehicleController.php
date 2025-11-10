<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
