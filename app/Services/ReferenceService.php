<?php

namespace App\Services;


use App\Models\References;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferenceService
{
    protected CommonService $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function store(Request $request)
    {
        $status = "success";
        $message = "Referans Kaydedildi";

        try {
            $slug = Str::slug($request->name, "-");
            $image = NULL;

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $extension = $imageFile->guessExtension();
                $image = $slug . "." . $extension;
                $this->commonService->uploadFile(config('constants.references_path'), $imageFile, $image);
            }

            $reference = References::create([
                'name' => $request->name,
                'type' => $request->type,
                'image' => $image,
                'hit' => $request->hit,
                'url' => $request->url,
                'lang_id' => $request->lang_id,
            ]);

            LogService::add("Reference Service Store", $status, $message);
            return ["status" => $status, "message" => $message];

        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Referans Kaydedilemedi";
            LogService::add("Reference Service Store", $status, $message . " => " . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }

    public function destroy($id)
    {
        $status = "success";
        $message = "Refeans Silindi";
        try {
            $reference = References::findOrFail($id);
            $reference->delete();
            $deleteReference = $this->commonService->deleteFile(config("constants.references_path"), $reference->image);
            LogService::add("Reference Service Destroy", $status, $reference->name . " " . $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Referans Silinemedi";
            LogService::add("Reference Service Destroy", $status, $message . " => " . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }

    public function publish($id)
    {
        $status = "success";
        $message = "Referans Yayınlandı";
        try {
            $reference = References::findOrFail($id);
            if ($reference->published == 1) {
                $reference->update(["published" => 0]);
                $message = "Referans Yayından Kaldırıldı.";
            } else {
                $reference->update(["published" => 1]);
                $message = "Referans Yayınlandı";
            }
            LogService::add("Pop-Up Service Publish", $status, $reference->title . " " . $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Referans Yayın İşlemi Başarısız";
            LogService::add("Pop-Up Service Publish", $status, $message . " => " . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }

}
