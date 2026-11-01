# 📖 LAPORAN TUGAS PRAKTIKUM PERTEMUAN 6 PRAK PBW (SE)
**👨‍💼 Delsyad Iza - 4524210025**

# 🏫 Website Sistem Manajemen Buku "Authbook"
Merupakan aplikasi Sistem Manajemen Buku menggunakan framework Laravel dan Filament 3.x. Aplikasi ini mencakup fitur lengkap CRUD (Create, Read, Update, Delete) untuk mengelola data buku dan penulis, dilengkapi dengan fitur pencarian, filter, upload gambar, dan sistem relasi database.
<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge\&logo=php\&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind\_CSS-4.0-38B2AC?style=for-the-badge\&logo=tailwind-css\&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

# Instalasi Authbook
## BAGIAN 1: Setup Project Laravel
### Langkah 1.1: Membuat Project Laravel Baru
```bash
# Buat project Laravel baru
composer create-project laravel/laravel authbook

# Masuk ke direktori project
cd authbook

# Jalankan development server untuk test
php artisan serve
```

### Langkah 1.2: Konfigurasi Database
#### Untuk SQLite (paling mudah untuk praktikum)
```bash
touch database/database.sqlite
```
Edit file `.env`:
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
#### Alternatif menggunakan MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=authbook
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 1.3: Install Filament
```bash
# Install Filament via Composer
composer require filament/filament:"^3.0"

# Setup Filament panel
php artisan filament:install --panels
```
*Input yang diminta:**
- Panel ID: `admin` (tekan Enter untuk default)
- Filament akan publish assets dan setup konfigurasi
- [ ] **✅ Checkpoint:** Cek apakah file `app/Providers/Filament/AdminPanelProvider.php` sudah ada.


## BAGIAN 2: Membuat Model dan Database
### Langkah 2.1: Membuat Model Author
```bash
# Buat model Author dengan migration
php artisan make:model Author -m
```

### Langkah 2.2: Edit Migration Author
Buka file `database/migrations/xxxx_xx_xx_create_authors_table.php`:
```php
public function up(): void
{
    Schema::create('authors', function (Blueprint $table) {$table->id();
        $table->string('name');$table->timestamps();
    });
}
```

### Langkah 2.3: Edit Model Author
Buka file `app/Models/Author.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
```

### Langkah 2.4: Membuat Model Book
```bash
# Buat model Book dengan migration
php artisan make:model Book -m
```

### Langkah 2.5: Edit Migration Book
Buka file `database/migrations/xxxx_xx_xx_create_books_table.php`:
```php
public function up(): void
{
    Schema::create('books', function (Blueprint $table) {$table->id();
        $table->string('isbn')->unique();$table->string('title');
        $table->foreignId('author_id')->constrained()->onDelete('cascade');$table->string('publisher')->nullable();
        $table->year('year')->nullable();$table->string('cover')->nullable();
        $table->enum('status', ['available', 'borrowed'])->default('available');$table->timestamps();
    });
}
```

### Langkah 2.6: Edit Model Book
Buka file `app/Models/Book.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author_id',
        'publisher',
        'year',
        'cover',
        'status',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
```

### Langkah 2.7: Jalankan Migration
```bash
# Jalankan semua migration
php artisan migrate
```

- [ ] **✅ Checkpoint:**
  - Tidak ada error saat migration
  - Cek database, tabel `authors` dan `books` sudah ada

```bash
# Lihat status migration
php artisan migrate:status

# Lihat struktur database
php artisan db:show
```


## BAGIAN 3: Membuat Factory dan Seeder (30 menit)
### Langkah 3.1: Membuat Factory untuk Author
```bash
php artisan make:factory AuthorFactory
```

Edit file `database/factories/AuthorFactory.php`:
```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
```

### Langkah 3.2: Membuat Factory untuk Book
```bash
php artisan make:factory BookFactory
```

