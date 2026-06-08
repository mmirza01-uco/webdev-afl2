<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Web Development — AFL2

Aplikasi Laravel sederhana untuk pengelolaan artikel dengan sistem kategori dan komentar.
Project ini dibangun sebagai tugas AFL2 mata kuliah Web Development.

## Tech Stack

- **Laravel** (PHP framework)
- **SQLite** — database (default Laravel 11+)
- **Blade** — templating engine
- **Bootstrap 5.3** — CSS framework (via CDN)
- **Faker** — untuk generate data dummy
- **Laravel Herd** — environment lokal

## Fitur yang Diimplementasikan

Lima fitur sesuai kriteria penilaian (total 100 poin):

1. **Database seeder** dengan Factory dan Faker untuk generate 3 kategori, 30 artikel dengan kategori acak, dan 10-20 komentar pada setiap artikel (20 poin)
2. **Pencarian artikel** berdasarkan judul atau isi konten via query parameter `search` (20 poin)
3. **Hapus komentar** dari halaman single article dengan konfirmasi (20 poin)
4. **Edit komentar** dengan inline form dan tampilan tanggal perubahan otomatis (20 poin)
5. **Urutkan hasil pencarian** A-Z atau Z-A berdasarkan judul artikel (20 poin)

## Struktur Database

Tiga tabel dengan relasi sebagai berikut:

```
categories (1) ──< (banyak) articles (1) ──< (banyak) comments
```

**categories**
- `id`, `name`, `timestamps`

**articles**
- `id`, `title`, `slug` (unique), `content`, `category_id` (foreign key), `timestamps`
- Foreign key `category_id` dengan `cascadeOnDelete`

**comments**
- `id`, `article_id` (foreign key), `name`, `content`, `timestamps`
- Foreign key `article_id` dengan `cascadeOnDelete`

## Daftar Route

| Method | URI                       | Name              | Action                              |
| ------ | ------------------------- | ----------------- | ----------------------------------- |
| GET    | `/`                       | —                 | Redirect ke `/articles`             |
| GET    | `/articles`               | `articles.index`  | `ArticleController@index`           |
| GET    | `/articles/{slug}`        | `articles.show`   | `ArticleController@show`            |
| POST   | `/comments/update/{id}`   | `comments.update` | `CommentController@update`          |
| POST   | `/comments/destroy/{id}`  | `comments.destroy`| `CommentController@destroy`         |

### Query parameter pada `/articles`

- `search` — kata kunci pencarian (mencari di judul dan isi artikel)
- `sort` — `asc` (default, A-Z) atau `desc` (Z-A)

Contoh: `/articles?search=lorem&sort=desc`

## Struktur Folder Utama

```
.
├── app/
│   ├── Http/Controllers/
│   │   ├── ArticleController.php
│   │   └── CommentController.php
│   └── Models/
│       ├── Article.php
│       ├── Category.php
│       └── Comment.php
├── database/
│   ├── factories/
│   │   ├── ArticleFactory.php
│   │   ├── CategoryFactory.php
│   │   └── CommentFactory.php
│   ├── migrations/
│   │   ├── ..._create_categories_table.php
│   │   ├── ..._create_articles_table.php
│   │   └── ..._create_comments_table.php
│   └── seeders/
│       ├── ArticleContentSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── components/
│       │   └── template.blade.php
│       └── articles/
│           ├── list.blade.php
│           └── show.blade.php
└── routes/
    └── web.php
```

## Cara Menjalankan

### Prasyarat
- PHP 8.2+ (tersedia otomatis lewat [Laravel Herd](https://herd.laravel.com/))
- Composer
- Git

### Langkah-langkah

1. Clone repository:
   ```bash
   git clone https://github.com/mmirza01-uco/webdev-afl2.git
   cd webdev-afl2
   ```

2. Install dependency:
   ```bash
   composer install
   ```

3. Setup file environment dan generate application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Buat file database SQLite:
   ```bash
   touch database/database.sqlite
   ```

5. Jalankan migration dan isi data dummy:
   ```bash
   php artisan migrate --seed
   ```

6. Jalankan project:
   - **Dengan Herd**: letakkan folder project di direktori yang dikelola Herd (default `~/Herd`), lalu akses `http://webdev-afl2.test/articles` di browser.
   - **Tanpa Herd**: jalankan `php artisan serve`, lalu buka `http://127.0.0.1:8000/articles`.

## Pengujian Manual

| Halaman / Fitur     | URL atau aksi                                    |
| ------------------- | ------------------------------------------------ |
| Daftar artikel      | `/articles`                                      |
| Single article      | klik salah satu artikel dari daftar              |
| Pencarian           | `/articles?search=lorem`                         |
| Sort Z-A            | pilih dropdown "Nama Z-A" → klik Cari            |
| Search + sort       | `/articles?search=ipsum&sort=desc`               |
| Hapus komentar      | buka single article → klik **Hapus** → konfirmasi |
| Edit komentar       | buka single article → klik **Edit** → ubah → **Simpan** |

Untuk memverifikasi seluruh route terdaftar:
```bash
php artisan route:list
```

## Catatan

Data yang ditampilkan adalah data dummy yang di-generate oleh Faker via seeder.
Setiap kali `php artisan migrate:fresh --seed` dijalankan, data akan ulang dari nol
dengan jumlah komentar acak per artikel (10-20 komentar).

Aplikasi ini fokus pada implementasi backend (Eloquent, query builder, relasi, factory)
dan fitur CRUD komentar tanpa autentikasi user. Setiap pengunjung dapat mengedit dan
menghapus komentar siapa pun — implementasi sistem autentikasi dan otorisasi akan
dikerjakan pada tugas selanjutnya.
