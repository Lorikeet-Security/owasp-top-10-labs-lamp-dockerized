<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjMollieSDK extends pjPaymentsSDK
{
	protected function getEndPoint($path=null)
	{
		return "https://api.mollie.com/v2/" . $path;
	}
	
	protected function request($path=null, $params=null)
	{
		$http = new pjHttp();
		
		if ($params)
		{
			$http->setMethod("POST");
			$http->setData($params);
		} else {
			$http->setMethod("GET");
		}
		
		$http
			->addHeader("Authorization: Bearer " . $this->getPublicKey())
			->curlRequest($this->getEndPoint($path));
		
		$error = $http->getError();
		if ($error)
		{
			return array('status' => 'ERR', 'code' => 100, 'text' => $error['text']);
		}
		
		if (method_exists($http, 'getHttpCode') && !in_array($http->getHttpCode(), array(200, 201)))
		{
			return array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP Code: ' . $http->getHttpCode() . $http->getResponse());
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
 * Create payment
 *
 * @param array $params
 * @throws Exception
 * @return array
 */
	public function createPayment($params)
	{
		$data = $this->request('payments', $params);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result'];
	}
	
/**
 * Create customer
 *
 * @param array $params
 * @throws Exception
 * @return array
 */
	public function createCustomer($params)
	{
		$data = $this->request('customers', $params);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result'];
	}
	
	/**
	 * Create subscription
	 *
	 * @param array $params
	 * @throws Exception
	 * @return array
	 */
	public function createSubscription($customer_id, $params)
	{
		$data = $this->request('customers/' . $customer_id . '/subscriptions', $params);
	
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
	
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
	
		return $data['result'];
	}
/**
 * Retrieve all payment methods that Mollie offers
 * 
 * @param string $include Additional information, e.g. ?include=issuers
 * @throws Exception
 * @return array
 */
	public function getAllMethods($include=null)
	{
		$data = $this->request('methods/all' . $include);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result']['_embedded']['methods'];
	}
/**
 * Retrieve a single method by its ID
 *
 * @param string $method Method ID, e.g. ideal
 * @throws Exception
 * @return array
 */
	public function getMethod($method)
	{
		$data = $this->request('methods/' . $method);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result'];
	}
/**
 * Retrieve all enabled payment methods
 *
 * @param string $include Additional information, e.g. ?include=issuers
 * @throws Exception
 * @return array
 */
	public function getMethods($include=null)
	{
		$data = $this->request('methods' . $include);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result']['_embedded']['methods'];
	}
/**
 * Retrieve a single payment object by its payment token
 * 
 * @param string $id Payment token, for example tr_2Fmj4bxfp4
 * @throws Exception
 * @return array
 */
	public function getPayment($id)
	{
		$data = $this->request('payments/' . $id);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjMollieSDKResponse($data['result']);
		if (!$response->isOK())
		{
			throw new Exception("Invalid response data.");
		}
		
		return $data['result'];
	}
}