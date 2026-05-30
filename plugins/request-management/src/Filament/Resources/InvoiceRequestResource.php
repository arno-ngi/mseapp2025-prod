<?php

namespace Vendor\RequestManagement\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Vendor\RequestManagement\Models\InvoiceRequest;
use Vendor\RequestManagement\Notifications\DailyNotification;
use Vendor\RequestManagement\Notifications\StatusUpdateNotification;
use Illuminate\Support\Facades\Notification;

class InvoiceRequestResource extends Resource
{
    protected static ?string $model = InvoiceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tenant_id')
                    ->relationship('tenant', 'name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\Select::make('requester_id')
                    ->relationship('requester', 'name')
                    ->required(),
                Forms\Components\TextInput::make('supplier'),
                Forms\Components\DateTimePicker::make('invoice_date'),
                Forms\Components\TextInput::make('total_invoice_amount')
                    ->numeric(),
                Forms\Components\TextInput::make('currency')
                    ->default('EUR'),
                Forms\Components\Select::make('status')
                    ->options([
                        1 => 'Draft',
                        2 => 'Pending',
                        3 => 'Approved',
                        4 => 'Rejected',
                    ])
                    ->default(1),
                Forms\Components\Textarea::make('internal_information'),
                Forms\Components\Textarea::make('extra_info'),
                Forms\Components\TextInput::make('uniqueid')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uniqueid')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tenant.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requester.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_invoice_amount')
                    ->money(fn ($record) => $record->currency ?? 'EUR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'gray',
                        2 => 'warning',
                        3 => 'success',
                        4 => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        1 => 'Draft',
                        2 => 'Pending',
                        3 => 'Approved',
                        4 => 'Rejected',
                        default => 'Unknown',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('submit')
                    ->color('warning')
                    ->icon('heroicon-o-paper-airplane')
                    ->hidden(fn (InvoiceRequest $record) => $record->status !== 1)
                    ->action(function (InvoiceRequest $record) {
                        $record->update(['status' => 2]);

                        // Notify approvers (this is a simplified example, usually you'd find specific approvers)
                        $approvers = config('request-management.models.user')::whereHas('roles', function($q) {
                            $q->where('name', 'approver');
                        })->get();

                        if ($approvers->isEmpty()) {
                            // Fallback to all admins or similar if no specific approvers found
                             $approvers = config('request-management.models.user')::all();
                        }

                        Notification::send($approvers, new DailyNotification());
                    }),
                Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->hidden(fn (InvoiceRequest $record) => $record->status !== 2)
                    ->action(function (InvoiceRequest $record) {
                        $record->update(['status' => 3]);
                        $record->approvers()->create([
                            'user_id' => auth()->id(),
                            'status' => 3,
                        ]);

                        Notification::send($record->requester, new StatusUpdateNotification($record, 3));
                    }),
                Action::make('reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->hidden(fn (InvoiceRequest $record) => $record->status !== 2)
                    ->action(function (InvoiceRequest $record) {
                        $record->update(['status' => 4]);
                        $record->approvers()->create([
                            'user_id' => auth()->id(),
                            'status' => 4,
                        ]);

                        Notification::send($record->requester, new StatusUpdateNotification($record, 4));
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => InvoiceRequestResource\Pages\ListInvoiceRequests::route('/'),
            'create' => InvoiceRequestResource\Pages\CreateInvoiceRequest::route('/create'),
            'edit' => InvoiceRequestResource\Pages\EditInvoiceRequest::route('/{record}/edit'),
        ];
    }
}
