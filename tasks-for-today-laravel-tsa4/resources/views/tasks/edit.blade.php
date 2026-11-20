@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Update Task</p>
            <h1 class="page-title">Edit Task</h1>
            <p class="page-subtitle">
                Changing a task's status to <strong>Done</strong> automatically sends a completion email notification.
            </p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline">Back to All Tasks</a>
    </div>

    <section class="card card-narrow">
        <div class="card-header">
            <h2 class="card-title">Edit Task #{{ $task->id }}</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="error-banner" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">Task Title</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        class="form-control"
                        value="{{ old('title', $task->title) }}"
                        required
                    >
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="task_date" class="form-label">Task Date</label>
                    <input
                        id="task_date"
                        name="task_date"
                        type="date"
                        class="form-control"
                        value="{{ old('task_date', $task->task_date->toDateString()) }}"
                        required
                    >
                    @error('task_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    <p class="form-hint">
                        @if ($task->status === 'done')
                            This task is already marked Done — updating it again will not resend the notification email.
                        @else
                            Selecting <strong>Done</strong> will trigger an email notification to {{ config('mail.task_notification_recipient') }}.
                        @endif
                    </p>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </section>
@endsection
