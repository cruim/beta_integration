<?php

/*

<?xml version="1.0" encoding="UTF-8"?>
<request request_type="161" partner_id="267" password="u5/*yf;9O2]">
     <good good_id="009 " good_name="Крем-воск Здоров (пластик) универсальный">
          <ean mode="1" value="2627115770017"/>
     </good>
</request> 


 */

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", "on");
ini_set("display_startup_errors", "on");
ini_set('max_execution_time', 0);

//mb_internal_encoding("UTF-8");
require_once "shared/shared_lib.php";
/*
$lk = '267';
$pass = 'u5/*yf;9O2]';
$request_xml = doRequest(request_xml_161($lk, $pass, "009 ", "Крем-воск Здоров (пластик) универсальный", "2627115770017"));
$request_xml = doRequest(request_xml_161($lk, $pass, "014", "Крем-воск Здоров (пластик) морщины", "2627115770024"));
$request_xml = doRequest(request_xml_161($lk, $pass, "015", "Крем-воск Здоров (пластик) мастопатия", "2627115770055"));
$request_xml = doRequest(request_xml_161($lk, $pass, "016", "Крем-воск Здоров (пластик) от грибка", "2627115770031"));
$request_xml = doRequest(request_xml_161($lk, $pass, "017", "Крем-воск Здоров (пластик) от целлюлита", "2627115770062"));
$request_xml = doRequest(request_xml_161($lk, $pass, "019", "Крем-воск Здоров (пластик) от псориаза", "2627115770048"));

$lk = '280';
$pass = 'r8/KY9-+Cl';
$request_xml = doRequest(request_xml_161($lk, $pass, "009 ", "Крем-воск Здоров (пластик) универсальный", "2627115770017"));
$request_xml = doRequest(request_xml_161($lk, $pass, "014", "Крем-воск Здоров (пластик) морщины", "2627115770024"));
$request_xml = doRequest(request_xml_161($lk, $pass, "015", "Крем-воск Здоров (пластик) мастопатия", "2627115770055"));
$request_xml = doRequest(request_xml_161($lk, $pass, "016", "Крем-воск Здоров (пластик) от грибка", "2627115770031"));
$request_xml = doRequest(request_xml_161($lk, $pass, "017", "Крем-воск Здоров (пластик) от целлюлита", "2627115770062"));
$request_xml = doRequest(request_xml_161($lk, $pass, "019", "Крем-воск Здоров (пластик) от псориаза", "2627115770048"));
*/

$lk = '843';
$pass = '5342312';
$request_xml = doRequest(request_xml_161($lk, $pass, "009", "Крем-воск Здоров (пластик) универсальный", "2627115770017"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "014", "Крем-воск Здоров (пластик) морщины",       "2627115770024"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "015", "Крем-воск Здоров (пластик) мастопатия",    "2627115770055"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "016", "Крем-воск Здоров (пластик) от грибка",     "2627115770031"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "017", "Крем-воск Здоров (пластик) от целлюлита",  "2627115770062"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "019", "Крем-воск Здоров (пластик) от псориаза",   "2627115770048"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "020", "Крем-воск Здоров (пластик) для суставов",  "2627115770086"),$lk);
$request_xml = doRequest(request_xml_161($lk, $pass, "021", "Крем-воск Здоров (пластик) от варикоза",   "2627115770079"),$lk);

echo "<pre>";
echo (htmlspecialchars($request_xml));
echo "</pre>";
