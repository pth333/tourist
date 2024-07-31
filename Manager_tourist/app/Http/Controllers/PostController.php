<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Trait\StorageImageTrait;
use App\Trait\DeleteModalTrait;
use Illuminate\Support\Str;
use App\Components\Recusive;
use App\Models\Category;

class PostController extends Controller
{
    use StorageImageTrait;
    use DeleteModalTrait;
    private $post;
    private $category;
    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }
    public function index()
    {
        $posts = $this->post->latest()->paginate(5);
        $htmlOption = $this->getCategory($parentId = '');
        $key = request()->key;
        if ($key) {
            $posts = $this->post->where('name_post', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('admin.post.index', compact('posts', 'htmlOption'));
    }
    public function getCategory($parentId)
    {
        $categoriesRecusive = new Recusive($this->category->all());
        $htmlOption = $categoriesRecusive->getCategoryRecusive($parentId);
        return $htmlOption;
    }
    public function store(Request $request)
    {
        $post = [
            'name_post' => $request->name_post,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->name_post)
        ];

        $postImage = $this->storgeImageUpload($request, 'image_post', 'post');

        if (!empty($postImage)) {
            $post['image_name'] = $postImage['file_name'];
            $post['image_post'] = $postImage['file_path'];
        }

        $this->post->create($post);
        return redirect()->back()->with('ok', 'Bạn đã thêm bài viết thành công');
    }

    public function edit($id)
    {
        $post = $this->post->find($id);
        // dd($post);
        return response()->json([
            'code' => 200,
            'post' => $post
        ], 200);
    }
    public function update(Request $request)
    {
        $postId = $request->input('postId');
        if(empty($postId)){
            return view('errors.403');
        }
        $post = [
            'name_post' => $request->name_post,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->name_post)
        ];
        $postImage = $this->storgeImageUpload($request, 'image_post', 'post');
        if (!empty($postImage)) {
            $post['image_name'] = $postImage['file_name'];
            $post['image_post'] = $postImage['file_path'];
        }
        $this->post->find($postId)->update($post);

        return redirect()->back()->with('ok', 'Bạn đã sửa bài viết thành công');
    }
    public function delete($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->post);
    }
}
