<?php

namespace App\Services;

use App\Models\Category;

class CategoryService {

    public function getList(){
        return Category::get();
    }


}
