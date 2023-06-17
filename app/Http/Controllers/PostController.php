<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\PostService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.index');
    }

    public function queryTable()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, PostService $postService)
    {
        return $postService->createPost($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',[
            'post' => $post,
            'categories' => Category::orderBy('name', 'asc')->get()
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post, PostService $postService)
    {
        return $postService->updatePost($request, $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $post->delete();
    }
}
