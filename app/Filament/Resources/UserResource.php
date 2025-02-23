<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Loyalty Management';
    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('brand_user_id')
                            ->required()
                            ->default(fn () => Str::uuid())
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Personal Details')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->maxLength(255),
                        Forms\Components\Select::make('loyalty_tier_id')
                            ->relationship('loyaltyTier', 'tier_name')
                            ->required(),
                        Forms\Components\DateTimePicker::make('registration_date')
                            ->required()
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Loyalty Program Statistics')
                    ->schema([
                        Forms\Components\Placeholder::make('total_points')
                            ->label('Total Points')
                            ->content(fn ($record) => $record ? $record->points()->where('point_type', 'earned')->sum('point_value') : 0),
                        Forms\Components\Placeholder::make('redeemed_points')
                            ->label('Redeemed Points')
                            ->content(fn ($record) => $record ? $record->points()->where('point_type', 'redeemed')->sum('point_value') : 0),
                        Forms\Components\Placeholder::make('total_transactions')
                            ->label('Total Transactions')
                            ->content(fn ($record) => $record ? $record->transactions()->count() : 0),
                        Forms\Components\Placeholder::make('total_spent')
                            ->label('Total Spent')
                            ->content(fn ($record) => $record ? '₦' . number_format($record->transactions()->sum('transaction_amount'), 2) : '₦0.00'),
                    ])->columns(2),

                Forms\Components\Section::make('Recent Transactions')
                    ->schema([
                        Forms\Components\Repeater::make('recent_transactions')
                            ->relationship(
                                'transactions',
                                modifyQueryUsing: fn ($query) => $query->orderBy('transaction_date', 'desc')->limit(5)
                            )
                            ->schema([
                                Forms\Components\TextInput::make('transaction_type')
                                    ->disabled(),
                                Forms\Components\TextInput::make('transaction_amount')
                                    ->disabled()
                                    ->prefix('₦'),
                                Forms\Components\TextInput::make('status')
                                    ->disabled(),
                                Forms\Components\DateTimePicker::make('transaction_date')
                                    ->disabled(),
                            ])
                            ->columns(4)
                            ->disabled()
                            ->defaultItems(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('loyaltyTier.tier_name')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('points_balance')
                    ->label('Points Balance')
                    ->getStateUsing(fn ($record) =>
                        $record->points()->where('point_type', 'earned')->sum('point_value') -
                        $record->points()->where('point_type', 'redeemed')->sum('point_value')
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_spent')
                    ->label('Total Spent')
                    ->money('NGN')
                    ->getStateUsing(fn ($record) => $record->transactions()->sum('transaction_amount'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('loyalty_tier')
                    ->relationship('loyaltyTier', 'tier_name'),
                Tables\Filters\Filter::make('high_value')
                    ->query(fn ($query) => $query->whereHas('transactions', function ($query) {
                        $query->groupBy('user_id')
                            ->havingRaw('SUM(transaction_amount) > ?', [1000000]);
                    }))
                    ->label('High Value Customers'),
                Tables\Filters\Filter::make('active')
                    ->query(fn ($query) => $query->whereHas('transactions', function ($query) {
                        $query->where('transaction_date', '>=', now()->subMonths(3));
                    }))
                    ->label('Active Users (Last 3 Months)'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
