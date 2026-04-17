# 🔌 Dokumentasi API - Sistem BERKAT

## Titik Hujung Pengesahan

### Masuk (Login)
**POST** `/login`

Melakukan pengesahan pengguna.

**Permintaan**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Respons** (Berjaya)
```json
{
  "message": "Pengesahan berjaya",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "role": "member"
  }
}
```

---

### Keluar (Logout)
**POST** `/logout`

Melakukan keluar dari sistem.

**Pengepala (Headers)**
```
Authorization: Bearer {token}
```

**Respons**
```json
{
  "message": "Keluar berjaya"
}
```

---

## Titik Hujung Permohonan Bantuan

### Dapatkan Semua Permohonan
**GET** `/assistance-requests`

Mengambil senarai semua permohonan milik pengguna atau semua (jika pentadbir/agen).

**Parameter Pertanyaan (Query)**
- `page` - Nombor halaman (default: 1)
- `per_page` - Item per halaman (default: 10)
- `status` - Penapis status (draft, submitted, in_process, approved, rejected)
- `year` - Penapis tahun

**Respons**
```json
{
  "data": [
    {
      "id": 1,
      "reference_number": "#00001",
      "user_id": 1,
      "request_type": "Pendidikan",
      "category": "Kemasukan Persekolahan",
      "status": "submitted",
      "submitted_at": "2026-04-17 10:30:00",
      "approved_amount": null,
      "created_at": "2026-04-16 14:20:00",
      "updated_at": "2026-04-17 10:30:00"
    }
  ],
  "pagination": {
    "total": 15,
    "per_page": 10,
    "current_page": 1,
    "last_page": 2
  }
}
```

---

### Dapatkan Butiran Permohonan
**GET** `/assistance-requests/{id}`

Mengambil butiran lengkap satu permohonan.

**Parameter Jalan (Path)**
- `id` - ID permohonan

**Respons**
```json
{
  "id": 1,
  "reference_number": "#00001",
  "user": {
    "id": 1,
    "name": "Ahmad Bin Mohamed",
    "email": "ahmad@example.com"
  },
  "request_type": {
    "id": 1,
    "name": "Pendidikan"
  },
  "category": {
    "id": 1,
    "name": "Kemasukan Persekolahan"
  },
  "subcategory": {
    "id": 1,
    "name": "-"
  },
  "purpose": "Memohon bantuan untuk pembiayaan sekolah anak...",
  "applicant": {
    "name": "Ahmad Bin Mohamed",
    "ic": "123456789012",
    "salary": 3500.00,
    "position": "Penyelia",
    "phone": "0123456789",
    "email": "ahmad@example.com",
    "bank_account": "1234567890123456",
    "office_address": "Jalan Merdeka, Kuala Lumpur"
  },
  "spouse": {
    "name": "Siti Nurhaliza",
    "ic": "987654321098",
    "salary": 2800.00,
    "position": "Kerani"
  },
  "household": {
    "income": 6300.00,
    "dependents": 3,
    "disabled_dependents": 0
  },
  "status": "submitted",
  "agent_verification": null,
  "approved_amount": null,
  "rejection_reason": null,
  "approved_at": null,
  "jk_recommendation": null,
  "jk_recommendation_status": null,
  "submitted_at": "2026-04-17 10:30:00",
  "agent": null,
  "documents": [
    {
      "id": 1,
      "file_name": "Salinan KP.pdf",
      "file_path": "/storage/documents/ic-copy.pdf",
      "file_type": "application/pdf",
      "file_size": 245000,
      "uploaded_at": "2026-04-17 10:30:00"
    }
  ],
  "details": []
}
```

---

### Create Request
**GET** `/assistance-requests/create`

Menampilkan form pembuatan permohonan baru.

**Response**: HTML Form

---

### Store New Request
**POST** `/assistance-requests`

Menyimpan permohonan baru.

