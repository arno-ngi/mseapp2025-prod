<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Category;
use App\Models\InvoiceRequest;
use App\Models\ExpenseRequest;

class MigrateData extends Command
{
    protected $signature = 'migrate:data {url} {token}';
    protected $description = 'Migrate data from the source application API';

    public function handle()
    {
        $url = $this->argument('url');
        $token = $this->argument('token');

        $this->info("Fetching data from {$url}...");

        $response = Http::withHeaders([
            'X-Migration-Token' => $token,
        ])->get($url . '/api/migration/export');

        if ($response->failed()) {
            $this->error("Failed to fetch data: " . $response->body());
            return 1;
        }

        $data = $response->json();

        $this->migrateTenants($data['tenants']);
        $this->migrateUsers($data['users']);
        $this->migrateCategories($data['categories']);
        $this->migrateInvoiceRequests($data['invoice_requests']);
        $this->migrateExpenseRequests($data['expense_requests']);

        $this->info("Migration completed successfully!");
    }

    protected function migrateTenants($tenants)
    {
        $this->info("Migrating tenants...");
        foreach ($tenants as $tenantData) {
            Tenant::updateOrCreate(['id' => $tenantData['id']], [
                'name' => $tenantData['name'],
                'shortname' => $tenantData['shortname'],
            ]);
        }
    }

    protected function migrateUsers($users)
    {
        $this->info("Migrating users...");
        foreach ($users as $userData) {
            User::updateOrCreate(['id' => $userData['id']], [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);
        }
    }

    protected function migrateCategories($categories)
    {
        $this->info("Migrating categories...");
        foreach ($categories as $categoryData) {
            Category::updateOrCreate(['id' => $categoryData['id']], [
                'tenant_id' => $categoryData['tenant_id'],
                'name' => $categoryData['name'],
                'shortname' => $categoryData['shortname'],
            ]);
        }
    }

    protected function migrateInvoiceRequests($requests)
    {
        $this->info("Migrating invoice requests...");
        foreach ($requests as $requestData) {
            InvoiceRequest::updateOrCreate(['id' => $requestData['id']], [
                'uuid' => $requestData['uuid'],
                'tenant_id' => $requestData['tenant_id'],
                'category_id' => $requestData['category_id'],
                'requester_id' => $requestData['requester_id'],
                'total_invoice_amount' => $requestData['total_invoice_amount'],
                'supplier' => $requestData['supplier'],
                'status' => $requestData['status'],
                'invoice_date' => $requestData['invoice_date'],
                'uniqueid' => $requestData['uniqueid'],
            ]);
        }
    }

    protected function migrateExpenseRequests($requests)
    {
        $this->info("Migrating expense requests...");
        foreach ($requests as $requestData) {
            ExpenseRequest::updateOrCreate(['id' => $requestData['id']], [
                'uuid' => $requestData['uuid'],
                'tenant_id' => $requestData['tenant_id'],
                'category_id' => $requestData['category_id'],
                'requester_id' => $requestData['requester_id'],
                'status' => $requestData['status'],
                'expense_date' => $requestData['expense_date'],
                'uniqueid' => $requestData['uniqueid'],
            ]);
        }
    }
}
