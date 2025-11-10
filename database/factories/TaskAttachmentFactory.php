<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskAttachment>
 */
class TaskAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $extensions = ['pdf', 'jpg', 'png', 'docx'];
        $extension = fake()->randomElement($extensions);

        return [
            'task_id' => Task::factory(),
            'file_path' => 'task-attachments/'.fake()->uuid().'.'.$extension,
            'file_name' => fake()->word().'.'.$extension,
            'file_type' => match ($extension) {
                'pdf' => 'application/pdf',
                'jpg', 'png' => 'image/'.$extension,
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            },
            'uploaded_by' => User::factory(),
        ];
    }
}
