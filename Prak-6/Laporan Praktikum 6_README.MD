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
