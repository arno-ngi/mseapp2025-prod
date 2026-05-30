<?php

namespace Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Vendor\RequestManagement\Filament\Resources\ExpenseRequestResource;

class ListExpenseRequests extends ListRecords
{
    protected static string $resource = ExpenseRequestResource::class;
}
