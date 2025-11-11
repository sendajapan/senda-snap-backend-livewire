<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for assignment
        $admin = User::where('email', 'sulaiman@sendasnap.com')->first();
        $manager = User::where('email', 'acj.shiroyama@gmail.com')->first();
        $employees = User::where('role', 'employee')->get();

        if (! $admin || ! $manager || $employees->isEmpty()) {
            $this->command->error('Users must be seeded first. Run UserSeeder before TaskSeeder.');

            return;
        }

        // Create tasks for today
        $this->command->info('Creating today\'s tasks...');

        // Morning task - Urgent
        $task1 = Task::create([
            'title' => 'Vehicle Inspection - Toyota Camry',
            'description' => 'Complete full inspection including brakes, tires, and fluids before customer pickup.',
            'work_date' => today(),
            'work_time' => '09:00:00',
            'status' => 'pending',
            'priority' => 'urgent',
            'created_by' => $admin->id,
            'due_date' => today()->addHours(3),
        ]);
        $task1->assignedUsers()->sync($employees->random(2)->pluck('id'));

        // Midday task - High priority
        $task2 = Task::create([
            'title' => 'Customer Delivery - Airport',
            'description' => 'Deliver Honda Accord to customer at international airport terminal 3.',
            'work_date' => today(),
            'work_time' => '12:30:00',
            'status' => 'running',
            'priority' => 'high',
            'created_by' => $manager->id,
            'due_date' => today()->addHours(5),
        ]);
        $task2->assignedUsers()->sync($employees->random(1)->pluck('id'));

        // Afternoon task - Medium priority
        $task3 = Task::create([
            'title' => 'Vehicle Cleaning - Fleet Service',
            'description' => 'Deep clean and detail 3 vehicles returned from weekly rentals.',
            'work_date' => today(),
            'work_time' => '14:00:00',
            'status' => 'pending',
            'priority' => 'medium',
            'created_by' => $manager->id,
            'due_date' => today()->endOfDay(),
        ]);
        $task3->assignedUsers()->sync($employees->random(3)->pluck('id'));

        // Late afternoon task - Low priority
        $task4 = Task::create([
            'title' => 'Inventory Check',
            'description' => 'Update vehicle inventory system with latest status and mileage.',
            'work_date' => today(),
            'work_time' => '16:30:00',
            'status' => 'pending',
            'priority' => 'low',
            'created_by' => $admin->id,
            'due_date' => today()->endOfDay(),
        ]);
        $task4->assignedUsers()->sync([$employees->first()->id]);

        // Task without specific time (should show at end)
        $task5 = Task::create([
            'title' => 'Document Filing',
            'description' => 'File and organize customer rental agreements and insurance documents.',
            'work_date' => today(),
            'work_time' => null,
            'status' => 'pending',
            'priority' => 'low',
            'created_by' => $manager->id,
            'due_date' => today()->endOfDay(),
        ]);
        $task5->assignedUsers()->sync($employees->random(1)->pluck('id'));

        // Create tasks for tomorrow
        $this->command->info('Creating tomorrow\'s tasks...');

        for ($i = 1; $i <= 5; $i++) {
            $task = Task::create([
                'title' => fake()->randomElement([
                    'Vehicle Pickup',
                    'Customer Return Processing',
                    'Damage Assessment',
                    'Maintenance Schedule',
                    'Quality Check',
                ]).' - '.fake()->company(),
                'description' => fake()->sentence(15),
                'work_date' => today()->addDay(),
                'work_time' => fake()->time('H:i:s'),
                'status' => fake()->randomElement(['pending', 'running']),
                'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
                'created_by' => fake()->randomElement([$admin->id, $manager->id]),
                'due_date' => today()->addDay()->endOfDay(),
            ]);
            $task->assignedUsers()->sync($employees->random(rand(1, 3))->pluck('id'));
        }

        // Create tasks for this week (upcoming days)
        $this->command->info('Creating this week\'s tasks...');

        for ($day = 2; $day <= 7; $day++) {
            $date = today()->addDays($day);
            $taskCount = rand(2, 5);

            for ($i = 1; $i <= $taskCount; $i++) {
                $task = Task::create([
                    'title' => fake()->randomElement([
                        'Vehicle Transfer',
                        'Branch Delivery',
                        'Customer Consultation',
                        'Vehicle Photography',
                        'System Update',
                        'Safety Inspection',
                        'Tire Rotation',
                        'Oil Change Service',
                    ]).' - '.fake()->word(),
                    'description' => fake()->sentence(12),
                    'work_date' => $date,
                    'work_time' => fake()->time('H:i:s'),
                    'status' => 'pending',
                    'priority' => fake()->randomElement(['low', 'medium', 'high']),
                    'created_by' => fake()->randomElement([$admin->id, $manager->id]),
                    'due_date' => $date->endOfDay(),
                ]);
                $task->assignedUsers()->sync($employees->random(rand(1, 2))->pluck('id'));
            }
        }

        // Create some completed tasks from last week
        $this->command->info('Creating completed tasks from last week...');

        for ($day = 1; $day <= 7; $day++) {
            $date = today()->subDays($day);
            $taskCount = rand(3, 6);

            for ($i = 1; $i <= $taskCount; $i++) {
                $task = Task::create([
                    'title' => fake()->randomElement([
                        'Vehicle Pickup',
                        'Customer Service',
                        'Vehicle Cleaning',
                        'Maintenance Check',
                        'Document Processing',
                    ]).' - '.fake()->company(),
                    'description' => fake()->sentence(10),
                    'work_date' => $date,
                    'work_time' => fake()->time('H:i:s'),
                    'status' => 'completed',
                    'priority' => fake()->randomElement(['low', 'medium', 'high']),
                    'created_by' => fake()->randomElement([$admin->id, $manager->id]),
                    'due_date' => $date->endOfDay(),
                    'completed_at' => $date->addHours(rand(1, 8)),
                ]);
                $task->assignedUsers()->sync($employees->random(rand(1, 2))->pluck('id'));
            }
        }

        $this->command->info('Created '.Task::count().' tasks');
    }
}
