<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(
        protected ScheduleService $scheduleService
    ) {}

    /**
     * List all schedules with filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->input('search'),
            'vessel_name' => $request->input('vessel_name'),
            'voyage_no' => $request->input('voyage_no'),
            'carrier_id' => $request->input('carrier_id'),
            'start_port_id' => $request->input('start_port_id'),
            'end_port_id' => $request->input('end_port_id'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $schedules = $this->scheduleService->list($filters, $perPage);

        return $this->successResponse('Schedules retrieved successfully', [
            'schedules' => ScheduleResource::collection($schedules->items()),
            'pagination' => [
                'current_page' => $schedules->currentPage(),
                'last_page' => $schedules->lastPage(),
                'per_page' => $schedules->perPage(),
                'total' => $schedules->total(),
            ],
        ]);
    }

    /**
     * Create a new schedule
     */
    public function store(StoreScheduleRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->create($request->validated(), auth()->id());

        return $this->successResponse('Schedule created successfully', [
            'schedule' => new ScheduleResource($schedule),
        ], 201);
    }

    /**
     * Show a single schedule
     */
    public function show(Schedule $schedule): JsonResponse
    {
        $schedule->load([
            'carrier1',
            'carrier2',
            'carrier3',
            'startPort',
            'endPort',
            'stopovers.port',
            'addedBy',
        ]);

        return $this->successResponse('Schedule retrieved successfully', [
            'schedule' => new ScheduleResource($schedule),
        ]);
    }

    /**
     * Update an existing schedule
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule): JsonResponse
    {
        $updatedSchedule = $this->scheduleService->update($schedule, $request->validated());

        return $this->successResponse('Schedule updated successfully', [
            'schedule' => new ScheduleResource($updatedSchedule),
        ]);
    }

    /**
     * Delete a schedule
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $user = auth()->user();

        // Only admin or manager can delete schedules
        if (! in_array($user->role, ['admin', 'manager'])) {
            return $this->errorResponse('Unauthorized. Only admin or manager can delete schedules.', [], 403);
        }

        $this->scheduleService->delete($schedule);

        return $this->successResponse('Schedule deleted successfully', []);
    }
}
