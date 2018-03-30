<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Notifications\SupportCommented;

class PostController extends Controller
{
    public function list()
    {
    	$posts = Post::with('user','comments.user')->orderBy('id','desc')->paginate(5);

    	return view('support.list',['posts'=>$posts]);
    }

    public function form()
    {
    	return view('support.form');
    }

    public function store_post(Request $request)
    {
		$this->validate($request, [
			'body' => 'required',
		]);

		$request->user()->posts()->create($request->all());

		return redirect('/support');
    }

    public function store_comment(Post $post, Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $post->user->notify(new SupportCommented($post,$request));

        $data['body'] = $request->body;
        $data['user_id'] = $request->user()->id;
        $post->comments()->create($data);

        return redirect()->back();
    }
}
