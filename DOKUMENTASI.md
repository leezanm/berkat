# 📋 Dokumentasi Sistem BERKAT

**Sistem Permohonan Bantuan BERKAT** adalah aplikasi web modern untuk mengelola permohonan bantuan kepada anggota organisasi dengan alur kerja yang terstruktur dan terintegrasi.

---

## 📑 Daftar Isi

1. [Gambaran Umum](#gambaran-umum)
2. [Fitur Utama](#fitur-utama)
3. [Struktur Sistem](#struktur-sistem)
4. [Jenis Permohonan](#jenis-permohonan)
5. [Alur Kerja](#alur-kerja)
6. [Peranan Pengguna](#peranan-pengguna)
7. [Database Schema](#database-schema)
8. [Panduan Penggunaan](#panduan-penggunaan)
9. [Instalasi & Setup](#instalasi--setup)
10. [API Routes](#api-routes)

---

## 🎯 Gambaran Umum

BERKAT memfasilitasi:
- ✅ Permohonan bantuan online yang mudah
- ✅ Verifikasi multi-tier (Agen → JK → Admin)
- ✅ Manajemen dokumen pendukung
- ✅ Dashboard analitik untuk admin
- ✅ Pelacakan status permohonan real-time

### Stack Teknologi
| Komponen | Teknologi |
|----------|-----------|
| **Backend** | Laravel 11 |
| **Database** | SQLite / MySQL |
| **Frontend** | Bootstrap 5 |
| **PHP** | 8.1+ |
| **Build Tool** | Vite |

---

## ✨ Ciri-ciri Utama

### 1. **Pengurusan Permohonan**
- Daftar, Kemaskini, dan hantar permohonan
- Simpan sebagai draf untuk dikemaskini kemudian
- Muatnaik dokumen sokongan (PDF, Imej)
- Penjejakan status masa nyata

### 2. **Sistem Pengesahan Berbilang Peringkat**
- **Agen**: Pengesahan kelengkapan dokumen
- **JK (Jawatankuasa)**: Memberikan cadangan
- **Pentadbir**: Membuat keputusan akhir (terima/tolak)

### 3. **Papan Pemuka Pentadbir**
- Statistik permohonan (jumlah, diluluskan, proses, draf)
- Penapis berdasarkan tahun
- Laporan menyeluruh

### 4. **Pengurusan Dokumen**
- Muatnaik berbilang dokumen
- Muat turun dokumen yang telah dimuatnaik
- Pengesahan jenis dan saiz fail

---

## 🏗️ Struktur Sistem

```
berkat-app/
├── app/
│   ├── Models/                    # Data models
│   │   ├── AssistanceRequest.php
│   │   ├── AssistanceRequestDocument.php
│   │   ├── RequestCategory.php
│   │   ├── RequestSubcategory.php
│   │   ├── RequestType.php
│   │   ├── RequestDetail.php
│   │   └── User.php
│   ├── Http/
│   │   └── Controllers/           # Business logic
│   │       ├── AssistanceRequestController.php
│   │       ├── AdminDashboardController.php
│   │       └── Auth/
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── layouts/
│   │   ├── assistance-requests/
│   │   ├── admin/
│   │   └── auth/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php                    # URL routes
└── config/                        # Configuration files
```

---

## 📋 Jenis Permohonan

Sistem BERKAT mendukung **5 jenis permohonan utama**:

### 1. **Pendidikan** (Education)
| Kategori | Sub-kategori |
|----------|-------------|
| Kemasukan Persekolahan | - |
| IPT (Institusi Pengajian Tinggi) | - |
| Kecemerlangan Peperiksaan | - |

### 2. **Kesihatan** (Health)
| Kategori | Sub-kategori |
|----------|-------------|
| Masuk Wad | - |
| Kesihatan Kronik | - |
| Alat Sokongan | - |
| Kecederaan | - |

### 3. **Kebajikan** (Welfare)
| Kategori | Sub-kategori |
|----------|-------------|
| Bencana Alam | - |
| Kematian | - |
| Kesusahan | - |
| Program OKU | - |

### 4. **Sosial** (Social)
| Kategori | Sub-kategori |
|----------|-------------|
| Perayaan | - |
| Pencapaian Antarabangsa | - |

### 5. **Keahlian** (Membership)
| Kategori | Sub-kategori |
|----------|-------------|
| Persaraan | - |
| Pertukaran | - |

---

## 🔄 Aliran Kerja

### Tahapan Permohonan

```
┌─────────────┐
│   DRAFT     │ ← Ahli menyimpan permohonan
└──────┬──────┘
       │
       ↓
┌─────────────┐
│  SUBMITTED  │ ← Ahli menghantar permohonan
└──────┬──────┘
       │
       ↓
┌─────────────────────┐
│  AGENT VERIFICATION │ ← Agen memverifikasi dokumen
└──────┬──────────────┘
       │
       ↓
┌──────────────────┐
│ JK RECOMMENDATION │ ← JK memberikan rekomendasi
└──────┬───────────┘
       │
       ↓
┌──────────────┐
│ ADMIN REVIEW │ ← Admin membuat keputusan
└──────┬───────┘
       │
       ├──→ APPROVED ✅
       │
       └──→ REJECTED ❌
```

### Status Permohonan

| Status | Label | Deskripsi |
|--------|-------|-----------|
| `draft` | Draf | Belum dihantar |
| `submitted` | Dihantar | Menunggu verifikasi agen |
| `in_process` | Dalam Proses | Sedang diproses |
| `approved` | Diluluskan | Bantuan diluluskan |
| `rejected` | Ditolak | Permohonan ditolak |

---

## 👥 Peranan Pengguna

### 1. **Ahli** (Member)
- Membuat permohonan baru
- Menyunting permohonan (status draf)
- Menghantar permohonan
- Melihat status permohonan
- Muatnaik dokumen sokongan
- Melihat butiran keputusan

**Kebenaran**: `['assistance-requests.create', 'assistance-requests.store']`

### 2. **Agen** (Agen BERKAT)
- Melihat semua permohonan
- Mengesahkan kelengkapan dokumen
- Memberikan nota pengesahan
- Melihat laporan

**Kebenaran**: `['assistance-requests.verify']`

### 3. **JK** (Jawatankuasa)
- Melihat semua permohonan (selepas pengesahan agen)
- Memberikan cadangan pemberian bantuan
- Menentukan jumlah bantuan yang dicadangkan
- Melihat laporan

**Kebenaran**: `['assistance-requests.recommend']`

### 4. **Pentadbir** (Admin)
- Akses penuh ke semua permohonan
- Membuat keputusan akhir (terima/tolak)
- Melihat papan pemuka analitik
- Menguruskan pengguna
- Melihat laporan menyeluruh
- Tetapan semula/sunting permohonan jika perlu

**Kebenaran**: `['assistance-requests.decide', 'admin.access']`

---

## 💾 Database Schema

### Tabel Utama

#### `users`
```sql
id, name, email, password, role (member|agent|jk|admin), created_at, updated_at
```

#### `agents`
```sql
id, user_id (unique, foreign key to users),
office_name, office_address, office_phone, office_email,
designation, description,
status (active|inactive|on_leave|suspended),
remarks, registered_by (admin user_id),
registered_at, verified_at, last_activity_at,
requests_verified_count, created_at, updated_at
```

**Penjelasan Jadual Agents:**
- Profil terperinci untuk pengguna dengan role 'agent'
- Satu pengguna boleh mempunyai satu profil agen (one-to-one relationship)
- `registered_by` mencatat admin yang mendaftarkan agen
- `status` mengawal aktiviti agen (active, inactive, on_leave, suspended)
- `requests_verified_count` melacak bilangan permohonan yang telah disahkan
- Memungkinkan manajemen independen dari data autentikasi pengguna

#### `assistance_requests`
```sql
id, user_id, request_type_id, request_category_id, request_subcategory_id,
purpose, applicant_name, applicant_ic, applicant_salary, applicant_position,
applicant_phone, applicant_email, applicant_bank_account,
household_income, dependents_count, disabled_dependents_count,
spouse_name, spouse_ic, spouse_salary, spouse_position,
status, agent_verification, approved_amount, rejection_reason,
approved_at, jk_recommendation, jk_recommendation_status,
submitted_at, agent_id (foreign key to agents), agent_filled, created_at, updated_at
```

#### `request_types`
```sql
id, name (Pendidikan, Kesihatan, Kebajikan, Sosial, Keahlian), created_at, updated_at
```

#### `request_categories`
```sql
id, request_type_id, name, created_at, updated_at
```

#### `request_subcategories`
```sql
id, request_category_id, name, created_at, updated_at
```

#### `assistance_request_documents`
```sql
id, assistance_request_id, file_name, file_path, file_type, file_size, created_at, updated_at
```

#### `request_details`
```sql
id, assistance_request_id, field_name, field_value, created_at, updated_at
```

### Relasi Model

```
User
  ├── hasMany AssistanceRequest (as requester)
  ├── hasOne Agent (as agent profile)
  ├── hasMany Agent (as registered_by - admin)
  └── role: member|agent|jk|admin

Agent
  ├── belongsTo User (user_id)
  ├── belongsTo User (registered_by - admin user)
  ├── hasMany AssistanceRequest (verified requests)
  └── status: active|inactive|on_leave|suspended

AssistanceRequest
  ├── belongsTo User (user_id)
  ├── belongsTo RequestType
  ├── belongsTo RequestCategory
  ├── belongsTo RequestSubcategory
  ├── belongsTo Agent (agent_id)
  ├── hasMany RequestDetail
  └── hasMany AssistanceRequestDocument

RequestType
  └── hasMany RequestCategory

RequestCategory
  └── hasMany RequestSubcategory
```

---

## 📖 Panduan Penggunaan

### Untuk Ahli

**1. Membuat Permohonan Baru**
```
1. Klik "Permohonan Baru" di halaman utama
2. Pilih Jenis Permohonan (Pendidikan, Kesihatan, dll)
3. Pilih Kategori → Sub-kategori
4. Isi tujuan permohonan dengan jelas
5. PILIH AGEN yang akan menyemak permohonan*
   - Agen ditampilkan dengan nama dan lokasi pejabat
   - Hanya agen aktif tersedia untuk dipilih
6. Isi maklumat peribadi & pemohon
7. Klik "Simpan sebagai Draf"
```
*Penting: Ahli WAJIB memilih agen pada saat membuat permohonan. Agen yang dipilih akan secara otomatis melihat permohonan anda untuk semakan.

**2. Menghantar Permohonan**
```
1. Buka permohonan (status: Draf)
2. Periksa semua maklumat dan agen yang dipilih
3. Muatnaik dokumen sokongan (jika perlu)
4. Klik "Hantar Permohonan"
5. Status berubah ke: Dihantar
6. Agen yang dipilih akan melihat permohonan dalam senarai mereka
```

**3. Memantau Status**
```
1. Buka "Senarai Permohonan"
2. Lihat status terkini:
   - Dihantar → Agen sedang memeriksa dokumen
   - Dalam Proses → JK membuat keputusan
   - Diluluskan/Ditolak → Keputusan akhir
3. Periksa nota dan maklum balas dari agen
```

### Untuk Agen

**1. Melihat Permohonan yang Ditugaskan**
```
1. Login dengan akaun agen
2. Klik "Senarai Permohonan"
3. Permohonan ditampilkan dalam kategori:
   a) Permohonan saya (yang saya cipta)
   b) Permohonan yang ditugaskan kepada saya
   c) Permohonan belum ditugaskan dengan status: Dihantar
```

**2. Mengesahkan Permohonan Ditugaskan**
```
1. Lihat "Senarai Permohonan" dengan status: Dihantar
2. Klik permohonan yang ditugaskan kepada saya
3. Periksa dokumen yang dimuatnaik
4. Periksa kelengkapan maklumat pemohon
5. Berikan nota pengesahan
6. Klik "Sahkan" (jika lengkap) atau "Tolak" (jika tidak lengkap)
```

**3. Menangani Permohonan Belum Ditugaskan**
```
Jika ada permohonan berStatus 'Dihantar' tetapi belum ditugaskan ke agen manapun:
1. Lihat dalam senarai permohonan
2. Anda boleh mengambil alih untuk menyemak
3. Sistem akan mencatat anda sebagai agen pengesah
```

### Untuk Pentadbir

**1. Melihat Papan Pemuka**
```
1. Login sebagai Pentadbir
2. Klik "Papan Pemuka Pentadbir"
3. Lihat statistik:
   - Jumlah permohonan
   - Diluluskan vs Ditolak
   - Permohonan dalam proses
   - Penapis berdasarkan tahun
```

**2. Membuat Keputusan Akhir**
```
1. Lihat permohonan dengan status: Dalam Proses
2. Baca pengesahan agen & cadangan JK
3. Tentukan: Luluskan atau Tolak
4. Jika luluskan: Masukkan jumlah bantuan akhir
5. Simpan keputusan
```

**3. Mengurusan Agen**
```
1. Klik "Pengurusan Agen" (Admin menu)
2. Lihat senarai semua agen dengan status
3. Untuk mendaftarkan agen baru:
   - Klik "Daftar Agen Baru"
   - Masukkan maklumat pengguna
   - Isi maklumat pejabat agen
   - Tentukan status (active/inactive/on_leave/suspended)
   - Simpan profil agen
4. Untuk mengemas kini status:
   - Klik agen dalam senarai
   - Ubah status agen
   - Simpan perubahan
5. Lihat statistik agen:
   - Bilangan permohonan disahkan
   - Aktiviti terakhir
   - Status pengesahan
```

### Pengurusan Agen

**Model Agent:**
- Setiap agen adalah pengguna sistem dengan role 'agent'
- Memiliki profil agen terpisah dengan maklumat pejabat
- Didaftarkan oleh Pentadbir
- Boleh dipantau status aktiviti dan pengesahan

**Status Agen:**
- `active` - Agen aktif dan boleh mengesahkan permohonan
- `inactive` - Agen tidak aktif
- `on_leave` - Agen sedang cuti
- `suspended` - Agen digantung sementara

---

## 🚀 Instalasi & Setup

### Langkah 1: Clone Repository
```bash
cd ~/berkat
git clone <repo-url> berkat-app
cd berkat-app
```

### Langkah 2: Install Dependencies
```bash
composer install
npm install
```

### Langkah 3: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Langkah 4: Database Setup
```bash
# Create database
php artisan migrate

# Seed sample data
php artisan db:seed
```

### Langkah 5: Build Assets
```bash
npm run build
# atau untuk development:
npm run dev
```

### Langkah 6: Start Server
```bash
php artisan serve
```

Server berjalan di: `http://localhost:8000`

### Default Credentials (Sample Data)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Agen | agent@example.com | password |
| JK | jk@example.com | password |
| Member | member@example.com | password |

---

## 🌐 API Routes

### Authentication
```
GET    /login                              → Show login form
POST   /login                              → Process login
POST   /logout                             → Process logout
```

### Assistance Requests (Member)
```
GET    /assistance-requests                → List all requests
GET    /assistance-requests/create         → Create form
POST   /assistance-requests                → Store new request
GET    /assistance-requests/{id}           → View details
GET    /assistance-requests/{id}/edit      → Edit form
PUT    /assistance-requests/{id}           → Update request
DELETE /assistance-requests/{id}           → Delete request
POST   /assistance-requests/{id}/submit    → Submit for processing
```

### Agent Verification
```
POST   /assistance-requests/{id}/agent-review        → Verify by agent
```

### JK Recommendation
```
POST   /assistance-requests/{id}/jk-recommendation   → JK recommendation
```

### Admin Decision
```
POST   /assistance-requests/{id}/admin-decision      → Admin final decision
```

### Documents
```
GET    /assistance-requests/{id}/documents/{doc}/download → Download file
```

### Dynamic Data
```
GET    /request-types/{id}/categories                → Get categories
GET    /request-categories/{id}/subcategories       → Get subcategories
```

### Admin
```
GET    /admin/dashboard                   → Admin dashboard
```

---

## 🔧 Troubleshooting

### Database Migration Error
```bash
# Reset database (caution: deletes all data)
php artisan migrate:fresh --seed
```

### File Upload Issues
```bash
# Create storage symlink
php artisan storage:link

# Check permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Cache Issues
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📞 Support

Untuk bantuan lebih lanjut:
- Hubungi: berkat@example.com
- Telepon: +60-3-XXXX-XXXX
- Website: https://berkat.example.com

---

## 📝 Catatan Pengembang

### Best Practices
- Selalu gunakan migrations untuk perubahan database
- Validasi input di controller dan request class
- Gunakan authorization policies untuk access control
- Dokumentasikan API endpoints yang baru

### Folder Structure
- `app/Models/` - Eloquent models
- `app/Http/Controllers/` - Request handlers
- `database/migrations/` - Schema definitions
- `resources/views/` - Blade templates
- `routes/web.php` - Route definitions

### Code Style
- PSR-12 untuk PHP
- camelCase untuk variabel & method
- snake_case untuk database columns

---

**Last Updated**: 17 April 2026  
**Version**: 1.0.0  
**Status**: Production Ready
