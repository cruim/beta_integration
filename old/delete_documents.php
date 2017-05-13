<?php

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");

$serverSQL = 'zdorov.local.mySQL.Server';//'5.167.96.63'; //

$mysqli_ssl = mysqli_init();
$mysqli_ssl->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, TRUE);
$mysqli_ssl->ssl_set(
                    __DIR__.'/../shared/certs/client-key.pem',
                    __DIR__.'/../shared/certs/client-cert.pem',
                    __DIR__.'/../shared/certs/ca.pem',
                    NULL,
                    NULL);

$mysqli_ssl->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$result_connect = $mysqli_ssl->real_connect($serverSQL, 'landing', '123', 'integration_betapost', NULL, NULL, MYSQLI_CLIENT_SSL);
$mysqli_ssl->set_charset("utf8");

require_once "shared/shared_lib.php";

$doc_id = '414230A-417822A_245';


$request_xml = doRequest(request_xml_102('267', 'u5/*yf;9O2]', $doc_id), '267');
//$request_xml = doRequest(request_xml_102('280', 'r8/KY9-+Cl', $docs));
echo "<pre>";
echo (htmlspecialchars($request_xml));
echo "</pre>";

