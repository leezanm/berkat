<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: linear-gradient(135deg, #e84e0f, #c43c00); padding: 28px 32px; }
        .header h1 { color: #fff; margin: 0; font-size: 1.4rem; }
        .header p { color: rgba(255,255,255,.8); margin: 4px 0 0; font-size: 0.9rem; }
        .body { padding: 28px 32px; }
        .body p { color: #444; line-height: 1.6; margin-bottom: 12px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        .info-table td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; color: #444; }
        .info-table td:first-child { font-weight: 600; color: #222; width: 40%; background: #fafafa; }
        .btn { display: inline-block; margin-top: 16px; padding: 12px 28px; background: #e84e0f; color: #fff !important; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; }
        .footer { background: #f5f5f5; padding: 16px 32px; text-align: center; font-size: 0.8rem; color: #999; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🔔 Permohonan Baru Memerlukan Semakan</h1>
        <p>Sistem Pengurusan Permohonan Bantuan BERKAT</p>
    </div>
    <div class="body">
        <p>Salam hormat,</p>
        <p>Satu permohonan bantuan baru telah dihantar dan memerlukan semakan anda. Sila semak butiran permohonan di bawah:</p>

        <table class="info-table">
            <tr>
                <td>No. Rujukan</td>
                <td><strong>#{{ str_pad($assistanceRequest->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
            </tr>
            <tr>
                <td>Nama Pemohon</td>
                <td>{{ $assistanceRequest->applicant_name }}</td>
            </tr>
            <tr>
                <td>Jenis Bantuan</td>
                <td>{{ $assistanceRequest->requestType->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>{{ $assistanceRequest->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tujuan Permohonan</td>
                <td>{{ Str::limit($assistanceRequest->purpose, 100) }}</td>
            </tr>
            <tr>
                <td>Tarikh Dihantar</td>
                <td>{{ $assistanceRequest->submitted_at ? $assistanceRequest->submitted_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <p>Sila log masuk ke sistem BERKAT untuk menyemak dan mengesahkan permohonan ini.</p>

        <a href="{{ url('/assistance-requests/' . $assistanceRequest->id) }}" class="btn">
            Semak Permohonan
        </a>

        <p style="margin-top: 24px; font-size: 0.85rem; color: #888;">
            Emel ini dihantar secara automatik oleh sistem BERKAT. Sila jangan balas emel ini.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Sistem BERKAT – Pengurusan Permohonan Bantuan
    </div>
</div>
</body>
</html>
