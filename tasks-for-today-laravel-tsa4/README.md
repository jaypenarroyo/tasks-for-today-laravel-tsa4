# Tasks for Today Management System — Full CRUD, Auth & Email (Laravel)

**Course:** IT0049 — Web System Technologies  
**Assessment:** Technical Summative Assessment 4 (TSA4)  
**Developer:** John James (`jpenarroyo53@gmail.com`)

A Laravel rebuild of the TSA2/TSA3 **Tasks for Today Management System** featuring validated full CRUD, soft deletion via `is_archived`, **Laravel Breeze** authentication protecting all management actions, and an automatic **Mail** notification sent when a task transitions to `done`.

---

## Features & Routes

### Public Routes (Viewable by Anyone)
| Route | Name | Controller Action | Description |
| :--- | :--- | :--- | :--- |
| `GET /` | `welcome` | `TaskController@welcome` | Shows only today's active (`is_archived = false`) tasks. |
| `GET /tasks` | `tasks.index` | `TaskController@index` | Displays all active tasks ordered chronologically by `task_date`. |
| `GET /profile` | `profile.show` | `ProfileController@show` | Displays the user profile record and task overview. |
| `GET /about` | `about` | `PageController@about` | Static About page identifying the developer and architecture. |

### Authentication Routes (Laravel Breeze)
| Route | Name | Description |
| :--- | :--- | :--- |
| `GET /login`, `POST /login` | `login` | User sign-in with rate-limited validation (`LoginRequest`). |
| `GET /register`, `POST /register` | `register` | New user registration. |
| `POST /logout` | `logout` | Ends the authenticated session. |

### Protected CRUD Routes (`auth` Middleware Required)
| Route | Name | Controller Action | Description |
| :--- | :--- | :--- | :--- |
| `GET /tasks/create` | `tasks.create` | `TaskController@create` | Displays the Create Task form. |
| `POST /tasks` | `tasks.store` | `TaskController@store` | Validates (`StoreTaskRequest`) and creates a new task. |
| `GET /tasks/{task}/edit` | `tasks.edit` | `TaskController@edit` | Displays the Edit Task form. |
| `PUT /tasks/{task}` | `tasks.update` | `TaskController@update` | Validates (`UpdateTaskRequest`), updates the task, and emails on transition to `done`. |
| `DELETE /tasks/{task}` | `tasks.destroy` | `TaskController@destroy` | Soft-deletes the task by setting `is_archived = true`. |

---

## Database Schema

### `users` Table
- `id`, `username` (unique), `full_name`, `email` (unique), `email_verified_at`, `password`, `remember_token`, `timestamps`

### `tasks` Table
- `id`, `title`, `status` (default `'pending'`; supports `pending`, `in_progress`, `done`), `task_date` (`DATE`), `is_archived` (`BOOLEAN`, default `false`), `timestamps`

### Default Seeded Login Credentials
- **Email:** `jpenarroyo53@gmail.com`
- **Password:** `password`

---

## Local Setup & Running the Project

### Option A: Quick Start with SQLite (Recommended)

```bash
# 1. Clone the repository
git clone https://github.com/<your-username>/tasks-for-today-laravel-tsa4.git
cd tasks-for-today-laravel-tsa4

# 2. Install PHP dependencies
composer install

# 3. Create environment file and generate application key
cp .env.example .env
php artisan key:generate

# 4. Create the SQLite database file
touch database/database.sqlite

# 5. Run migrations and seed the database
php artisan migrate --seed

# 6. Start the development server
php artisan serve
```

Open **http://127.0.0.1:8000** in your browser.

### Option B: Setup with MySQL (XAMPP / Laragon)

1. Create a database named `tasks_for_today_tsa4` in phpMyAdmin or MySQL.
2. Update `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tasks_for_today_tsa4
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Run `php artisan migrate --seed` (or import `database/tasks_for_today_tsa4.sql`) and start with `php artisan serve`.

---

## Email Notification Configuration & Verification

When an authenticated user updates a task whose previous status was **not** `done` to **`done`**, `TaskController@update` dispatches `App\Mail\TaskCompletedMail` via Laravel's `Mail` facade to `TASK_NOTIFICATION_RECIPIENT`. Editing a task that is **already** `done` does **not** resend the email.

### Verifying with Laravel's `log` Driver (Default)
In `.env`:
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@tasksfortoday.local"
TASK_NOTIFICATION_RECIPIENT="jpenarroyo53@gmail.com"
```
1. Log in using `jpenarroyo53@gmail.com` / `password`.
2. Edit a `pending` task and change its status to **Done**.
3. Open `storage/logs/laravel.log` — you will see the full rendered HTML email (`Subject: Task Completed: ...`).
4. Edit that same `done` task again (e.g., change its title) and save — confirm no duplicate email entry is written to `storage/logs/laravel.log`.

### Using a Test SMTP Service (Mailtrap / Mailpit)
Update `.env` with your test SMTP credentials:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
TASK_NOTIFICATION_RECIPIENT="jpenarroyo53@gmail.com"
```

---

## Running Automated Tests

```bash
php artisan test
```

`tests/Feature/TaskCrudAuthMailTest.php` verifies:
- Public pages (`/`, `/tasks`, `/profile`, `/about`) are viewable by guests.
- Management actions (`/tasks/create`, `POST /tasks`, `edit`, `update`, `destroy`) redirect guests to `/login`.
- Form validation rejects bad input and accepts valid tasks.
- Marking a pending task as `done` sends `TaskCompletedMail` exactly once, and re-saving an already-`done` task sends nothing.
- Soft deletion sets `is_archived = true` and hides the task from public listings while preserving the row in the database.
- Breeze login and logout work end-to-end.

---

## References

- Laravel Documentation — [Mail](https://laravel.com/docs/13.x/mail)
- Laravel Documentation — [Starter Kits: Laravel Breeze](https://laravel.com/docs/13.x/starter-kits#laravel-breeze)
