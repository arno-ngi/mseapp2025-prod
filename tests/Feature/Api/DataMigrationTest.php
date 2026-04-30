<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_export_requires_token()
    {
        $response = $this->getJson('/api/migration/export');

        $response->assertStatus(401);
    }

    public function test_migration_export_works_with_valid_token()
    {
        $response = $this->getJson('/api/migration/export', [
            'X-Migration-Token' => 'migration-secret-token'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'tenants',
            'users',
            'categories',
            'invoice_requests',
            'expense_requests',
        ]);
    }
}
