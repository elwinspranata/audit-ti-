<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'policy_title',
                'value' => 'Kebijakan Layanan',
                'type' => 'text',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_subtitle',
                'value' => 'Audit Teknologi Informasi',
                'type' => 'text',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_welcome_message',
                'value' => 'Selamat datang di Platform Audit TI.',
                'type' => 'text',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_main_description',
                'value' => 'Layanan audit kami dilaksanakan menggunakan kerangka kerja COBIT 2019 sebagai acuan utama dalam evaluasi tata kelola, manajemen risiko, dan efektivitas proses TI organisasi Anda.',
                'type' => 'textarea',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_point_1_title',
                'value' => 'Kerahasiaan Data',
                'type' => 'text',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_point_1_content',
                'value' => 'Seluruh informasi yang diperoleh dijamin rahasia dan hanya digunakan untuk kepentingan audit.',
                'type' => 'textarea',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_point_2_title',
                'value' => 'Hasil Audit',
                'type' => 'text',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_point_2_content',
                'value' => 'Temuan dan rekomendasi mencerminkan kondisi organisasi pada saat penilaian dilakukan.',
                'type' => 'textarea',
                'group' => 'policy',
            ],
            [
                'key' => 'policy_footer_message',
                'value' => 'Dengan melanjutkan penggunaan layanan ini, Anda dianggap telah memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku.',
                'type' => 'textarea',
                'group' => 'policy',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
