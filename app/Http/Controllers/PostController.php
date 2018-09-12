<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostController extends Controller
{
    public function index()
    {
        $posts = new Collection;

        $post_collections = Post::all()->groupBy(function ($item) {

            if(strstr($item['code'],'-')) {
                list($code) = explode('-', $item['code']);
                return $code;
            }
            return $item['code'];

        });

        foreach($post_collections as $code_collection) {
            foreach($code_collection as $key=>$post) {
                $post['is_main'] = ($key==0) ? 1 : null;
                $posts->push($post);
            }
        }

        return view('welcome',compact('posts'));
    }
}
