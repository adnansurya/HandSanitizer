<?php

//fungsi untuk mengubah teks waktu ke dalam bahasa Indonesia
function tglWaktuIndo($tglWaktu){
    $pisahSpasi =  explode(' ', $tglWaktu);
    $tanggal = $pisahSpasi[0];
    $waktu = $pisahSpasi[1];

	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
	if($tanggal != ''){
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0] . ' ('.$waktu.')';
	}else{
		return 'Belum Tersedia';
	}
	
}


//fungsi untuk menampilkan teks status cairan
function statCairan($cairan, $cairMax, $cairMin){

    $batasPenuh = $cairMax * 0.9; //batas penuh adalah 90%
    $status = 'Error';

    if($cairan < $cairMin){
        $status = 'Kosong';  //'Kosong' jika nilai ADC di bawah nilai minimal
    }elseif($cairan >= $cairMin && $cairan <= $batasPenuh){
        $status = 'Normal'; //'Normal jika nilai ADC di antara nilai minimal dan batas penuh
    }elseif($cairan > $batasPenuh){
        $status = 'Penuh'; //'Penuh jika nilai ADC melebihi batas penuh
    }

    return $status;
}

?>