Edit file `database/factories/BookFactory.php`:
```php
<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->sentence(3),
            'author_id' => Author::factory(),
            'publisher' => fake()->company(),
            'year' => fake()->numberBetween(1950, 2024),
            'status' => fake()->randomElement(['available', 'borrowed']),
        ];
    }
}
```

### Langkah 3.3: Edit Database Seeder
Edit file `database/seeders/DatabaseSeeder.php`:
```php
<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin user untuk Filament
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Buat 10 authors
        $authors = Author::factory(10)->create();

        // Buat 50 books dengan random authors
        Book::factory(50)->create([
            'author_id' => fn() => $authors->random()->id,
        ]);
    }
}
```

### Langkah 3.4: Setup Storage Link
```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### Langkah 3.5: Jalankan Seeder
```bash
# Reset database dan seed data
php artisan migrate:fresh --seed
```


## BAGIAN 4: Membuat Filament Resources (60 menit)
### Langkah 4.1: Membuat Author Resource
```bash
php artisan make:filament-resource Author --generate
```

### Langkah 4.2: Kustomisasi Author Resource
Edit file `app/Filament/Resources/AuthorResource.php`:
```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Library Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Author Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter author name'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('books_count')
                    ->counts('books')
                    ->label('Books')
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('created_at')
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
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
```

### Langkah 4.3: Membuat Book Resource
```bash
php artisan make:filament-resource Book --generate --view
```

### Langkah 4.4: Kustomisasi Book Resource
Edit file `app/Filament/Resources/BookResource.php`:
```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Library Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Book Information')
                    ->schema([
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\TextInput::make('publisher')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('year')
                            ->numeric()
                            ->minValue(1000)
                            ->maxValue(date('Y'))
                            ->step(1),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'available' => 'Available',
                                'borrowed' => 'Borrowed',
                            ])
                            ->required()
                            ->default('available'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Cover Image')
                    ->schema([
                        Forms\Components\FileUpload::make('cover')
                            ->image()
                            ->directory('book-covers')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Maximum file size: 2MB. Accepted formats: JPEG, PNG, WebP'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-book-cover.png')),
                
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('publisher')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('year')
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'available',
                        'warning' => 'borrowed',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'available',
                        'heroicon-o-clock' => 'borrowed',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'borrowed' => 'Borrowed',
                    ]),
                
                Tables\Filters\SelectFilter::make('year')
                    ->options(function () {
                        $currentYear = date('Y');$years = [];
                        for ($year = $currentYear; $year >= 1950; $year--) {$years[$year] =$year;
                        }
                        return $years;
                    })
                    ->searchable(),
                
                Tables\Filters\SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'view' => Pages\ViewBook::route('/{record}'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
```

### Langkah 4.5: Kustomisasi View Book Page
Edit file `app/Filament/Resources/BookResource/Pages/ViewBook.php`:
```php
<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBook extends ViewRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Book Details')
                    ->schema([
                        Infolists\Components\ImageEntry::make('cover')
                            ->height(200)
                            ->defaultImageUrl(url('/images/default-book-cover.png')),
                        
                        Infolists\Components\TextEntry::make('isbn')
                            ->label('ISBN')
                            ->copyable(),
                        
                        Infolists\Components\TextEntry::make('title')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        
                        Infolists\Components\TextEntry::make('author.name')
                            ->label('Author'),
                        
                        Infolists\Components\TextEntry::make('publisher'),
                        
                        Infolists\Components\TextEntry::make('year'),
                        
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'available' => 'success',
                                'borrowed' => 'warning',
                            }),
                        
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
```


## BAGIAN 5: Authorization dengan Policies (30 menit)
### Langkah 5.1: Membuat Policy untuk Book
```bash
php artisan make:policy BookPolicy --model=Book
```

Edit file `app/Policies/BookPolicy.php`:
```php
<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Semua user bisa lihat list
    }

    public function view(User $user, Book$book): bool
    {
        return true; // Semua user bisa lihat detail
    }

    public function create(User $user): bool
    {
        return true; // Semua user bisa buat buku baru
    }

    public function update(User $user, Book$book): bool
    {
        return true; // Semua user bisa edit
    }

    public function delete(User $user, Book$book): bool
    {
        return true; // Semua user bisa hapus
    }

    public function restore(User $user, Book$book): bool
    {
        return true;
    }

    public function forceDelete(User $user, Book$book): bool
    {
        return true;
    }
}
```

**Contoh Role-Based:**
```php
public function create(User $user): bool
{
    return $user->role === 'admin' \vert{}\vert{}$user->role === 'librarian';
}

