<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\References;
use App\Services\CommonService;
use App\Services\ReferenceService;
use Illuminate\Http\Request;

class ReferencesController extends Controller
{
    protected ReferenceService $referenceService;

    public function __construct(ReferenceService $referenceService)
    {
        $this->referenceService = $referenceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $references = References::all();
        return view('cms.references.index', compact('references'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('cms.references.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->referenceService->store($request);
        return redirect()->route('cms.references.index')
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->referenceService->destroy($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function publish($id)
    {
        $result = $this->referenceService->publish($id);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }
}
