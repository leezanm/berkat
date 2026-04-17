<?php

namespace Database\Seeders;

use App\Models\RequestType;
use App\Models\RequestCategory;
use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pendidikan (Education)
        $pendidikan = RequestType::create(['name' => 'Pendidikan', 'description' => 'Permohonan berkaitan pendidikan']);
        RequestCategory::create(['request_type_id' => $pendidikan->id, 'name' => 'Kemasukan Persekolahan', 'description' => 'Bantuan untuk kemasukan sekolah'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Pelajaran', 'description' => 'Bantuan untuk persediaan masuk sekolah'],
                ['name' => 'Bantuan Buku dan Alatan Tulis', 'description' => 'Bantuan membeli buku dan alatan tulis'],
            ]);

        RequestCategory::create(['request_type_id' => $pendidikan->id, 'name' => 'Kemasukan IPT Kali Pertama', 'description' => 'Bantuan untuk kemasukan institusi pendidikan tinggi'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Yuran', 'description' => 'Bantuan membayar yuran IPT'],
                ['name' => 'Bantuan Akomodasi', 'description' => 'Bantuan untuk kos akomodasi'],
            ]);

        RequestCategory::create(['request_type_id' => $pendidikan->id, 'name' => 'Kecemerlangan Peperiksaan', 'description' => 'Bantuan untuk pencapaian cemerlang dalam peperiksaan'])
            ->subcategories()->createMany([
                ['name' => 'Ganjaran Pencapaian', 'description' => 'Ganjaran untuk pencapaian akademik cemerlang'],
            ]);

        // Kesihatan (Health)
        $kesihatan = RequestType::create(['name' => 'Kesihatan', 'description' => 'Permohonan berkaitan kesihatan']);
        RequestCategory::create(['request_type_id' => $kesihatan->id, 'name' => 'Masuk Wad', 'description' => 'Bantuan untuk perawatan di hospital'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Perubatan', 'description' => 'Bantuan untuk kos perubatan'],
                ['name' => 'Bantuan Perawatan', 'description' => 'Bantuan untuk kos perawatan'],
            ]);

        RequestCategory::create(['request_type_id' => $kesihatan->id, 'name' => 'Masalah Kesihatan Kronik', 'description' => 'Bantuan untuk penyakit kronik'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Ubatan', 'description' => 'Bantuan membeli ubatan'],
                ['name' => 'Bantuan Pemeriksaan Kesihatan', 'description' => 'Bantuan untuk pemeriksaan kesihatan berkala'],
            ]);

        RequestCategory::create(['request_type_id' => $kesihatan->id, 'name' => 'Bantuan Peralatan Sokongan', 'description' => 'Bantuan untuk alat pembantu kesihatan'])
            ->subcategories()->createMany([
                ['name' => 'Kursi Roda', 'description' => 'Bantuan membeli kursi roda'],
                ['name' => 'Alat Bantu Jalan', 'description' => 'Bantuan membeli alat bantu jalan'],
                ['name' => 'Alat Pendengaran', 'description' => 'Bantuan membeli alat pendengaran'],
            ]);

        RequestCategory::create(['request_type_id' => $kesihatan->id, 'name' => 'Kecederaan Parah', 'description' => 'Bantuan untuk kecederaan parah'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Perubatan Kecemasan', 'description' => 'Bantuan untuk rawatan kecemasan'],
                ['name' => 'Bantuan Pemulihan', 'description' => 'Bantuan untuk proses pemulihan'],
            ]);

        // Kebajikan (Welfare)
        $kebajikan = RequestType::create(['name' => 'Kebajikan', 'description' => 'Permohonan berkaitan kebajikan']);
        RequestCategory::create(['request_type_id' => $kebajikan->id, 'name' => 'Bencana Alam', 'description' => 'Bantuan untuk mangsa bencana alam'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Perumahan', 'description' => 'Bantuan untuk perumahan sementara'],
                ['name' => 'Bantuan Keperluan Asas', 'description' => 'Bantuan untuk keperluan asas'],
            ]);

        RequestCategory::create(['request_type_id' => $kebajikan->id, 'name' => 'Kematian Ahli/Keluarga', 'description' => 'Bantuan untuk kematian ahli atau keluarga ahli'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Pengebumian', 'description' => 'Bantuan untuk acara pengebumian'],
                ['name' => 'Bantuan Sokongan Keluarga', 'description' => 'Bantuan untuk sokongan keluarga yang ditinggalkan'],
            ]);

        RequestCategory::create(['request_type_id' => $kebajikan->id, 'name' => 'Bantuan Kesusahan', 'description' => 'Bantuan untuk ahli yang mengalami kesusahan'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Tunai', 'description' => 'Bantuan tunai segera'],
                ['name' => 'Bantuan Pembayaran Hutang', 'description' => 'Bantuan untuk membayar hutang yang membebani'],
            ]);

        RequestCategory::create(['request_type_id' => $kebajikan->id, 'name' => 'Kursus Pengurusan Anak OKU', 'description' => 'Bantuan kursus pengurusan anak cacat'])
            ->subcategories()->createMany([
                ['name' => 'Yuran Kursus', 'description' => 'Bantuan membayar yuran kursus'],
            ]);

        RequestCategory::create(['request_type_id' => $kebajikan->id, 'name' => 'Perkembangan/Peralatan Anak OKU', 'description' => 'Bantuan untuk perkembangan anak cacat'])
            ->subcategories()->createMany([
                ['name' => 'Peralatan Terapi', 'description' => 'Bantuan membeli peralatan terapi'],
                ['name' => 'Program Perkembangan', 'description' => 'Bantuan untuk program perkembangan khusus'],
            ]);

        // Sosial (Social)
        $sosial = RequestType::create(['name' => 'Sosial', 'description' => 'Permohonan berkaitan sosial']);
        RequestCategory::create(['request_type_id' => $sosial->id, 'name' => 'Perayaan Utama', 'description' => 'Bantuan untuk perayaan utama'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Hari Raya', 'description' => 'Bantuan untuk perayaan Hari Raya'],
                ['name' => 'Bantuan Tahun Baru', 'description' => 'Bantuan untuk perayaan Tahun Baru'],
            ]);

        RequestCategory::create(['request_type_id' => $sosial->id, 'name' => 'Kecemerlangan Sosial Peringkat Antarabangsa', 'description' => 'Bantuan untuk pencapaian sosial antarabangsa'])
            ->subcategories()->createMany([
                ['name' => 'Ganjaran Pencapaian', 'description' => 'Ganjaran untuk pencapaian sosial'],
            ]);

        // Keahlian (Membership)
        $keahlian = RequestType::create(['name' => 'Keahlian', 'description' => 'Permohonan berkaitan keahlian']);
        RequestCategory::create(['request_type_id' => $keahlian->id, 'name' => 'Persaraan', 'description' => 'Bantuan untuk persaraan anggota'])
            ->subcategories()->createMany([
                ['name' => 'Hadiah Persaraan', 'description' => 'Hadiah untuk persaraan'],
            ]);

        RequestCategory::create(['request_type_id' => $keahlian->id, 'name' => 'Pertukaran', 'description' => 'Bantuan untuk pertukaran anggota'])
            ->subcategories()->createMany([
                ['name' => 'Bantuan Pertukaran', 'description' => 'Bantuan untuk proses pertukaran'],
            ]);
    }
}
