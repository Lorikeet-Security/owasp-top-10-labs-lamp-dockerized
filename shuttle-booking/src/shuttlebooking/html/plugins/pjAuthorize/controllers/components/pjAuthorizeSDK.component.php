<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuthorizeSDK extends pjPaymentsSDK
{
	protected function getEndPoint($path=null)
	{
		return $this->getSandbox()
			? "https://apitest.authorize.net/xml/v1/request.api"
			: "https://api.authorize.net/xml/v1/request.api";
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
			->setData($params, false)
			->addHeader("Content-Type: application/json")
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
		
		# Remove Byte-order-mask (BOM)
		$bom = pack('CCC', 0xEF, 0xBB, 0xBF);
		if (substr($response, 0, 3) === $bom)
		{
			$response = substr($response, 3);
		}
		
		$result = json_decode($response, true);
		
		return array('status' => 'OK', 'code' => 200, 'text' => 'Success', 'result' => $result);
	}
	
	public function createCustomer($transId)
	{
	    $params = array(
	        'createCustomerProfileFromTransactionRequest' => array(
	            'merchantAuthentication' => array(
	                'name' => $this->getMerchantId(),
	                'transactionKey' => $this->getPublicKey(),
	            ),
	            'transId' => $transId,
	        )
	    );
	    
	    $data = $this->request(null, $params);
	    
	    if ($data['status'] != 'OK')
	    {
	        throw new Exception($data['text']);
	    }
	    
	    $response = new pjAuthorizeSDKResponse($data['result']);
	    if (!$response->isOK())
	    {
	        $errors = $response->getErrors();
	        throw new Exception(@$errors[0]['text']);
	    }
	    
	    return $data['result'];
	}
	
	public function createSubscription($amount, $invoiceNumber, $description, $customer_profile_id, $customer_payment_profile_id, $interval_length=null, $interval_unit=null)
	{
	    if (!in_array($interval_unit, array('days', 'months')))
	    {
	        $interval_unit = 'months';
	    }
	    
	    if ($interval_unit == 'days' && !($interval_length >= 7 && $interval_length <= 365))
	    {
	        $interval_length = 7;
	    } elseif ($interval_unit == 'months' && !($interval_length >= 1 && $interval_length <= 12)) {
	        $interval_length = 1;
	    }
	    
	    $interval_length = $interval_length ? $interval_length : 1;
	    
		$params = array(
			'ARBCreateSubscriptionRequest' => array(
				'merchantAuthentication' => array(
					'name' => $this->getMerchantId(),
					'transactionKey' => $this->getPublicKey(),
				),
				'refId' => $invoiceNumber,
				'subscription' => array(
					'name' => $description,
					'paymentSchedule' => array(
						'interval' => array(
						    'length' => $interval_length,
						    'unit' => $interval_unit,
						),
						'startDate' => date('Y-m-d'),
						'totalOccurrences' => '9999',
						'trialOccurrences' => '0',
					),
					'amount' => $amount,
					'trialAmount' => '0.00',
				    'profile' => array(
				        'customerProfileId' => $customer_profile_id,
				        'customerPaymentProfileId' => $customer_payment_profile_id,
				    ),
				),
			),
		);
	
		$data = $this->request(null, $params);
		
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
	
		$response = new pjAuthorizeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			throw new Exception(@$errors[0]['text']);
		}
		
		return $data['result'];
	}
	
	public function getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId)
	{
	    $params = array(
	        'getCustomerPaymentProfileRequest' => array(
	            'merchantAuthentication' => array(
	                'name' => $this->getMerchantId(),
	                'transactionKey' => $this->getPublicKey(),
	            ),
	            'customerProfileId' => $customerProfileId,
	            'customerPaymentProfileId' => $customerPaymentProfileId,
	            'includeIssuerInfo' => 'true',
	        )
	    );
	    
	    $data = $this->request(null, $params);
	    
	    if ($data['status'] != 'OK')
	    {
	        throw new Exception($data['text']);
	    }
	    
	    $response = new pjAuthorizeSDKResponse($data['result']);
	    if (!$response->isOK())
	    {
	        $errors = $response->getErrors();
	        throw new Exception(@$errors[0]['text']);
	    }
	    
	    return $data['result'];
	}
	
	public function updateCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId, $billTo, $payment)
	{
	    $params = array(
	        'updateCustomerPaymentProfileRequest' => array(
	            'merchantAuthentication' => array(
	                'name' => $this->getMerchantId(),
	                'transactionKey' => $this->getPublicKey(),
	            ),
	            'customerProfileId' => $customerProfileId,
	            'paymentProfile' => array(
	                'billTo' => $billTo,
	                'payment' => $payment,
	                'customerPaymentProfileId' => $customerPaymentProfileId,
	            ),
	        )
	    );
	    
	    $data = $this->request(null, $params);
	    
	    if ($data['status'] != 'OK')
	    {
	        throw new Exception($data['text']);
	    }
	    
	    $response = new pjAuthorizeSDKResponse($data['result']);
	    if (!$response->isOK())
	    {
	        $errors = $response->getErrors();
	        throw new Exception(@$errors[0]['text']);
	    }
	    
	    return $data['result'];
	}
	
	public function getClientToken($amount, $invoiceNumber, $description, $url, $cancelUrl, $iframeUrl, $payText='Pay', $urlText='Continue', $cancelText='Cancel')
	{
		$params = array(
			'getHostedPaymentPageRequest' => array(
				'merchantAuthentication' => array(
					'name' => $this->getMerchantId(),
					'transactionKey' => $this->getPublicKey()
				),
				'transactionRequest' => array(
					'transactionType' => 'authCaptureTransaction',
					'amount' => $amount,
					'order' => array(
						'invoiceNumber' => $invoiceNumber,
						'description' => $description
					)
				),
				'hostedPaymentSettings' => array(
					'setting' => array(
						array(
							'settingName' => 'hostedPaymentBillingAddressOptions',
							'settingValue' => '{"show": false, "required": false}'
						),
						array(
							'settingName' => 'hostedPaymentButtonOptions',
							'settingValue' => '{"text": "'. $payText .'"}'
						),
						array(
							'settingName' => 'hostedPaymentReturnOptions',
							'settingValue' => '{"showReceipt": false, "url": "'.$url.'", "urlText": "'.$urlText.'", "cancelUrl": "'.$cancelUrl.'", "cancelUrlText": "'.$cancelText.'"}'
						),
						array(
							'settingName' => 'hostedPaymentIFrameCommunicatorUrl',
							'settingValue' => '{"url": "'. $iframeUrl .'"}'
						)
					)
				),
			),
		);
		
		$data = $this->request(null, $params);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}
		
		$response = new pjAuthorizeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			throw new Exception(@$errors[0]['text']);
		}
		
		return $data['result']['token'];
	}

	public function getTransactionDetails($id)
	{
		$params = array(
			'getTransactionDetailsRequest' => array(
				'merchantAuthentication' => array(
					'name' => $this->getMerchantId(),
					'transactionKey' => $this->getPublicKey()
				),
				'transId' => $id
			)
		);
		
		$data = $this->request(null, $params);
		if ($data['status'] != 'OK')
		{
			throw new Exception($data['text']);
		}

		$response = new pjAuthorizeSDKResponse($data['result']);
		if (!$response->isOK())
		{
			$errors = $response->getErrors();
			throw new Exception(@$errors[0]['text']);
		}
		
		return $data['result']['transaction'];
	}
}