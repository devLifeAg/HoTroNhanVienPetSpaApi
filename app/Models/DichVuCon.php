<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DichVuCon extends Model
{
    protected $table = 'dichvucon';
    public $timestamps = false;
    protected $primaryKey = 'dvc_id';

    protected $fillable = [
        'tendichvucon',
        'forDog',
        'forCat',
        'tilehh',
        'dv_id'
    ];

    public function listThongTinHoaHong() 
    {
        return $this->hasMany(ThongTinHoaHong::class, 'dvc_id', 'dvc_id'); //class, foreignkey, localkey
    }

    public function getDichVu()
    {
        return $this->belongsTo(DichVu::class, 'dv_id', 'dv_id'); //class, foreignkey, ownerkey
    }
}
