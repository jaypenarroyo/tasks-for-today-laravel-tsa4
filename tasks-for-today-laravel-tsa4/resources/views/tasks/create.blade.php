@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">New Task</p>
            <h1 class="page-title">Create Task</h1>
            <p class="page-subtitle">Add a new task to your schedule.</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline">Back to All Tasks</a>
    </div>

    <section class="card card-narrow">
        <div class="card-header">
            <h2 class="card-title">Task Details</h2>
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

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Task Title</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="e.g., Review Laravel Mail documentation"
                        required
                        autofocus
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
                        value="{{ old('task_date', $defaultDate) }}"
                        required
                    >
                    @error('task_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </section>
@endsection
