<?php

namespace App\Trait;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait StorageImageTrait{
    public function storgeImageUpload($request, $fieldName, $folderName){
        if($request->hasFile($fieldName)){
            $file = $request->$fieldName;
            // Lấy tên file gốc
            $fileNameOrigin = $file->getClientOriginalName();
            // tên file trên hệ thống
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);

            $dataUploadTrait = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($filePath)
            ];
            return $dataUploadTrait;
        }else{
            return null;
        }
    }

    public function storgeMultiImageUpload($file, $folderName){
            // Lấy tên file gốc
            $fileNameOrigin = $file->getClientOriginalName();
            // tên file trên hệ thống
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);

            $dataUploadTrait = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($filePath)
            ];
            return $dataUploadTrait;
    }
}
