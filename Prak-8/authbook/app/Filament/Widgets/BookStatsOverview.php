<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Books', Book::count())
                ->description('Total koleksi buku')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),

            Stat::make('Total Authors', Author::count())
                ->description('Total penulis terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Books Available', Book::where('status', 'available')->count())
                ->description('Buku siap dipinjam')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Books Borrowed', Book::where('status', 'borrowed')->count())
                ->description('Buku sedang dipinjam')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}