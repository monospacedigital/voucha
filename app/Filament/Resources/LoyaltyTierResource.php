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
                Forms\Components\Section::make('Tier Details')
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
                    ])->columns(2),

                Forms\Components\Section::make('Tier Statistics')
                    ->schema([
                        Forms\Components\Placeholder::make('total_users')
                            ->label('Total Users')
                            ->content(fn ($record) => $record ? $record->users()->count() : 0),
                        Forms\Components\Placeholder::make('total_points')
                            ->label('Total Points')
                            ->content(function ($record) {
                                if (!$record) return 0;
                                return $record->users->sum(function ($user) {
                                    return $user->points()->where('point_type', 'earned')->sum('point_value') -
                                           $user->points()->where('point_type', 'redeemed')->sum('point_value');
                                });
                            }),
                        Forms\Components\Placeholder::make('average_points')
                            ->label('Average Points per User')
                            ->content(function ($record) {
                                if (!$record) return 0;
                                $totalPoints = $record->users->sum(function ($user) {
                                    return $user->points()->where('point_type', 'earned')->sum('point_value') -
                                           $user->points()->where('point_type', 'redeemed')->sum('point_value');
                                });
                                $userCount = $record->users()->count();
                                return $userCount > 0 ? round($totalPoints / $userCount) : 0;
                            }),
                        Forms\Components\Placeholder::make('total_spent')
                            ->label('Total Amount Spent')
                            ->content(function ($record) {
                                if (!$record) return '₦0.00';
                                $totalSpent = $record->users->sum(function ($user) {
                                    return $user->transactions()->sum('transaction_amount');
                                });
                                return '₦' . number_format($totalSpent, 2);
                            }),
                        Forms\Components\Placeholder::make('average_spent')
                            ->label('Average Spend per User')
                            ->content(function ($record) {
                                if (!$record) return '₦0.00';
                                $totalSpent = $record->users->sum(function ($user) {
                                    return $user->transactions()->sum('transaction_amount');
                                });
                                $userCount = $record->users()->count();
                                return $userCount > 0 ? '₦' . number_format($totalSpent / $userCount, 2) : '₦0.00';
                            }),
                    ])->columns(2)
                    ->hidden(fn ($record) => !$record),
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
                    ->label('Total Users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_points')
                    ->label('Total Points')
                    ->getStateUsing(function ($record) {
                        return $record->users->sum(function ($user) {
                            return $user->points()->where('point_type', 'earned')->sum('point_value') -
                                   $user->points()->where('point_type', 'redeemed')->sum('point_value');
                        });
                    })
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('average_spend')
                    ->label('Avg. Spend')
                    ->money('NGN')
                    ->getStateUsing(function ($record) {
                        $totalSpent = $record->users->sum(function ($user) {
                            return $user->transactions()->sum('transaction_amount');
                        });
                        $userCount = $record->users()->count();
                        return $userCount > 0 ? $totalSpent / $userCount : 0;
                    })
                    ->sortable(),
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
                Tables\Actions\Action::make('view_users')
                    ->label('View Users')
                    ->icon('heroicon-o-users')
                    ->url(fn ($record) => route('filament.admin.resources.users.index', [
                        'tableFilters[loyalty_tier_id][value]' => $record->loyalty_tier_id
                    ]))
                    ->openUrlInNewTab(),
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
