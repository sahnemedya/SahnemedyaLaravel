<?php

namespace App\Services;

use App\Models\Blade;
use App\Models\Page;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoService
{
    public function store(Request $request)
    {
        $status = "success";
        $message = "Seo Bilgisi Kaydedildi";

        try {
            $page = Page::find($request->page_id);
            $seo = Seo::create([
                "title" => $request->title,
                "description" => $request->description,
                "geo_title" => $request->geo_title,
                "geo_description" => $request->geo_description,
                "canonical" => $request->canonical,
                "page_id" => $request->page_id
            ]);
            $message = $seo->title . ' ' . $message;
            LogService::add("Seo Service Store", $status, $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Seo Bilgisi Kaydedilemedi";
            LogService::add("Seo Service Store", $status, $message . ' => ' . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }

    }


    public function update(Request $request, $id)
    {
        $status = "success";
        $message = "Seo Bilgisi Güncellendi";

        try {
            $page = Page::find($request->page_id);
            $seo = Seo::findOrFail($id);
            $seo->update([
                "title" => $request->title,
                "description" => $request->description,
                "canonical" => $request->canonical,
                "page_id" => $request->page_id
            ]);
            $message = $seo->title . ' ' . $message;
            LogService::add("Seo Service Update", $status, $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Seo Bilgisi Güncellenemedi";
            LogService::add("Seo Service Update", $status, $message . ' => ' . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }

    }

    public function destroy($id)
    {
        try {
            $seo = Seo::findOrFail($id);
            $seo->delete();
            $status = "success";
            $message = $seo->title . " Seo Bilgisi Silindi";
            LogService::add("Seo Service Destroy", $status, $message);
            return ["status" => $status, "message" => $message];
        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Seo Bilgisi Silinemedi";
            LogService::add("Seo Service Destroy", $status, $message);
            return ["status" => $status, "message" => $message];
        }
    }


}
