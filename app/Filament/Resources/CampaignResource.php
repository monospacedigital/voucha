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
                Forms\Components\Section::make('Campaign Details')
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
                    ])->columns(2),

                Forms\Components\Section::make('Campaign Rules')
                    ->schema([
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
                    ])->columns(2),

                Forms\Components\Section::make('Campaign Statistics')
                    ->schema([
                        Forms\Components\Placeholder::make('total_points')
                            ->label('Total Points Awarded')
                            ->content(fn ($record) => $record ? number_format($record->points()->sum('point_value')) : 0),
                        Forms\Components\Placeholder::make('total_transactions')
                            ->label('Qualifying Transactions')
                            ->content(fn ($record) => $record ? $record->points()->count() : 0),
                        Forms\Components\Placeholder::make('unique_users')
                            ->label('Unique Users')
                            ->content(fn ($record) => $record ? $record->points()->distinct('user_id')->count() : 0),
                        Forms\Components\Placeholder::make('average_points')
                            ->label('Average Points per Transaction')
                            ->content(fn ($record) => $record && $record->points()->count() > 0
                                ? number_format($record->points()->sum('point_value') / $record->points()->count(), 2)
                                : 0),
                    ])->columns(2),

                Forms\Components\Section::make('Points Awarded')
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Repeater::make('points')
                                    ->relationship(
                                        'points',
                                        modifyQueryUsing: fn ($query) => $query->with('user')->orderBy('created_at', 'desc')
                                    )
                                    ->schema([
                                        Forms\Components\TextInput::make('user.name')
                                            ->label('User')
                                            ->formatStateUsing(fn ($state, $record) => $record->user?->name ?? 'N/A')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('point_value')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('point_type')
                                            ->disabled(),
                                        Forms\Components\DateTimePicker::make('created_at')
                                            ->disabled(),
                                    ])
                                    ->columns(4)
                                    ->disabled()
                            ]),
                    ]),
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
                    ->label('Points Awarded')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unique_users')
                    ->label('Unique Users')
                    ->getStateUsing(fn ($record) => $record->points()->distinct('user_id')->count()),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn ($record) =>
                        now() < $record->start_date ? 'upcoming' :
                        (now() > $record->end_date ? 'ended' : 'active')
                    )
                    ->colors([
                        'warning' => 'upcoming',
                        'success' => 'active',
                        'danger' => 'ended',
                    ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn ($query) => $query->where('end_date', '>=', now())),
                Tables\Filters\Filter::make('completed')
                    ->query(fn ($query) => $query->where('end_date', '<', now())),
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
