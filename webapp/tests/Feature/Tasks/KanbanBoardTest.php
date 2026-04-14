<?php

use App\Livewire\Tasks\KanbanBoard;
use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Livewire;

test('kanban board page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/tasks/kanban')->assertOk();
});

test('kanban board displays tasks grouped by status', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['created_by' => $user->id]);

    $pendingTask = Task::factory()->create([
        'status' => 'pending',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $runningTask = Task::factory()->create([
        'status' => 'running',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $completedTask = Task::factory()->create([
        'status' => 'completed',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $this->actingAs($user);

    Livewire::test(KanbanBoard::class)
        ->assertSee($pendingTask->title)
        ->assertSee($runningTask->title)
        ->assertSee($completedTask->title);
});

test('kanban board can update task status', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['created_by' => $user->id]);

    $task = Task::factory()->create([
        'status' => 'pending',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $this->actingAs($user);

    Livewire::test(KanbanBoard::class)
        ->call('updateTaskStatus', $task->id, 'running')
        ->assertDispatched('notify');

    expect($task->fresh()->status)->toBe('running');
});

test('kanban board filters tasks by search', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['created_by' => $user->id]);

    $task1 = Task::factory()->create([
        'title' => 'Important Task',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $task2 = Task::factory()->create([
        'title' => 'Regular Task',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $this->actingAs($user);

    Livewire::test(KanbanBoard::class)
        ->set('search', 'Important')
        ->assertSee('Important Task')
        ->assertDontSee('Regular Task');
});

test('kanban board filters tasks by priority', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['created_by' => $user->id]);

    $highPriorityTask = Task::factory()->create([
        'priority' => 'high',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $lowPriorityTask = Task::factory()->create([
        'priority' => 'low',
        'created_by' => $user->id,
        'vehicle_id' => $vehicle->id,
    ]);

    $this->actingAs($user);

    Livewire::test(KanbanBoard::class)
        ->set('priorityFilter', 'high')
        ->assertSee($highPriorityTask->title)
        ->assertDontSee($lowPriorityTask->title);
});

test('kanban board can clear filters', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(KanbanBoard::class)
        ->set('search', 'test')
        ->set('priorityFilter', 'high')
        ->call('clearFilters')
        ->assertSet('search', null)
        ->assertSet('priorityFilter', null);
});
