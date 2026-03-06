<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Information')
                    ->description('Basic account details for the official')
                    ->schema([
                        TextEntry::make('first_name')
                            ->label('First Name'),
                        TextEntry::make('middle_name')
                            ->label('Middle Name')
                            ->placeholder('—'),
                        TextEntry::make('surname')
                            ->label('Surname'),
                        TextEntry::make('email')
                            ->label('Email Address'),
                        TextEntry::make('phone')
                            ->label('Phone Number'),
                        TextEntry::make('address')
                            ->label('Address'),
                    ])->columns(2),

                Section::make('Personal Information')
                    ->description('Additional personal details')
                    ->schema([
                        TextEntry::make('birthdate')
                            ->label('Birthdate')
                            ->date(),
                        TextEntry::make('gender')
                            ->label('Gender')
                            ->formatStateUsing(fn (?string $state): ?string => match ($state) {
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                                null => 'Not specified',
                            }),
                    ])->columns(2),

                Section::make('Status and Dates')
                    ->description('Account status and important dates')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
