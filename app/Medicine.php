<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // protected $table = 'medicine';
    // protected $fillable = [
    //     'type','name', 'email','phone','city'
    // ];

    public function prescriptions(){
        return $this->belongsToMany('App\Prescription');
    }
}
