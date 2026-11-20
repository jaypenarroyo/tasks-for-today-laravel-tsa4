@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">About the Project</p>
            <h1 class="page-title">Tasks for Today Management System</h1>
            <p class="page-subtitle">
                IT0049 (Web System Technologies) &mdash; Technical Summative Assessment 4
            </p>
        </div>
    </div>

    <section class="card">
        <div class="card-header">
            <h2 class="card-title">Developer Information</h2>
        </div>
        <div class="card-body">
            <dl class="detail-list">
                <div class="detail-item">
                    <dt>Developer</dt>
                    <dd>John James</dd>
                </div>
                <div class="detail-item">
                    <dt>Email</dt>
                    <dd>jpenarroyo53@gmail.com</dd>
                </div>
                <div class="detail-item">
                    <dt>Course</dt>
                    <dd>IT0049 &mdash; Web System Technologies</dd>
                </div>
                <div class="detail-item">
                    <dt>Assessment</dt>
                    <dd>TSA4 &mdash; Full CRUD, Auth, and Email (Laravel)</dd>
                </div>
            </dl>
        </div>
    </section>

    <div class="about-grid">
        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Project Overview</h2>
            </div>
            <div class="card-body">
                <p style="margin-top: 0; color: var(--text-muted);">
                    This application extends the TSA3 Tasks for Today Management System with validated
                    full CRUD workflows, soft deletion via an <code>is_archived</code> flag, Laravel Breeze
                    authentication protecting management actions, and automatic email notifications
                    powered by Laravel's <code>Mail</code> facade.
                </p>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <h2 class="card-title">Key Features</h2>
            </div>
            <div class="card-body">
                <ul class="feature-list">
                    <li><strong>Full Validated CRUD:</strong> Create, edit, and archive tasks with Form Request validation.</li>
                    <li><strong>Breeze Authentication:</strong> Public read pages; authenticated write actions.</li>
                    <li><strong>Soft Delete:</strong> Archiving sets <code>is_archived = true</code> without removing records.</li>
                    <li><strong>Mail Notification:</strong> Sends <code>TaskCompletedMail</code> only on transition to <code>done</code>.</li>
                </ul>
            </div>
        </section>
    </div>
@endsection
