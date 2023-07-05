<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;


class PostService
{
    public function createPost($request) {
        Post::create([
            'name' => $request->name,
            'salary' => $request->salary,
            'category_id' => $request->category_id,
            'requirements' => $request->requirements,
            'job_desc' => $request->job_desc,
            'info' => $request->info,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('post.index')->with('success', 'Successfully Created');
    }

    public function tableList() {
        $lists = Post::with(['category', 'user'])->latest()->get();
        return DataTables::of($lists)
            ->addColumn('action', function ($value) {
                $show = '<a href="' . route('post.show', $value->id) . '" class="btn btn-primary btn-sm">Show</a>';

                $edit = '<a href="' . route('post.edit', $value->id) . '" class="btn btn-secondary btn-sm ml-2">Edit</a>';

                $del = '<a href="#" class="btn btn-danger text-white btn-sm del-btn ms-2" data-id="' . $value->id . '">Delete</a>';

               return '<span>' . $show . $edit . $del . '</span>';
            })
            ->editColumn('id', function () {
                static $counter = 1;
                return $counter++;
            })
            ->editColumn('category',fn($value) => $value->category->name)
            ->editColumn('owner',fn($value) => $value->user->name)
            ->editColumn('created', fn ($value) => Carbon::parse($value->created_at)->format('d M Y'))
            ->make(true);
    }


    public function updatePost($request, $post) {
        $post->update([
            'name' => $request->name,
            "salary" => $request->salary,
            "category_id" => $request->category_id,
            "requirements" => $request->requirements,
            'job_desc' => $request->job_desc,
            "info" => $request->info
        ]);
        return redirect()->route('post.index')->with('success', 'Successfully Updated');
    }
}

?>
