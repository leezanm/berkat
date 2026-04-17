# ⚡ Panduan Permulaan Pantas - Sistem BERKAT

Panduan cepat untuk memulai dengan sistem BERKAT dalam 5 minit!

---

## 🎯 Prasyarat

Pastikan Anda sudah memasang:
- ✅ PHP 8.1+
- ✅ Composer
- ✅ Node.js & npm
- ✅ Git

Pengesahan:
```bash
php --version     # PHP 8.1+
composer --version
node --version    # v18+
npm --version
```

---

## 🚀 Persediaan Pantas (5 Minit)

### 1️⃣ Klon & Persediaan (1 minit)
```bash
cd ~/berkat
git clone <repo-url> berkat-app
cd berkat-app
```

### 2️⃣ Pasang Kebergantungan (2 minit)
```bash
composer install
npm install
```

### 3️⃣ Persediaan Persekitaran (30 saat)
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Persediaan Pangkalan Data (1 minit)
```bash
# Cipta & migrasi pangkalan data dengan data sampel
php artisan migrate:fresh --seed
```

### 5️⃣ Jalankan Aplikasi (30 saat)
```bash
# Terminal 1: Mulakan pelayan Laravel
php artisan serve

# Terminal 2: Bina aset (jika membangun)
npm run dev
```

✅ **Buka**: http://localhost:8000

---

## 🔐 Kelayakan Masuk

Gunakan akaun berikut untuk ujian:

### Papan Pemuka Pentadbir
- **E-mel**: admin@example.com
- **Kata Laluan**: password
- **Peranan**: admin
- **Akses**: Papan Pemuka, semua ciri

### Agen Pengesahan
- **E-mel**: agent@example.com
- **Kata Laluan**: password
- **Peranan**: agent
- **Akses**: Pengesahan dokumen

### Jawatankuasa (JK)
- **E-mel**: jk@example.com
- **Kata Laluan**: password
- **Peranan**: jk
- **Akses**: Cadangan bantuan

### Ahli
- **E-mel**: member@example.com
- **Kata Laluan**: password
- **Peranan**: member
- **Akses**: Buat & uruskan permohonan

---

## 📋 Ujian Sistem

### Senario Ujian 1: Cipta & Hantar Permohonan (Ahli)

**Masuk sebagai member@example.com**

1. **Buat Permohonan**
   - Klik "Permohonan Baru"
   - Pilih Jenis: `Pendidikan`
   - Pilih Kategori: `Kemasukan Persekolahan`
   - Isi form dengan data dummy
   - Klik "Simpan sebagai Draf"

2. **Upload Dokumen**
   - Buka permohonan yang baru dibuat
   - Klik "Upload Dokumen"
   - Upload file (PDF/Image)

3. **Hantar Permohonan**
   - Klik "Hantar Permohonan"
   - Status berubah ke: `Dihantar`

---

### Test Scenario 2: Agent Verification

**Login sebagai agent@example.com**

1. **Lihat Daftar Permohonan**
   - Klik "Senarai Permohonan"
   - Filter status: `Dihantar`

2. **Verifikasi Dokumen**
   - Klik permohonan untuk detail
   - Review dokumen yang diupload
   - Berikan catatan verifikasi
   - Klik "Sahkan Permohonan"

---

### Test Scenario 3: Admin Decision

**Login sebagai admin@example.com**

1. **Dashboard Overview**
   - Lihat statistik permohonan
   - Filter berdasarkan tahun

2. **Buat Keputusan**
   - Buka permohonan status: `Dalam Proses`
   - Review semua informasi
   - Tentukan: Luluskan atau Tolak
   - Jika luluskan: Masukkan jumlah bantuan
   - Klik "Simpan Keputusan"

---

## 🛠️ Common Commands

```bash
# Migrate database
php artisan migrate

# Reset database & seed
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Generate model + migration + factory
php artisan make:model ModelName -mf

# Create controller
php artisan make:controller ControllerName

# Serve application
php artisan serve --port=8000

# Build assets for production
npm run build

# Watch assets for development
npm run dev

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Create storage symlink
php artisan storage:link
```

---

## 📁 Project Structure Quick Reference

```
berkat-app/
├── app/
│   ├── Models/                    ← Database models
│   ├── Http/Controllers/          ← Business logic
│   └── Providers/
├── database/
│   ├── migrations/                ← Database schema
│   └── seeders/                   ← Sample data
├── resources/
│   ├── views/                     ← Blade templates
│   ├── css/
│   └── js/
├── routes/
│   └── web.php                    ← URL routes
└── config/                        ← Configuration
```

