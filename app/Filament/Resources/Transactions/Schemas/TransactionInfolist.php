<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // General Information
                Section::make()
                    ->schema([
                        TextEntry::make('invoice')
                            ->label('Invoice'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'success' => 'success',
                                'expired' => 'gray',
                                'failed' => 'danger',
                            }),
                        TextEntry::make('created_at')
                            ->label('Created At'),
                    ])
                    ->columns(3),

                // Customer Information
                Section::make()
                    ->schema([
                        TextEntry::make('customer.name')
                            ->label('Customer Name'),
                        TextEntry::make('customer.email')
                            ->label('Email Address'),
                        TextEntry::make('address')
                            ->label('Address'),
                    ])
                    ->columns(3),

                // Ongkos Kirim
                Section::make()
                    ->schema([
                        TextEntry::make('shipping.shipping_courier')
                            ->label('Jasa Kirim'),
                        TextEntry::make('shipping.shipping_service')
                            ->label('Layanan Kirim'),
                        TextEntry::make('shipping.shipping_cost')
                            ->label('Ongkos Kirim')
                            ->numeric(decimalPlaces: 0)
                            ->money('IDR', locale: 'id'),
                    ])
                    ->columns(3),

                // Transaction Details
                Section::make()
                    ->schema([
                        RepeatableEntry::make('transactionDetails')
                            ->label('Item Details')
                            ->schema([
                                ImageEntry::make('product.image')
                                    ->label('Product Image')
                                    ->circular()
                                    ->imageWidth(100)
                                    ->imageHeight(100),
                                TextEntry::make('product.title')
                                    ->label('Product Name'),
                                TextEntry::make('qty')
                                    ->label('Quantity'),
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->numeric(decimalPlaces: 0)
                                    ->money('IDR', locale: 'id'),
                            ])
                            ->columns(4),
                    ]),

                // Grand Total
                Section::make()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('total')
                                    ->label('Grand Total')
                                    ->numeric(decimalPlaces: 0)
                                    ->money('IDR', locale: 'id')
                                    ->size(TextSize::Large)
                                    ->color('primary')
                                    ->alignEnd(),
                            ]),
                    ]),
            ]);
    }
}