# 📚 Indeks Dokumentasi BERKAT

Selamat datang ke Dokumentasi Sistem BERKAT! 📖

Dokumentasi lengkap untuk Sistem Permohonan Bantuan BERKAT.

---

## 📑 Dokumentasi Tersedia

### 1. 🚀 **[QUICK_START.md](QUICK_START.md)**
**Panduan Permulaan Pantas (5 minit)**

Untuk yang ingin langsung mencuba:
- ✅ Persediaan dalam 5 langkah mudah
- ✅ Kelayakan default untuk ujian
- ✅ Senario ujian yang siap dicuba
- ✅ Penyelesaian masalah pantas
- ✅ Rujukan arahan biasa

**👉 Mulai dari sini jika ingin langsung persediaan!**

---

### 2. 📋 **[DOKUMENTASI.md](DOKUMENTASI.md)**
**Dokumentasi Sistem Lengkap**

Panduan menyeluruh untuk memahami sistem:
- 📊 Gambaran umum sistem
- ✨ Ciri-ciri utama
- 🏗️ Struktur sistem & folder
- 📋 Jenis permohonan (5 kategori)
- 🔄 Alur kerja permohonan
- 👥 Peranan & kebenaran pengguna
- 💾 Skema pangkalan data & hubungan
- 📖 Panduan penggunaan per peranan
- 🚀 Pemasangan lengkap
- 🌐 Gambaran keseluruhan laluan API
- 🔧 Penyelesaian masalah

**👉 Baca ini untuk pemahaman mendalam!**

---

### 3. 🔌 **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)**
**Rujukan API & Panduan Integrasi**

Dokumentasi terperinci untuk semua titik hujung:
- 🔐 Titik hujung pengesahan
- 📝 Titik hujung permohonan bantuan
- ✅ Titik hujung pengesahan agen
- 🏛️ Titik hujung JK/Jawatankuasa
- 👨‍💼 Titik hujung keputusan pentadbir
- 📄 Titik hujung pengurusan dokumen
- 🔄 Titik hujung data dinamik
- 📊 Titik hujung papan pemuka pentadbir
- ❌ Respons ralat
- 📈 Rujukan kod status
- ⚡ Maklumat had kadar

**👉 Gunakan ini untuk integrasi & pembangunan!**

---

## 🎯 Pilih Jalan Anda

### Saya Pembangun Baru 👨‍💻
```
1. Baca: QUICK_START.md (persediaan)
2. Persediaan persekitaran tempatan
3. Ujian dengan data sampel
4. Baca: DOKUMENTASI.md (ciri)
5. Mulai pembangunan
```

### Saya Ingin Membangun Ciri Baru 🛠️
```
1. Baca: DOKUMENTASI.md (struktur)
2. Semak: QUICK_START.md (arahan)
3. Rujuk: API_DOCUMENTATION.md (titik hujung)
4. Pengekodan...
```

### Saya Ingin Mengintegrasikan dengan Sistem Lain 🔗
```
1. Baca: API_DOCUMENTATION.md (lengkap)
2. Semak respons ralat & kod status
3. Ujian dengan kelayakan sampel
4. Integrasikan...
```

### Saya Pengguna Sistem - Pentadbir/Agen/JK 👤
```
1. Baca: DOKUMENTASI.md → Panduan Penggunaan
2. Atau hubungi: berkat@example.com
```

---

## 🔍 Navigasi Pantas

