<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPaypalExpressSDK extends pjPaymentsSDK
{
	protected function getEndPointV1($path=null)
	{
		return $this->getSandbox()
		? 'https://api.sandbox.paypal.com/v1/' . $path
		: 'https://api.paypal.com/v1/' . $path;
	}
	
	protected function getEndPoint($path=null)
	{
		return $this->getSandbox()
			? 'https://api.sandbox.paypal.com/v2/' . $path
			: 'https://api.paypal.com/v2/' . $path;
	}
	
	protected function request($path=null, $params=null)
	{
		$http = new pjHttp();
		
		if (is_array($params))
		{
			$params = json_encode($params);
		}
		
		if ($params)
		{
			$http->setMethod("POST");
			$http->setData($params, false);
		} else {
			$http->setMethod("GET");
		}
		
		$http
			->addHeader("Content-Type: application/json")
			->addHeader("Authorization: Basic " . base64_encode($this->getMerchantId() . ":" . $this->getPrivateKey()))
			->curlRequest($this->getEndPoint($path));
		
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
/**
 * Show order details
 * 
 * @param string $order_id
 * @throws Exception
 * @return array
 */
	public function getOrder($order_id)
	{
		$data = $this->request('checkout/orders/' . $order_id);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjPaypalExpressSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$error = $response->getError();
			throw new Exception(@$error['message']);
		}
		
		return $data['result'];
	}
	
/**
 * Create Product
 * 
 * @throws Exception
 * @return array
 */
	public function createProduct($params)
	{
		$http = new pjHttp();
		
		if (is_array($params))
		{
			$params = json_encode($params);
		}
		
		if ($params)
		{
			$http->setMethod("POST");
			$http->setData($params, false);
		} else {
			$http->setMethod("GET");
		}
		
		$http
			->addHeader("Content-Type: application/json")
			->addHeader("Authorization: Basic " . base64_encode($this->getMerchantId() . ":" . $this->getPrivateKey()))
			->curlRequest($this->getEndPointV1('catalogs/products/'));
		
		$response = $http->getResponse();
		if (!$response)
		{
			return array('status' => 'ERR', 'code' => 102, 'text' => 'Empty response');
		}
		
		$result = json_decode($response, true);
		
		return $result;
	}

/**
 * Create Plan
 * 
 * @throws Exception
 * @return array
 */
	public function createPlan($params)
	{
		$http = new pjHttp();
		
		if ($params)
		{
			$http->setMethod("POST");
			$http->setData($params, false);
		} else {
			$http->setMethod("GET");
		}
		$http
			->addHeader("Content-Type: application/json")
			->addHeader("Authorization: Basic " . base64_encode($this->getMerchantId() . ":" . $this->getPrivateKey()))
			->curlRequest($this->getEndPointV1('billing/plans/'));
		
		$response = $http->getResponse();
		if (!$response)
		{
			return array('status' => 'ERR', 'code' => 102, 'text' => 'Empty response');
		}
		
		$result = json_decode($response, true);
		
		return $result;
	}

/**
 * Show order details
 * 
 * @param string $order_id
 * @throws Exception
 * @return array
 */
	public function getSubscription($subscription_id)
	{
		$http = new pjHttp();
		
		$http
			->setMethod("GET")
			->addHeader("Content-Type: application/json")
			->addHeader("Authorization: Basic " . base64_encode($this->getMerchantId() . ":" . $this->getPrivateKey()))
			->curlRequest($this->getEndPointV1('billing/subscriptions/' . $subscription_id));

		$response = $http->getResponse();

		if (!$response)
		{
			return array('status' => 'ERR', 'code' => 102, 'text' => 'Empty response');
		}
		
		$result = json_decode($response, true);
		
		return $result;
	}
}