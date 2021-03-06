<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsPost;
use App\Models\Portal;

use HelperData;
use cURL;

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

    public function portalNews($portalTitle, Request $request){
        $portal = Portal::where('title', $portalTitle)->first();

        if(!$portal){
            return 'page not found';
        }

        $title = 'NewsFeed | Portal ' . $portal->title;

        $seo = [
            'description'   => '',
            'keywords'      => '',
            'body_class'    => '',
            'route'         => 'home'
        ];

        $kanals = $request->input('kanal');
        $filterKanal = HelperData::kanal2Filter($kanals);
        
        if($filterKanal){
            $filter = 'Portal News: ' . $portal->title . 
                        ' - Kanal: '. $filterKanal;
        }else{
            $filter = 'Portal News: ' . $portal->title;
        }

        $newsList = NewsPost::where('id_portal', $portal->id)
                                ->where(function($query) use ($kanals){
                                    if($kanals){
                                        foreach ($kanals as $key => $value) {
                                            $query->where('kanal_index', 'like', '%'.$value.'%');
                                        }
                                    }
                                })->orderBy('date_publish', 'desc')
                                ->simplePaginate(env('PAGINATION', 15));

        return view('home.home', 
            compact(
                'title', 
                'seo',
                'newsList',
                'filter'
            ));

        return $portal;
    }

    public function dateList($date, Request $request){
        $check = HelperData::validDate($date);

        if(!$check){
            return 'page not found';
        }

        $title = 'NewsFeed | Portal - ' . $date;

        $seo = [
            'description'   => '',
            'keywords'      => '',
            'body_class'    => '',
            'route'         => 'home'
        ];

        $newsList = NewsPost::whereDate('date_publish', $date)
                        ->orderBy('date_publish', 'desc')
                        ->simplePaginate(env('PAGINATION', 15));

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

    public function doCrawler(Request $request){
        $date = $request->input('date',date('Y-m-d'));

        $result = [];
        $result['date_crawler'] = $date;

        if($request->input('portal') == 'tempo'){
            try {
                // 2018/06/21
                $dateTempo = date('Y/m/d', strtotime($date));
                $responseTempo = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/tempo/list?date=' . $dateTempo);
                $result['tempo'] = json_decode($responseTempo->body);
            } catch (Exception $e) {
                
            }
        }else if($request->input('portal') == 'kompas'){
            try {
                $responseKompas = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/kompas/list?date=' . $date);
                $result['kompas'] = json_decode($responseKompas->body);
            } catch (Exception $e) {
                
            }
        }else if($request->input('portal') == 'detik'){
            try {
                // bln/tgl/thn
                $dateDetik = date('m/d/Y', strtotime($date));
                $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/list?date=' . $dateDetik);
                $result['detik'] = json_decode($responseDetik->body);
            } catch (Exception $e) {
                
            }
        }else{
            try {
                $responseKompas = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/kompas/list?date=' . $date);
                $result['kompas'] = json_decode($responseKompas->body);
            } catch (Exception $e) {
                
            }

            try {
                // bln/tgl/thn
                $dateDetik = date('m/d/Y', strtotime($date));
                $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/list?date=' . $dateDetik);
                $result['detik'] = json_decode($responseDetik->body);
            } catch (Exception $e) {
                
            }

            try {
                // 2018/06/21
                $dateTempo = date('Y/m/d', strtotime($date));
                $responseTempo = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/tempo/list?date=' . $dateTempo);
                $result['tempo'] = json_decode($responseTempo->body);
            } catch (Exception $e) {
                
            }
        }

        return json_encode($result);
    }

    public function doCrawlerCron(){
        $date = date('Y-m-d');

        $result = [];
        $result['date_crawler'] = $date;

        try {
            $responseKompas = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/kompas/list?date=' . $date);
            $result['kompas'] = json_decode($responseKompas->body);
        } catch (Exception $e) {
            
        }

        
        try {
            // bln/tgl/thn
            $dateDetik = date('m/d/Y', strtotime($date));
            $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/list?date=' . $dateDetik);
            $result['detik'] = json_decode($responseDetik->body);
        } catch (Exception $e) {
            
        }

        try {
            // 2018/06/21
            $dateTempo = date('Y/m/d', strtotime($date));
            $responseTempo = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/tempo/list?date=' . $dateTempo);
            $result['tempo'] = json_decode($responseTempo->body);
        } catch (Exception $e) {
            
        }
        

        return json_encode($result);
    }

    public function doCrawlerDetail(Request $request){
        $limit = $request->input('limit', 20);

        $result = [];
        $result['limit'] = $limit;

        try {
            $responseKompas = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/kompas/detail?limit=' . $limit);
            $result['kompas'] = json_decode($responseKompas->body);
        } catch (Exception $e) {
            
        }
        
        try {
            // crawler content type
            $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/news-type?limit=' . $limit);
            $result['detik_content_type'] = json_decode($responseDetik->body);    
        } catch (Exception $e) {
            
        }

        try {
            // crawler detail
            // singlepagenews
            $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/detail/singlepagenews?limit=' . $limit);
            $result['detik_singlepagenews'] = json_decode($responseDetik->body);    
        } catch (Exception $e) {
            
        }

        return json_encode($result);
    }

    public function doCrawlerDetailCron(){
        $limit = 200;

        $result = [];
        $result['limit'] = $limit;

        try {
            $responseKompas = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/kompas/detail?limit=' . $limit);
            $result['kompas'] = json_decode($responseKompas->body);
        } catch (Exception $e) {
            
        }
        
        try {
            // crawler content type
            $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/news-type?limit=' . $limit);
            $result['detik_content_type'] = json_decode($responseDetik->body);    
        } catch (Exception $e) {
            
        }

        try {
            // crawler detail
            // singlepagenews
            $responseDetik = cURL::get(env('HOME_CRAWLER', 'http://0.0.0.0:8000/') . 'crawler/detik/detail/singlepagenews?limit=' . $limit);
            $result['detik_singlepagenews'] = json_decode($responseDetik->body);    
        } catch (Exception $e) {
            
        }

        return json_encode($result);
    }

    public function pilkada(){
        $title = 'Pilkada 2018 | NewsFeed';
        $seo = [
            'description'   => '',
            'keywords'      => '',
            'body_class'    => '',
            'route'         => 'home'
        ];

        $newsList = NewsPost::where(function($query){
                                    $query->where('title', 'like', '%quick count%');
                                    $query->orWhere('title', 'like', '%pilkada%');
                                    $query->orWhere('title', 'like', '%pilkada%');
                                })->orderBy('date_publish', 'desc')->simplePaginate(env('PAGINATION', 15));

        return view('home.pilkada', 
            compact(
                'title', 
                'seo',
                'newsList'
            ));
    }
}
