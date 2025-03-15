<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinHoaHong extends Model
{
    protected $table = 'thongtinhoahong';
    public $timestamps = false;
    protected $primaryKey = 'tt_id';

    protected $fillable = [
        'tt_tenboss',
        'cho_meo',
        'tt_weight',
        'tt_total',
        'dvc_id',
        'ngaygio',
        'hoa_hong',
        'nv_id',
    ];

    public function getNhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nv_id', 'nv_id'); //class, foreignkey, ownerkey
    }

    public function getDichVuCon()
    {
        return $this->belongsTo(DichVu::class, 'dvc_id', 'dvc_id');
    }
}
