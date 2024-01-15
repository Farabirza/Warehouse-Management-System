<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];
    
    public function inStorage()
    {
        return $this->hasMany(ItemInStorage::class);
    }
    public function recordFrom()
    {
        return $this->hasMany(Record::class, 'storage_from');
    }
    public function recordTo()
    {
        return $this->hasMany(Record::class, 'storage_to');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
