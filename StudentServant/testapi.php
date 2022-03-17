<?php
header("Content-Type:application/json");
include 'system/func.php';

// $json_pembayaran;


// //System for Tagihan Mahasiswa
// $getdata = get_curl("nim=A11.2021.13931", "https://academic.dinus.ac.id/home/tagihan");
// $spp = explode("<td>", explode("</td>", explode("Kewajiban SPP", $getdata)[1])[2])[1];
// $belum_terbayar = explode("<td>", explode("</td>", explode("Kekurangan Lalu", $getdata)[1])[2])[1];
// $total_tagihan = explode("<td>", explode("</td>", explode("Total Tagihan", $getdata)[1])[2])[1];
// $status_pembayaran = explode("</b>", explode("<b style='color:green;'>", explode("Status Pembayaran", $getdata)[1])[1])[0];

$list_id = ['A11.2021.13931-219783','A11.2021.13931-219684','A11.2021.13931-219702','A11.2021.13931-219960','A11.2021.13931-220040','A11.2021.13931-220174'];

$data = $list_id[0];
// echo sizeof($list_id); << hitung jumlah array

$headers = [
    'Host: dinus.ac.id',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0
    Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language: id,en-US;q=0.7,en;q=0.3',
    'Accept-Encoding: gzip, deflate, br',
    'Content-Type: application/x-www-form-urlencoded charset=utf-8',
    'Content-Length: 24',
    'Connection: keep-alive',
    'Upgrade-Insecure-Requests: 1',
    'Sec-Fetch-Dest: document',
    'Cache-Control: no-cache'
];


$getdata = get_curl("id=".$list_id[0], "https://dinus.ac.id/Menu/modalhadir", "POST", $headers);

//regex get hari = /<td>(.*)<\/td>/i
//regex get tanggal = /<td align=center>(.*)<\/a>/i
//regex get Mata Kuliah = /<h4.*>.*-(.*)<\/h4>/gm
//regex jumlah data = <td .*>(\d)<\/td>

preg_match_all("/<td>(.*)<\/td>/i", $getdata, $hari);
preg_match_all("/<td align=center>(.*)<\/a>/i", $getdata, $tanggal);
preg_match_all("/<h4.*>.*-(.*)<\/h4>/i", $getdata, $matkul);
preg_match_all("/<td .*>(\d+\.?\d*)<\/td>/", $getdata, $jml_data);
var_dump($jml_data[1]);

// $getdata = get_curl("", "https://dinus.ac.id/mahasiswa/A11.2021.13931", "GET", 0);

// preg_match_all("/<td>(\d)<\/td>/i", $getdata, $SKS);

// $data_SKS = array();

// for($i=0;$i<=sizeof($SKS[1]);$i++){
//     if($i%2 == 1){
//         $data_SKS[] = $SKS[1][$i];
//     }
// }

// print_r($data_SKS);