---

## 🐛 Troubleshooting

### Issue: "SQLSTATE[HY000]: General error: 1 database is locked"

**Solution**:
```bash
# Delete old database file
rm database/database.sqlite

# Migrate fresh
php artisan migrate:fresh --seed
```

### Issue: "No Application Encryption Key has been specified"

**Solution**:
```bash
php artisan key:generate
```

### Issue: Cannot access `/storage/` directory

**Solution**:
```bash
php artisan storage:link
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Issue: 404 on styling/JS

**Solution**:
```bash
npm run build
# atau untuk dev:
npm run dev
```

### Issue: "Class not found" error

**Solution**:
```bash
composer dump-autoload
```

---

## 📊 Sample Data Overview

Setelah `migrate:fresh --seed`, sistem akan terisi dengan:

| Item | Jumlah |
|------|--------|
| Users | 4 (1 admin, 1 agen, 1 JK, 1 member) |
| Request Types | 5 |
| Assistance Requests | 15 (sample) |
| Documents | ~20 (sample) |

---

## 🔄 Development Workflow

### 1. **Create Feature Branch**
```bash
git checkout -b feature/my-feature
```

### 2. **Make Changes**
- Edit models, controllers, views
- Update database via migrations
- Test locally

### 3. **Commit Changes**
```bash
git add .
git commit -m "feat: add new feature"
```

### 4. **Push & Create PR**
```bash
git push origin feature/my-feature
```

---

## 📚 Next Steps

Setelah setup berhasil:

1. **Baca dokumentasi lengkap**: [DOKUMENTASI.md](DOKUMENTASI.md)
2. **Pelajari API**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
3. **Explore database schema**: `database/migrations/`
4. **Check routes**: `routes/web.php`
5. **Review models**: `app/Models/`

---

## 🎨 Customization Tips

### Change Primary Color
Edit: `resources/views/layouts/app.blade.php`
```css
:root {
  --primary-color: #FF5722; /* Change this */
  ...
}
```

### Add New Request Type
1. Create migration:
```bash
php artisan make:migration add_new_request_type
```

2. Add in seeder or manual:
```php
RequestType::create(['name' => 'New Type']);
```

### Customize Email Templates
1. Create in: `resources/views/emails/`
2. Use in controller:
```php
Mail::send('emails.template', $data, function($m) { ... });
```

---

## 🚨 Security Notes

### Before Production:

1. **Change APP_KEY**
```bash
php artisan key:generate
```

2. **Set .env correctly**
```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql  # Use MySQL
```

3. **Enable HTTPS**
```
FORCE_HTTPS=true
```

4. **Hash Passwords**
All passwords are hashed using bcrypt by default ✅

5. **CORS Setup** (if needed)
Edit: `config/cors.php`

6. **Environment Variables**
Never commit `.env` file to git (already in .gitignore) ✅

---

## 💡 Pro Tips

1. **Use Tinker for testing**
```bash
php artisan tinker
>>> User::count()
>>> AssistanceRequest::with('user', 'requestType')->first()
```

2. **Monitor logs**
```bash
tail -f storage/logs/laravel.log
```

3. **Database debugging**
```bash
php artisan tinker
>>> DB::enableQueryLog()
>>> User::all()
>>> dd(DB::getQueryLog())
```

4. **Asset debugging**
If styles not loading:
```bash
npm run dev  # Watch for changes
# Vs
npm run build  # Build once for prod
```

---

## 📞 Getting Help

- **Laravel Docs**: https://laravel.com/docs/11
- **Laravel Discord**: https://discord.gg/laravel
- **Local Issues**: Check `storage/logs/laravel.log`

---

## ✅ Checklist - First Time Setup

- [ ] PHP 8.1+ installed
- [ ] Composer installed
- [ ] Node.js & npm installed
- [ ] Git cloned successfully
- [ ] `composer install` completed
- [ ] `npm install` completed
- [ ] `.env` file created
- [ ] `php artisan key:generate` done
- [ ] `php artisan migrate:fresh --seed` done
- [ ] `php artisan serve` running
- [ ] Website accessible at http://localhost:8000
- [ ] Can login with sample credentials
- [ ] Can create & submit a request

---

**Ready to code?** 🚀

Start with creating your first feature branch:
```bash
git checkout -b feature/first-feature
```

Happy coding! 💻

---

**Version**: 1.0  
**Last Updated**: 17 April 2026
