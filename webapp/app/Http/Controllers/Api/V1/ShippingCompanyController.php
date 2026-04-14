<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShippingCompanyRequest;
use App\Http\Requests\UpdateShippingCompanyRequest;
use App\Http\Resources\ShippingCompanyResource;
use App\Models\ShipLine;
use App\Services\ShipLineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    public function __construct(
        protected ShipLineService $shipLineService
    ) {}

    /**
     * List all shipping companies with filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'sort_by' => $request->input('sort_by', 'line_name'),
            'sort_direction' => $request->input('sort_direction', 'asc'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $shippingCompanies = $this->shipLineService->list($filters, $perPage);

        return $this->successResponse('Shipping companies retrieved successfully', [
            'shipping_companies' => ShippingCompanyResource::collection($shippingCompanies->items()),
            'pagination' => [
                'current_page' => $shippingCompanies->currentPage(),
                'last_page' => $shippingCompanies->lastPage(),
                'per_page' => $shippingCompanies->perPage(),
                'total' => $shippingCompanies->total(),
            ],
        ]);
    }

    /**
     * Create a new shipping company
     */
    public function store(StoreShippingCompanyRequest $request): JsonResponse
    {
        $shippingCompany = $this->shipLineService->create($request->validated());

        return $this->successResponse('Shipping company created successfully', [
            'shipping_company' => new ShippingCompanyResource($shippingCompany),
        ], 201);
    }

    /**
     * Show a single shipping company
     */
    public function show(ShipLine $shippingCompany): JsonResponse
    {
        return $this->successResponse('Shipping company retrieved successfully', [
            'shipping_company' => new ShippingCompanyResource($shippingCompany),
        ]);
    }

    /**
     * Update an existing shipping company
     */
    public function update(UpdateShippingCompanyRequest $request, ShipLine $shippingCompany): JsonResponse
    {
        $updatedShippingCompany = $this->shipLineService->update($shippingCompany, $request->validated());

        return $this->successResponse('Shipping company updated successfully', [
            'shipping_company' => new ShippingCompanyResource($updatedShippingCompany),
        ]);
    }

    /**
     * Delete a shipping company
     */
    public function destroy(ShipLine $shippingCompany): JsonResponse
    {
        $this->shipLineService->delete($shippingCompany);

        return $this->successResponse('Shipping company deleted successfully', []);
    }
}
