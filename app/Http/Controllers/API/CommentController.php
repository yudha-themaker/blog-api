<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment_dislike;
use App\Models\Comment_like;
use App\Models\Post_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function add_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_post' => 'required',
            'id_user' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Post_comment::firstOrCreate([
            'id_post' => $request->id_post,
            'id_user' => $request->id_user,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success Like Post',
        ]);

    }
    public function like_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_comment' => 'required',
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $comment_like = Comment_like::where('id_comment', $request->id_comment)->where('id_user', $request->id_user)->first();
        if ($comment_like) {
            $comment_like->delete();
        } else {
            Comment_like::firstOrCreate([
                'id_comment' => $request->id_comment,
                'id_user' => $request->id_user,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success Like Post',
        ]);

    }
    public function dislike_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_comment' => 'required',
            'id_user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comment_dislike = Comment_dislike::where('id_comment', $request->id_comment)->where('id_user', $request->id_user)->first();
        if ($comment_dislike) {
            $comment_dislike->delete();
        } else {
            Comment_dislike::firstOrCreate([
                'id_comment' => $request->id_comment,
                'id_user' => $request->id_user,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success Like Post',
        ]);

    }
}
