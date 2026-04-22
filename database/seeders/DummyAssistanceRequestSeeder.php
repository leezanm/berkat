<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\AssistanceRequest;
use App\Models\AssistanceRequestDocument;
use App\Models\RequestType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DummyAssistanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (AssistanceRequest::exists()) {
            return;
        }

        // Buat lebih banyak test members
        $members = [];
        $memberNames = [
            'Member Test',
            'Nurul Aina',
            'Faris Hakim',
            'Siti Mariam',
            'Ahmad Hassan',
            'Rohana Abdullah',
            'Ibrahim Khalid',
            'Nur Aziz',
            'Zainab Ibrahim',
            'Mohd Rafi',
            'Leila Mustafa',
            'Ali Baharim',
        ];

        foreach ($memberNames as $index => $name) {
            $email = 'member' . ($index + 1) . '@test.com';
            $members[] = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => bcrypt('password'), 'role' => 'member']
            );
        }

        $memberOne = $members[0];
        $memberTwo = $members[1];
        $memberThree = $members[2];

        // Dapatkan Agents dari table agents, bukan users
        $agent = Agent::first();
        $agent2 = Agent::skip(1)->first();

        // Jika tiada agents, return untuk mengelakkan error
        if (!$agent || !$agent2) {
            return;
        }

        $typeMap = RequestType::with('categories.subcategories')->get()->keyBy('name');

        $records = [
            // Draft requests
            [
                'user' => $members[0],
                'type' => 'Pendidikan',
                'category' => 'Kemasukan Persekolahan',
                'subcategory' => 'Bantuan Pelajaran',
                'purpose' => 'Bantuan persediaan sesi persekolahan anak untuk tahun baharu.',
                'status' => 'draft',
                'submitted_at' => null,
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[6],
                'type' => 'Kesihatan',
                'category' => 'Bantuan Peralatan Sokongan',
                'subcategory' => 'Kursi Roda',
                'purpose' => 'Permohonan bantuan membeli kursi roda untuk kegunaan ahli yang memerlukan.',
                'status' => 'draft',
                'submitted_at' => null,
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            // Submitted requests
            [
                'user' => $members[0],
                'type' => 'Kesihatan',
                'category' => 'Masuk Wad',
                'subcategory' => 'Bantuan Perubatan',
                'purpose' => 'Permohonan bantuan kos rawatan dan ubat selepas dimasukkan ke wad.',
                'status' => 'submitted',
                'submitted_at' => Carbon::now()->subDays(2),
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[1],
                'type' => 'Kebajikan',
                'category' => 'Kematian Ahli/Keluarga',
                'subcategory' => 'Bantuan Pengebumian',
                'purpose' => 'Permohonan bantuan pengebumian kerana kematian ibu kandung ahli.',
                'status' => 'submitted',
                'submitted_at' => Carbon::now()->subDays(1),
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[4],
                'type' => 'Kesihatan',
                'category' => 'Masalah Kesihatan Kronik',
                'subcategory' => 'Bantuan Ubatan',
                'purpose' => 'Permohonan bantuan pembelian ubat berkala untuk rawatan kronik.',
                'status' => 'submitted',
                'submitted_at' => Carbon::now()->subDay(),
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[7],
                'type' => 'Pendidikan',
                'category' => 'Kemasukan Persekolahan',
                'subcategory' => 'Bantuan Buku dan Alatan Tulis',
                'purpose' => 'Bantuan untuk membeli buku dan alatan tulis untuk anak dalam tahun akademik baru.',
                'status' => 'submitted',
                'submitted_at' => Carbon::now()->subDays(3),
                'agent_verification' => 'pending',
                'agent_id' => null,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            // In process requests
            [
                'user' => $members[1],
                'type' => 'Kebajikan',
                'category' => 'Bencana Alam',
                'subcategory' => 'Bantuan Keperluan Asas',
                'purpose' => 'Memohon bantuan keperluan asas selepas rumah dinaiki air.',
                'status' => 'in_process',
                'submitted_at' => Carbon::now()->subDays(6),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => 'recommended',
                'jk_recommendation' => 'JK menyokong bantuan penuh kerana situasi mendesak dan dokumen lengkap.',
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[2],
                'type' => 'Pendidikan',
                'category' => 'Kemasukan IPT Kali Pertama',
                'subcategory' => 'Bantuan Yuran',
                'purpose' => 'Memohon bantuan yuran pendaftaran universiti untuk anak.',
                'status' => 'in_process',
                'submitted_at' => Carbon::now()->subDays(4),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => null,
                'jk_recommendation' => null,
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            [
                'user' => $members[5],
                'type' => 'Kebajikan',
                'category' => 'Perkembangan/Peralatan Anak OKU',
                'subcategory' => 'Peralatan Terapi',
                'purpose' => 'Permohonan bantuan membeli peralatan terapi untuk anak berkeahlian khusus.',
                'status' => 'in_process',
                'submitted_at' => Carbon::now()->subDays(5),
                'agent_verification' => 'verified',
                'agent_id' => $agent2->id,
                'jk_recommendation_status' => 'recommended_with_conditions',
                'jk_recommendation' => 'JK menyokong dengan syarat keluarga bertemu dengan perunding sokongan bulanan.',
                'approved_amount' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ],
            // Approved requests
            [
                'user' => $members[2],
                'type' => 'Kebajikan',
                'category' => 'Bantuan Kesusahan',
                'subcategory' => 'Bantuan Tunai',
                'purpose' => 'Bantuan tunai segera untuk meringankan beban kewangan keluarga.',
                'status' => 'approved',
                'submitted_at' => Carbon::now()->subDays(10),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => 'recommended_with_conditions',
                'jk_recommendation' => 'JK menyokong bersyarat dengan semakan semula selepas tiga bulan.',
                'approved_amount' => 1200.00,
                'approved_at' => Carbon::now()->subDays(3),
                'rejection_reason' => null,
            ],
            [
                'user' => $members[1],
                'type' => 'Keahlian',
                'category' => 'Persaraan',
                'subcategory' => 'Hadiah Persaraan',
                'purpose' => 'Permohonan bantuan berkaitan persaraan ahli yang akan tamat perkhidmatan.',
                'status' => 'approved',
                'submitted_at' => Carbon::now()->subDays(14),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => 'recommended',
                'jk_recommendation' => 'JK menyokong hadiah persaraan berdasarkan tempoh perkhidmatan yang panjang.',
                'approved_amount' => 800.00,
                'approved_at' => Carbon::now()->subDays(7),
                'rejection_reason' => null,
            ],
            [
                'user' => $members[3],
                'type' => 'Sosial',
                'category' => 'Perayaan Utama',
                'subcategory' => 'Bantuan Tahun Baru',
                'purpose' => 'Permohonan bantuan untuk perayaan Tahun Baru keluarga.',
                'status' => 'approved',
                'submitted_at' => Carbon::now()->subDays(20),
                'agent_verification' => 'verified',
                'agent_id' => $agent2->id,
                'jk_recommendation_status' => 'recommended',
                'jk_recommendation' => 'JK menyokong permohonan ini sebagai bantuan sosial kepada ahli.',
                'approved_amount' => 500.00,
                'approved_at' => Carbon::now()->subDays(12),
                'rejection_reason' => null,
            ],
            [
                'user' => $members[8],
                'type' => 'Kesihatan',
                'category' => 'Kecederaan Parah',
                'subcategory' => 'Bantuan Perubatan Kecemasan',
                'purpose' => 'Bantuan kecemasan untuk kos rawatan akibat kemalangan jalan raya.',
                'status' => 'approved',
                'submitted_at' => Carbon::now()->subDays(25),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => 'recommended',
                'jk_recommendation' => 'JK menyokong penuh kerana situasi darurat yang mendesak.',
                'approved_amount' => 3500.00,
                'approved_at' => Carbon::now()->subDays(18),
                'rejection_reason' => null,
            ],
            // Rejected requests
            [
                'user' => $members[1],
                'type' => 'Sosial',
                'category' => 'Perayaan Utama',
                'subcategory' => 'Bantuan Hari Raya',
                'purpose' => 'Permohonan bantuan perayaan untuk persediaan keluarga.',
                'status' => 'rejected',
                'submitted_at' => Carbon::now()->subDays(9),
                'agent_verification' => 'verified',
                'agent_id' => $agent->id,
                'jk_recommendation_status' => 'not_recommended',
                'jk_recommendation' => 'JK tidak menyokong kerana permohonan melebihi syarat kelayakan semasa.',
                'approved_amount' => null,
                'approved_at' => Carbon::now()->subDays(4),
                'rejection_reason' => 'Permohonan tidak memenuhi garis panduan bantuan semasa.',
            ],
            [
                'user' => $members[9],
                'type' => 'Kebajikan',
                'category' => 'Bantuan Kesusahan',
                'subcategory' => 'Bantuan Pembayaran Hutang',
                'purpose' => 'Permohonan bantuan pembayaran hutang yang membebani.',
                'status' => 'rejected',
                'submitted_at' => Carbon::now()->subDays(11),
                'agent_verification' => 'verified',
                'agent_id' => $agent2->id,
                'jk_recommendation_status' => 'not_recommended',
                'jk_recommendation' => 'JK tidak merekomendasikan kerana pendapatan keluarga melebihi had yang ditetapkan.',
                'approved_amount' => null,
                'approved_at' => Carbon::now()->subDays(6),
                'rejection_reason' => 'Tidak memenuhi kriteria pendapatan untuk kategori bantuan ini.',
            ],
        ];

        foreach ($records as $index => $record) {
            $type = $typeMap[$record['type']];
            $category = $type->categories->firstWhere('name', $record['category']);
            $subcategory = $category->subcategories->firstWhere('name', $record['subcategory']);

            $assistance = AssistanceRequest::create([
                'user_id' => $record['user']->id,
                'request_type_id' => $type->id,
                'request_category_id' => $category->id,
                'request_subcategory_id' => $subcategory->id,
                'purpose' => $record['purpose'],
                'applicant_name' => $record['user']->name,
                'applicant_ic' => '88010' . str_pad((string) ($index + 1), 7, '0', STR_PAD_LEFT),
                'applicant_salary' => 3800 + ($index * 220),
                'applicant_position' => 'Pegawai Sokongan Gred N' . (20 + ($index % 5)),
                'applicant_office_address' => 'Pejabat BERKAT Cawangan ' . (($index % 3) + 1) . ', Selangor',
                'applicant_accounting_office' => 'Pejabat Akaun Negeri Selangor',
                'applicant_phone' => '0' . (12 + ($index % 2)) . '234567' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'applicant_email' => $record['user']->email,
                'applicant_bank_account' => 'Maybank 1144' . str_pad((string) ($index + 11), 4, '0', STR_PAD_LEFT),
                'household_income' => 6500 + ($index * 350),
                'dependents_count' => ($index % 4) + 1,
                'disabled_dependents_count' => $index % 3,
                'spouse_name' => $index % 2 === 0 ? 'Pasangan ' . $record['user']->name : null,
                'spouse_ic' => $index % 2 === 0 ? '90020' . str_pad((string) ($index + 1), 7, '0', STR_PAD_LEFT) : null,
                'spouse_salary' => $index % 2 === 0 ? 2200 + ($index * 120) : null,
                'spouse_position' => $index % 2 === 0 ? 'Pembantu Tadbir Gred N11' : null,
                'status' => $record['status'],
                'agent_verification' => $record['agent_verification'],
                'approved_amount' => $record['approved_amount'],
                'rejection_reason' => $record['rejection_reason'],
                'approved_at' => $record['approved_at'],
                'jk_recommendation' => $record['jk_recommendation'],
                'jk_recommendation_status' => $record['jk_recommendation_status'],
                'submitted_at' => $record['submitted_at'],
                'agent_id' => $record['agent_id'],
                'agent_filled' => $record['agent_id'] !== null,
            ]);

            // Tambah dokumen untuk beberapa permohonan
            if ($index % 2 === 0 && $assistance->status !== 'draft') {
                $documentTypes = [
                    ['key' => 'ic_copy', 'label' => 'Salinan Kad Pengenalan'],
                    ['key' => 'payslip', 'label' => 'Slip Gaji Terkini'],
                    ['key' => 'medical_report', 'label' => 'Laporan Perubatan'],
                    ['key' => 'bank_statement', 'label' => 'Penyata Bank'],
                    ['key' => 'family_support', 'label' => 'Borang Sokongan Keluarga'],
                ];
                $docType = $documentTypes[$index % count($documentTypes)];

                AssistanceRequestDocument::create([
                    'assistance_request_id' => $assistance->id,
                    'document_key' => $docType['key'],
                    'document_label' => $docType['label'],
                    'file_path' => '/documents/assistance_' . $assistance->id . '/' . $docType['key'] . '.pdf',
                    'original_name' => $docType['label'] . '_' . $index . '.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => rand(50000, 500000),
                ]);
            }
        }
    }
}
