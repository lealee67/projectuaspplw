# Archamp

Sistem Manajemen Kompetisi & Turnamen Esport — Tugas Project UAS PWBF.

> Mata kuliah: PPLW
> Kelompok: 2 | Dosen:

---

## Daftar Isi

1. [Deskripsi Proyek](#1-deskripsi-proyek)
2. [Fitur Utama](#2-fitur-utama)
3. [Teknologi yang Digunakan](#3-teknologi-yang-digunakan)
4. [Alur Kerja Sistem](#4-alur-kerja-sistem)
5. [Role & Hak Akses](#5-role--hak-akses)
6. [Struktur Database & ERD](#6-struktur-database--erd)
7. [Aturan Bisnis & Validasi](#7-aturan-bisnis--validasi)
8. [Cara Instalasi](#8-cara-instalasi)
9. [Akun Demo](#9-akun-demo)
10. [Laporan (Query Builder)](#10-laporan-query-builder)
11. [Pemetaan ke Persyaratan UAS](#11-pemetaan-ke-persyaratan-uas)
12. [Pengujian](#12-pengujian)
13. [Screenshot](#13-screenshot)
14. [Pembagian Kerja Tim](#14-pembagian-kerja-tim)

---

## 1. Deskripsi Proyek

Archamp adalah aplikasi web berbasis Laravel untuk pengelolaan dan pendaftaran turnamen e-sports secara terstruktur, mulai dari manajemen data game, kategori kompetisi, dan turnamen, hingga alur pendaftaran peserta/tim (pola header-detail), verifikasi panitia, penyusunan jadwal & bracket single elimination, pencatatan skor pertandingan, serta penetapan juara.

## 2. Fitur Utama

- Autentikasi dan otorisasi berbasis role (RBAC)
- CRUD data master: Games, Kategori Kompetisi, Turnamen
- Pendaftaran peserta individu/tim dengan pola header-detail
- Verifikasi pendaftaran (setuju/tolak) oleh panitia
- Penjadwalan pertandingan dan bracket single elimination
- Pencatatan hasil pertandingan dengan auto-advance pemenang
- Penetapan peringkat juara
- Laporan rekapitulasi dengan Query Builder
- Proteksi penghapusan data master yang sudah dipakai transaksi

## 3. Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Framework | Laravel [VERSI] |
| Bahasa | PHP [VERSI] |
| Database | MySQL / MariaDB [VERSI] |
| Frontend | Blade [+ Bootstrap/Tailwind — ISI SESUAI YANG DIPAKAI] |
| Lainnya | [ISI JIKA ADA, mis. Laravel Breeze] |

## 4. Alur Kerja Sistem

1. Pengelolaan Master — Panitia mengelola game, kategori kompetisi, dan turnamen.
2. T1 Pendaftaran — Ketua login, memilih turnamen, mengisi data tim/anggota (disimpan atomik dengan `DB::transaction()`).
3. T2 Verifikasi — Panitia menyetujui/menolak; status `pendaftaran` ikut diperbarui.
4. T3 Jadwal — Panitia menyusun jadwal dan bracket dari peserta yang diterima.
5. T4 Hasil — Panitia memasukkan skor; sistem mencatat pemenang, mengubah status jadwal menjadi selesai, dan meneruskan pemenang ke babak berikutnya.
6. T5 Penetapan Juara — Panitia menetapkan peringkat juara berdasarkan rekap hasil akhir.

```text
Peserta (Ketua)            Panitia
     │                        │
 Daftar (T1) ───────────► Verifikasi (T2)
                              │
                         Jadwal (T3)
                              │
                         Hasil (T4)
                              │
                       Juara (T5)
```

## 5. Role & Hak Akses

| Role | Hak Akses |
|---|---|
| Panitia | [ISI: kelola master, verifikasi, jadwal, hasil, juara, laporan] |
| Peserta (Ketua) | [ISI: lihat turnamen, daftar, lihat status pendaftaran sendiri] |

## 6. Struktur Database & ERD

Basis data terdiri dari **11 tabel**: 2 pendukung, 3 master, dan 6 tabel transaksi (T1 memakai pola header-detail).

![ERD E-Tourney](docs/erd.png)
<!-- TODO: export ERD ke docs/erd.png -->

| Kelompok | Tabel |
|---|---|
| Pendukung | `roles`, `users` |
| Master | `games`, `kategori_kompetisi`, `turnamen` |
| T1 | `pendaftaran`, `detail_pendaftaran` |
| T2 | `verifikasi_pendaftaran` |
| T3 | `jadwal_pertandingan` |
| T4 | `hasil_pertandingan` |
| T5 | `penetapan_juara` |

**Relasi hierarki master:** `games` → `kategori_kompetisi` → `turnamen`

**Urutan migration:**
`roles` → `users` → `games` → `kategori_kompetisi` → `turnamen` → `pendaftaran` → `detail_pendaftaran` → `verifikasi_pendaftaran` → `jadwal_pertandingan` → `hasil_pertandingan` → `penetapan_juara`

```mermaid
erDiagram
    roles ||--o{ erDiagram
    roles ||--o{ users : memiliki
    games ||--o{ kategori_kompetisi : memiliki
    kategori_kompetisi ||--o{ turnamen : digunakan
    turnamen ||--o{ pendaftaran : menerima
    users ||--o{ pendaftaran : "ketua mendaftarkan"
    pendaftaran ||--|{ detail_pendaftaran : "memiliki anggota"
    pendaftaran ||--o{ verifikasi_pendaftaran : diverifikasi
    turnamen ||--o{ verifikasi_pendaftaran : mencatat
    users ||--o{ verifikasi_pendaftaran : "panitia memverifikasi"
    turnamen ||--o{ jadwal_pertandingan : memiliki
    pendaftaran |o--o{ jadwal_pertandingan : "peserta_1 / peserta_2"
    jadwal_pertandingan |o--o{ jadwal_pertandingan : next_match
    users ||--o{ jadwal_pertandingan : "panitia menyusun"
    jadwal_pertandingan ||--o| hasil_pertandingan : "satu hasil (UNIQUE)"
    turnamen ||--o{ hasil_pertandingan : mencatat
    pendaftaran ||--o{ hasil_pertandingan : "pemenang"
    users ||--o{ hasil_pertandingan : "panitia menginput"
    turnamen ||--o{ penetapan_juara : memiliki
    pendaftaran ||--o{ penetapan_juara : "meraih peringkat"
    users ||--o{ penetapan_juara : "panitia menetapkan"

    roles {
        bigint id PK
        varchar nama_role
    }
    users {
        bigint id PK
        bigint role_id FK
        varchar nama
        varchar email
        varchar password
    }
    games {
        bigint id PK
        varchar nama_game
        varchar developer
        varchar status
    }
    kategori_kompetisi {
        bigint id PK
        bigint game_id FK
        varchar nama_kategori
        varchar tipe_peserta
        int minimal_anggota
        int maksimal_anggota
        varchar status
    }
    turnamen {
        bigint id PK
        bigint kategori_kompetisi_id FK
        varchar nama_turnamen
        date tanggal_mulai
        date tanggal_selesai
        int kuota_peserta
        decimal biaya_pendaftaran
        varchar status
    }
    pendaftaran {
        bigint id PK
        bigint turnamen_id FK
        bigint user_id FK
        varchar nama_tim
        varchar status
        timestamp created_at
        timestamp updated_at
    }
    detail_pendaftaran {
        bigint id PK
        bigint pendaftaran_id FK
        varchar nama_anggota
        varchar identitas_anggota
        varchar posisi
    }
    verifikasi_pendaftaran {
        bigint id PK
        bigint pendaftaran_id FK
        bigint turnamen_id FK
        bigint user_id FK
        varchar keputusan
        text catatan
        timestamp created_at
    }
    jadwal_pertandingan {
        bigint id PK
        bigint turnamen_id FK
        bigint peserta_1_id FK
        bigint peserta_2_id FK
        bigint next_match_id FK
        varchar next_match_slot
        bigint user_id FK
        date tanggal_pertandingan
        time jam_pertandingan
        varchar mode_pelaksanaan
        varchar lokasi
        varchar link_pertandingan
        varchar status
        timestamp created_at
    }
    hasil_pertandingan {
        bigint id PK
        bigint jadwal_pertandingan_id FK "UNIQUE"
        bigint turnamen_id FK
        bigint pemenang_pendaftaran_id FK
        bigint user_id FK
        int skor_peserta_1
        int skor_peserta_2
        timestamp created_at
    }
    penetapan_juara {
        bigint id PK
        bigint turnamen_id FK
        bigint pendaftaran_id FK
        bigint user_id FK
        int peringkat
        timestamp created_at
    }
```

## 7. Aturan Bisnis & Validasi

1. **Individu:** `nama_tim` boleh kosong dan `detail_pendaftaran` hanya 1 baris.
2. **Tim:** `nama_tim` wajib; jumlah anggota harus di antara `minimal_anggota` dan `maksimal_anggota` kategori terkait.
3. Satu akun ketua boleh punya banyak pendaftaran (turnamen berbeda); satu pendaftaran hanya milik satu ketua.
4. Anggota tim tidak punya akun; `detail_pendaftaran` tidak punya FK ke `users`.
5. Satu jadwal hanya boleh punya satu hasil (`UNIQUE` pada `jadwal_pertandingan_id`).
6. Pemenang harus salah satu dari `peserta_1_id` atau `peserta_2_id` pada jadwal tersebut.
7. `next_match_id` dan `next_match_slot` dipakai untuk meneruskan pemenang ke babak berikutnya.
8. Data master yang sudah dipakai transaksi tidak boleh dihapus (`restrictOnDelete` + pesan peringatan).

## 8. Cara Instalasi

**Prasyarat:** PHP [VERSI], Composer, MySQL, Node.js [JIKA PERLU]

```bash
# 1. Clone repository
git clone [URL_REPO]
cd [NAMA_FOLDER]

# 2. Install dependency
composer install
npm install && npm run build   # jika memakai Vite

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database di .env
#    DB_DATABASE=e_tourney
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Migrasi dan seeder
php artisan migrate --seed

# 6. Jalankan aplikasi
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## 9. Akun Demo

| Role | Email | Password |
|---|---|---|
| Panitia | [ISI] | [ISI] |
| Peserta (Ketua) | [ISI] | [ISI] |

> Akun dibuat oleh seeder. Hanya untuk demo, jangan dipakai di produksi.

## 10. Laporan (Query Builder)

Laporan dibuat dengan `DB::table()` (Query Builder).

| Laporan | Deskripsi | Route |
|---|---|---|
| Jumlah peserta per turnamen | [ISI] | [ISI] |
| Rekap turnamen per game | [ISI] | [ISI] |
| Rekap hasil pertandingan & juara | [ISI] | [ISI] |

## 11. Pemetaan ke Persyaratan UAS

| Persyaratan | Implementasi |
|---|---|
| 3 Data Master | `games`, `kategori_kompetisi`, `turnamen` |
| 5 Transaksi berbeda | Pendaftaran, Verifikasi, Jadwal, Hasil, Penetapan Juara |
| Minimal 2 master berelasi | `games` → `kategori_kompetisi` → `turnamen` |
| Pola header-detail | `pendaftaran` + `detail_pendaftaran` |
| Dua role dalam alur | Peserta mendaftar (T1) → Panitia verifikasi (T2) |
| Transaksi mengubah data lain | Verifikasi → status `pendaftaran`; Hasil → status `jadwal_pertandingan` |
| Laporan Query Builder | Lihat [bagian 10](#10-laporan-query-builder) |

## 12. Pengujian

Skenario yang diuji:

| No | Skenario | Hasil yang Diharapkan | Status |
|---|---|---|---|
| 1 | Alur end-to-end: daftar → verifikasi → jadwal → hasil → juara | Semua tahap berjalan | [ ] |
| 2 | Pendaftaran individu dengan >1 anggota | Ditolak | [ ] |
| 3 | Pendaftaran tim di luar rentang min/max anggota | Ditolak | [ ] |
| 4 | Input hasil kedua untuk jadwal yang sama | Ditolak (UNIQUE) | [ ] |
| 5 | Pemenang bukan peserta pada jadwal | Ditolak | [ ] |
| 6 | Hapus master yang sudah dipakai transaksi | Ditolak + pesan jelas | [ ] |
| 7 | Akses halaman panitia oleh peserta | Ditolak (403/redirect) | [ ] |
| 8 | Peringkat juara dobel pada satu turnamen | Ditolak | [ ] |

Menjalankan test otomatis (jika ada):

```bash
php artisan test
```

## 13. Screenshot

| Halaman | Gambar |
|---|---|
| Login | ![Login](docs/screenshots/login.png) |
| Dashboard | ![Dashboard](docs/screenshots/dashboard.png) |
| Form Pendaftaran | ![Pendaftaran](docs/screenshots/pendaftaran.png) |
| Bracket / Jadwal | ![Jadwal](docs/screenshots/jadwal.png) |
| Laporan | ![Laporan](docs/screenshots/laporan.png) |

## 14. Pembagian Kerja Tim

| Anggota | NIM | Data Master | Transaksi | Tanggung Jawab Tambahan |
|---|---|---|---|---|
| [NAMA 1] | [NIM] | `games` | T1 Pendaftaran, T2 Verifikasi | Setup repo, autentikasi, RBAC, seeder akun |
| [NAMA 2] | [NIM] | `kategori_kompetisi` | T3 Jadwal, T4 Hasil | Layout Blade, halaman guest, dashboard |
| [NAMA 3] | [NIM] | `turnamen` | T5 Penetapan Juara | Testing, laporan Query Builder, README, dokumentasi ERD |
