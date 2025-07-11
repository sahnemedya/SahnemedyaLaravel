<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeoStoreRequest;
use App\Models\Page;
use App\Models\Seo;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seos = Seo::all();
        return view('cms.seo.index', compact('seos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Cache::remember('pages', now()->addDay(), function () {
            return Page::all();
        });
        return view('cms.seo.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeoStoreRequest $request)
    {
        $result = $this->seoService->store($request);
        return redirect()->route('cms.seos.index')
            ->with('status', $result['status'])
            ->with('message', $result['message']);
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
    public function edit(string $id)
    {
        $pages = Cache::remember('pages', now()->addDay(), function () {
            return Page::all();
        });
        $seo = Seo::find($id);
        return view('cms.seo.edit', compact('pages', 'seo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeoStoreRequest $request, string $id)
    {
        $result = $this->seoService->update($request,$id);
        return redirect()->route('cms.seos.index')
            ->with('status', $result['status'])
            ->with('message', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->seoService->destroy($id);
        return response()->json(['status' => $result['status'], 'message' => $result['message']]);
    }
}
