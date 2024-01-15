<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function inStorage()
    {
        return $this->hasMany(ItemInStorage::class);
    }
    public function record()
    {
        return $this->hasMany(Record::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
