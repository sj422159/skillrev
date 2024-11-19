<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ContentController extends Controller
{
    // Display the form for creating content
    public function create()
    {
        // Fetch categories using raw DB queries
        $categories = DB::table('categories')->get();

        // Assuming content types are stored in a similar way
        $contenttypes1 = DB::table('contenttypes')->get();
        $contenttypes2 = DB::table('contenttypes')->get();
        $contenttypes3 = DB::table('contenttypes')->get();
        $contenttypes4 = DB::table('contenttypes')->get();

        return view('controller.content.create', compact('categories', 'contenttypes1', 'contenttypes2', 'contenttypes3', 'contenttypes4'));
    }

    // Save the content data
    public function store(Request $request)
    {
        // Handle the form submission logic (validation, file uploads, saving data)
        $validated = $request->validate([
            'category' => 'required',
            'domain' => 'required',
            'skillset' => 'required',
            'skillattribute' => 'required',
            'contenttype1' => 'required',
            'file1' => 'nullable|file',
            'video3' => 'nullable|url',
        ]);

        // Save data logic...
    }

    // Fetch subbranch data based on the category
    public function getSubBranch($category_id)
    {
        // Fetch subbranch data directly from the database
        $subbranches = DB::table('domains')->where('category', $category_id)->get();
        return response()->json($subbranches);
    }

    // Fetch skillset data based on the domain (subbranch)
    public function getSkillset($domain_id)
    {
        // Fetch skillset data directly from the database
        $skillsets = DB::table('skillsets')->where('subbranch_id', $domain_id)->get();
        return response()->json($skillsets);
    }

    // Fetch skill attributes based on the skillset
    public function getSkillattribute($skillset_id)
    {
        // Fetch skill attribute data directly from the database
        $skillattributes = DB::table('skillattributes')->where('skillset_id', $skillset_id)->get();
        return response()->json($skillattributes);
    }
}
