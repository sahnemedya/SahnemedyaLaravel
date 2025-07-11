<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Models\Blade;
use App\Models\Category;
use App\Models\Language;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pages = Page::where('is_main',1)->get();
        return view('cms.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select("id", "name")->get();
        $blades = Blade::select("id", "name")->get();
        $languages = Language::select("id", "name")->get();
        $pages = Page::select("id", "title")->get();
        return view('cms.pages.create', compact('categories', 'blades', 'languages', 'pages'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $result = $this->pageService->store($request);
        return redirect()->route('cms.pages.index')->with("status", $result['status'])->with("message", $result['message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $categories = Category::select("id", "name")->get();
        $blades = Blade::select("id", "name")->get();
        $languages = Language::select("id", "name")->get();
        $pages = Page::select("id", "title")->where("id", "!=", $id)->get();
        $page = Page::find($id);
        return view('cms.pages.edit', compact('categories', 'blades', 'languages', 'page', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, string $id)
    {
        $result = $this->pageService->update($request, $id);
        return redirect()->route('cms.pages.index')->with("status", $result['status'])->with("message", $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->pageService->destroy($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message'],
        ]);
    }

    /**
     * Sayfanın Yayınlanmasını sağlamak için kullanabilirsiniz.
     * @param string $id
     * @return JsonResponse
     */
    public function publishPage(string $id): JsonResponse
    {
        $result = $this->pageService->publishPage($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message'],
        ]);
    }
//    public function activate(Request $request, string $id)
//    {
//        $result = $this->pageService->activate($request, $id);
//        return response()->json($result);
//    }
    /**
     * Silinen kayıtları listeler
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function deleted()
    {
        $pages = Page::onlyTrashed()->where("is_main",1)->get();
        return view('cms.pages.deleted', compact('pages'));
    }

    public function restore(string $id): JsonResponse
    {
        $result = $this->pageService->restore($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function forceDelete(string $id)
    {
        $result = $this->pageService->forceDelete($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }

}
