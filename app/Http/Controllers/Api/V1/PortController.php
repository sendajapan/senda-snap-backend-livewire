<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortRequest;
use App\Http\Requests\UpdatePortRequest;
use App\Http\Resources\PortResource;
use App\Models\Port;
use App\Services\PortService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function __construct(
        protected PortService $portService
    ) {}

    /**
     * List all ports with filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'port_type' => $request->input('port_type'),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_direction' => $request->input('sort_direction', 'desc'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $ports = $this->portService->list($filters, $perPage);

        return $this->successResponse('Ports retrieved successfully', [
            'ports' => PortResource::collection($ports->items()),
            'pagination' => [
                'current_page' => $ports->currentPage(),
                'last_page' => $ports->lastPage(),
                'per_page' => $ports->perPage(),
                'total' => $ports->total(),
            ],
        ]);
    }

    /**
     * Create a new port
     */
    public function store(StorePortRequest $request): JsonResponse
    {
        $port = $this->portService->create($request->validated());

        return $this->successResponse('Port created successfully', [
            'port' => new PortResource($port),
        ], 201);
    }

    /**
     * Show a single port
     */
    public function show(Port $port): JsonResponse
    {
        return $this->successResponse('Port retrieved successfully', [
            'port' => new PortResource($port),
        ]);
    }

    /**
     * Update an existing port
     */
    public function update(UpdatePortRequest $request, Port $port): JsonResponse
    {
        $updatedPort = $this->portService->update($port, $request->validated());

        return $this->successResponse('Port updated successfully', [
            'port' => new PortResource($updatedPort),
        ]);
    }

    /**
     * Delete a port
     */
    public function destroy(Port $port): JsonResponse
    {
        $this->portService->delete($port);

        return $this->successResponse('Port deleted successfully', []);
    }
}
