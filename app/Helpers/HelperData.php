<?php

namespace App\Helpers;

use App\Models\NewsPost;
use App\Models\NewsKanal;
use App\Models\Portal;

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

	public static function kanal2Filter($kanalList){
		if(!$kanalList){
			return false;
		}

		$tmp = [];
		foreach ($kanalList as $key => $value) {
			$kanal = NewsKanal::where('slug', $value)->first();
			if($kanal){
				$tmp[] = $kanal->title;
			}else{
				$tmp[] = $value;
			}
		}

		return implode(', ', $tmp);
	}

	public static function validDate($date){
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
		    return true;
		} else {
		    return false;
		}
	}
}