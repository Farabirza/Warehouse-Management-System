<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category = Category::where('name', $row[0])->first();
        if(!$category) {
            return new Category([
                'name' => $row[0],
                'description' => $row[1],
            ]);
        }
    }
}
