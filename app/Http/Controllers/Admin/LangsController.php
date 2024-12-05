<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breand;
use Illuminate\Http\Request;
use App\Models\Lang;

class LangsController extends Controller
{
    public function index()
    {
        $langs = Lang::all();
        return view('admin.langs.index', [
            'langs' => $langs
        ]);
    }



    public function create()
    {
        return view('admin.langs.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([

        //     'lang' => 'unique|max:255',
        //     'small' => 'unique|max:255',
        // ]);
        $request->validate([
            'small' => 'required|string|unique:langs', // replace your_table_name with the actual table name
        ]);

        $lang = new Lang;

        $lang->lang = $request->lang;
        $lang->small = $request->small;

        $lang->save();

        return redirect()->route('admin.langs.index')->with(['message' => 'Successfully added!']);
    }

    public function destroy($id)
    {
        Lang::find($id)->delete();

        return back()->with(['message' => 'Successfully deleted!']);
    }

}
