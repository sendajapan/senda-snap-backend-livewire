<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct(
        protected VendorService $vendorService
    ) {
        // Only admin can access vendor management
        $this->middleware(function ($request, $next) {
            if (auth()->user()?->role !== 'admin') {
                abort(403, 'Only administrators can access vendor management.');
            }

            return $next($request);
        });
    }

    /**
     * List all vendors with filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_direction' => $request->input('sort_direction', 'desc'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $vendors = $this->vendorService->list($filters, $perPage);

        return $this->successResponse('Vendors retrieved successfully', [
            'vendors' => VendorResource::collection($vendors->items()),
            'pagination' => [
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'per_page' => $vendors->perPage(),
                'total' => $vendors->total(),
            ],
        ]);
    }

    /**
     * Create a new vendor
     */
    public function store(StoreVendorRequest $request): JsonResponse
    {
        $vendor = $this->vendorService->create($request->validated());

        return $this->successResponse('Vendor created successfully', [
            'vendor' => new VendorResource($vendor),
        ], 201);
    }

    /**
     * Show a single vendor
     */
    public function show(Vendor $vendor): JsonResponse
    {
        return $this->successResponse('Vendor retrieved successfully', [
            'vendor' => new VendorResource($vendor),
        ]);
    }

    /**
     * Update an existing vendor
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor): JsonResponse
    {
        $updatedVendor = $this->vendorService->update($vendor, $request->validated());

        return $this->successResponse('Vendor updated successfully', [
            'vendor' => new VendorResource($updatedVendor),
        ]);
    }

    /**
     * Delete a vendor
     */
    public function destroy(Vendor $vendor): JsonResponse
    {
        $this->vendorService->delete($vendor);

        return $this->successResponse('Vendor deleted successfully', []);
    }
}
