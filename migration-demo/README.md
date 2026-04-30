# Migration Demo Utility

This directory contains a demonstration of how you can migrate data from the source application to a new Laravel application.

## Contents

- `app/Models/`: Basic models representing the target entities.
- `app/Console/Commands/MigrateData.php`: A Laravel console command that:
    1. Connects to the source application API.
    2. Fetches the exported JSON data.
    3. Populates the target database using `updateOrCreate`.

## How to use

1. Set up a new Laravel 11 application.
2. Install Filament (e.g., `composer require filament/filament`).
3. Copy the models and the `MigrateData` command to your new application.
4. Run the migration command:
   ```bash
   php artisan migrate:data http://source-app-url your-migration-secret-token
   ```
