<?php

namespace Vendor\RequestManagement;

use Filament\Panel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vendor\RequestManagement\Filament\Resources\InvoiceRequestResource;
use Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource;

class RequestManagementServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('request-management')
            ->hasConfigFile()
            ->hasMigrations([
                'create_invoice_requests_table',
                'create_expense_requests_table',
                'create_approvers_table',
                'create_request_items_table',
                'create_daily_allowances_table',
                'create_extrafiles_table',
            ])
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        //
    }

    public function packageBooted(): void
    {
        //
    }
}
