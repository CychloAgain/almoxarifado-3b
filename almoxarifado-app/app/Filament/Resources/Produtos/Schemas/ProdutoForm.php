<?php

namespace App\Filament\Resources\Produtos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProdutoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('marca')
                    ->required(),
                TextInput::make('estoque')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
