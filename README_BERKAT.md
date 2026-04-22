# Sistem Permohonan Bantuan BERKAT

## Gambaran Keseluruhan

Sistem Permohonan Bantuan BERKAT adalah aplikasi web berbasis Laravel yang memudahkan proses permohonan bantuan kepada anggota organisasi. Sistem ini menyokong 5 jenis permohonan dengan pelbagai kategori dan sub-kategori.

## Ciri-ciri Utama

### 1. Jenis Permohonan (5 Kategori Utama)
- **Pendidikan** (Kemasukan Persekolahan, IPT, Kecemerlangan Peperiksaan)
    
- **Kesihatan** (Masuk Wad, Kesihatan Kronik, Alat Sokongan, Kecederaan)
- **Kebajikan** (Bencana Alam, Kematian, Kesusahan, Program OKU)
- **Sosial** (Perayaan, Pencapaian Antarabangsa)
- **Keahlian** (Persaraan, Pertukaran)

### 2. Sistem Pengguna dengan 4 Peranan
- **Member**: Ahli yang membuat permohonan
- **Agen**: Agen BERKAT yang membantu dan mengesahkan permohonan
- **JK**: Jawatankuasa yang mengesyorkan pemberian bantuan
- **Admin**: Pentadbir sistem

### 3. Aliran Kerja Permohonan
1. Member mengisi dan menyimpan borang (status: draft)
2. Member menghantar permohonan (status: submitted)
3. Agen mengesahkan kelengkapan dokumen
4. JK membuat pengesyoran pemberian bantuan
5. Status akhir: approved atau rejected

### 4. Maklumat Permohonan
- Maklumat pemohon (nama, KP, gaji, jawatan)
- Maklumat pasangan (jika ada)
- Maklumat tanggungan
- Maklumat anak (untuk bantuan pendidikan dan sosial)

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: SQLite (dapat diganti dengan MySQL)
- **Frontend**: Bootstrap 5
- **PHP Version**: 8.1+

## Instalasi

### Prasyarat
- PHP 8.1 atau lebih tinggi
- Composer
- Git

### Langkah Instalasi

1. **Navigasi ke direktori projek**
```bash
cd /Users/leezanm/berkat/berkat-app
```

2. **Pasang kebergantungan**
```bash
composer install
```

3. **Sedia fail persekitaran**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Jalankan migrasi**
```bash
php artisan migrate:fresh --seed
```

5. **Mulai pelayan pembangunan**
```bash
php artisan serve
```

Server akan mula di `http://localhost:8000`

## Akaun Ujian

Sistem telah disediakan dengan 4 akaun ujian yang berbeza dengan peranan:

### Member
- **Email**: member@test.com
- **Password**: password

### Agen BERKAT
- **Email**: agent@berkat.com
- **Password**: password

### JK Committee
- **Email**: jk@berkat.com
- **Password**: password

### Admin
- **Email**: admin@berkat.com
- **Password**: password

## Struktur Database

### Jadual Utama

1. **users** - Pengguna sistem
2. **request_types** - Jenis permohonan (Pendidikan, Kesihatan, dll)
3. **request_categories** - Kategori dalam setiap jenis
4. **request_subcategories** - Sub-kategori dalam setiap kategori
5. **assistance_requests** - Rekod permohonan utama
6. **request_details** - Maklumat anak/tanggungan

### Status Permohonan
- `draft` - Disimpan sebagai draf
- `submitted` - Dihantar untuk semakan
- `in_process` - Dalam proses (untuk kegunaan masa depan)
- `approved` - Diluluskan
- `rejected` - Ditolak

## Rute dan Titik Akhir

### Pengesahan
- `GET /login` - Papar borang log masuk
- `POST /login` - Proses log masuk
- `POST /logout` - Log keluar

### Permohonan
- `GET /assistance-requests` - Senarai permohonan pengguna
- `GET /assistance-requests/create` - Borang tambah permohonan
- `POST /assistance-requests` - Simpan permohonan
- `GET /assistance-requests/{id}` - Lihat permohonan
- `GET /assistance-requests/{id}/edit` - Edit permohonan
- `PUT /assistance-requests/{id}` - Kemaskini permohonan
- `DELETE /assistance-requests/{id}` - Padam permohonan
- `POST /assistance-requests/{id}/submit` - Hantar permohonan

### API untuk Dynamic Forms
- `GET /request-types/{typeId}/categories` - Ambil kategori satu jenis
- `GET /request-categories/{categoryId}/subcategories` - Ambil sub-kategori satu kategori

## Model dan Relationship

### AssistanceRequest (Permohonan Bantuan)
```
belongsTo User (pemohon)
belongsTo RequestType (jenis permohonan)
belongsTo RequestCategory (kategori)
belongsTo RequestSubcategory (sub-kategori)
belongsTo User (agen) - agen yang memproses
hasMany RequestDetail (maklumat anak/tanggungan)
```

### RequestType (Jenis Permohonan)
```
hasMany RequestCategory (kategori)
hasMany AssistanceRequest (permohonan)
```

## Ciri untuk Pembangunan Masa Depan

1. **Unggah Dokumen** - Sistem untuk mengunggah dokumen sokongan
2. **Notifikasi Email** - Pengiriman email kepada pemohon tentang status
3. **Dashboard Analitik** - Papar statistik dan laporan permohonan
4. **Export ke PDF** - Kemampuan untuk mengekspot permohonan ke PDF
5. **Sistem Kelulusan** - Workflow kelulusan oleh JK dengan approval/rejection notes
6. **Audit Log** - Pencatatan aktivitas pengguna dalam sistem
7. **Multiple Languages** - Sokongan untuk bahasa Inggeris dan bahasa Malaysia

## Testing Fitur

### Membuat Permohonan Baru
1. Log masuk sebagai member@test.com (password: password)
2. Klik "Buat Permohonan Baru"
3. Pilih jenis, kategori, dan sub-kategori permohonan
4. Isi maklumat pemohon
5. Klik "Simpan sebagai Draf"

### Menghantar Permohonan
1. Pergi ke "Senarai Permohonan"
2. Klik "Lihat" pada permohonan dalam status draft
3. Klik "Hantar Permohonan"

### Mengedit Permohonan
1. Lihat permohonan dalam status draft
2. Klik "Edit"
3. Ubah maklumat seperti diperlukan
4. Klik "Simpan Perubahan"

## Troubleshooting

### Migrasi gagal
```bash
php artisan migrate:fresh --seed
```

### Cache tidak terbaru
```bash
php artisan cache:clear
php artisan config:clear
```

### Masalah dengan permissions
Pastikan direktori `storage/` boleh ditulis:
```bash
chmod -R 775 storage
```

## File Struktur Penting

```
berkat-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AssistanceRequestController.php
│   │       └── Auth/
│   │           └── LoginController.php
│   └── Models/
│       ├── AssistanceRequest.php
│       ├── RequestType.php
│       ├── RequestCategory.php
│       └── RequestSubcategory.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── RequestTypeSeeder.php
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── assistance-requests/
│       └── auth/
├── routes/
│   └── web.php
└── .env
```

## Lisensi

Copyright © 2026 Sistem BERKAT

## Dukungan

Untuk bantuan atau pertanyaan, sila hubungi pasukan pembangun sistem BERKAT.
