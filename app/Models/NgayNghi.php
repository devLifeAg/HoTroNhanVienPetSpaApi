<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgayNghi extends Model
{
    protected $table = 'ngaynghi';
    public $timestamps = false;
    protected $primaryKey = 'nn_id';

    protected $fillable = [
        'ngay_off',
        'nv_id',
    ];

    public function getNhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nv_id', 'nv_id'); //class, foreignkey, ownerkey
    }
}
