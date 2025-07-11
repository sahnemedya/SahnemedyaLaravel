<?php

namespace App\Services;

use App\Models\Blade;
use App\Models\Category;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;

class DoctorService
{
    protected CommonService $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
        //$this->commonService-> olarak kullanılacak
    }

    public function store(Request $request)
    {
        $status = 'success';
        $message = 'Doktor Kaydedildi';

        try {
            $defaultName = $request->doctor_title . " " . $request->name . " " . $request->surname;
            $imageName = NULL;
            $image2Name = NULL;

            if ($request->hasFile("image")) {
                $image = $request->file("image");
                $extension = $image->guessExtension();
                $imageName = Str::slug($defaultName, "-") . "." . $extension;
                $upload = $this->commonService->uploadFile(config("contants.doctor_path"), $image, $imageName);
            }
            if ($request->hasFile("image2")) {
                $image = $request->file("image2");
                $extension = $image->guessExtension();
                $image2Name = Str::slug($defaultName, "-") . "-2." . $extension;
                $upload = $this->commonService->uploadFile(config("contants.doctor_path"), $image, $image2Name);
            }

            $doctor = Doctor::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'doctor_title' => $request->doctor_title,
                'medical_unit' => $request->medical_unit,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imageName,
                'image2' => $image2Name,
            ]);

            LogService::add("Doctor Service Store", $status, $defaultName . " " . $message);
            return [
                "status" => $status,
                "message" => $message,
            ];

        } catch (\Throwable $exception) {
            $status = 'error';
            $message = "Doktor Bilgisi Kaydedilemedi";
            LogService::add("Doctor Service Store", $status, $message . " => " . $exception->getMessage());
            return [
                "status" => $status,
                "message" => $message,
            ];
        }

    }

    public function edit($id)
    {
        $status = 'success';
        $message = 'Doktor Bulundu.';
        try {
            $doctor = Doctor::findOrFail($id);
            $medicalUnit = Category::where("is_medical_unit", 1)->first();
            return [
                "status" => $status,
                "message" => $message,
                "doctor" => $doctor,
                "medicalUnit" => $medicalUnit,
            ];
        } catch (\Throwable $exception) {
            $status = 'error';
            $message = "Doktor Bulunamadı.";
            LogService::add("Doctor Service Edit", $status, $message . " => " . $exception->getMessage());
            return [
                "status" => $status,
                "message" => $message,
            ];
        }
    }

    public function update(Request $request, $id)
    {
        $status = 'success';
        $message = 'Doktor Bilgileri Güncellendi';
        $doctor = NULL;
        try {
            $doctor = Doctor::findOrFail($id);
            $defaultName = $request->doctor_title . " " . $request->name . " " . $request->surname;
            $imageName = NULL;
            $image2Name = NULL;

            if ($request->hasFile("image")) {
                if ($doctor->image) {
                    $deleteImage = $this->commonService->deleteFile(config("constants.doctor_path"), $doctor->image);
                }
                $image = $request->file("image");
                $extension = $image->guessExtension();
                $imageName = Str::slug($defaultName, "-") . "." . $extension;
                $upload = $this->commonService->uploadFile(config("contants.doctor_path"), $image, $imageName);
            }
            if ($request->hasFile("image2")) {
                if ($doctor->image2) {
                    $deleteImage = $this->commonService->deleteFile(config("constants.doctor_path"), $doctor->image2);
                }
                $image = $request->file("image2");
                $extension = $image->guessExtension();
                $image2Name = Str::slug($defaultName, "-") . "-2." . $extension;
                $upload = $this->commonService->uploadFile(config("contants.doctor_path"), $image, $image2Name);
            }

            $doctor->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'doctor_title' => $request->doctor_title,
                'medical_unit' => $request->medical_unit,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imageName,
                'image2' => $image2Name,
            ]);
            LogService::add("Doctor Service Update", $status, $defaultName . " " . $message);

            return ["status" => $status, "message" => $message];


        } catch (\Throwable $exception) {
            $status = 'error';
            $message = "Doktor Bilgisi Güncellenemedi.";
            if ($doctor != NULL) {
                LogService::add("Doctor Service Update", $status, $doctor->doctor() . $message . " => " . $exception->getMessage());
            } else {
                LogService::add("Doctor Service Update", $status, $message . " => " . $exception->getMessage());
            }
            return ["status" => $status, "message" => $message];

        }

    }

    public function destroy($id)
    {
        $status = 'success';
        $message = 'Doktor Bilgisi Silindi.';
        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->delete();
            LogService::add("Doctor Service Destroy", $status, $doctor->doctor() . " " . $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = 'error';
            $message = "Doktor Bilgisi Silinemedi.";
            LogService::add("Doctor Service Destroy", $status, $message . " => " . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }

    public function deleted()
    {
        $status = 'success';
        $message = 'Silinen Doktorlar Listelendi.';
        try {
            $doctors = Doctor::onlyTrashed()->get();
            return [
                "status" => $status,
                "message" => $message,
                "doctors" => $doctors
            ];
        } catch (\Throwable $exception) {
            $status = 'error';
            $message = "Silinen Doktorlar Listelenemedi.";
            LogService::add("Doctor Service Deleted", $status, $message . " => " . $exception->getMessage());
            return [
                "status" => $status,
                "message" => $message,
            ];
        }
    }

    public function forceDelete($id)
    {
        $status = 'success';
        $message = 'Doktor Silindi.';
        try {
            $doctor = Doctor::onlyTrashed()->where('id', $id)->firstOrFail();
            $doctor->forceDelete();
            if($doctor->image){
                $this->commonService->deleteFile(config('constants.doctor_path'), $doctor->image);
            }
            if($doctor->image2){
                $this->commonService->deleteFile(config('constants.doctor_path'), $doctor->image2);
            }
            $message = $doctor->doctor() . ' Doktor Silindi.';
            LogService::add("Doctor Service ForceDelete", $status, $message);
            return ['status' => $status, 'message' => $message];
        } catch (\Throwable $exception) {
            $status = 'error';
            $message = $doctor->doctor() . ' Kategori Silinemedi.';
            LogService::add("Doctor Service ForceDelete", $status, $message . ' => ' . $exception->getMessage());
            return ['status' => $status, 'message' => $message];
        }
    }

    public function restore($id)
    {
        $status = 'success';
        $message = 'Doktor Geri Yüklendi.';
        try {
            $doctor = Doctor::onlyTrashed()->where('id', $id)->firstOrFail();
            $doctor->restore();
            $message = $doctor->doctor() . ' Kategori Geri Yüklendi.';
            LogService::add("Doctor Service Restore", $status, $message);
            return ['status' => $status, 'message' => $message];
        } catch (\Throwable $exception) {
            $status = 'error';
            $message = 'Doktor Geri Yüklenemedi.';
            LogService::add("Doctor Service Restore", $status, $message . ' => ' . $exception->getMessage());
            return ['status' => $status, 'message' => $message];
        }
    }


}
