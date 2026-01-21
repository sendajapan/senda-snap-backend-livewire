<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleStopoverRequest;
use App\Http\Requests\UpdateScheduleStopoverRequest;
use App\Http\Resources\ScheduleStopoverResource;
use App\Models\Schedule;
use App\Models\ScheduleStopover;
use App\Services\ScheduleStopoverService;
use Illuminate\Http\JsonResponse;

class ScheduleStopoverController extends Controller
{
    public function __construct(
        protected ScheduleStopoverService $stopoverService
    ) {}

    /**
     * Create a new stopover
     */
    public function store(StoreScheduleStopoverRequest $request, Schedule $schedule): JsonResponse
    {
        $data = $request->validated();
        $data['schedule_id'] = $schedule->id;

        $stopover = $this->stopoverService->create($data, auth()->id());

        return $this->successResponse('Stopover created successfully', [
            'stopover' => new ScheduleStopoverResource($stopover),
        ], 201);
    }

    /**
     * Show a single stopover
     */
    public function show(ScheduleStopover $stopover): JsonResponse
    {
        $stopover->load(['schedule', 'port', 'addedBy']);

        return $this->successResponse('Stopover retrieved successfully', [
            'stopover' => new ScheduleStopoverResource($stopover),
        ]);
    }

    /**
     * Update an existing stopover
     */
    public function update(UpdateScheduleStopoverRequest $request, ScheduleStopover $stopover): JsonResponse
    {
        $updatedStopover = $this->stopoverService->update($stopover, $request->validated());

        return $this->successResponse('Stopover updated successfully', [
            'stopover' => new ScheduleStopoverResource($updatedStopover),
        ]);
    }

    /**
     * Delete a stopover
     */
    public function destroy(ScheduleStopover $stopover): JsonResponse
    {
        $user = auth()->user();

        // Only admin or manager can delete stopovers
        if (! in_array($user->role, ['admin', 'manager'])) {
            return $this->errorResponse('Unauthorized. Only admin or manager can delete stopovers.', [], 403);
        }

        $this->stopoverService->delete($stopover);

        return $this->successResponse('Stopover deleted successfully', []);
    }
}
