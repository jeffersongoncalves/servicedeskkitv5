<?php

namespace App\Filament\Admin\Resources\Operators;

use App\Filament\Admin\Resources\Operators\Pages\CreateOperator;
use App\Filament\Admin\Resources\Operators\Pages\EditOperator;
use App\Filament\Admin\Resources\Operators\Pages\ListOperators;
use App\Filament\Admin\Resources\Operators\Pages\ViewOperator;
use App\Filament\Admin\Resources\Operators\Schemas\OperatorForm;
use App\Filament\Admin\Resources\Operators\Schemas\OperatorInfolist;
use App\Filament\Admin\Resources\Operators\Tables\OperatorsTable;
use App\Models\Operator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

use function __;

class OperatorResource extends Resource
{
    protected static ?string $model = Operator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Wrench;

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultUrl($record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('Operator');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Operators');
    }

    public static function getNavigationLabel(): string
    {
        return __('Operators');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever('operators_count', fn () => Operator::query()->count());
    }

    public static function form(Schema $schema): Schema
    {
        return OperatorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OperatorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OperatorsTable::configure($table);
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
            'index' => ListOperators::route('/'),
            'create' => CreateOperator::route('/create'),
            'view' => ViewOperator::route('/{record}'),
            'edit' => EditOperator::route('/{record}/edit'),
        ];
    }
}
