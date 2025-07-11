<?php

namespace App\Services;

use App\Models\Blade;
use App\Models\Category;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SideMenuElementService
{
    protected CommonService $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function index($id)
    {
        $status = "success";
        $message = "Kategori Alt Sayfaları Çekildi.";
        try {
            $category = Category::findOrFail($id);
            $pages = $category->subPages()->get();
            LogService::add("Side Menu Element Service Index", $status, $message);
            return [
                "status" => $status,
                "message" => $message,
                "pages" => $pages,
                "category" => $category
            ];

        } catch (\Exception $exception) {
            $status = "error";
            $message = "Kategori Alt Sayfaları Çekilemedi.";
            LogService::add("Side Menu Element Service Index", $status, $message." => ".$exception->getMessage());
        }
    }

    public function create($id)
    {
        $status = "success";
        $message = "Kategoriye Alt Sayfa Eklemek İçin Gerekli Veriler Çekildi.";
        try {
            $category = Category::select("id", "name")->where('id', $id)->first();
            $blades = Blade::select("id", "name")->get();
            $languages = Language::select("id", "name")->get();
            $pages = Page::select("id", "title")
                ->where('category_id',$id)
                ->orderBy('is_main','desc')
                ->orderBy('title','asc')
                ->get();
            LogService::add("Side Menu Element Service Create", $status, $message);
            return [
                "status" => $status,
                "message" => $message,
                "pages" => $pages,
                "category" => $category,
                "blades" => $blades,
                "languages" => $languages
            ];
        }catch (\Throwable $exception){
            $status = "error";
            $message = "Kategoriye Alt Sayfa Eklemek İçin Gerekli Veriler Çekilemedi.";
            LogService::add("Side Menu Element Service Create", $status, $message." => ".$exception->getMessage());
            return [
                "status" => $status,
                "message" => $message,
            ];
        }
    }

    public function store(Request $request)
    {
        $status = "success";
        $message = "Sayfa Kaydedildi";

        try {
            $page = Page::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content_text,
                'hit' => $request->hit,
                'category_id' => $request->category_id,
                "parent_page" => $request->parent_page,
                'blade_id' => $request->blade_id,
                'translation_of' => $request->translation_of,
                'lang_id' => $request->lang_id,
                'is_main' => 0
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->guessExtension();
                $fileName = $page->slug . '.' . $extension;
                $this->commonService->uploadFile(config('constants.page_path'), $file, $fileName);
                $page->update([
                    "image" => $fileName,
                ]);
                LogService::add("Side Menu Element Service Store", "success", $page->title . ' Sayfa Resmi Kaydedildi');
            }
            return ["status" => $status, "message" => $message,"category" => $page->category_id];

        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Kaydedilemedi";
            LogService::add("Side Menu Element Service Store ", $status, $message . ' => ' . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }

    public function edit($categoryId,$pageId)
    {
        $status = "success";
        $message = "Kategori Alt Sayfa Bilgileri Çekildi";

        try {
            $category = Category::findOrFail($categoryId);
            $categories= Category::orderBy('name','asc')->get();
            $page=Page::findOrFail($pageId);
            $blades = Blade::select("id", "name")->get();
            $languages = Language::select("id", "name")->get();
            $pages = Page::select("id", "title")
                ->where("id", "!=", $category->id)
                ->where("category_id",$categoryId)
                ->orderBy('is_main','desc')
                ->orderBy('title','asc')
                ->get();
            LogService::add("Side Menu Element Service Edit", $status, $message);
            return [
                "status" => $status,
                "message" => $message,
                "category" => $category,
                "categories" => $categories,
                "page" => $page,
                "pages" => $pages,
                "blades" => $blades,
                "languages" => $languages
            ];
        }catch (\Throwable $exception){
            $status = "error";
            $message = "Kategori Alt Sayfa Bilgileri Çekilemedi";
            LogService::add("Side Menu Element Service Edit", $status, $message." => ".$exception->getMessage());
            return ["status" => $status, "message" => $message];

        }
    }
    public function update(Request $request, $pageId)
    {
        $status = "success";
        $message = "Kategori Alt Sayfası Güncellendi";

        try {
            $page = Page::findOrFail($pageId);
            $category = Category::findOrFail($request->category_id);

            // Resim Silinmesi İstenmişse Resim Silinir.
            if ($request->removeImage) {
                // $page->image null değilse sil
                if ($page->image) {
                    $this->commonService->deleteFile(config('constants.page_path'), $page->image);
                }
                $page->update(["image" => NULL]);
            }

            if ($request->hasFile('image')) {
                // Mevcut resmi sil (null değilse)
                if ($page->image) {
                    $this->commonService->deleteFile(config('constants.page_path'), $page->image);
                }
                $file = $request->file('image');
                $extension = $file->guessExtension();
                $fileName = $page->slug . '-' . Str::lower(Str::random(4)) . '.' . $extension;
                $this->commonService->uploadFile(config('constants.page_path'), $file, $fileName);
                $page->update(["image" => $fileName]);
            }

            if (!$request->removeImage && !$request->hasFile('image') && $page->image) {
                // Resmin adı değişmesi gerekiyorsa
                if ($request->slug != $page->slug) {
                    $extension = pathinfo($page->image, PATHINFO_EXTENSION);
                    $newImageName = $request->slug . '-' . Str::lower(Str::random(4)) . '.' . $extension;
                    $this->commonService->renameFile(config('constants.page_path'), $page->image, $newImageName);
                    $page->update(["image" => $newImageName]);
                }
            }

            $page->update([
                "title" => $request->title,
                "slug" => $request->slug,
                "content" => $request->content_text,
                "hit" => $request->hit,
                "blade_id" => $request->blade_id,
                "category_id" => $request->category_id,
                "translation_of" => $request->translation_of,
                "parent_page" => $request->parent_page,
                "lang_id" => $request->lang_id
            ]);

            LogService::add("Side Menu Element Service Update", $status, $message);
            return ["status" => $status, "message" => $message,"category" => $category];

        } catch (\Throwable $exception) {
            $status = "error";
            $message = "Kategori Alt Sayfası Güncellenemedi";
            LogService::add("Side Menu Element Service Update ", $status, $message . ' => ' . $exception->getMessage());
            return ["status" => $status, "message" => $message];
        }
    }
//    public function update(Request $request, $pageId)
//    {
//        $status = "success";
//        $message = "Kategori Alt Sayfası Güncellendi";
//
//        try {
//            $page = Page::findOrFail($pageId);
//            $category = Category::findOrFail($request->category_id);
////            Resim Silinmesi İstenmişse Resim Silinir.
//            if ($request->removeImage) {
//                $this->commonService->deleteFile(config('constants.page_path'), $page->image);
//                $page->update(["image" => NULL]);
//            }
//            if ($request->hasFile('image')) {
//                $this->commonService->deleteFile(config('constants.page_path'), $page->image);
//                $file = $request->file('image');
//                $extension = $file->guessExtension();
//                $fileName = $page->slug . '-' . Str::lower(Str::random(4)) . '.' . $extension;
//                $this->commonService->uploadFile(config('constants.page_path'), $file, $fileName);
//                $page->update(["image" => $fileName]);
//            }
//            if (!$request->removeImage && !$request->hasFile('image') && $page->image) {
////                Resmin adı değişmesi gerekiyorsa
//                if ($request->slug != $page->slug) {
//                    $extension = pathinfo($page->image, PATHINFO_EXTENSION);
//                    $newImageName = $request->slug . '-' . Str::lower(Str::random(4)) . '.' . $extension;
//                    $this->commonService->renameFile(config('constants.page_path'), $page->image, $newImageName);
//                    $page->update(["image" => $newImageName]);
//                }
//            }
//            $page->update([
//                "title" => $request->title,
//                "slug" => $request->slug,
//                "content" => $request->content_text,
//                "hit" => $request->hit,
//                "blade_id" => $request->blade_id,
//                "category_id" => $request->category_id,
//                "translation_of" => $request->translation_of,
//                "parent_page" => $request->parent_page,
//                "lang_id" => $request->lang_id
//            ]);
//
//            LogService::add("Side Menu Element Service Update", $status, $message);
//            return ["status" => $status, "message" => $message,"category" => $category];
//
//        } catch (\Throwable $exception) {
//            $status = "error";
//            $message = "Katefori Alt Sayfası Güncellenemedi";
//            LogService::add("Side Menu Element Service Update ", $status, $message . ' => ' . $exception->getMessage());
//            return ["status" => $status, "message" => $message];
//        }
//    }

    public function deleted($categoryId)
    {

    }


}































