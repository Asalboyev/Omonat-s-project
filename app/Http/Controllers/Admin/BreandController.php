<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breand;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BreandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $languages = Lang::all();
        $breands = Breand::query()->paginate(10);
        return view('admin.langs.b-index',compact('languages','breands',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function ajax(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('upload/logo', $imageName, 'public');

            return response()->json(['success' => $path]);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('upload/logo', 'public');
            $data['photo'] = $path;
        }
        Breand::create($data);
        return redirect()->route('admin.breands.index')->with(['message' => 'Successfully added!']);

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
    public function edit(Breand $breand)
    {
        return view('admin.langs.edit',compact('breand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
//            'product_category_id.uz' => 'required'


        ]);

        $breand = Breand::findOrFail($id);
        $data = $request->all();

        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }
        $breand->update($data);

        return redirect()->route('admin.breands.index')->with(['message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $breand = Breand::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($breand->photo) {
            Storage::disk('public')->delete($breand->photo);
        }

        $breand->delete();

        return redirect()->route('admin.breands.index')->with(['message' => 'Successfully deleted!']);
    }
    public function search(Request $request)
    {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $categories = Breand::where('title', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $breands = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.langs.search', compact('breands', 'search_word'));
    }

}
