# 📖 LAPORAN TUGAS PRAKTIKUM PERTEMUAN 8 PRAK PBW (SE)
**👨‍💼 Delsyad Iza - 4524210025**

# 🏫 Website Sistem Manajemen Buku "Authbook"
Merupakan aplikasi Sistem Manajemen Buku menggunakan framework Laravel dan Filament 3.x. Aplikasi ini mencakup fitur lengkap CRUD (Create, Read, Update, Delete) untuk mengelola data buku dan penulis, dilengkapi dengan fitur pencarian, filter, upload gambar, dan sistem relasi database.
<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge\&logo=php\&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind\_CSS-4.0-38B2AC?style=for-the-badge\&logo=tailwind-css\&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

# Tugas 3: Analisis dan Dokumentasi (Nilai: 20)
Buat laporan yang berisi:

## Penjelasan Arsitektur 
### Diagram ERD (Entity Relationship Diagram)
<img width="1096" height="766" alt="image" src="https://github.com/user-attachments/assets/ad6906b5-ba9e-405a-830e-783d705b8af1" />

### Penjelasan Relasi Antar Tabel
1. **`authors` ke `books` (One-to-Many / 1:N):**
   * **Struktur Basis Data:** Kolom `author_id` pada tabel `books` berperan sebagai *foreign key* yang mengacu pada `id` di tabel `authors` dengan aturan referensial `onDelete('cascade')`.
   * **Kardinalitas:** Satu penulis dapat menghasilkan banyak buku terdaftar, namun sebuah buku hanya dimiliki oleh satu penulis penanggung jawab.
   * **Implementasi Eloquent:**
     * `Author.php` $\rightarrow$ `public function books(): HasMany { return $this->hasMany(Book::class); }`
     * `Book.php` $\rightarrow$ `public function author(): BelongsTo { return $this->belongsTo(Author::class); }`

2. **`books` ke `categories` (Many-to-Many / N:M):**
   * **Struktur Basis Data:** Dihubungkan secara fisik melalui tabel perantara (*pivot table*) `book_category` yang menyimpan pasangan kolom `book_id` dan `category_id` dengan integritas referensial bertingkat (*cascade delete*).
   * **Kardinalitas:** Sebuah buku dapat memiliki beberapa klasifikasi kategori (misal: *Komputer* dan *Pendidikan*), serta satu kategori dapat menaungi banyak koleksi buku.
   * **Implementasi Eloquent:**
     * `Book.php` $\rightarrow$ `public function categories(): BelongsToMany { return $this->belongsToMany(Category::class); }`
     * `Category.php` $\rightarrow$ `public function books(): BelongsToMany { return $this->belongsToMany(Book::class); }`

3. **`users` ke `books` (Relasi Otorisasi Logis / RBAC):**
   * **Mekanisme:** Entitas `users` tidak diikat langsung melalui *foreign key* kolom fisik pada buku, melainkan dihubungkan melalui layer otorisasi kebijakan (*Laravel Policy* / `BookPolicy`).
   * **Kardinalitas Logis:** Atribut `role` pada pengguna (`admin`, `staff`, `viewer`) membatasi kemampuan manipulasi data terhadap seluruh koleksi buku pada level aplikasi (kontrol aksi *Create, Read, Update, Delete*).

### Penjelasan Alur Aplikasi 
```text
[ Browser / Klien ]
        │
        ▼  1. Mengirim HTTP Request (misal: GET /admin/books atau POST simpan buku)
[ Web Server (PHP Built-in / Laragon) ]
        │
        ▼  2. Meneruskan ke public/index.php & Inisialisasi HTTP Kernel
[ Laravel Routing & Pipeline Middleware ]
        │  (Validasi session, CSRF token, & autentikasi panel Filament)
        ▼
[ Authorization Layer (BookPolicy) ]
        │── Apakah User memiliki izin aksi? ──[Tidak]──> Abort 403 (Forbidden)
        │
        ▼ [Ya: Izin Diberikan]
[ Filament Resource Page (Livewire Component) ]
        │  (Merender form/tabel schema, memproses state input)
        ▼
[ Eloquent ORM & Query Builder ]
        │  (Menyusun kueri SQL relasional secara teroptimasi)
        ▼
[ Database MySQL ]
        │  (Menjalankan kueri dan mengembalikan result set)
        ▼
[ Livewire & Blade Rendering Engine ]
        │  (Mengompilasi markup Blade + state DOM reaktif Alpine.js)
        ▼  3. Mengirimkan HTTP Response (HTML/JSON State)
[ Browser / Klien ] ──> Merender Tampilan Dashboard Interaktif
```

* **Rincian Alur:**
  1. **HTTP Request:** Pengguna berinteraksi dengan antarmuka admin (mengakses menu, menyortir tabel, atau mengunggah cover buku).
  2. **Pipeline Middleware & Otentikasi:** Request melewati pemeriksaan middleware panel Filament untuk memastikan sesi user aktif.
  3. **Evaluasi Policy:** Method otorisasi pada `BookPolicy` dieksekusi berdasarkan nilai `auth()->user()->role`. Jika role tidak memiliki hak (contoh: staff mengeklik hapus buku), eksekusi dibatalkan sebelum menyentuh data.
  4. **Eksekusi Livewire & Eloquent:** Komponen Livewire memproses data tanpa me-refresh halaman secara penuh, memanggil model Eloquent untuk bertransaksi dengan basis data MySQL.
  5. **HTTP Response:** Hasil olahan data dirender menjadi markup HTML responsif yang dihias oleh Tailwind CSS, lalu dikembalikan ke peramban.