**Request Body**
```json
{
  "request_type_id": 1,
  "request_category_id": 1,
  "request_subcategory_id": 1,
  "purpose": "Memohon bantuan untuk pembiayaan pendidikan anak",
  "applicant_name": "Ahmad Bin Mohamed",
  "applicant_ic": "123456789012",
  "applicant_salary": 3500.00,
  "applicant_position": "Supervisor",
  "applicant_office_address": "Jalan Merdeka, Kuala Lumpur",
  "applicant_accounting_office": "Pusat Pentadbiran",
  "applicant_phone": "0123456789",
  "applicant_email": "ahmad@example.com",
  "applicant_bank_account": "1234567890123456",
  "household_income": 6300.00,
  "dependents_count": 3,
  "disabled_dependents_count": 0,
  "spouse_name": "Siti Nurhaliza",
  "spouse_ic": "987654321098",
  "spouse_salary": 2800.00,
  "spouse_position": "Clerk"
}
```

**Response** (Success - 201)
```json
{
  "message": "Permohonan disimpan sebagai draf",
  "request_id": 1,
  "status": "draft"
}
```

---

### Update Request
**PUT** `/assistance-requests/{id}`

Memperbarui permohonan yang masih berstatus draft.

**Path Parameters**
- `id` - ID permohonan

**Request Body**: Sama seperti Store

**Response**
```json
{
  "message": "Permohonan diperbarui",
  "request_id": 1
}
```

---

### Delete Request
**DELETE** `/assistance-requests/{id}`

Menghapus permohonan (hanya berstatus draft).

**Path Parameters**
- `id` - ID permohonan

**Response**
```json
{
  "message": "Permohonan dihapus"
}
```

---

### Submit Request
**POST** `/assistance-requests/{id}/submit`

Menghantar permohonan untuk diproses.

**Path Parameters**
- `id` - ID permohonan

**Request Body**
```json
{
  "documents": [
    {
      "file_name": "ic-copy.pdf",
      "file_path": "/path/to/file"
    }
  ]
}
```

**Response**
```json
{
  "message": "Permohonan telah dihantar untuk diproses",
  "request_id": 1,
  "status": "submitted",
  "submitted_at": "2026-04-17 10:35:00"
}
```

---

## Agent Verification Endpoints

### Agent Review
**POST** `/assistance-requests/{id}/agent-review`

Agen melakukan verifikasi kelengkapan dokumen.

**Requires**: User role = 'agent'

**Request Body**
```json
{
  "agent_verification": "verified",
  "notes": "Semua dokumen lengkap dan jelas",
  "approved_amount": 1500.00
}
```

**Response**
```json
{
  "message": "Verifikasi agen selesai",
  "request_id": 1,
  "agent_verification": "verified",
  "status": "in_process"
}
```

---

## JK (Committee) Endpoints

### JK Recommendation
**POST** `/assistance-requests/{id}/jk-recommendation`

Jawatankuasa memberikan rekomendasi pemberian bantuan.

**Requires**: User role = 'jk'

**Request Body**
```json
{
  "jk_recommendation": "approved",
  "jk_recommendation_status": "eligible_for_assistance",
  "recommended_amount": 1500.00,
  "notes": "Anggota layak menerima bantuan berdasarkan kriteria"
}
```

**Response**
```json
{
  "message": "Rekomendasi JK disimpan",
  "request_id": 1,
  "jk_recommendation": "approved",
  "recommended_amount": 1500.00
}
```

---

## Admin Decision Endpoints

### Admin Decision
**POST** `/assistance-requests/{id}/admin-decision`

Admin membuat keputusan final (setujui/tolak).

**Requires**: User role = 'admin'

**Request Body**
```json
{
  "status": "approved",
  "approved_amount": 1500.00,
  "rejection_reason": null
}
```

Atau untuk penolakan:
```json
{
  "status": "rejected",
  "approved_amount": null,
  "rejection_reason": "Tidak memenuhi kriteria bantuan"
}
```

**Response** (Approved)
```json
{
  "message": "Keputusan disimpan - Permohonan diluluskan",
  "request_id": 1,
  "status": "approved",
  "approved_amount": 1500.00,
  "approved_at": "2026-04-17 11:00:00"
}
```

