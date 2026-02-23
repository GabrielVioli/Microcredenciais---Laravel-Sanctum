<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Course extends Model
{

    use hasFactory;
    protected $fillable = [
        'name',
        'description',
        'workload',
    ];

    public function students() {
        return $this->belongsToMany(Student::class);
    }


}
