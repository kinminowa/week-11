# week_11

A CodeIgniter 4 application built around three principles: clear routes,
CSRF-protected forms, and escaped output. The UI is a minimal black/white
dashboard with a single accent blue.

## Features

- Public landing page
- User registration and login (passwords hashed with `password_hash`)
- Protected dashboard guarded by a custom `AuthFilter`
- Notes form with persistent MySQL storage — used to demonstrate CSRF and XSS protection

## Setup

1. Clone the repository.
2. Run `composer install` to fetch the framework.
3. Copy `env` to `.env` and update the database credentials if your XAMPP MySQL is not the default `root` / empty password.
4. In phpMyAdmin (or via SQL) create a database named `week_11`.
5. Run `php spark migrate` to create the `users` and `notes` tables.
6. Visit the site through XAMPP at <http://localhost/week%2011/public/>.

## Routes

| Method | URI                       | Handler                  | Notes                  |
| ------ | ------------------------- | ------------------------ | ---------------------- |
| GET    | `/`                       | `Home::index`            | Public landing         |
| GET    | `/login`                  | `Auth::login`            | Login form             |
| POST   | `/login`                  | `Auth::attemptLogin`     | CSRF-protected         |
| GET    | `/register`               | `Auth::register`         | Register form          |
| POST   | `/register`               | `Auth::attemptRegister`  | CSRF-protected         |
| POST   | `/logout`                 | `Auth::logout`           | CSRF-protected         |
| GET    | `/dashboard`              | `Dashboard::index`       | `auth` filter          |
| POST   | `/notes`                  | `Dashboard::storeNote`   | `auth` + CSRF          |
| POST   | `/notes/{id}/delete`      | `Dashboard::deleteNote`  | `auth` + CSRF          |

## Security demonstrations

### CSRF Test

Form submission fails with **HTTP 403** if `csrf_field()` is missing from the form.

The dashboard includes a "POST without CSRF token" button that uses `fetch()` to send a raw POST to `/notes` without the hidden token. The global `csrf` filter (registered in `app/Config/Filters.php`) rejects the request before it ever reaches the controller, and the JavaScript prints **"Blocked (HTTP 403) — CSRF filter is working."** in the result box.

### XSS Test

Typing `<b>John</b>` (or `<script>alert(1)</script>`) into the notes form displays the literal string `<b>John</b>` on the dashboard — not bold text, and no JavaScript executes.

### Why it works

`esc()` converts `<` to `&lt;` and `>` to `&gt;` so the browser treats them as text, not HTML tags. Every place a user-supplied value is echoed in a view (note bodies, username, email, flash messages), the output is wrapped in `esc(...)`, so the browser never receives executable HTML or JavaScript that came from user input.

## Project layout

```
app/
├── Config/
│   ├── Filters.php          ← CSRF added to globals.before
│   └── Routes.php           ← all routes mapped
├── Controllers/
│   ├── Home.php             ← landing
│   ├── Auth.php             ← register / login / logout
│   └── Dashboard.php        ← index / storeNote / deleteNote
├── Filters/
│   └── AuthFilter.php       ← redirects unauthenticated visitors
├── Models/
│   ├── UserModel.php        ← hashes passwords on insert/update
│   └── NoteModel.php        ← user-scoped queries
├── Database/Migrations/
│   ├── 2026-05-04-000001_CreateUsersTable.php
│   └── 2026-05-04-000002_CreateNotesTable.php
└── Views/
    ├── home.php
    ├── templates/main.php   ← shared layout (the minimalytic CSS)
    ├── auth/login.php
    ├── auth/register.php
    └── dashboard/index.php
```

## Server requirements

PHP 8.2 or higher with the `intl`, `mbstring`, and `mysqlnd` extensions enabled.
