<?php
header("Content-Type:application/json");
error_reporting(0);
include 'func.php';

if(isset($_GET["nim"])){  
    //System for Tagihan Mahasiswa
    $getdata = func::get_data("\x6e\x69\x6d\x3d".$_GET['nim'], "https://academic.dinus.ac.id/home/tagihan", "\x50\x4f\x53T", 0);
    
    if($getdata !== ""){
        $spp = explode("<td>", explode("</td>", explode("Kewajiban SPP", $getdata)[1])[2])[1];
        $belum_terbayar = explode("<td>", explode("</td>", explode("Kekurangan Lalu", $getdata)[1])[2])[1];
        $total_tagihan = explode("<td>", explode("</td>", explode("Total Tagihan", $getdata)[1])[2])[1];

        if($total_tagihan === "Rp. 0"){
            $status_pembayaran = explode("</b>", explode("<b style='color:green;'>", explode("Status Pembayaran", $getdata)[1])[1])[0];
        }else{
            $status_pembayaran = "Tagihan belum lunas";
        }
        
            if($spp !== NULL || $belum_terbayar !== NULL || $total_tagihan !== NULL){
                $response["response"]->status = 200;
                $response["response"]->pesan = "OK";
                $response["data"]->spp = $spp;
                $response["data"]->belum_terbayar = $belum_terbayar;
                $response["data"]->total_tagihan = $total_tagihan;
                $response["data"]->status_pembayaran = $status_pembayaran;
            }else{
                $response["response"]->status = 400;
                $response["response"]->pesan = "Data not found";
            }
    }else{
        $response["response"]->status = 400;
        $response["response"]->pesan = "Data not found";
    }

}else{
    $response['response']->status = 400;
    $response['response']->pesan = "Data not found";
}

    $json_res = json_encode((object) $response);
    echo $json_res;
