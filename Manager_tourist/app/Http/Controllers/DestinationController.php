<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Components\Recusive;
use App\Http\Requests\DestinationAddRequest;
use App\Models\Category;
use App\Models\DestinationImage;
use App\Trait\DeleteModalTrait;
use App\Trait\StorageImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    use StorageImageTrait;
    use DeleteModalTrait;
    private $destination;
    private $category;
    private $destinationImage;
    public function __construct(Destination $destination, Category $category, DestinationImage $destinationImage)
    {
        $this->destination = $destination;
        $this->category = $category;
        $this->destinationImage = $destinationImage;
    }
    public function index()
    {
        $destinations = $this->destination->latest()->paginate(5);
        $htmlOption = $this->getCategory($parentId = '');
        $key = request()->key;
        if ($key) {
            $destinations = $this->destination->where('name_des', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('admin.destination.index', compact('destinations', 'htmlOption'));
    }

    public function getCategory($parentId)
    {
        $categoriesRecusive = new Recusive($this->category->all());
        $htmlOption = $categoriesRecusive->getCategoryRecusive($parentId);
        return $htmlOption;
    }

    public function store(DestinationAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataDestinationCreate = [
                'name_des' => $request->name_des,
                'address' => $request->address,
                'description' => $request->description,
                'ticket_price' => $request->ticket_price,
                'views_count' => 0,
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'latitude' => $request->latitude,
                'longtitude' => $request->longtitude,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name_des, '-')
            ];

            $dataUploadFeatureImage = $this->storgeImageUpload($request, 'feature_image_path', 'destination');

            if (!empty($dataUploadFeatureImage)) {
                $dataDestinationCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataDestinationCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $destinations = $this->destination->create($dataDestinationCreate);

            // Ảnh chi tiết
            foreach ($request->image_path as $fileItems) {
                $imageDetail = $this->storgeMultiImageUpload($fileItems, 'destination');
                $destinations->images()->create([
                    'image_path' => $imageDetail['file_path'],
                    'image_name' => $imageDetail['file_name']
                ]);
            }
            DB::commit();
            return redirect()->route('destination.index')->with('ok', 'Thêm địa điểm thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line : ' . $exception->getLine());
        }
    }
    public function edit($id)
    {
        $destination = $this->destination->find($id);
        $destinationImageDetail = $this->destinationImage->where('destination_id', $id)->get();
        // dd($destinationImageDetail);
        return response()->json([
            'code' => 200,
            'destination' => $destination,
            'destinationImage' => $destinationImageDetail,
        ], 200);
    }

    public function update(Request $request)
    {

        try {
            DB::beginTransaction();
            $desId = $request->input('destinationId');
            if (empty($desId)) {
                return view('errors.403');
            }
            $dataDestinationUpdate = [
                'name_des' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'ticket_price' => $request->ticket_price,
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'latitude' => $request->latitude,
                'longtitude' => $request->longtitude,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name, '-')
            ];

            $dataUploadFeatureImage = $this->storgeImageUpload($request, 'feature_image_path', 'destination');

            if (!empty($dataUploadFeatureImage)) {
                $dataDestinationUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataDestinationUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $this->destination->find($desId)->update($dataDestinationUpdate);
            $destinations = $this->destination->find($desId);

            // Ảnh chi tiết
            if ($request->hasFile('image_path')) {
                $this->destinationImage->where('destination_id', $desId)->delete();
                foreach ($request->image_path as $fileItems) {
                    $imageDetail = $this->storgeMultiImageUpload($fileItems, 'destination');
                    $destinations->images()->create([
                        'image_path' => $imageDetail['file_path'],
                        'image_name' => $imageDetail['file_name']
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('destination.index')->with('ok', 'Sửa địa điểm thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line : ' . $exception->getLine());
        }
    }
    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        $deleteDes = $this->destination->find($id);
        $deleteImageDetail = $deleteDes->images;
        foreach ($deleteImageDetail as $image) {
            $image->delete();
        }
        // dd($deleteImageDetail);
        return $this->deleteModalTrait($id, $this->destination);
    }
}
