<?php
// $base_url = 'http://localhost/php/aceem_php';
$base_url = 'http://localhost/aceem_php';
$title = "Aceem";
$token_key_start = "]m_4W0?XF2T+L:]>%EL§PmCl,_n}):QTn-!dIZ#JOG|Wv#Ij{6=A<:WO>Ou(b°d";
$token_key_end = "Sf4^usk@IR{.QU!^0_-,~0Gogt/Rb5GgfW_)Z/tS=c!°NaRv]uBj%:^gRo]^m2^";
$upload_dir = __DIR__ . "/../resources/";
$file_dir = $base_url . "/resources/";

if (!function_exists('getValueOfKey')) {
    function getValueOfKey($key, $data) {
        $r = [];
        foreach ($data as $v) {
            array_push($r, $v[$key]);
        }
        return $r;
    }
}

if (!function_exists('getAllMounth')) {
    function getAllMounth() {
        return ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    }
}
if (!function_exists('format_money')) {
	function format_money($number) {
		return number_format($number, 0, ',', ' '). " Ar";
	}
}