<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoyaltyTierResource\Pages;
use App\Models\LoyaltyTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoyaltyTierResource extends Resource
{
    protected static ?string $model = LoyaltyTier::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Loyalty Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tier_name')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('points_required')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\Textarea::make('benefits_description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tier_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('points_required')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLoyaltyTiers::route('/'),
            'create' => Pages\CreateLoyaltyTier::route('/create'),
            'edit' => Pages\EditLoyaltyTier::route('/{record}/edit'),
        ];
    }
}
