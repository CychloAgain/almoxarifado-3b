<?php

namespace App\Filament\Resources\Movimentos;

use App\Filament\Resources\Movimentos\Pages\CreateMovimento;
use App\Filament\Resources\Movimentos\Pages\EditMovimento;
use App\Filament\Resources\Movimentos\Pages\ListMovimentos;
use App\Filament\Resources\Movimentos\Pages\ViewMovimento;
use App\Filament\Resources\Movimentos\Schemas\MovimentoForm;
use App\Filament\Resources\Movimentos\Schemas\MovimentoInfolist;
use App\Filament\Resources\Movimentos\Tables\MovimentosTable;
use App\Models\Movimento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MovimentoResource extends Resource
{
    protected static ?string $model = Movimento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MovimentoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MovimentoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MovimentosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMovimentos::route('/'),
            'create' => CreateMovimento::route('/create'),
            'view' => ViewMovimento::route('/{record}'),
            'edit' => EditMovimento::route('/{record}/edit'),
        ];
    }
}
