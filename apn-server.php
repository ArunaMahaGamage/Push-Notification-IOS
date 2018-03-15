<?php 
$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = 'ck.pem';
$apnsPort = 2195;
$apnsPass = 'test';
$token = '52a04c0f437d3cced3f86663a0b0a2096bacb0fd2a086e7b404995a4dd4c8929';

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);

$payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 1, 'sound' => 'default');
$output = json_encode($payload);
$token = pack('H*', str_replace(' ', '', $token));
$apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;
fwrite($apns, $apnsMessage);

socket_close($apns);
fclose($apns);

echo 'ok';