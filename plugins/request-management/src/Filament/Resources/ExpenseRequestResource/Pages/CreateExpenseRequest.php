<?php

namespace Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource;

class CreateExpenseRequest extends CreateRecord
{
    protected static string $resource = ExpenseRequestResource::class;
}
