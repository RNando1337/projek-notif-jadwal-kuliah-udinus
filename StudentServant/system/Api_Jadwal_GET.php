<?php
header("Content-Type:application/json");
include 'func.php';
include 'Database.php';

${"\x47\x4c\x4f\x42AL\x53"}["\x67\x72\x69\x6d\x66\x64\x74\x6da\x71"]="\x68\x65ad\x65\x72s";${${"\x47\x4cO\x42A\x4c\x53"}["g\x72\x69\x6d\x66\x64\x74\x6d\x61\x71"]}=["H\x6f\x73t: \x64\x69\x6eu\x73\x2ea\x63.i\x64","\x55\x73\x65\x72-A\x67\x65n\x74: M\x6fz\x69\x6c\x6ca/\x35\x2e\x30 (Wi\x6e\x64ows\x20\x4eT 10\x2e\x30; W\x69n\x36\x34\x3b\x20x\x36\x34\x3b\x20rv:96\x2e\x30) \x47e\x63k\x6f/2\x30\x310\x3010\x31 \x46i\x72\x65fo\x78/96\x2e\x30"];

    $data_SKS = array();
    $k=0;
    $new_tanggal = array();
    $total_pertemuan = 0;

    $kode1 = "\x47\x45\x54";
    $kode2 = "\x50\x4f\x53\x54";

// GET DATA SKS
$getdata2 = func::get_data("", "https://dinus.ac.id/mahasiswa/".${"\x6e\x69\x6d"}, ${"\x6b\x6f\x64\x65\x31"}, 0);
preg_match_all("/<td>(\d)<\/td>/i", $getdata2, $SKS);
for($i=0;$i<=sizeof($SKS[1]);$i++){
    if($i%2 == 1){
        $k++;
        $data_SKS[$k-1] = $SKS[1][$i];
    }
}

//GET DATA HARI & TANGGAL

/**
 * http://academic.dinus.ac.id/home/dosen_mengajar_perharidansesi => CARI DATA ID
 * 219684 = Kalkulus 1
 * 219702 = Fisika 1
 * 219783 = MATEMATIKA DISKRIT
 * 219960 = Jaringan Komputer
 * 220040 = Sistem Informasi
 * 220174 = Sistem Temu Kembali Informasi
 * NB = 
 * -Kemungkinan jadwal muncul setelah dilakukan 1 minggu pertemuan
 * - 2 SKS = 14 pertemuan & 4 SKS = 28 Pertemuan
 */
 
 /**
  * Output yang diinginkan:
  * - nama mata kuliah (done)
  * - SKS (done)
  * - tanggal 
  * - hari (done)
  * - persentase kehadiran selama 1 semester = kehadiran/(total_pertemuan)* 100 (done)
  * Algoritma mencari total pertemuan berarti if(sks === 2 || sks === 3){total_temu = 14}else if(sks === 4){total_temu = 28}
  */
  
if(sizeof($data_SKS) == 0){
    $response['response']['status'] = 204;
    $response['response']['pesan'] = "Proses Input KRS";
}else if(sizeof($data_SKS)>0){
    $response['response']['status'] = 200;
    $response['response']['pesan'] = "OK";
    for($i=0;$i<sizeof(Database::datamahasiswa($nim,$id));$i++){
        $getdata = func::get_data("\x69\x64\x3d".Database::datamahasiswa($nim,$id)[$i], "https://dinus.ac.id/Menu/modalhadir", $kode2, $headers);
            preg_match_all("/<td .*>(\d+\.?\d*)<\/td>/", $getdata, $jml_data);
            preg_match_all("/<h4.*>*-(.*)<\/h4>/i", $getdata, $matkul);
            preg_match_all("/<td>(.*)<\/td>/i", $getdata, $hari);
            for($j=0;$j<sizeof($jml_data);$j++){
                if($j===0){
                    $response["data"][$i]["mata_kuliah"] = $matkul[1][0];
                    $response["data"][$i]["sks"] = $data_SKS[$i];
                    $response["data"][$i]["hari"] = array_values(array_unique($hari[1]));
                    if($data_SKS[$i] === "2" || $data_SKS[$i] === "3"){
                        $total_pertemuan = 14;
                    }else{
                        $total_pertemuan = 28;
                    }
                    $kehadiran = (sizeof($jml_data[1])/$total_pertemuan)*100;
                    $response["data"][$i]["persentase"] = round($kehadiran,2);
                }
            }
    }
}

$json_res = json_encode((object) $response);
echo $json_res;