## Perbandingan dengan Pendekatan Tradisional
### Tabel Komparasi Fitur CRUD

| Aspek Arsitektur | Pendekatan Tradisional (Blade + Controller Manual) | Pendekatan Modern (Filament v3) |
| :--- | :--- | :--- |
| **Manajemen Rute** | Harus mendeklarasikan setiap URL manual di `routes/web.php` (`Route::resource(...)`). | Rute otomatis didaftarkan dan dikelompokkan oleh class `Pages` bawaan Filament. |
| **Struktur Controller** | Membutuhkan controller eksplisit berisikan method `index`, `create`, `store`, `edit`, `update`, `destroy`. | Tidak memerlukan file controller terpisah; logika ditangani oleh *Resource Pages* berbasis Livewire. |
| **Validasi & Desain Form** | Menulis tag `<form>` HTML/Blade manual, mengelola atribut `name`, error directive `@error`, dan `FormRequest`. | Didefinisikan secara deklaratif menggunakan PHP Schema (`TextInput`, `Select`, `FileUpload`) beserta rantai aturan validasinya. |
| **Tabel Data & Interaktivitas** | Menyusun elemen HTML `<table>`, script AJAX, pagination manual, serta pustaka JavaScript (seperti DataTables). | Metode `table()` otomatis menyediakan fitur server-side searching, multi-column sorting, pagination, dan filter terisolasi. |
| **Manajemen Unggah Berkas** | Menulis logika manual pada controller (`store()`, validasi MIME type, hashing nama berkas, pembuatan symlink). | Menggunakan komponen `FileUpload::make()` yang sudah dilengkapi validasi tipe berkas, crop/editor gambar, dan integrasi storage instan. |

### Kelebihan dan Kekurangan Masing-Masing
#### Filament v3
* **Kelebihan:**
  * **Efisiensi Waktu Signifikan:** Pembuatan antarmuka manajemen data lengkap dapat diselesaikan dalam hitungan menit tanpa menulis *boilerplate code*.
  * **Konsistensi UI/UX:** Tampilan seragam dan standar industri berkat penggunaan Tailwind CSS dan Alpine.js yang responsif.
  * **Ekosistem Fitur Luas:** Komponen kompleks seperti grafik analitik, widget ringkasan, multi-select relasi, dan ekspor data tersedia siap pakai.
* **Kekurangan:**
  * **Kurva Belajar Framework Khusus:** Menuntut pemahaman mendalam terkait siklus hidup Livewire, hook form, dan arsitektur internal Filament.
  * **Rigiditas Tata Letak:** Melakukan kustomisasi tampilan yang menyimpang jauh dari paradigma panel admin Filament memerlukan usaha ekstra (*custom Blade view*).

#### Pendekatan Tradisional (Manual Blade + Controller)
* **Kelebihan:**
  * **Kustomisasi Bebas 100%:** Struktur DOM HTML, alur transisi halaman, dan estetika visual dapat diatur bebas tanpa batas pembawaan library.
  * **Pemahaman Pola MVC Fundamental:** Sangat ideal untuk memahami siklus kerja asli framework Laravel bagi pengembang tahap awal.
* **Kekurangan:**
  * **Biaya Pemeliharaan Kode Tinggi:** Perubahan struktur tabel database menuntut pembaruan manual di banyak berkas (migration, controller, request, dan view Blade).
  * **Pengerjaan Repetitif:** Memerlukan waktu berulang hanya untuk membangun fungsi dasar CRUD pada setiap entitas baru.

### Kapan Menggunakan Filament vs Kapan Tidak
* **Gunakan Filament Saat:**
  * Mengembangkan sistem internal, panel kontrol manajemen data, backoffice, ERP, dashboard analitik, atau CMS.
  * Waktu pengerjaan proyek terbatas dan prioritas utama terletak pada kelengkapan fungsionalitas data daripada keunikan visual antarmuka.
  * Diperlukan integrasi cepat untuk visualisasi bagan metrik, filter data kompleks, dan matriks hak akses bertingkat.

* **Sebaiknya TIDAK Menggunakan Filament Saat:**
  * Membangun aplikasi yang berorientasi langsung ke pelanggan (*Customer-Facing App*), seperti landing page promosi, situs e-commerce umum, atau media sosial.
  * Aplikasi yang interaksi penggunanya tidak berpusat pada pengelolaan data tabular dan formulir entri standar.
  * Proyek skala mikro yang membutuhkan ukuran footprint dependensi dan konsumsi RAM server seminimal mungkin.
    

## Refleksi Pembelajaran
### 3.1 Poin Pembelajaran Praktikum
* **Penguasaan Ekosistem TALL Stack:** Memahami implementasi nyata dari sinergi Tailwind CSS, Alpine.js, Laravel, dan Livewire yang diorkestrasi oleh Filament v3 untuk menghasilkan aplikasi reaktif tanpa penulisan JavaScript mentah yang rumit.
* **Manajemen Relasi Lanjutan Eloquent:** Mengaplikasikan relasi *One-to-Many* (Author–Book) dan *Many-to-Many* (Book–Category) langsung ke dalam antarmuka form deklaratif menggunakan input multi-select dan tabel pivot.
* **Penerapan Keamanan RBAC Melalui Policy:** Mengonfigurasi hak akses berbasis peran menggunakan *Laravel Policy* untuk mengontrol hak aksi pengguna secara dinamis pada tampilan web.
* **Penyajian Data Anal
