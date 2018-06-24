<?php

namespace App\Helpers;

use App\models\NewsPost;

class HelperData{

	public static function countGeneralStas(){
		$data = [];
		$data['all'] = NewsPost::count();
		$data['month'] = NewsPost::whereYear('date_publish', date('Y'))
									->whereMonth('date_publish', date('m'))->count();
		$data['day'] = NewsPost::whereDate('date_publish', date('Y-m-d'))->count();

		return $data;
	}

}