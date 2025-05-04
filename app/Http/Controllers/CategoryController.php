<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $blogs = $category->blogs()->latest()->paginate(6); // يمكنك تغيير العدد أو استخدام get()

        return view('category-details', compact('category', 'blogs'));
    }
}
