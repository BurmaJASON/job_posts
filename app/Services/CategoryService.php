<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class CategoryService
{
    public function createCategory($request) {
        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('category.index');
    }

    public function updateCategory($request, $category) {
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('category.index');
    }

    public function ssdataTable() {
        $lists = Category::withTrashed()->get();
        return DataTables::of($lists)
            ->addColumn('action', function ($value) {
                $edit = '<a href="' . route('category.edit', $value->id) . '" class="btn btn-secondary btn-sm">Edit</a>';
                $del = '<a href="#" class="btn btn-danger text-white btn-sm del-btn ms-2" data-id="' . $value->id . '">Delete</a>';


                if ($value->deleted_at) {
                    $del = '<a href="#" class="btn btn-success text-white btn-sm restore-btn ms-2" data-id="' . $value->id . '">Restore</a>';
                } else {
                    $del = '<a href="#" class="btn btn-danger text-white btn-sm del-btn ms-2" data-id="' . $value->id . '">Delete</a>';
                }
                return '<span>' . $edit . $del . '</span>';
            })
            ->editColumn('created', fn ($value) => Carbon::parse($value->created_at)->format('d M Y'))
            ->make(true);
    }
}

?>
