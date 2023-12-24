<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Post_dislike;
use App\Models\Post_like;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('post_comment')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Post',
            'data' => $posts
        ]);
    }
    public function search($keyword = '')
    {
        $this->keyword = $keyword;

       $posts =  Post::with('post_comment')->with('user')->whereHas('user', function (Builder $query) {
            $query->where('name', 'like', $this->keyword .'%');
        })->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Post',
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Post::with('post_comment')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Post',
            'data' => $post
        ]);
    }
    public function showBy($id_user)
    {
        $post = Post::with('post_comment')->where('id_user', $id_user)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Post',
            'data' => $post
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = Post::create([
            'id_user' => $request->id_user,
            'title' => $request->title,
            'content' => $request->content,
            'published_date' => date('Y-m-d H:i:s'),
            'id_status' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success Insert Post',
            'data' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = Post::find($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success Update Post',
            'data' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success Deleted Post',
            'data' => $post
        ]);
    }

    public function like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post_like = Post_like::where('id_post', $request->id_post)->where('id_user', $request->id_user)->first();
        if ($post_like) {
            $post_like->delete();
        } else {
            Post_like::create([
                'id_post' => $request->id_post,
                'id_user' => $request->id_user,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success Like Post',
        ]);
    }
    public function dislike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post_dislike = Post_dislike::where('id_post', $request->id_post)->where('id_user', $request->id_user)->first();
        if ($post_dislike) {
            $post_dislike->delete();
        } else {
            Post_dislike::create([
                'id_post' => $request->id_post,
                'id_user' => $request->id_user,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success dislike Post',
        ]);
    }
}
