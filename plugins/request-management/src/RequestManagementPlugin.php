<?php

namespace Vendor\RequestManagement;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Vendor\RequestManagement\Filament\Resources\InvoiceRequestResource;
use Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource;

class RequestManagementPlugin implements Plugin
{
    public function getId(): string
    {
        return 'request-management';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                InvoiceRequestResource::class,
                ExpenseRequestResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