| Anda Ingin... | Baca Dokumen |
|-------------|------------|
| Persediaan pantas | [QUICK_START](QUICK_START.md) |
| Pahami sistem | [DOKUMENTASI](DOKUMENTASI.md) |
| Integrasi API | [API_DOCUMENTATION](API_DOCUMENTATION.md) |
| Arahan Laravel | [QUICK_START](QUICK_START.md#-perintah-biasa) |
| Skema pangkalan data | [DOKUMENTASI](DOKUMENTASI.md#-skema-pangkalan-data) |
| Peranan pengguna | [DOKUMENTASI](DOKUMENTASI.md#-peranan-pengguna) |
| Alur kerja permintaan | [DOKUMENTASI](DOKUMENTASI.md#-alur-kerja) |
| Penyelesaian masalah | [QUICK_START](QUICK_START.md#-penyelesaian-masalah) |
| Kelayakan masuk | [QUICK_START](QUICK_START.md#-kelayakan-masuk) |
| Titik hujung API | [API_DOCUMENTATION](API_DOCUMENTATION.md#titik-hujung-pengesahan) |

---

## 📊 Gambaran Keseluruhan Sistem

```
┌─────────────────────────────────────────────────────────┐
│      BERKAT - Sistem Permohonan Bantuan                 │
│                                                          │
│  Rangka Kerja: Laravel 11  |  Bahagian Hadapan: Bootstrap 5│
│  Pangkalan Data: SQLite/MySQL  |  PHP: 8.1+             │
└─────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│           PERANAN PENGGUNA & ALUR KERJA                 │
├──────────────────────────────────────────────────────────┤
│                                                          │
│  AHLI (Pemohon)                                         │
│    └─ Cipta → Sunting → Hantar → Pantau → Terima Keputusan│
│                                                          │
│  AGEN (Agen BERKAT)                                    │
│    └─ Terima → Pengesahan → Luluskan/Tolak           │
│                                                          │
│  JK (Jawatankuasa)                                      │
│    └─ Semak → Cadangan → Tentukan Jumlah             │
│                                                          │
│  PENTADBIR (Admin)                                      │
│    └─ Pantau → Semak → Keputusan Akhir → Papan Pemuka│
│                                                          │
└──────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│         JENIS PERMOHONAN (5 Kategori)                    │
├──────────────────────────────────────────────────────────┤
│  1. Pendidikan (Pendidikan)                              │
│  2. Kesihatan (Kesihatan)                                │
│  3. Kebajikan (Kebajikan)                                │
│  4. Sosial (Sosial)                                      │
│  5. Keahlian (Keahlian)                                  │
└──────────────────────────────────────────────────────────┘
```

---

## 🚀 Bermula dalam 3 Langkah

### Langkah 1: Persediaan (5 minit)
Ikuti [QUICK_START.md → Persediaan Pantas](QUICK_START.md#-persediaan-pantas-5-minit)

### Langkah 2: Masuk & Ujian (10 minit)
Gunakan kelayakan dari [QUICK_START.md → Kelayakan Masuk](QUICK_START.md#-kelayakan-masuk)

### Langkah 3: Baca & Pelajari (30 minit)
Layari [DOKUMENTASI.md](DOKUMENTASI.md) mengikut keperluan

---

## 📚 Statistik Dokumentasi

| Fail | Halaman | Topik | Saiz |
|------|---------|-------|------|
| DOKUMENTASI.md | 12 | 10+ | ~15KB |
| API_DOCUMENTATION.md | 8 | 15+ | ~12KB |
| QUICK_START.md | 6 | 20+ | ~10KB |

**Jumlah**: 26 halaman dokumentasi menyeluruh ✅

---

## 🔐 Nota Keselamatan Penting

Sebelum pelaksanaan pengeluaran:

- [ ] Janakan APP_KEY baru
- [ ] Tetapkan APP_DEBUG=false
- [ ] Dayakan HTTPS
- [ ] Ubah kelayakan pangkalan data
- [ ] Persediaan pemboleh ubah persekitaran
- [ ] Semak pengesahan/kebenaran
- [ ] Persediaan pengelogan yang sesuai
- [ ] Ujian pengendalian ralat

Lihat [QUICK_START.md → Nota Keselamatan](QUICK_START.md#-nota-keselamatan)

---

## 📞 Sokongan & Hubungan

### Perlukan Bantuan?

1. **Semak Dokumentasi Dahulu**
   - QUICK_START.md → Penyelesaian Masalah
   - DOKUMENTASI.md → bahagian yang relevan

2. **Hubungi**
   - E-mel: berkat@example.com
   - Telefon: +60-3-XXXX-XXXX
   - Laman Web: https://berkat.example.com

3. **Untuk Pembangun**
   - Semak log Laravel: `storage/logs/laravel.log`
   - Jalankan: `php artisan tinker` untuk ujian
   - Semak: `routes/web.php` untuk laluan

---

## 🔄 Versi & Kemaskini

| Versi | Tarikh | Status | Catatan |
|--------|--------|--------|---------|
| 1.0.0 | 17 Apr 2026 | Pengeluaran | Pelancaran awal |

**Kemaskini Terakhir**: 17 April 2026

---

## 📄 Lesen & Hak Cipta

Sistem BERKAT © 2026  
Semua Hak Terpelihara

---

## 🎯 Langkah Seterusnya

### Untuk Pengguna Baru
→ Pergi ke [**QUICK_START.md**](QUICK_START.md)

### Untuk Pembangun
→ Pergi ke [**DOKUMENTASI.md**](DOKUMENTASI.md)

### Untuk Integrasi
→ Pergi ke [**API_DOCUMENTATION.md**](API_DOCUMENTATION.md)

---

**Selamat Belajar! 🎉**

Jika ada soalan atau maklum balas tentang dokumentasi ini,  
sila hubungi pasukan pembangunan.

---

*Dokumentasi ini dikekalkan dan dikemaskini secara berkala.*  
*Semakan terakhir: 17 April 2026*
