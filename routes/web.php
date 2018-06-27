<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
	Route::get('/', 'HomeController@index')
			->name('home');

	Route::get('/pilkada', 'HomeController@pilkada')
			->name('home.pilkada');

	Route::get('/portal/{portal}', 'HomeController@portalNews')
			->name('news.portal');

	Route::get('/date/{date}', 'HomeController@dateList')
			->name('news.date');

	Route::get('/{id}/{slug}', 'HomeController@detailNews')
			->name('news.detail');

	Route::get('/do-crawler', 'HomeController@doCrawler')
			->name('crawler.kompas');

	Route::get('/do-crawler-detail', 'HomeController@doCrawlerDetail')
			->name('crawler.kompas');
});