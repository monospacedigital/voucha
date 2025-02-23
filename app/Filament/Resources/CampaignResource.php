<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Loyalty Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('campaign_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('campaign_description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->after('start_date'),
                Forms\Components\TextInput::make('point_multiplier')
                    ->required()
                    ->numeric()
                    ->default(1.00)
                    ->minValue(1)
                    ->step(0.01),
                Forms\Components\Select::make('target_transaction_types')
                    ->multiple()
                    ->options([
                        'airtime' => 'Airtime',
                        'bill_payment' => 'Bill Payment',
                        'transfer' => 'Transfer',
                        'etc' => 'Other',
                    ])
                    ->required(),
                Forms\Components\Select::make('target_user_segments')
                    ->multiple()
                    ->options([
                        'new_users' => 'New Users',
                        'silver' => 'Silver Tier',
                        'gold' => 'Gold Tier',
                        'platinum' => 'Platinum Tier',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('campaign_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('point_multiplier')
                    ->numeric(
                        decimalPlaces: 2,
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('points_count')
                    ->counts('points')
                    ->label('Points Awarded'),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn ($query) => $query->where('end_date', '>=', now())),
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
