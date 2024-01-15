<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
