<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjStripeSDK extends pjPaymentsSDK
{
	protected static $version = "2022-08-01";
	
	protected function getEndPoint($path=null)
	{
		return "https://api.stripe.com/v1/" . $path;
	}
	
	protected function request($path=null, $params=null)
	{
		$http = new pjHttp();
		
		if ($params)
		{
			$http->setMethod("POST");
			if (!is_bool($params))
            {
				$http->setData($params);
            }
		} else {
			$http->setMethod("GET");
		}
		
		$http
			->addHeader("Authorization: Basic " . base64_encode($this->getPrivateKey() . ":"))
			->addHeader("Stripe-Version: " . self::$version)
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
     * Create a PaymentIntent
     *
     * @param array $params
     * @return mixed
     * @throws Exception
     */
	public function create($params)
    {
        $data = $this->request('payment_intents', $params);
        if ($data['status'] != 'OK')
        {
            throw new Exception($data['text']);
        }

        $response = new pjStripeSDKResponse($data['result']);
        if (!$response->isOK())
        {
            $error = $response->getError();
            throw new Exception(@$error['message']);
        }

        return $data['result'];
    }

    /**
     * Cancel/refund a PaymentIntent
     *
     * @param string $id For example: pi_3KrNNH2eZvKYlo2C0NRfxpSD
     * @return mixed
     * @throws Exception
     */
    public function cancel($id)
    {
        $data = $this->request("payment_intents/$id/cancel", true);
        if ($data['status'] != 'OK')
        {
            throw new Exception($data['text']);
        }

        $response = new pjStripeSDKResponse($data['result']);
        if (!$response->isOK())
        {
            $error = $response->getError();
            throw new Exception(@$error['message']);
        }

        return $data['result'];
    }

    /**
     * Capture the funds of an existing uncaptured PaymentIntent
     *
     * @param string $id For example: pi_3KrNNH2eZvKYlo2C0NRfxpSD
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function capture($id, $params)
    {
        $data = $this->request("payment_intents/$id/capture", $params);
        if ($data['status'] != 'OK')
        {
            throw new Exception($data['text']);
        }

        $response = new pjStripeSDKResponse($data['result']);
        if (!$response->isOK())
        {
            $error = $response->getError();
            throw new Exception(@$error['message']);
        }

        return $data['result'];
    }

    /**
 * Creates a Session object.
 * 
 * @param array $params
 * @throws Exception
 * @return array
 */
	public function createSession($params)
	{
		$data = $this->request('checkout/sessions', $params);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjStripeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$error = $response->getError();
			throw new Exception(@$error['message']);
		}
		
		return $data['result'];
	}

	/**
 * Creates a Product object.
 * 
 * @param array $params
 * @throws Exception
 * @return array
 */
	public function createProduct($params)
	{
		$data = $this->request('products', $params);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjStripeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$error = $response->getError();
			throw new Exception(@$error['message']);
		}
		
		return $data['result'];
	}

	/**
 * Creates a Prices object.
 * 
 * @param array $params
 * @throws Exception
 * @return array
 */
	public function createPrice($params)
	{
		$data = $this->request('prices', $params);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjStripeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$error = $response->getError();
			throw new Exception(@$error['message']);
		}
		
		return $data['result'];
	}

	/**
 * List all events
 * 
 * @throws Exception
 * @return array
 */
	public function getEvents()
	{
		list($year, $month, $day) = explode("-", date("Y-n-j"));
		
		$queryString = http_build_query(array(
			'created' => array(
				'gte' => mktime(0, 0, 0, $month, $day, $year),
			),
		), null, '&');
		
		$data = $this->request('events?' . $queryString);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjStripeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$error = $response->getError();
			throw new Exception(@$error['message']);
		}
		
		return $data['result'];
	}
}