<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_tinggi_pohon_limit')) {
	function get_tinggi_pohon_limit()
	{
		return 10;
	}
}

if (!function_exists('get_bentangan_pohon')) {
	function get_bentangan_pohon($metode_rintis, $tinggi)
	{
		if (strtolower($metode_rintis) == 'rabas-rabas') {
			return 3;
		} else {
			return $tinggi;
		}
	}
}

if (!function_exists('get_eksekusi_selanjutnya')) {
	function get_eksekusi_selanjutnya($tanggal_eksekusi, $laju_pertumbuhan)
	{
		if (empty($laju_pertumbuhan)) {
			return '';
		}

		if (strpos($tanggal_eksekusi, '/') !== false) {
			$tanggal_eksekusi = DateTime::createFromFormat('d/m/Y', $tanggal_eksekusi);
		} elseif (strpos($tanggal_eksekusi, '-') !== false) {
			$tanggal_eksekusi = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal_eksekusi);
		} else {
			return '';
		}

		$c = 1;
		$laju_pertumbuhan = floatval($laju_pertumbuhan);
		$limit_tinggi = get_tinggi_pohon_limit();

		while (($c * $laju_pertumbuhan) < $limit_tinggi) {
			$c++;
		}

		$tanggal_eksekusi->modify("+$c months");
		return $tanggal_eksekusi->format('Y-m-d');
	}
}
