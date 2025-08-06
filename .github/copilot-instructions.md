# Copilot Instructions for AI Agents

## Project Overview
- This is a Laravel-based admin platform for user, role, and permission management.
- The codebase follows standard Laravel conventions for controllers, models, requests, and views.
- Major features include user management, role assignment, permission grouping, and activity logging.

## Key Architectural Patterns
- **MVC Structure:**
  - Controllers: `app/Http/Controllers/`
  - Models: `app/Models/`
  - Views: `resources/views/`
- **Routes:**
  - Main route files in `routes/` (e.g., `web.php`, `admin.php`).
  - Admin-specific logic is typically in `routes/admin.php`.
- **Authorization:**
  - Permission checks use `$user->hasPermission('permission_name')`.
  - Roles and permissions are managed via pivot tables and Eloquent relationships.
- **User Management:**
  - User details, status toggling, email verification, and password reset are handled in `resources/views/admin/users/show.blade.php` and related controllers.
  - Role assignment uses a modal form and is permission-protected.
- **Activity Logging:**
  - User activity is displayed if available via `$user->activities`.

## Developer Workflows
- **Install dependencies:**
  - PHP: `composer install`
  - JS/CSS: `npm install`
- **Build assets:**
  - `npm run build` (uses Vite and Tailwind CSS)
- **Run tests:**
  - `php artisan test` or `vendor/bin/phpunit`
- **Database:**
  - SQLite by default (`database/database.sqlite`)
  - Migrations: `php artisan migrate`
  - Seeders: `php artisan db:seed`

## Project-Specific Conventions
- **Blade Views:**
  - Use Tailwind CSS for styling.
  - FontAwesome icons are used for UI elements.
  - Modals are toggled via simple JS functions in the view.
- **Permissions:**
  - Permission and role checks are explicit in Blade and controllers.
  - Assigning roles is only available to users with `users.edit` permission.
- **Testing:**
  - Tests are organized under `tests/Feature/` and `tests/Unit/`.
- **Seeders:**
  - Admin and permission seeders are in `database/seeders/`.

## Integration Points
- **External:**
  - Laravel packages via Composer (see `composer.json`).
  - JS dependencies via NPM (see `package.json`).
- **Internal:**
  - Cross-component communication is via Eloquent relationships and service providers.

## Examples
- To check if a user can edit another user:
  ```php
  @if(auth()->user()->hasPermission('users.edit'))
      <!-- show edit button -->
  @endif
  ```
- To assign roles to a user:
  - Use the modal form in `show.blade.php` and submit to `admin.users.assign-roles` route.

## Key Files/Directories
- `app/Models/` — Eloquent models for User, Role, Permission, etc.
- `app/Http/Controllers/` — Controllers for admin/user logic.
- `resources/views/admin/users/show.blade.php` — Main user detail and management UI.
- `routes/admin.php` — Admin-specific routes.
- `database/seeders/` — Seeders for initial data.

---
If you are unsure about a workflow or pattern, check the relevant controller, model, or Blade view for examples. When in doubt, follow Laravel best practices unless a project-specific pattern is documented here.
