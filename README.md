# Lab Equipment Booking System

A beginner-friendly Laravel full-stack web application for university lab equipment booking. Students can request equipment, track booking status, request returns, view fines, and report damage. Admins or lab assistants can manage inventory, bookings, users, fines, damage reports, and summary reports.

## Features

- Student registration, login, logout, dashboard, profile
- Admin login, dashboard, inventory, categories, users, fines, reports
- Equipment search and filtering by name, category, and status
- Booking flow: Pending, Approved, Issued, Return Requested, Returned, Closed
- Rejection flow: Pending to Rejected
- Overdue tracking and late fine calculation
- Fine rule: 20 BDT per late day
- Damage report submission and admin review
- Role protected student and admin dashboards
- Simple responsive Blade UI with light blue/green styling

## Technology Used

- PHP 8.2+
- Laravel 11
- Laravel Blade templates
- SQLite by default, MySQL compatible migrations
- SQL database with Eloquent models
- Custom authentication and role middleware

## Installation

1. Install dependencies:

```bash
composer install
```

2. Create the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

3. Generate the application key:

```bash
php artisan key:generate
```

4. Use SQLite quickly:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

The default `.env.example` uses SQLite. For MySQL, set `DB_CONNECTION=mysql` and fill in `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

5. Run migrations and seeders:

```bash
php artisan migrate --seed
```

6. Start the development server:

```bash
php artisan serve
```

Open `http://localhost:8000`.

## Login Credentials

Admin:

- Email: `lab.admin@kuet.ac.bd`
- Password: `password`

Students:

- Rana: roll `2207094`, email `rana.2207094@kuet.ac.bd` / `password`
- Issac: roll `2207095`, email `issac.2207095@kuet.ac.bd` / `password`
- Bipro: roll `2207096`, email `bipro.2207096@kuet.ac.bd` / `password`
- Mutiur: roll `2207097`, email `mutiur.2207097@kuet.ac.bd` / `password`
- Alok: roll `2207098`, email `alok.2207098@kuet.ac.bd` / `password`
- Avash: roll `2207099`, email `avash.2207099@kuet.ac.bd` / `password`
## Main Routes

Public:

- `/`
- `/login`
- `/register`

Student:

- `/student/dashboard`
- `/student/equipment`
- `/student/equipment/{id}`
- `/student/bookings`
- `/student/bookings/create`
- `/student/fines`
- `/student/damage-reports`
- `/student/profile`

Admin:

- `/admin/dashboard`
- `/admin/equipment`
- `/admin/equipment/create`
- `/admin/equipment/{id}/edit`
- `/admin/categories`
- `/admin/bookings`
- `/admin/requests`
- `/admin/issued`
- `/admin/overdue`
- `/admin/fines`
- `/admin/users`
- `/admin/damage-reports`
- `/admin/reports`

## Team Project Explanation

This project is organized for a university team assignment. The backend group can explain migrations, Eloquent relationships, controllers, validation, authentication, and role middleware. The frontend group can explain Blade layouts, sidebar navigation, dashboard cards, forms, tables, and status badges. The database group can explain the users, equipment categories, equipment, bookings, fines, and damage reports tables. The business logic group can explain booking approval, issuing, return requests, overdue detection, quantity updates, blocked users, and late fine calculation.

## Notes

- Students cannot access admin pages.
- Admins cannot submit student booking requests.
- Blocked users are logged out and cannot use dashboards.
- Students can only cancel Pending requests.
- Students can only request returns for Issued equipment.
- Admins can only approve or reject Pending requests.
