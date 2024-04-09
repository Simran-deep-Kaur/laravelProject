<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function name():Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucwords($value),
        );
    }

    protected $appends = ['unique_id'];

    public function getUniqueIdAttribute()
    {
        return strtolower(Str::limit($this->name, 3,'' )) . Str::limit($this->email, 3,''). $this->id;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-M-Y', strtotime($value));
    }
}