<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\v1\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validated();

        $user = Auth::user();

        $post = new Post();
        $post->user()->associate($user);

        $url_image = $this->upload($request->file('image'));
        $post->url_image = $url_image;

        $post->title = $request->input('title');
        $post->description = $request->input('description');

        $res = $post->save();

        if($res){
            return response()->json(['message' => 'Post creado exitosamente'], 201);
        }
        return response()->json(['message' => 'Ocurrió un error'], 500);

    }
    private function upload($image){
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/post';
        $rename = uniqid(). '.'.$path_info['extension'];
        $image->move(public_path()."/$post_path", $rename);
        return "$post_path/$rename";
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
}
