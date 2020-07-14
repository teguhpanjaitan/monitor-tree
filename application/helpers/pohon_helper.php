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
	function get_eksekusi_selanjutnya($tanggal_eksekusi, $laju_pertumbuhan, $tinggi = 0, $metode_rintis = '')
	{
		if (empty($laju_pertumbuhan)) {
			return '';
		}
		$laju_pertumbuhan = floatval($laju_pertumbuhan);

		if (strpos($tanggal_eksekusi, '/') !== false) {
			$tanggal_eksekusi = DateTime::createFromFormat('d/m/Y', $tanggal_eksekusi);
		} elseif (strpos($tanggal_eksekusi, '-') !== false) {
			$tanggal_eksekusi = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal_eksekusi);
		} else {
			return '';
		}

		if (strtolower($metode_rintis) == 'rabas-rabas') {
			if ($laju_pertumbuhan >= 3) {
				$tanggal_eksekusi->modify("+1 month");
			} else {
				$bulan = 3 / $laju_pertumbuhan;
				$bulan = round($bulan, 1);
				$days = moth_to_days($bulan);
				$tanggal_eksekusi->modify("+$days days");
			}

			return $tanggal_eksekusi->format('Y-m-d');
		} else {
			$tinggi = floatval($tinggi);
			$c = 1;
			$limit_tinggi = get_tinggi_pohon_limit();

			while ((($c * $laju_pertumbuhan) + $tinggi) < $limit_tinggi) {
				$c++;
			}

			$tanggal_eksekusi->modify("+$c months");
			return $tanggal_eksekusi->format('Y-m-d');
		}
	}
}

if (!function_exists('moth_to_days')) {
	function moth_to_days($month)
	{
		$days = $month * 30;
		return floor($days);
	}
}
