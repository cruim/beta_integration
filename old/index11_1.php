<?

		require_once "../vendor/autoload.php";
		
		
		class Ret extends RetailCrm\ApiClient {

			function Edit($neworder, $order_site) {
				
				//$client = static::getApiClient();
				
				$response = $this->ordersEdit( $neworder, 'id', $order_site );
				
				//var_dump($this->response['success']);
				//var_dump($this->getResponse());
				return $response;
			}
		}
/*
		$retail_client = new RetailCrm\ApiClient(
			'https://varifort.retailcrm.ru',
			'hEZN2dXTGppGCj4KzHM8gjZzUisy4PIx'
		);
*/




		$retail_client = new Ret(
			'https://varifort.retailcrm.ru',
			'hEZN2dXTGppGCj4KzHM8gjZzUisy4PIx'
		);
		//306572 306581 306604
		$neworder = array ();
		$neworder["id"] = '306604';
		$neworder["customFields"]["nomer_otpravleniya"] = '';
		$neworder["customFields"]["api_mark"] = 'from_BetaPost_API';
		//var_dump($neworder);
		
		//var_dump($retail_client);
		
		$result = $retail_client->Edit( $neworder, 'vari-cream-com' );
		
		//var_dump($retail_client);
		var_dump($result);
		echo "<br />";
		
		var_dump($result->success);
		
		
		unset($retail_client);



?>