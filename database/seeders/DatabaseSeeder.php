<?php

namespace Database\Seeders;

use App\Models\DichVu;
use App\Models\DichVuCon;
use App\Models\NgayNghi;
use App\Models\NhanVien;
use App\Models\TangCa;
use App\Models\ThongTinHoaHong;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $listNhanVien = [
            'nguyenthuynhung' => 'Nguyễn Thùy Nhung',
            'huavinhthang' => 'Hứa Vinh Thắng',
            'test' => 'Nhân Viên Test',
        ];

        foreach ($listNhanVien as $key => $value) {
            NhanVien::create([
                'nv_username' => $key,
                'nv_password' => Hash::make('123'),
                'nv_name' => $value,
                'nv_chucvu' => 'nhân viên'
            ]);
        }

        $listDichVu = [
            'Combo tắm' => [
                true,
                true,
                [
                    'Chỉ tắm' => [true, true, 0.06, 1],
                    'Combo tắm cơ bản' => [true, true, 0.1, 1],
                    'Combo tắm đầy đủ' => [true, true, 0.1, 1],
                    'Combo tắm toàn diện' => [true, true, 0.1, 1],
                    'Combo tắm cạo' => [true, true, 0.1, 1],
                    'Combo tắm cắt tỉa' => [true, true, 0.15, 1],
                    'Combo tắm thảo mộc' => [true, true, 0.1, 1],
                ]
            ],
            'Dịch vụ lẻ' => [
                true,
                true,
                [
                    'Vệ sinh tai' => [true, true, 0.05, 2],
                    'Cắt, mài móng' => [true, true, 0.05, 2],
                    'Cạo vệ sinh' => [true, true, 0.05, 2],
                    'Đánh răng' => [true, true, 0.05, 2],
                    'Cạo vôi răng' => [true, false, 0.15, 2],
                ]
            ],
            'Cắt tỉa, gỡ rối' => [
                true,
                true,
                [
                    'Chỉ cắt' => [true, true, 0.09, 3],
                    'Tỉa 1 bộ phận (đầu, chân, đuôi)' => [true, true, 0.1, 3],
                    'Tỉa trái tim, trái đào' => [true, false, 0.1, 3],
                    'Chải lông chết' => [true, true, 0.1, 3],
                    'Gỡ rối' => [true, false, 0.5, 3],
                    'Gỡ keo dính chuột' => [true, true, 0.5, 3],
                ]
            ],
            'Nhuộm lông' => [
                true,
                false,
                [
                    'Nhuộm 2 tai' => [true, false, 0.1, 4],
                    'Nhuộm 4 chân' => [true, false, 0.1, 4],
                    'Nhuộm đuôi' => [true, false, 0.1, 4],
                    'Combo 2 tai, 4 chân, đuôi' => [true, false, 0.1, 4],
                    'Nhuộm trái tim' => [true, false, 0.1, 4],
                    'Nhuộm trái tim galaxy' => [true, false, 0.1, 4],
                    'Nhuộm trái đào' => [true, false, 0.1, 4],
                ]
            ],
        ];

        foreach ($listDichVu as $tendvcha => $valuedvcha) {
            DichVu::create([
                'tendichvu' => $tendvcha,
                'forDog' => $valuedvcha[0],
                'forCat' => $valuedvcha[1],
            ]);
            foreach ($valuedvcha[2] as $tendvcon => $valuedvcon) {
                DichVuCon::create([
                    'tendichvucon' => $tendvcon,
                    'forDog' => $valuedvcon[0],
                    'forCat' => $valuedvcon[1],
                    'tilehh' => $valuedvcon[2],
                    'dv_id' => $valuedvcon[3]
                ]);
            }
        }

        $listThongTinHoaHong = [
            'Bò' => [true, 5.0, 150000, 1, date('Y-m-d H:i:s'), 15000, 1],
            'Mimi' => [false, 2.0, 50000, 7, date('Y-m-d H:i:s', strtotime('+1 hour')), 2500, 1],
            'Mì' => [true, 3.5, 200000, 15, date('Y-m-d H:i:s', strtotime('+2 hour')), 100000, 1],
            'Đốm' => [true, 5.0, 150000, 2, date('Y-m-d H:i:s', strtotime('+3 hour')), 15000, 2],
            'Meo' => [false, 2.0, 50000, 8, date('Y-m-d H:i:s', strtotime('+4 hour')), 2500, 2],
            'Quyền' => [true, 3.5, 200000, 15, date('Y-m-d H:i:s', strtotime('+5 hour')), 100000, 2],
            'Cheems' => [true, 5.0, 150000, 3, date('Y-m-d H:i:s', strtotime('+6 hour')), 15000, 3],
            'Doraemon' => [false, 2.0, 50000, 8, date('Y-m-d H:i:s', strtotime('+7 hour')), 2500, 3],
            'Doge' => [true, 3.5, 200000, 15, date('Y-m-d H:i:s', strtotime('+8 hour')), 100000, 3],
        ];

        foreach ($listThongTinHoaHong as $tenboss => $value) {
            ThongTinHoaHong::create([
                'tt_tenboss' => $tenboss,
                'cho_meo' => $value[0],
                'tt_weight' => $value[1],
                'tt_total' => $value[2],
                'dvc_id' => $value[3],
                'ngaygio' => $value[4],
                'hoa_hong' => $value[5],
                'nv_id' => $value[6],
            ]);
        }

        $listNgayNghi = [
            [1, date('Y-m-d H:i:s')],
            [1, date('Y-m-d H:i:s', strtotime('-2 day'))],
            [1, date('Y-m-d H:i:s', strtotime('-4 day'))],
            [2, date('Y-m-d H:i:s')],
            [2, date('Y-m-d H:i:s', strtotime('-2 day'))],
            [2, date('Y-m-d H:i:s', strtotime('-4 day'))],
            [3, date('Y-m-d H:i:s')],
            [3, date('Y-m-d H:i:s', strtotime('-2 day'))],
            [3, date('Y-m-d H:i:s', strtotime('-4 day'))],
        ];

        foreach ($listNgayNghi as $ngaynghi) {
            NgayNghi::create([
                'ngay_off' => $ngaynghi[1],
                'nv_id' => $ngaynghi[0],
            ]);
        }

        $listTangCa = [
            [1, date('Y-m-d H:i:s', strtotime('-1 day')), 1],
            [1, date('Y-m-d H:i:s', strtotime('-3 day')), 2],
            [1, date('Y-m-d H:i:s', strtotime('-5 day')), 3],
            [2, date('Y-m-d H:i:s', strtotime('-1 day')), 1],
            [2, date('Y-m-d H:i:s', strtotime('-3 day')), 2],
            [2, date('Y-m-d H:i:s', strtotime('-5 day')), 3],
            [3, date('Y-m-d H:i:s', strtotime('-1 day')), 1],
            [3, date('Y-m-d H:i:s', strtotime('-3 day')), 2],
            [3, date('Y-m-d H:i:s', strtotime('-5 day')), 3],
        ];

        foreach ($listTangCa as $tcvalue) {
            TangCa::create([
                'ngay' => $tcvalue[1],
                'sogio' => $tcvalue[2],
                'nv_id' => $tcvalue[0],
            ]);
        }
    }
}
