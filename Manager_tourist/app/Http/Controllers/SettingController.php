<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Trait\DeleteModalTrait;

class SettingController extends Controller
{
    use DeleteModalTrait;
    private $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    public function index(Request $request)
    {

        $settings = $this->setting->latest()->paginate(5);
        // dd($category);
        $key = request()->key;
        if ($key) {
            $settings = $this->setting->where('name', 'like', "%{$key}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('admin.setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $this->setting->create([
            'config_key' => $request->config_key,
            'config_value' => $request->config_value,
        ]);
        return redirect()->route('setting.index')->with('ok', 'Danh mục đã được thêm thành công !');
    }

    public function edit($id)
    {
        $settings = $this->setting->find($id);

        return response()->json([
            'code' => 200,
            'setting' => $settings,
        ], 200);
    }

    public function update(Request $request)
    {
        $settingId = $request->input('settingId');
        if(empty($settingId)){
            return view('errors.403');
        }
        $settings = $this->setting->find($settingId);
        $settings->update([
            'config_key' => $request->config_key,
            'config_value' => $request->config_value,
        ]);
        return redirect()->route('setting.index')->with('ok', 'Đã sửa cài đặt thành công !');
    }

    public function destroy($id)
    {
        if (empty($id)) {
            return view('errors.403');
        }
        return $this->deleteModalTrait($id, $this->setting);
    }
}
