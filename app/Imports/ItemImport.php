<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category = Category::where('name', $row[1])->first();
        if(!$category) {
            $category = Category::create(['name' => $row[1]]);
        }
        return new Item([
            'name' => $row[0],
            'category_id' => $category->id,
        ]);
    }
}
