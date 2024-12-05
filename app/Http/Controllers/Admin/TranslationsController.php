<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Lang;
use App\Models\Group;

class TranslationsController extends Controller
{
    public function index() {
        $translations = Translation::orderBy('id', 'desc')->paginate(10);
        $languages = Lang::all();
        $groups = Group::all();

        return view('admin.translations.index', [
            'translations' => $translations,
            'languages' => $languages,
            'groups' =>$groups,
        ]);
    }


    public function create($id) {

        $group = Group::findOrFail($id);
        $languages = Lang::all();
        // $translation = Translation::all();
        $translation = Translation::where('group_id', $group->id)->get();

        return view('admin.translations.edit', [
            'translation' => $translation,
            'languages' => $languages,
            'group' => $group,
        ]);
    }

    public function update(Request $request, $groupId)
{
    $request->validate([
        'key.*' => 'required|unique:translations,key,' . $groupId . ',group_id',
        // 'val.*.uz' => 'required',
    ]);

    $group = Group::find($groupId);
    $keys = $request->input('key');
    $translationIds = $request->input('group_id');
    $values = $request->input('val');

    if (is_array($translationIds) || is_object($translationIds)) {
        foreach ($translationIds as $index => $translationId) {
            $key = $keys[$index];
            $value = $values[$index];

            if (!empty($translationId)) {
                // Update existing translation
                $translation = Translation::find($translationId);

                if ($translation->key !== $key) {
                    $existingTranslation = Translation::where('key', $key)->where('group_id', $groupId)->first();
                    if ($existingTranslation) {
                        return redirect()->back()->withErrors(['key' => "The key '{$key}' is already in use for this group."]);
                    }
                }

                $translation->key = $key;
            } else {
                // Create new translation
                $existingTranslation = Translation::where('key', $key)->where('group_id', $groupId)->first();
                if ($existingTranslation) {
                    return redirect()->back()->withErrors(['key' => "The key '{$key}' is already in use for this group."]);
                }

                $translation = new Translation();
                $translation->group_id = $groupId;
                $translation->key = $key;
            }

            $translation->val = $value;
            $translation->save();
        }
    }

    return redirect()->route('admin.group.show', $request->id)->with(['message' => 'Translations updated successfully.']);
}



    public function edit() {
        $languages = Lang::all();
        return view('admin.translations.create',compact('languages'));
    }

    public function tr_update(Request $request, $id) {
        // dd($request->all());
        $request->validate([
            'key' => 'required|unique:groups,name',
            // 'val' => 'required|max:255',
          ]);

          $translation = Translation::find($id);

          $translation->key = $request->key;
          $translation->val = $request->val;

          $translation->save();

          return redirect()->back()->with(['message' => 'Successfully added!']);
        }

    public function destroy($id) {


        Translation::find($id)->delete();
        return back()->with(['message' => 'Successfully deleted!']);
    }


    public function search(Request $request) {

        $languages = Lang::all();
        $a = Translation::all();
        $groups = Group::all();
        $cc = mb_strtolower($request->search);
        $search_word = $request->search;

        $result = collect();

        foreach ($a as $item) {
            foreach ($languages as $lang) {
                $langKey = 'val->'.$lang->small;

                // Check if the language key exists in the item's 'val' array
                if (isset($item->val[$lang->small])) {
                    // Convert language value to lowercase
                    $c[$lang->small] = mb_strtolower($item->val[$lang->small]);
                    $item->val = $c;

                    // Check if the lowercase language value contains the search term
                    if (stripos($item->val[$lang->small], $cc) !== false) {
                        // Add item to the result collection
                        $result->push($item);
                        break; // Break the loop if found to avoid duplicates
                    }
                }
            }
        }

        return view('admin.translations.search', compact([
            'result',
            'search_word',
            'languages',
            'groups'
        ]));

    }

    public function group_store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:groups,name',
        'subtext' => 'required|unique:groups,subtext',
    ]);

    $group = Group::create($request->all());
    return redirect()->back()->with(['message' => 'Successfully added!']);
}

public function group_show($id)
{
    $group = Group::findOrFail($id);
    $groups = Group::all();
    $languages = Lang::all();
    $translations = Translation::where('group_id', $group->id)->latest()->paginate(10);

    $currentRoute = \Route::current(); // Joriy ro'yxat ma'lumoti

    return view('admin.translations.show', [
        'translations' => $translations,
        'languages' => $languages,
        'group' => $group,
        'groups' => $groups,
        'id' => $id
    ]);
}

}
