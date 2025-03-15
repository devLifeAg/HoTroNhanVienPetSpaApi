<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TangCa extends Model
{
    protected $table = 'tangca';
    public $timestamps = false;
    protected $primaryKey = 'tc_id';

    protected $fillable = [
        'ngay',
        'sogio',
        'nv_id',
    ];

    public function getNhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nv_id', 'nv_id'); //class, foreignkey, ownerkey
    }
}
