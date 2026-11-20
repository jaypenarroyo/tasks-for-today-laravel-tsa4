<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Only authenticated users may create tasks.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Validation rules for creating a new task.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'status' => ['required', Rule::in(Task::STATUSES)],
            'task_date' => ['required', 'date'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a task title.',
            'title.min' => 'The task title must be at least 3 characters.',
            'status.in' => 'Status must be pending, in_progress, or done.',
            'task_date.required' => 'Please choose a valid task date.',
        ];
    }
}
