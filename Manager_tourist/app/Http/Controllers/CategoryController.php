<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Http\Requests\CategoryAddRequest;
use App\Models\Category;
use App\Trait\DeleteModalTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use DeleteModalTrait;
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {

        $categories = $this->category->latest()->paginate(5);
        // dd($category);
        $key = request()->key;
        if ($key) {
            $categories = $this->category->where('name', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        $htmlOption = $this->getCategory($parentId = '');
        return view('admin.category.index', compact('categories', 'htmlOption'));
    }

    public function getCategory($parentId)
    {
        $categoriesRecusive = new Recusive($this->category->all());
        $htmlOption = $categoriesRecusive->getCategoryRecusive($parentId);
        return $htmlOption;
    }

    public function store(CategoryAddRequest $request)
    {
        $this->category->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name, '-')
        ]);
        return redirect()->route('categories.index')->with('ok', 'Danh mục đã được thêm thành công !');
    }

    public function edit($id, Request $request)
    {

        $categories = $this->category->find($id);
        return response()->json([
            'code' => 200,
            'categories' => $categories,
        ], 200);
    }

    public function update(Request $request)
    {
        $cateId = $request->input('categoryId');
        if (empty($cateId)) {
            return view('errors.403');
        } else {
            $categories = $this->category->find($cateId);
            $categories->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'slug' => Str::slug($request->name, '-')
            ]);
            return redirect()->route('categories.index')->with('ok', 'Đã sửa danh mục thành công !');
        }
    }

    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->category);
    }
}
