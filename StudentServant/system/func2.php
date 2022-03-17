<?php
class func{
    public static function get_data($data=0,$situs,$request=0,$header=0){
        // $certificate_location = "C:/xampp/apache/bin/curl-ca-bundle.crt"; // modify this line accordingly (may need to be absolute)
        // $postf_query = http_build_query($data);
        $ch = curl_init();
        if($request === "POST"){
            curl_setopt($ch, CURLOPT_URL, $situs);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }else{
            curl_setopt($ch, CURLOPT_URL, $situs);
        }
        if($header !== 0){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Digunakan untuk berjaga ketika menghadapi redirect page/diarahkan ke halaman lain
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); //anti redirect page
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);
        // Untuk mengatasi error SSLcertificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //untuk mengatasi kelamaan curl/response time
        curl_setopt($ch, CURLOPT_ENCODING, '');

        $server_output = curl_exec($ch);


        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            // ." ".curl_getinfo($ch)['total_time']
            return $server_output;
        }

        curl_close ($ch);
    }
}
