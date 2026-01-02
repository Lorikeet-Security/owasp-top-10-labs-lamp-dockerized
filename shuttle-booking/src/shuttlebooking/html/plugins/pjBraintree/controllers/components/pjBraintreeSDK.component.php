<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBraintreeSDK extends pjPaymentsSDK
{	
	protected static $version = "2019-01-01";
	
	public function getClientToken()
	{
		$params = array();
		$params['query'] = 'mutation ExampleClientToken($input: CreateClientTokenInput) {
			createClientToken(input: $input) {
				clientToken
      		}
		}';
		$params['variables'] = array(
			'input' => array(
				'clientToken' => array(
					'merchantAccountId' => $this->getMerchantId()
				)
			)
		);
		
		$data = $this->request(null, $params);
		/*
		{
		 	"data": {
		 		"createClientToken": {
		 			"clientToken" : "eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpGVXpJMU5pSXNJbXRwWkNJNklqSXdNVGd3TkRJMk1UWXRjMkZ1WkdKdmVDSXNJbWx6Y3lJNklrRjFkR2g1SW4wLmV5SmxlSEFpT2pFMU56RXpNRFU0TXpRc0ltcDBhU0k2SWpaaE5qaGxOalJpTFRFNE1ESXROREZoWXkwNFpUazFMVFJsWWpreE1EazRZak01TUNJc0luTjFZaUk2SW5GMll6bHllREl5ZDJOMGJuZDJaR2NpTENKcGMzTWlPaUpCZFhSb2VTSXNJbTFsY21Ob1lXNTBJanA3SW5CMVlteHBZMTlwWkNJNkluRjJZemx5ZURJeWQyTjBibmQyWkdjaUxDSjJaWEpwWm5sZlkyRnlaRjlpZVY5a1pXWmhkV3gwSWpwbVlXeHpaWDBzSW5KcFoyaDBjeUk2V3lKdFlXNWhaMlZmZG1GMWJIUWlYU3dpYjNCMGFXOXVjeUk2ZXlKdFpYSmphR0Z1ZEY5aFkyTnZkVzUwWDJsa0lqb2ljWFpqT1hKNE1qSjNZM1J1ZDNaa1p5SjlmUS5YOXVIa1gzRjVQeGNySmtaaGVxcWViN3RINEtNNGFiNDZWTnhoNnhrNVAtYlBOeVNEcjZ1dGVGdElTV05QbWdXamY5Y0xnZU9xS2pYOEJiZ1lMeW5rUSIsImNvbmZpZ1VybCI6Imh0dHBzOi8vYXBpLnNhbmRib3guYnJhaW50cmVlZ2F0ZXdheS5jb206NDQzL21lcmNoYW50cy9xdmM5cngyMndjdG53dmRnL2NsaWVudF9hcGkvdjEvY29uZmlndXJhdGlvbiIsImdyYXBoUUwiOnsidXJsIjoiaHR0cHM6Ly9wYXltZW50cy5zYW5kYm94LmJyYWludHJlZS1hcGkuY29tL2dyYXBocWwiLCJkYXRlIjoiMjAxOC0wNS0wOCJ9LCJjaGFsbGVuZ2VzIjpbXSwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwiY2xpZW50QXBpVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzL3F2YzlyeDIyd2N0bnd2ZGcvY2xpZW50X2FwaSIsImFzc2V0c1VybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXV0aFVybCI6Imh0dHBzOi8vYXV0aC52ZW5tby5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIiwiYW5hbHl0aWNzIjp7InVybCI6Imh0dHBzOi8vb3JpZ2luLWFuYWx5dGljcy1zYW5kLnNhbmRib3guYnJhaW50cmVlLWFwaS5jb20vcXZjOXJ4MjJ3Y3Rud3ZkZyJ9LCJ0aHJlZURTZWN1cmVFbmFibGVkIjp0cnVlLCJwYXlwYWxFbmFibGVkIjp0cnVlLCJwYXlwYWwiOnsiZGlzcGxheU5hbWUiOiJTdGl2YVNvZnQiLCJjbGllbnRJZCI6bnVsbCwicHJpdmFjeVVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS9wcCIsInVzZXJBZ3JlZW1lbnRVcmwiOiJodHRwOi8vZXhhbXBsZS5jb20vdG9zIiwiYmFzZVVybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXNzZXRzVXJsIjoiaHR0cHM6Ly9jaGVja291dC5wYXlwYWwuY29tIiwiZGlyZWN0QmFzZVVybCI6bnVsbCwiYWxsb3dIdHRwIjp0cnVlLCJlbnZpcm9ubWVudE5vTmV0d29yayI6dHJ1ZSwiZW52aXJvbm1lbnQiOiJvZmZsaW5lIiwidW52ZXR0ZWRNZXJjaGFudCI6ZmFsc2UsImJyYWludHJlZUNsaWVudElkIjoibWFzdGVyY2xpZW50MyIsImJpbGxpbmdBZ3JlZW1lbnRzRW5hYmxlZCI6dHJ1ZSwibWVyY2hhbnRBY2NvdW50SWQiOiJzdGl2YXNvZnQiLCJjdXJyZW5jeUlzb0NvZGUiOiJFVVIifSwibWVyY2hhbnRJZCI6InF2YzlyeDIyd2N0bnd2ZGciLCJ2ZW5tbyI6Im9mZiIsIm1lcmNoYW50QWNjb3VudElkIjoicXZjOXJ4MjJ3Y3Rud3ZkZyJ9"
		 		}
		 	},
		 	"extensions": {
		 		"requestId": "4Ss9YhTK2hnu01cVbBOyBp30aMTjE1jdVgeXN35z1EQCFKUPS097pQ=="
		 	}
		}
		*/
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjBraintreeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			$message = @$errors[0]['message'];
			
			throw new Exception($message);
		}
		
		$arr = $response->toArray();
		
		return $arr['data']['createClientToken']['clientToken'];
	}
	
	public function transactionSale($nonce, $amount)
	{
		$params = array();
		$params['query'] = 'mutation ExampleCharge($input: ChargePaymentMethodInput!) {
			chargePaymentMethod(input: $input) {
				transaction {
					id
					status
				}
			}
		}';
		$params['variables'] = array(
			'input' => array(
				'paymentMethodId' => $nonce,
				'transaction' => array(
					'amount' => $amount
				)
			)
		);
		
		$data = $this->request(null, $params);
		/*
		{
			"data": {
				"chargePaymentMethod": {
					"transaction": {
						"id": "id_of_transaction",
						"status": "SUBMITTED_FOR_SETTLEMENT"
					}
				}
			}
		}
		*/
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjBraintreeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			$message = @$errors[0]['message'];
			
			throw new Exception($message);
		}
		
		$arr = $response->toArray();
		
		return $arr['data']['chargePaymentMethod'];
	}
	
	public function transactionFind($transaction_id)
	{
		$params = array();
		$params['query'] = 'query {
			node(id: "'.$transaction_id.'") {
				... on Transaction {
					status
					id
					amount {
						value
						currencyIsoCode
					}
					createdAt
					paymentMethod {
						id
						details {
							__typename
						}
					}
				}
			}
		}';
		
		$data = $this->request(null, $params);
		/*
		{
			"data": {
				"node": {
					"status": "SUBMITTED_FOR_SETTLEMENT",
					"paymentMethod": {
						"id": "id_of_transaction",
						"details": {
							"__typename": "CreditCardDetails"
						}
					}
				}
			},
			"extensions": {
				"requestId": "cf78db46-a44d-4394-90f5-e5af86243517"
			}
		}
		*/
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjBraintreeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			$message = @$errors[0]['message'];
			
			throw new Exception($message);
		}
		
		$arr = $response->toArray();
		
		return $arr['data'];
	}
	
	public static function isValidStatus($status)
	{
		return in_array(strtoupper($status), array(
			'AUTHORIZED',
			'AUTHORIZING',
			'SETTLED',
			'SETTLING',
			'SETTLEMENT_CONFIRMED',
			'SETTLEMENT_PENDING',
			'SUBMITTED_FOR_SETTLEMENT',
		));
	}
	
	protected function request($path=null, $params=null)
	{
		if (is_array($params))
		{
			$params = json_encode($params);
		}
		
		$http = new pjHttp();
		
		$http
			->setMethod("POST")
			->addHeader("Content-Type: application/json")
			->addHeader("Authorization: Basic " . base64_encode($this->getPublicKey(). ":" . $this->getPrivateKey()))
			->addHeader("Braintree-Version: " . self::$version)
			->setData($params, false)
			->curlRequest($this->getEndPoint());
		
		$error = $http->getError();
		if ($error)
		{
			return array('status' => 'ERR', 'code' => 100, 'text' => $error['text']);
		}
		
		if (method_exists($http, 'getHttpCode') && $http->getHttpCode() != 200)
		{
			return array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP Code: ' . $http->getHttpCode());
		}
		
		$response = $http->getResponse();
		if (!$response)
		{
			return array('status' => 'ERR', 'code' => 102, 'text' => 'Empty response');
		}
		
		$result = json_decode($response, true);
		
		return array('status' => 'OK', 'code' => 200, 'text' => 'Success', 'result' => $result);
	}
	
	protected function getEndPoint($path=null)
	{
		return $this->getSandbox()
			? "https://payments.sandbox.braintree-api.com/graphql"
			: "https://payments.braintree-api.com/graphql";
	}

	public function createCustomer($firstName, $lastName, $paymentMethodNonce)
	{
	    $xml = "<customer>".
	       "<firstName>$firstName</firstName>".
	       "<lastName>$lastName</lastName>".
	       "<paymentMethodNonce>$paymentMethodNonce</paymentMethodNonce>".
	    "</customer>";
	    
	    $data = $this->requestAPI('customers', $xml);
	    
	    if ($data['status'] != 'OK')
	    {
	        throw new Exception($data['text']);
	    }
	    
	    $response = new pjBraintreeSDKResponse($data['result']);
	    
	    if (!$response->isOK())
	    {
	        $errors = $response->getErrors();
	        $message = @$errors[0]['message'];
	        
	        throw new Exception($message);
	    }
	    
	    $arr = $response->toArray();
	    
	    return $arr['credit-cards']['credit-card']['token'];
	}
	
	public function createSubscription($planId, $token, $price)
	{
	    $xml = "<subscription>".
	       "<paymentMethodToken>$token</paymentMethodToken>".
           "<planId>$planId</planId>".
           "<neverExpires>true</neverExpires>".
           "<trialPeriod>false</trialPeriod>".
           "<price>$price</price>".
           "<options>".
               "<doNotInheritAddOnsOrDiscounts>true</doNotInheritAddOnsOrDiscounts>".
               "<startImmediately>true</startImmediately>".
           "</options>".
        "</subscription>";
	    
	    $data = $this->requestAPI('subscriptions', $xml);
	    
	    if ($data['status'] != 'OK')
	    {
	        throw new Exception($data['text']);
	    }
	    
	    $response = new pjBraintreeSDKResponse($data['result']);
	    
	    if (!$response->isOK())
	    {
	        $errors = $response->getErrors();
	        $message = @$errors[0]['message'];
	        
	        throw new Exception($message);
	    }
	    
	    $arr = $response->toArray();
	    
	    return $arr;
	}
	
	protected function requestAPI($path=null, $xml=null)
	{
		$http = new pjHttp();
		
		$http
    		->setMethod("POST")
    		->addHeader("Accept: application/xml")
    		->addHeader("Content-Type: application/xml")
    		->addHeader("User-Agent: Braintree PHP Library 5.3.1")
    		->addHeader("X-ApiVersion: 6")
    		->addHeader("Authorization: Basic " . base64_encode($this->getPublicKey(). ":" . $this->getPrivateKey()))
    		->setData($xml, false)
    		->curlRequest($this->getAPIEndPoint($path));
	
		$response = $http->getResponse();
		if (!$response)
		{
			return array('status' => 'ERR', 'code' => 102, 'text' => 'Empty response');
		}
	
		$response = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
		$response = json_encode($response);
		$result = json_decode($response, true);
		
		return array('status' => 'OK', 'code' => 200, 'text' => 'Success', 'result' => $result);
	}
	
	protected function getAPIEndPoint($path='')
	{
		return $this->getSandbox()
			? "https://api.sandbox.braintreegateway.com:443/merchants/" . $this->getMerchantId() . '/' . $path
			: "https://api.braintreegateway.com:443/merchants/" . $this->getMerchantId() . '/' . $path;
	}
}