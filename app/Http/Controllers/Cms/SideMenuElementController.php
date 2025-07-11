<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Models\Category;
use App\Models\Page;
use App\Services\SideMenuElementService;
use Illuminate\Http\Request;

class SideMenuElementController extends Controller
{
    protected SideMenuElementService $sideMenuElementService;

    public function __construct(SideMenuElementService $sideMenuElementService)
    {
        $this->sideMenuElementService = $sideMenuElementService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $result = $this->sideMenuElementService->index($id);
        return view('cms.sideMenuElements.index')->with([
            'category' => $result['category'],
            'pages' => $result['pages'],
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $result = $this->sideMenuElementService->create($id);

        // Sadece blog kategorisi için ana sayfa ve blade'i bul
        $mainPage = null;
        $blogDetailBlade = null;

        if (isset($result['category']) && isset($result['pages']) && isset($result['blades'])) {
            // Kategori "blog" ise
            if (strtolower($result['category']->title) == 'blog' || strtolower($result['category']->name) == 'blog') {
                // Ana sayfayı bul
                $mainPage = collect($result['pages'])->where('name', $result['category']->title)->first();

                // Blog-detay blade'ini bul
                $blogDetailBlade = collect($result['blades'])->where('name', 'Blog Detay')->first();
            }
        }
        return view('cms.sideMenuElements.create')
            ->with([
                'category' => $result['category'],
                'pages' => $result['pages'],
                'blades' => $result['blades'],
                'languages' => $result['languages'],
                'mainPage' => $mainPage,
                'blogDetailBlade' => $blogDetailBlade,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $result = $this->sideMenuElementService->store($request);

        return redirect()->route('cms.side-menu-elements.index', $request->category_id)
            ->with([
                'status' => $result['status'],
                'message' => $result['message']
            ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($categoryId, $pageId)
    {
        $result = $this->sideMenuElementService->edit($categoryId, $pageId);
        if ($result['status'] === "success") {
            return view('cms.sideMenuElements.edit')
                ->with([
                    'category' => $result['category'],
                    'categories' => $result['categories'],
                    "page" => $result['page'],
                    'pages' => $result['pages'],
                    'blades' => $result['blades'],
                    'languages' => $result['languages'],
                ]);
        } else {
            return redirect()->route('cms.side-menu-elements.index', $categoryId)
                ->with(['status' => $result['status'], 'message' => $result['message']]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $pageId)
    {
        $result = $this->sideMenuElementService->update($request, $pageId);
        if ($result['status'] == "success" && $result["category"]->show_panel != 1) {
            return redirect()->route('cms.page.index');
        }
        return redirect()->route('cms.side-menu-elements.index', $request->category_id)
            ->with([
                "status", $result['status'],
                "message", $result['message']
            ]);
    }

    public function deleted($categoryId)
    {
        $pages = Page::onlyTrashed()->where("category_id", $categoryId)->where("is_main", 0)->get();
        $category = Category::find($categoryId);
        if ($category) {
            return view('cms.sideMenuElements.deleted', [
                'category' => $category,
                'pages' => $pages,
            ]);
        } else {
            return view('cms.category.index', [
                "status" =>"error",
                "message"=> "Ardığınız Menu Bulunamadı."

        ]);
        }
    }
}
