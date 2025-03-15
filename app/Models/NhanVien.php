<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class NhanVien extends Authenticatable
{
    protected $table = 'nhanvien';
    public $timestamps = false;
    protected $primaryKey = 'nv_id'; // Đặt khóa chính nếu không phải là 'id'

    protected $fillable = [
        'nv_username',
        'nv_password',
        'nv_name',
        'nv_chucvu',
    ];

    protected $hidden = [
        'nv_password', // Ẩn mật khẩu khi chuyển đổi sang mảng hoặc JSON
    ]; 

     // Đặt trường mật khẩu
     public function getAuthPassword()
     {
        //  return $this->o_pass;
        return 'nv_password';
     }
  
     // Đặt trường tên đăng nhập
     public function getAuthIdentifierName()
     {
         return 'nv_username';
     }

    public function listThongTinHoaHong() 
    {
        return $this->hasMany(ThongTinHoaHong::class, 'nv_id', 'nv_id'); //class, foreignkey, localkey
    }

    public function listNgayNghi()
    {
        return $this->hasMany(NgayNghi::class, 'nv_id', 'nv_id'); //class, foreignkey, localkey
    }

    public function listTangCa(){
        return $this->hasMany(TangCa::class, 'nv_id', 'nv_id');
    }
}