**Response** (Rejected)
```json
{
  "message": "Keputusan disimpan - Permohonan ditolak",
  "request_id": 1,
  "status": "rejected",
  "rejection_reason": "Tidak memenuhi kriteria bantuan"
}
```

---

## Document Endpoints

### Download Document
**GET** `/assistance-requests/{id}/documents/{document}/download`

Mengunduh dokumen yang telah diupload.

**Path Parameters**
- `id` - ID permohonan
- `document` - ID dokumen

**Response**: Binary file stream (PDF/Image)

---

### Upload Document
**POST** `/assistance-requests/{id}/documents`

Upload dokumen pendukung (via form submission).

**Form Data**
```
document: <file>
```

**Supported Files**: PDF, JPG, JPEG, PNG (max 5MB)

**Response**
```json
{
  "message": "Dokumen berhasil diupload",
  "document": {
    "id": 1,
    "file_name": "ic-copy.pdf",
    "file_size": 245000,
    "uploaded_at": "2026-04-17 10:35:00"
  }
}
```

---

## Dynamic Data Endpoints

### Get Categories by Request Type
**GET** `/request-types/{id}/categories`

Mengambil kategori berdasarkan jenis permohonan.

**Path Parameters**
- `id` - ID request type

**Response**
```json
[
  {
    "id": 1,
    "name": "Kemasukan Persekolahan",
    "request_type_id": 1
  },
  {
    "id": 2,
    "name": "IPT",
    "request_type_id": 1
  }
]
```

---

### Get Subcategories by Category
**GET** `/request-categories/{id}/subcategories`

Mengambil sub-kategori berdasarkan kategori.

**Path Parameters**
- `id` - ID request category

**Response**
```json
[
  {
    "id": 1,
    "name": "-",
    "request_category_id": 1
  }
]
```

---

## Admin Dashboard Endpoints

### Admin Dashboard
**GET** `/admin/dashboard`

Mengambil data dashboard admin.

**Requires**: User role = 'admin'

**Query Parameters**
- `year` - Filter berdasarkan tahun (optional)

**Response**
```json
{
  "total_requests": 15,
  "approved_count": 8,
  "in_process_count": 4,
  "rejected_count": 2,
  "draft_count": 1,
  "total_approved_amount": 12000.00,
  "selected_year": 2026,
  "available_years": [2024, 2025, 2026],
  "monthly_stats": [
    {
      "month": "January",
      "count": 5,
      "approved": 3
    }
  ]
}
```

---

## Error Responses

### 400 Bad Request
```json
{
  "message": "Validasi gagal",
  "errors": {
    "applicant_name": ["Nama harus diisi"],
    "applicant_ic": ["IC tidak valid"]
  }
}
```

### 401 Unauthorized
```json
{
  "message": "Silakan login terlebih dahulu"
}
```

### 403 Forbidden
```json
{
  "message": "Anda tidak memiliki akses ke resource ini"
}
```

### 404 Not Found
```json
{
  "message": "Permohonan tidak ditemukan"
}
```

### 500 Internal Server Error
```json
{
  "message": "Terjadi kesalahan pada server",
  "error": "Error details..."
}
```

---

## Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Data tidak valid |
| 401 | Unauthorized - Belum login |
| 403 | Forbidden - Tidak punya akses |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validasi error |
| 500 | Server Error - Kesalahan server |

---

## Rate Limiting

- **Default**: 60 requests per minute
- **Authenticated**: 120 requests per minute

---

## Best Practices

1. **Selalu check status code** response
2. **Gunakan headers yang sesuai**:
   - `Content-Type: application/json`
   - `Accept: application/json`
3. **Handle error responses** dengan graceful
4. **Validasi input** sebelum submit
5. **Gunakan pagination** untuk list endpoints

---

**API Version**: v1.0  
**Last Updated**: 17 April 2026  
**Base URL**: `http://localhost:8000`
