# 📖 LAPORAN TUGAS PRAKTIKUM PERTEMUAN 6 PRAK PBW (SE)
**👨‍💼 Delsyad Iza - 4524210025**

# 🏫 Website Sistem Manajemen Buku "Authbook"
Merupakan aplikasi Sistem Manajemen Buku menggunakan framework Laravel dan Filament 3.x. Aplikasi ini mencakup fitur lengkap CRUD (Create, Read, Update, Delete) untuk mengelola data buku dan penulis, dilengkapi dengan fitur pencarian, filter, upload gambar, dan sistem relasi database.
<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge\&logo=php\&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind\_CSS-4.0-38B2AC?style=for-the-badge\&logo=tailwind-css\&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

# Tugas 2: Kustomisasi dan Pengembangan
Tambahkan fitur-fitur berikut:
## 1. Penambahan Field Description pada Book

### 1.1 Buat File Migrasi
```bash
php artisan make:migration add_description_to_books_table --table=books
```

Edit file `database/migrations/xxxx_xx_xx_xxxxxx_add_description_to_books_table.php`:
```php
public function up(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->text('description')->nullable()->after('title');
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('description');
    });
}
```

### 1.2 Update Model `Book.php`
Buka `app/Models/Book.php` dan tambahkan `description` pada properti `$fillable`:
```php
protected $fillable = [
    'isbn',
    'title',
    'description',
    'author_id',
    'publisher',
    'year',
    'cover',
    'status',
];
```

### 1.3 Update Form di `BookResource.php`
Tambahkan komponen `Textarea` pada `app/Filament/Resources/BookResource.php`:
```php
Forms\Components\TextInput::make('title')
    ->required()
    ->maxLength(255),

Forms\Components\Textarea::make('description')
    ->rows(4)
    ->columnSpanFull(),
```

### 1.4 Update Factory dan Jalankan Migrasi
Tambahkan `description` di `database/factories/BookFactory.php`:
```php
public function definition(): array
{
    return [
        'isbn' => fake()->unique()->isbn13(),
        'title' => fake()->sentence(3),
        'description' => fake()->paragraph(),
        'author_id' => Author::factory(),
        'publisher' => fake()->company(),
        'year' => fake()->numberBetween(1950, 2024),
        'status' => fake()->randomElement(['available', 'borrowed']),
    ];
}
```

Jalankan perintah migrasi:
```bash
php artisan migrate
```

## 2. Implementasi Role-Based Access Control (RBAC)

### 2.1 Tambah Kolom `role` pada Tabel Users
```bash
php artisan make:migration add_role_to_users_table --table=users
```

Edit file migrasi `database/migrations/xxxx_xx_xx_xxxxxx_add_role_to_users_table.php`:
```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('viewer')->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
```

Tambahkan kolom `role` pada `$fillable` di `app/Models/User.php`:
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];
```

Jalankan migrasi:
```bash
php artisan migrate
```

### 2.2 Buat Seeder User Berdasarkan Role
Edit file `database/seeders/DatabaseSeeder.php`:
```php
<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
                'role' => 'viewer',
            ]
        );

        $authors = Author::factory(10)->create();

        Book::factory(50)->create([
            'author_id' => fn() => $authors->random()->id,
        ]);
    }
}
```

Jalankan seeder:
```bash
php artisan db:seed
```

### 2.3 Konfigurasi `BookPolicy.php`
Edit `app/Policies/BookPolicy.php`:
```php
<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function view(User $user, Book $book): bool
    {
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function update(User $user, Book $book): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }
}
```

## 3. Penambahan Widget Dashboard

### 3.1 Buat Stats Overview Widget
```bash
php artisan make:filament-widget BookStatsOverview --stats-overview
```
> *Catatan Prompt CLI:* Kosongkan pilihan Resource (tekan `Enter`), lalu pilih panel `admin`.

Edit file `app/Filament/Widgets/BookStatsOverview.php`:
```php
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
```

### 3.2 Buat Chart Widget Book Status (Opsional/Grafik Visual)
```bash
php artisan make:filament-widget BookStatusChart --chart
```
> Pilih tipe chart: `doughnut`.

Edit file `app/Filament/Widgets/BookStatusChart.php`:
```php
<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\ChartWidget;

class BookStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Ketersediaan Buku (Available vs Borrowed)';

    protected function getData(): array
    {
        $available = Book::where('status', 'available')->count();
        $borrowed = Book::where('status', 'borrowed')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Buku',
                    'data' => [$available, $borrowed],
                    'backgroundColor' => ['#10B981', '#F59E0B'],
                ],
            ],
            'labels' => ['Available', 'Borrowed'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
```

## 4. Kategori Buku (Many-to-Many)

### 4.1 Buat Model Category & Pivot Migration
```bash
php artisan make:model Category -m
php artisan make:migration create_book_category_table --create=book_category
```

Edit skema `database/migrations/xxxx_xx_xx_xxxxxx_create_categories_table.php`:
```php
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });
}
```

Edit skema pivot `database/migrations/xxxx_xx_xx_xxxxxx_create_book_category_table.php`:
```php
public function up(): void
{
    Schema::create('book_category', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained()->cascadeOnDelete();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });
}
```

Jalankan migrasi:
```bash
php artisan migrate
```

### 4.2 Definisikan Relasi Eloquent
Edit `app/Models/Category.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
```

Tambahkan method relasi di `app/Models/Book.php`:
```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class);
}
```

### 4.3 Tambahkan Multiple Select di Form `BookResource.php`
Edit `app/Filament/Resources/BookResource.php` pada method `form()`:
```php
Forms\Components\Select::make('categories')
    ->relationship('categories', 'name')
    ->multiple()
    ->searchable()
    ->preload()
    ->createOptionForm([
        Forms\Components\TextInput::make('name')
            ->required()
            ->unique('categories', 'name')
            ->maxLength(255),
    ]),
```

*(Opsional)* Buat resource terpisah untuk pengelolaan data master kategori:
```bash
php artisan make:filament-resource Category --generate
```

## 🔍 Pengujian & Verifikasi Akhir

1. **Bersihkan Cache:**
   ```bash
   php artisan optimize:clear
   ```

2. **Jalankan Server:**
   ```bash
   php artisan serve
   ```

3. **Uji Matriks Hak Akses (RBAC):**
   - **`admin@example.com`** (Password: `password`): Memiliki akses penuh (Create, View, Edit, Delete).
   - **`staff@example.com`** (Password: `password`): Memiliki akses Create, View, dan Edit (Aksi Delete tidak tersedia).
   - **`viewer@example.com`** (Password: `password`): Hanya memiliki hak akses View data.

4. **Verifikasi Dashboard:**
   Buka halaman dashboard utama untuk memastikan widget ringkasan statistik dan chart status buku telah muncul dan sinkron dengan data database.


# Hasil
## Poin 1 (Description)
<img width="959" height="538" alt="image" src="https://github.com/user-attachments/assets/b83baaeb-0cfb-4a61-9325-57bc8b9dd28a" />

## Poin 2 (Role Access)
### Admin - Create, View, Edit, Delete
<img width="956" height="540" alt="image" src="https://github.com/user-attachments/assets/b62b3aee-9789-448c-b4b3-fe824e1073bd" />

<img width="953" height="539" alt="image" src="https://github.com/user-attachments/assets/21d4bb4a-593a-4190-b602-1cc499484034" />

### Staff - Create, View, Edit
<img width="959" height="540" alt="image" src="https://github.com/user-attachments/assets/8527d2b0-192c-4c35-adb3-ccb22c8a2c08" />

<img width="958" height="542" alt="image" src="https://github.com/user-attachments/assets/907ffd35-50c2-40ec-8e8c-c74529bfe8e8" />

### Viewer - View only
<img width="959" height="540" alt="image" src="https://github.com/user-attachments/assets/4eb6870b-f84c-4a7a-9d94-d3fd358da619" />

<img width="959" height="542" alt="image" src="https://github.com/user-attachments/assets/bb65beb2-c2c8-4ca9-8b75-2534564bb0c7" />


## Poin 3 (Widget Dashboard)
<img width="959" height="541" alt="image" src="https://github.com/user-attachments/assets/0c13d0d0-ed4c-4d98-a877-f8acd9c2f422" />

<img width="959" height="540" alt="image" src="https://github.com/user-attachments/assets/f2541b7f-2e8d-4332-8bac-2bb397c20b3a" />


## Poin 4 (Category)
<img width="956" height="539" alt="image" src="https://github.com/user-attachments/assets/a8443feb-9e0a-4df1-843c-f44f4cb18b6c" />

<img width="957" height="539" alt="image" src="https://github.com/user-attachments/assets/4ec91976-60dc-4bcc-b209-7241f4842063" />
