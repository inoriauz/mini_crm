<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('comment')
                    ->columnSpanFull(),
                Select::make('client_id')
                    ->relationship('client', 'id')
                    ->required(),
                Select::make('manager_id')
                    ->relationship('manager', 'name'),
                Select::make('status')
                    ->options(['new' => 'New', 'in_progress' => 'In progress', 'done' => 'Done', 'canceled' => 'Canceled'])
                    ->default('new')
                    ->required(),
            ]);
    }
}
