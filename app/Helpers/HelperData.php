<?php

namespace App\Helpers;

use App\models\NewsPost;
use App\models\Portal;

class HelperData{

	public static function countGeneralStas(){
		$data = [];
		$data['all'] = NewsPost::count();
		$data['month'] = NewsPost::whereYear('date_publish', date('Y'))
									->whereMonth('date_publish', date('m'))->count();
		$data['day'] = NewsPost::whereDate('date_publish', date('Y-m-d'))->count();

		$portal = Portal::get();
		$tmp = [];
		foreach ($portal as $key => $value) {
			$tmp[] = '<strong>' . $value->title . '</strong>';
		}
		
		$data['portal'] = implode(', ', $tmp);

		return $data;
	}

	public static function kanalParam2Link($kanal){
		$kanalArray = explode(',', $kanal);

		$tmp = [];
		foreach ($kanalArray as $key => $value) {
			$tmp[] = 'kanal[]='.trim($value);
		}

		return implode('&', $tmp);
	}

}