# KB 'Aisyiyah 2 Dau

Website resmi KB 'Aisyiyah 2 Dau — Kelompok Bermain di bawah naungan
Pimpinan Cabang 'Aisyiyah Dau, Kabupaten Malang. Laravel + sebuah ECMS
(Extensible Content Management System) config-driven: setiap teks, gambar,
dan daftar (galeri, artikel, staf, dst.) di halaman publik bisa diedit dari
`/admin` tanpa mengubah layout.

## Menu

Home · About Us (About KB 'Aisyiyah 2 Dau, Struktur Organisasi, Sumber Daya
Manusia) · Gallery · Artikel — plus Contact Us (dapat diakses lewat tombol
"Hubungi Kami", tidak ada di menu header).

## Setup

Butuh PHP ^8.3 dan Composer. Tidak ada langkah build front-end — Tailwind
dan Google Fonts dimuat dari CDN, JS-nya file statis biasa di `public/js/`.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Login admin (ganti password ini sebelum production):

```
email:    admin@dau.com
password: password
```

## Testing

```bash
php artisan test
vendor/bin/pint --test
```

## Menambah section/collection baru di ECMS

Lihat [`docs/ECMS.md`](docs/ECMS.md) — polanya config-driven
(`config/ecms.php`), jadi collection baru cukup migration + model + satu
entry config, tanpa controller/route/JS baru.

## Struktur proyek

- `proto/` — prototipe desain statis (referensi, sudah tidak dipakai
  langsung oleh aplikasi).
- `markdowns/dev_markdown.md` — spesifikasi ECMS yang jadi acuan build ini.
- `docs/ECMS.md` — dokumentasi arsitektur & cara extend.
