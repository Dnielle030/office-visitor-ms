# Office Visitor Management System (Laravel)

Overlay files for a fresh Laravel 11/12 project (PHP 8.2+). No extra packages needed.

## Setup
```bash
composer create-project laravel/laravel ovms
cd ovms
# copy the app/, database/, resources/, routes/ folders from this zip over the project (overwrite when asked)
```
In `.env`:
```
APP_TIMEZONE=Asia/Manila
SESSION_LIFETIME=30
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
# SESSION_SECURE_COOKIE=true   # enable when serving over HTTPS
```
(Default DB is SQLite. For MySQL, set the DB_* values and create the database first.)
```bash
php artisan migrate --seed
php artisan serve
```
Open http://127.0.0.1:8000

| Role | Email | Password |
|---|---|---|
| Administrator | admin@office.test | Admin@12345 |
| Receptionist | reception@office.test | Reception@12345 |

Change these after first login (or edit `database/seeders/DatabaseSeeder.php` first).

## Security requirement map
| Requirement | Where |
|---|---|
| Authentication | `AuthController`, `auth` middleware on every route, inactive accounts blocked |
| Role-based access | `RoleMiddleware` + route groups in `routes/web.php` |
| Password hashing | `'password' => 'hashed'` cast in `User` |
| Data privacy | Receptionists see masked contact numbers (`Visitor::contactFor`); admin sees full |
| SQL injection | Eloquent / bound parameters only |
| Input validation | `VisitorRequest`, `StaffController::store`, login + report inputs |
| Activity logs | `ActivityLog::record()` called in every controller action that changes data |
| Data integrity | Only admins edit; time in/out not editable; archive = soft delete; checkout once only |
| Session security | Session regeneration on login, invalidation on logout, CSRF on all forms, login rate limit (5/min), idle timeout via SESSION_LIFETIME |
| Output safety | Blade `{{ }}` escapes output; CSV export guards against formula injection |
