<?php

namespace App\Imports;

use App\Models\Storage;
use Maatwebsite\Excel\Concerns\ToModel;

class StorageImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $storage = Storage::where('name', $row[0])->first();
        if(!$storage) {
            return new Storage([
                'name' => $row[0],
                'description' => $row[1],
            ]);
        }
    }
}
