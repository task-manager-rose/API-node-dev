<?php
if(isset($_GET["ip"])){
  $ip = "172.217.15.196";                    
}else{
  echo "No enviaste ip para hacer ping";
  return 0;
}


if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $ip);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Petición HEAD
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);

    $content = curl_exec($ch);

    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);

        print_r("\nSe recibió respuesta " . $info['http_code'] . ' en ' . $info['total_time'] . " segundos \n");
    } else {
        print_r("\nError en petición: " . curl_error($ch) . "\n");
    }

    curl_close($ch);

} else {
    print_r("\nDirección IP no válida: " . $ip . "\n");
}