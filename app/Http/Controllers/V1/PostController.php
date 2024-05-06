<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            "title"=>"required",
            "contentHTML"=>"required",
            "contentText"=>"required",
            "thumbnail"=>["required",File::image()->max(10*1024)]
        ]);

        if (Auth::check($validate)) {
            $filename = Str::random(10).strval(floor(microtime(true)*1000)).".".$request->file("thumbnail")->extension();
            $request->file("thumbnail")->storeAs("images",$filename);

            $post = new Post;
            $post->title = $request->input("title");
            $post->contentHTML = $request->input("contentHTML");
            $post->contentText = $request->input("contentText");
            $post->thumbnail = $filename;
            $post->category = 1;
            $post->author = $request->user()->id;
            $post->save();

            return response()->json([
                "message"=>"Posted",
                "data"=>$post
            ]);
        }

        return response()->json(['message' => 'Failed to post'], 401);

    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            "title"=>"required",
            "contentHTML"=>"required",
            "contentText"=>"required",
            "category"=>"required",
            "thumbnail"=>[File::image()->max(10*1024)]
        ]);

        $post = Post::find($id);
        $post->title = $request->input("title");
        $post->contentHTML = $request->input("contentHTML");
        $post->contentText = $request->input("contentText");
        if ($request->file("thumbnail")) {
            $filename = Str::random(10).strval(floor(microtime(true)*1000)).".".$request->file("thumbnail")->extension();
            $request->file("thumbnail")->storeAs("images",$filename);
            $post->thumbnail = $filename;
        }
        $post->category = $request->input("category");
        $post->save();

        return response()->json([
            "message"=>"success"
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            "message"=>"success"
        ]);
    }

    public function getAll(Request $request)
    {
        if ($request->get("cat")) {
            return response()->json([
                "message"=>"success",
                "data"=>Post::with("category")->where("category", $request->get("cat"))->get()
            ]);
        }
        return response()->json([
            "message"=>"success",
            "data"=>Post::with("category")->get()
        ]);
    }

    public function getByID(Request $request, string $id)
    {
        $post = Post::find($id);

        return response()->json([
            "message"=>"success",
            "data"=>$post
        ]);
    }

    public function getByCategory(Request $request, string $id)
    {
        $posts = Post::where("categories", $id);

        return response()->json([
            "message"=>"success",
            "data"=>$posts
        ]);
    }
}