public function delete(User $user, Book$book): bool
{
    return $user->role === 'admin'; // Hanya admin bisa hapus
}
```

---

### Langkah 5.2: Membuat Policy untuk Author
```bash
php artisan make:policy AuthorPolicy --model=Author
```

Edit file `app/Policies/AuthorPolicy.php` (sama seperti `BookPolicy`, semua return `true`).


## BAGIAN 6: Membuat Admin User dan Testing (30 menit)
### Langkah 6.1: Membuat Admin User
```bash
php artisan make:filament-user
```

**Input yang diminta:**
- Name: `Admin`
- Email: `admin@example.com`
- Password: `password` (atau sesuai keinginan)

- [ ] **✅ Checkpoint:** User admin berhasil dibuat.

---

### Langkah 6.2: Akses Admin Panel
```bash
# Jalankan development server
php artisan serve
```

1. Buka browser: `http://localhost:8000/admin/login`
2. Login dengan credentials yang baru dibuat
3. Explore fitur-fitur yang ada

---

### Langkah 6.3: Testing CRUD Operations

#### 1. Test Create Book:
1. Klik menu **"Books"** → **"New Book"**
2. Isi form:
   - ISBN: `978-0-545-01022-1`
   - Title: `Harry Potter and the Deathly Hallows`
   - Author: Pilih dari dropdown atau buat baru
   - Publisher: `Scholastic`
   - Year: `2007`
   - Status: `Available`
   - Upload cover image (opsional)
3. Klik **"Create"**

#### 2. Test Search:
1. Di halaman list books
2. Ketik di search box: `Harry Potter`
3. Pastikan hasil muncul

#### 3. Test Filter:
1. Klik icon filter
2. Filter by Status: `Available`
3. Filter by Year: `2007`
4. Pastikan hasil terfilter

#### 4. Test Edit:
1. Klik icon edit pada buku
2. Ubah beberapa field
3. Klik **"Save changes"**

#### 5. Test Delete:
1. Klik icon delete
2. Confirm deletion
3. Pastikan buku terhapus

#### 6. Test Bulk Delete:
1. Checklist beberapa buku
2. Klik bulk action **"Delete"**
3. Confirm
4. Pastikan semua terhapus

#### 7. Test View:
1. Klik icon view pada buku
2. Pastikan semua detail tampil dengan baik
3. Test edit/delete dari halaman view


## BAGIAN 7: Verifikasi dan Optimasi (15 menit)
### Langkah 7.1: Verifikasi Routes
```bash
php artisan route:list --path=admin
```

- [ ] **✅ Checkpoint:** Pastikan semua routes Filament terdaftar.


### Langkah 7.2: Verifikasi Database
```bash
php artisan db:show
php artisan tinker
```

Di dalam tinker:
```php
# Import Models terlebih dahulu
use App\Models\Author;
use App\Models\Book;

// Cek jumlah data
Author::count();
Book::count();

// Cek relasi
$author = Author::first();$author->books; // Tampilkan semua buku dari author ini

$book = Book::first();$book->author; // Tampilkan author dari buku ini

exit;
```

---

### Langkah 7.3: Clear Cache (Jika ada masalah)
```bash
php artisan optimize:clear
```


# 📝 Tugas dan Evaluasi
### Tugas 1: Implementasi Dasar (Nilai: 40)

Implementasikan semua langkah di atas dan buktikan dengan:

✅ Screenshot admin panel yang berhasil login

✅ Screenshot list books dengan data yang terseed

✅ Screenshot form create book

✅ Screenshot hasil pencarian

✅ Screenshot filter aktif

