<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    protected $table = 'dichvu';
    public $timestamps = false;
    protected $primaryKey = 'dv_id';

    protected $fillable = [
        'tendichvu',
        'forDog',
        'forCat',
    ];

    public function listDichVuCon()
    {
        return $this->hasMany(DichVuCon::class, 'dv_id', 'dv_id'); //class, foreignkey, localkey
    }

    public function getAverageCommission()
    {
        return ThongTinHoaHong::whereHas('getDichVuCon', function ($query) {
            $query->whereIn('dvc_id', $this->listDichVuCon()->pluck('dvc_id'));
        })->avg('hoa_hong'); // Tính trung bình hoa_hong
    }
}
