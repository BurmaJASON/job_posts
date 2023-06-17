<?php

namespace App\Services;

use App\Models\Post;


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
