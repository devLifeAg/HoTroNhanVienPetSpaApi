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
}
