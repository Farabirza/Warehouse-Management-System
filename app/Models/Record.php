<?php

namespace App\Models;

use App\Traits\GenerateUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory, GenerateUuid;
    protected $guarded = [ 'id' ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function fromStorage()
    {
        return $this->belongsTo(Storage::class, 'storage_from');
    }
    public function toStorage()
    {
        return $this->belongsTo(Storage::class, 'storage_to');
    }
}
