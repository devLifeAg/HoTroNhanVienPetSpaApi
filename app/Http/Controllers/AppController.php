<?php

namespace App\Http\Controllers;

use App\Models\DichVu;
use App\Models\DichVuCon;
use App\Models\NgayNghi;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\TangCa;
use App\Models\ThongTinHoaHong;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AppController extends Controller
{
    public function Login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tìm user theo username
        $nv = NhanVien::where('nv_username', $request->username)->first();

        // Kiểm tra user tồn tại và password đúng
        if ($nv && Hash::check($request->password, $nv->nv_password)) {
            return response()->json([
                'success' => true,
                'nhanvien' => $nv
            ]);
        }

        // Nếu sai, trả về JSON false
        return response()->json([
            'success' => false,
        ]);
    }

    public function getDanhSachTTHH(Request $request)
    {
        $ngaybd = $request->ngaybd;
        $ngaykt = $request->ngaykt;
        // Truy vấn danh sách thông tin hoa hồng theo khoảng thời gian
        $listThongTinHH = ThongTinHoaHong::where('nv_id', $request->id)->whereBetween('ngaygio', [$ngaybd, $ngaykt])
            ->orderBy('ngaygio', 'asc')->get();
        $listDichVuCon = DichVuCon::leftJoin('thongtinhoahong', 'dichvucon.dvc_id', '=', 'thongtinhoahong.dvc_id')
            ->where('thongtinhoahong.nv_id', $request->id)
            ->whereBetween('thongtinhoahong.ngaygio', [$ngaybd, $ngaykt])
            ->pluck('dichvucon.tendichvucon', 'dichvucon.dvc_id'); // Lấy key-value
        return response()->json([
            'listhoahong' => $listThongTinHH,
            'listdichvucon' => $listDichVuCon
        ]);
    }

    public function getDanhSachDichVuChaCon()
    {
        $listDichVuCha = DichVu::all();
        $listDichVuCon = DichVuCon::all();
        return response()->json([
            'dichvucha' => $listDichVuCha,
            'dichvucon' => $listDichVuCon
        ]);
    }

    public function themTTHH(Request $request)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
            $validatedData = $request->validate([
                'tt_tenboss' => 'required|string|max:20',
                'cho_meo' => 'required|boolean',
                'tt_weight' => 'required|numeric',
                'tt_total' => 'required|numeric',
                'dvc_id' => 'required|integer|exists:dichvucon,dvc_id',
                'ngaygio' => 'required|date_format:Y-m-d H:i:s',
                'hoa_hong' => 'required|numeric',
                'nv_id' => 'required|integer|exists:nhanvien,nv_id',
            ]);

            // Tạo mới bản ghi trong database
            $thongTinHoaHong = ThongTinHoaHong::create($validatedData);

            return response()->json([
                'message' => 'Thêm thông tin hoa hồng thành công!',
                'tt_id' => $thongTinHoaHong->tt_id, // Trả về ID mới thêm
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi thêm thông tin hoa hồng!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function capNhatTTHH(Request $request)
    {
        try {
            // Kiểm tra dữ liệu đầu vào, bao gồm tt_id
            $validatedData = $request->validate([
                'tt_tenboss' => 'required|string|max:20',
                'cho_meo' => 'required|boolean',
                'tt_weight' => 'required|numeric',
                'tt_total' => 'required|numeric',
                'dvc_id' => 'required|integer|exists:dichvucon,dvc_id',
                'ngaygio' => 'required|date_format:Y-m-d H:i:s',
                'hoa_hong' => 'required|numeric',
            ]);

            // Tìm bản ghi cần cập nhật
            $thongTinHoaHong = ThongTinHoaHong::find($request->input('tt_id'));

            // Cập nhật thông tin
            $thongTinHoaHong->update($validatedData);

            return response()->json([
                'message' => 'Cập nhật thông tin hoa hồng thành công!',
                'tt_id' => $thongTinHoaHong->tt_id, // Trả về ID sau khi cập nhật
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi cập nhật thông tin hoa hồng!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function xoaTTHH(Request $request)
    {
        try {
            // Tìm bản ghi cần xóa
            $thongTinHoaHong = ThongTinHoaHong::find($request->input('tt_id'));

            if (!$thongTinHoaHong) {
                return response()->json([
                    'message' => 'Không tìm thấy thông tin hoa hồng!',
                ], 404);
            }

            // Xóa bản ghi
            $thongTinHoaHong->delete();

            return response()->json([
                'message' => 'Xóa thông tin hoa hồng thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi xóa thông tin hoa hồng!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getNgayNghi(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $ngaybd = $request->input('ngaybd');
            $ngaykt = $request->input('ngaykt');
            $nv_id = $request->input('id');

            // Kiểm tra đầu vào hợp lệ
            if (!$ngaybd || !$ngaykt || !$nv_id) {
                return response()->json([
                    'message' => 'Vui lòng cung cấp đầy đủ tháng, năm và nv_id'
                ], 400);
            }

            // Truy vấn danh sách ngày nghỉ
            $ngayNghiList = NgayNghi::where('nv_id', $nv_id)
                ->whereBetween('ngay_off', [$ngaybd, $ngaykt])
                ->orderBy('ngay_off', 'asc')
                ->get();

            return response()->json([
                'listngaynghi' => $ngayNghiList,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi lấy danh sách ngày nghỉ!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function themNgayNghi(Request $request)
    {
        $validated = $request->validate([
            'ngay_off' => 'required|date',
            'nv_id' => 'required|integer|exists:nhanvien,nv_id',
        ]);

        try {
            $ngayNghi = NgayNghi::create($validated);
            return response()->json(['message' => 'Tạo ngày off thành công!', 'nn_id' => $ngayNghi->nn_id], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo ngày off!', 'error' => $e->getMessage()], 500);
        }
    }

    public function capNhatNgayNghi(Request $request)
    {
        try {
            $validated = $request->validate([
                'ngay_off' => 'required|date',
            ]);

            $ngayNghi = NgayNghi::find($request->input('nn_id'));
            if (!$ngayNghi) {
                return response()->json(['message' => 'Ngày off không tồn tại!'], 404);
            }

            $ngayNghi->update($validated);
            return response()->json(['message' => 'Cập nhật ngày off thành công!'],);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi cập nhật ngày off!', 'error' => $e->getMessage()], 500);
        }
    }

    public function xoaNgayNghi(Request $request)
    {
        try {
            $ngayNghi = NgayNghi::find($request->input('nn_id'));
            if (!$ngayNghi) {
                return response()->json(['message' => 'Ngày off không tồn tại!'], 404);
            }

            $ngayNghi->delete();
            return response()->json(['message' => 'Xóa ngày off thành công!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xóa ngày off!', 'error' => $e->getMessage()], 500);
        }
    }

    public function getTangCa(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $ngaybd = $request->input('ngaybd');
            $ngaykt = $request->input('ngaykt');
            $nv_id = $request->input('id');

            // Kiểm tra đầu vào hợp lệ
            if (!$ngaybd || !$ngaykt || !$nv_id) {
                return response()->json([
                    'message' => 'Vui lòng cung cấp đầy đủ tháng, năm và nv_id'
                ], 400);
            }

            // Truy vấn danh sách ngày nghỉ
            $tangCaList = TangCa::where('nv_id', $nv_id)
                ->whereBetween('ngay', [$ngaybd, $ngaykt])
                ->orderBy('ngay', 'asc')
                ->get();

            return response()->json([
                'listtangca' => $tangCaList,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi lấy danh sách tăng ca!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function themTangCa(Request $request)
    {
        $validated = $request->validate([
            'ngay' => 'required|date',
            'sogio' => 'required|integer',
            'nv_id' => 'required|integer|exists:nhanvien,nv_id',
        ]);

        // Kiểm tra ngày tăng ca đã tồn tại chưa
        $existingTangCa = TangCa::where('ngay', $validated['ngay'])
            ->where('nv_id', $validated['nv_id'])
            ->exists();

        if ($existingTangCa) {
            return response()->json(['message' => 'Ngày tăng ca đã tồn tại!'], 400);
        }

        try {
            $tangCa = TangCa::create($validated);
            return response()->json(['message' => 'Tạo tăng ca thành công!', 'tc_id' => $tangCa->tc_id], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo tăng ca!', 'error' => $e->getMessage()], 500);
        }
    }

    public function capNhatTangCa(Request $request)
    {
        try {
            $validated = $request->validate([
                'ngay' => 'required|date',
                'sogio' => 'required|integer',
            ]);

            $tangCa = TangCa::find($request->input('tc_id'));
            if (!$tangCa) {
                return response()->json(['message' => 'Tăng ca không tồn tại!'], 404);
            }

            // Kiểm tra ngày tăng ca đã tồn tại chưa
            $existingTangCa = TangCa::where('tc_id', '!=', $request->input('tc_id'))
                ->where('ngay', $validated['ngay'])
                ->exists();

            if ($existingTangCa) {
                return response()->json(['message' => 'Ngày tăng ca đã tồn tại!'], 400);
            }

            $tangCa->update($validated);
            return response()->json(['message' => 'Cập nhật tăng ca thành công!'],);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi cập nhật tăng ca!', 'error' => $e->getMessage()], 500);
        }
    }

    public function xoaTangCa(Request $request)
    {
        try {
            $tangCa = TangCa::find($request->input('tc_id'));
            if (!$tangCa) {
                return response()->json(['message' => 'Ngày off không tồn tại!'], 404);
            }

            $tangCa->delete();
            return response()->json(['message' => 'Xóa tăng ca thành công!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xóa tăng ca!', 'error' => $e->getMessage()], 500);
        }
    }

    public function getBangLuong(Request $request)
    {
        $nv_id = $request->input('id');
        $startDate = $request->input('ngaybd');
        $endDate = $request->input('ngaykt');

        try {
            $result = DB::select("
            SELECT 
                (SELECT COUNT(*) FROM ngaynghi WHERE nv_id = ? AND ngay_off BETWEEN ? AND ?) AS soNgayNghi,
                (SELECT SUM(CAST(sogio AS UNSIGNED)) FROM tangca WHERE nv_id = ? AND ngay BETWEEN ? AND ?) AS soGioTangCa,
                (SELECT COUNT(*) FROM thongtinhoahong WHERE nv_id = ? AND ngaygio BETWEEN ? AND ?) AS soLuongDvLam,
                (SELECT SUM(hoa_hong) FROM thongtinhoahong WHERE nv_id = ? AND ngaygio BETWEEN ? AND ?) AS tongHoaHong
        ", [$nv_id, $startDate, $endDate, $nv_id, $startDate, $endDate, $nv_id, $startDate, $endDate, $nv_id, $startDate, $endDate]);

            // Định dạng dữ liệu trả về
            $data = [
                'soNgayNghi'   => (int) $result[0]->soNgayNghi,
                'soGioTangCa'  => (int) $result[0]->soGioTangCa,
                'soLuongDvLam' => (int) $result[0]->soLuongDvLam,
                'tongHoaHong'  => (float) $result[0]->tongHoaHong,
            ];

            // if ($data['soLuongDvLam'] > 0) {
            return response()->json([
                'bangluong' => $data
            ], 200);
            // }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi lấy dữ liệu!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function callDeepseekR1($prompt)
    {
        // $prompt = $request->input('input');
        $apiKey = env('DEEPSEEK_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type'  => 'application/json',
        ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'    => 'deepseek/deepseek-r1-distill-llama-70b:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
        ]);

        return $response->json();
    }

    public function aiPhanTichTaiChinh(Request $request)
    {
        $soTienMuonDat = $request->input('money');
        $thoiGian = $request->input('time');

        $listDichVu = DichVu::with('listDichVuCon')->get();

        $result = $listDichVu->map(function ($dichVu) {
            return $dichVu->tendichvu . ": " .
                ($dichVu->getAverageCommission() !== null
                    ? $dichVu->getAverageCommission() . " đồng/dịch vụ"
                    : "chưa có bản ghi cho dịch vụ này");
        })->toArray();

        $servicesText = implode(", ", $result);

        $prompt = "Phân tích cho tôi phải làm những gì để đạt mức thu nhập " . $soTienMuonDat . " đồng trong " . $thoiGian . " với các số liệu sau: "
            . "Lương cứng và phụ cấp một tháng nếu không có ngày nghỉ: "
            . "Lương cứng: 5000000 đồng, "
            . "Phụ cấp: 750000 đồng, tăng ca 1h 25000 đồng. "
            . "Trung bình tiền hoa hồng của mỗi dịch vụ làm cho chó mèo: "
            . $servicesText . ". Hãy trả lời ngắn gọn bằng tiếng việt và không dùng ký hiệu đặc biệt";
            
        // Gọi API OpenRouter thông qua callDeepseekR1
        $apiResponse = $this->callDeepseekR1($prompt);

        return response()->json($apiResponse);
    }
}
