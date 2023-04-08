<?php

namespace App\Lib;

use DB;

class Helper
{

	public function get_all_currencies($currency = NULL){
		$currencies = DB::table('currencies')->orderBy('code','ASC')->get();
		return $currencies;
	}
	public function get_currency_rates($currency = NULL){
		$rates = DB::table('currency_rates')->orderBy('id','DESC')->first();
		$currencies = json_decode($rates->rates);
		if($currency != NULL){
			$currency = strtoupper($currency);
			return $currencies->$currency;
		}else{
			return $currencies;
		}
	}
	public function convert_to_currency($currency = NULL, $amount = NULL){
		// echo $amount; 
		$rates = DB::table('currency_rates')->orderBy('id','DESC')->first();
		$currencies = json_decode($rates->rates);
		if($currency != NULL){
			$currency = strtoupper($currency);
			$rate = $currencies->$currency;
			if($amount != NULL){
				return str_replace(',','',(int)$amount)*$rate;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	public function count_raffle_tickets($id = NULL){
		if($id != NULL){
			$count = DB::table('raffle_game_tickets')->where('raffle_game_id',$id)->count();
			return $count;
		}else{
			return 0;
		}
	}
}
