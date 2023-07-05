<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tag;
use Yajra\DataTables\DataTables;


class TagService {

    public function createTag($request) {
        Tag::create([
            'name' => $request->name
        ]);
        return redirect()->route('tag.index')->with('created', 'Successfully Created!');
    }

    public function updateTag($request,$tag) {
        $tag->update([
            'name' => $request->name
        ]);
        return redirect()->route('tag.index')->with('updated','Successfully Updated!');
    }

    public function dataTable () {
        $lists = Tag::latest()->get();
        return DataTables::of($lists)
            ->addColumn('action', function ($value) {
                $edit = '<a href="' . route('tag.edit', $value->id) . '" class="btn btn-secondary btn-sm">Edit</a>';
                $del = '<a href="#" class="btn btn-danger text-white btn-sm del-btn ms-2" data-id="' . $value->id . '">Delete</a>';
                return '<span>' . $edit . $del . '</span>';
            })
            ->editColumn('id', function () {
                static $counter = 1;
                return $counter++;
            })
            ->editColumn('created', fn ($value) => Carbon::parse($value->created_at)->format('d M Y'))
            ->make(true);
    }
}



?>
