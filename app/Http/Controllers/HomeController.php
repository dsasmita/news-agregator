<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsPost;

class HomeController extends Controller
{
    public function index(Request $request){
        $title = 'NewsFeed';
        $seo = [
            'description'   => '',
            'keywords'      => '',
            'body_class'    => '',
            'route'         => 'home'
        ];

        $newsList = NewsPost::orderBy('date_publish', 'desc')->simplePaginate(env('PAGINATION', 15));

        return view('home.home', 
            compact(
                'title', 
                'seo',
                'newsList'
            ));
    }

    public function detailNews($id, $slug, Request $request){
        $news = NewsPost::where('id', $id)->first();

        if(!$news){
            return 'page not found';
        }

        if($slug != str_slug($news->title)){
            return 'page not found';
        }

        $title = $news->title . ' | ' . $news->kanal_index;
        $seo = [
            'description'   => '',
            'keywords'      => '',
            'body_class'    => '',
            'route'         => 'home'
        ];


        return view('home.detail', 
            compact(
                'title', 
                'seo',
                'news'
            ));
    }

    public function kompasList(){
        return 'kompas list';
    }
}
