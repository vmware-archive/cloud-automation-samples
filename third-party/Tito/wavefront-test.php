<?php

/* Create a TCP/IP socket. */
$wf_proxy_name="127.0.0.1";
$wf_proxy_port=2878;
$metric_name="vince1706.test3.metric";
$metric_value="100";
$metric_epoch="1523021479";
$source_name="vince-France";
$tag_name="test1";
$tag_value="060418";


$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}
echo "Attempting to connect to ‘$wf_proxy_name' on port ‘$wf_proxy_port'...";
$result = socket_connect($socket, $wf_proxy_name, $wf_proxy_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}
$data_point = "$metric_name $metric_value $metric_epoch source=$source_name  $tag_name=$tag_value\n";
echo "Sending Wavefront Data point";
socket_write($socket, $data_point, strlen($data_point));
echo "Closing socket...";
socket_close($socket);

?>
