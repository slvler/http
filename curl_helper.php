<?php
if(!function_exists('curl')){
    function curl($a,$data = array()){
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $a);
		if(isset($data['post'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if($data['json']) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['post']));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data['post']));
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	if(isset($data['header'])) curl_setopt($ch, CURLOPT_HTTPHEADER, $data['header']);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $isle = curl_exec($ch);
        //log_message('error', print_r(curl_getinfo($ch), true));
    	curl_close($ch);
    	return $isle;

    }
}