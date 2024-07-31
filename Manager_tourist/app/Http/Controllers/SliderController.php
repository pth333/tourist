<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderAddRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Trait\StorageImageTrait;
use App\Trait\DeleteModalTrait;

class SliderController extends Controller
{
    use StorageImageTrait;
    use DeleteModalTrait;
    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {
        $sliders = $this->slider->latest()->paginate(5);
        // dd($sliders);
        $key = request()->key;
        if ($key) {
            $sliders = $this->slider->where('name', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('admin.slider.index', compact('sliders'));
    }

    public function store(SliderAddRequest $request)
    {
        $sliderCreate = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $sliderUploadFile = $this->storgeImageUpload($request, 'image_path', 'slider');

        // dd($sliderUploadFile);
        if ($sliderUploadFile) {
            $sliderCreate['image_path'] = $sliderUploadFile['file_path'];
            $sliderCreate['image_name'] = $sliderUploadFile['file_name'];
        }

        $this->slider->create($sliderCreate);

        return redirect()->route('slider.index')->with('ok', 'Bạn đã thêm slider thành công!');
    }

    public function edit($id)
    {
        $slider = $this->slider->find($id);
        return response()->json([
            'code' => 200,
            'slider' => $slider,
        ], 200);
    }

    public function update(Request $request)
    {
        $sliderId = $request->input('sliderId');
        if(empty($sliderId)){
            return view('errors.403');
        }
        $sliderUpdate = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $sliderUploadFile = $this->storgeImageUpload($request, 'image_path', 'slider');
        // dd($sliderUploadFile);
        if ($sliderUploadFile) {
            $sliderUpdate['image_path'] = $sliderUploadFile['file_path'];
            $sliderUpdate['image_name'] = $sliderUploadFile['file_name'];
        }
        // dd($sliderId);
        $this->slider->find($sliderId)->update($sliderUpdate);
        return redirect()->route('slider.index')->with('ok', 'Bạn đã sửa slider thành công!');
    }

    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->slider);
    }
}
