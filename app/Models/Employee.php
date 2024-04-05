<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'age',
        'profile_image',
        'profile_url',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    protected $appends = ['unique_id'];

    public function getUniqueIdAttribute()
    {
        return Str::limit($this->name, 3,'' ) . Str::limit($this->email, 3,''). $this->age;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-M-Y', strtotime($value));
    }
}