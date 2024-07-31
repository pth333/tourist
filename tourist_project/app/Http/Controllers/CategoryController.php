<?php

namespace App\Http\Controllers;


use App\Models\Destination;
use App\Traits\QueryCommonData;
use App\Models\Post;

class CategoryController extends Controller
{
    use QueryCommonData;
    public function listAllFollowCategory($id, $slug)
    {
        $commonData = $this->getCommonData();

        $destinations = Destination::where('category_id', $id)->paginate(12);

        // Lấy danh sách bài viết
        $posts = Post::where('category_id', $id)->paginate();

        // Kiểm tra nếu có địa điểm trong danh mục và không có bài viết
        if ($destinations->count() > 0 && $posts->isEmpty()) {
            $categoryTitleDestination = $destinations->first()->category;
            return view('category.destination.list', array_merge($commonData, compact('destinations', 'categoryTitleDestination')));
        }

        // Kiểm tra nếu có bài viết trong danh mục
        if ($posts->count() > 0) {
            $categoryTitlePost = $posts->first()->category;
            return view('category.post.list', array_merge($commonData, compact('posts', 'categoryTitlePost')));
        }

        // Nếu không có địa điểm và bài viết, có thể trả về trang lỗi hoặc thông báo
        return redirect()->back()->with('no', 'Không tìm thấy danh mục.');
    }
}
