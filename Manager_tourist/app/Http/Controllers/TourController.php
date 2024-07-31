<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use App\Components\Recusive;
use App\Http\Requests\TourAddRequest;
use App\Models\Category;
use App\Models\TourImage;
use App\Models\TourSchedule;
use App\Trait\DeleteModalTrait;
use App\Trait\StorageImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class TourController extends Controller
{
    use StorageImageTrait;
    use DeleteModalTrait;
    private $tour;
    private $category;
    private $tourImage;
    private $tourSchedule;
    public function __construct(Tour $tour, Category $category, TourImage $tourImage, TourSchedule $tourSchedule)
    {
        $this->tour = $tour;
        $this->category = $category;
        $this->tourImage = $tourImage;
        $this->tourSchedule = $tourSchedule;
    }

    public function index()
    {
        $tours = $this->tour->latest()->paginate(5);
        $htmlOption = $this->getCategory($parentId = '');
        $key = request()->key;
        if ($key) {
            $tours = $this->tour->where('name_tour', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('admin.tour.index', compact('tours', 'htmlOption'));
    }

    public function getCategory($parentId)
    {
        $categoriesRecusive = new Recusive($this->category->all());
        $htmlOption = $categoriesRecusive->getCategoryRecusive($parentId);
        return $htmlOption;
    }

    public function store(TourAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataTourCreate = [
                'name_tour' => $request->name_tour,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'departure_day' => $request->departure_day,
                'return_day' => $request->return_day,
                'type_vehical' => $request->type_vehical,
                'max_participants' => $request->max_participants,
                'description' => strip_tags($request->description),
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name_tour, '-'),
                'departure' => $request->departure,
                'destination' => $request->destination,
                'price_adult' => $request->price_adult,
                'price_child' => $request->price_child,
                'price_infant' => $request->price_infant,
            ];
            $dataUploadFeatureImage = $this->storgeImageUpload($request, 'feature_image_path', 'tour');

            if (!empty($dataUploadFeatureImage)) {
                $dataTourCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataTourCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $tours = $this->tour->create($dataTourCreate);
            // Ảnh chi tiết

            foreach ($request->image_path as $fileItems) {
                $imageDetail = $this->storgeMultiImageUpload($fileItems, 'tour');
                $tours->images()->create([
                    'image_path' => $imageDetail['file_path'],
                    'image_name' => $imageDetail['file_name']
                ]);
            }

            DB::commit();
            return redirect()->route('tour.index')->with('ok', 'Thêm tour thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line : ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $tour = $this->tour->find($id);
        $tourImageDetail = $this->tourImage->where('tour_id', $id)->get();
        // dd($destinationImageDetail);
        return response()->json([
            'code' => 200,
            'tour' => $tour,
            'tourImageDetail' => $tourImageDetail,
        ], 200);
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $tourId = $request->input('tourId');
            if (empty($tourId)) {
                return view('errors.403');
            }
            $dataTourUpdate = [
                'name_tour' => $request->name_tour,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'description' => strip_tags($request->description),
                'departure_day' => $request->departure_day,
                'return_day' => $request->return_day,
                'type_vehical' => $request->type_vehical,
                'max_participants' => $request->max_participants,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name_tour, '-'),
                'departure' => $request->departure,
                'destination' => $request->destination,
                'price_adult' => $request->price_adult,
                'price_child' => $request->price_child,
                'price_infant' => $request->price_infant,
            ];
            // dd($dataTourUpdate);
            $dataUploadFeatureImage = $this->storgeImageUpload($request, 'feature_image_path', 'tour');
            // dd($dataUploadFeatureImage);
            if (!empty($dataUploadFeatureImage)) {
                $dataTourUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataTourUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $this->tour->find($tourId)->update($dataTourUpdate);
            $tours = $this->tour->find($tourId);

            // Ảnh chi tiết
            if ($request->hasFile('image_path')) {
                $this->tourImage->where('tour_id', $tourId)->delete();
                foreach ($request->image_path as $fileItems) {
                    $imageDetail = $this->storgeMultiImageUpload($fileItems, 'tour');
                    $tours->images()->create([
                        'image_path' => $imageDetail['file_path'],
                        'image_name' => $imageDetail['file_name']
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('tour.index')->with('ok', 'Sửa tour thành công!');
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
        return $this->deleteModalTrait($id, $this->tour);
    }

    public function listSchedule()
    {
        $tourSchedules = $this->tourSchedule->latest()->paginate(5);
        $schedules = $this->tour->where('t_status', 0)->latest()->limit(5)->get();
        return view('admin.schedule_tour.index', compact('tourSchedules', 'schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $this->tourSchedule->create([
            'tour_id' => $request->tour_id,
            'order_date' => $request->order_date,
            'schedule' => $request->schedule,
            'activity' => $request->activity,
            'description' => $request->description
        ]);

        return redirect()->back()->with('ok', 'Thêm lịch trình thành công!');
    }

    public function editSchedule($id)
    {
        $tourSchedule = $this->tourSchedule->find($id);
        $scheduleRelationship = $tourSchedule->tour;
        return response()->json([
            'code' => 200,
            'tourSchedule' => $tourSchedule,
            'scheduleRelationship' => $scheduleRelationship,
        ], 200);
    }

    public function updateSchedule(Request $request)
    {
        $scheduleId = $request->input('scheduleId');
        if (empty($scheduleId)) {
            return view('errors.403');
        }
        $schedule = $this->tourSchedule->find($scheduleId);
        $schedule->update([
            'tour_id' => $request->tour_id,
            'order_date' => $request->order_date,
            'schedule' => $request->schedule,
            'activity' => $request->activity,
            'description' => $request->description
        ]);
        return redirect()->back()->with('ok', 'Sửa lịch trình thành công!');
    }

    public function destroySchedule($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        $deleteTour = $this->tour->find($id);
        $deleteImageDetail = $deleteTour->images;
        foreach ($deleteImageDetail as $image) {
            $image->delete();
        }
        return $this->deleteModalTrait($id, $this->tourSchedule);
    }
}
