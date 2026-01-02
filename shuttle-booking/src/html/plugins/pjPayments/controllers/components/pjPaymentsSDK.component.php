<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
abstract class pjPaymentsSDK
{
	protected $merchantId;
	
	protected $privateKey;
	
	protected $publicKey;
	
	protected $sandbox;
	
	public function __construct($merchant_id=null, $public_key=null, $private_key=null, $sandbox=false)
	{
		$this->setMerchantId($merchant_id);
		$this->setPublicKey($public_key);
		$this->setPrivateKey($private_key);
		$this->setSandbox($sandbox);
	}
	
	abstract protected function request($path=null, $params=null);
	
	abstract protected function getEndPoint($path=null);
	
	public function getMerchantId()
	{
		return $this->merchantId;
	}
	
	public function getPrivateKey()
	{
		return $this->privateKey;
	}
	
	public function getPublicKey()
	{
		return $this->publicKey;
	}
	
	public function getSandbox()
	{
		return $this->sandbox;
	}
	
	public function setMerchantId($value)
	{
		$this->merchantId = $value;
		
		return $this;
	}
	
	public function setPrivateKey($value)
	{
		$this->privateKey = $value;
		
		return $this;
	}
	
	public function setPublicKey($value)
	{
		$this->publicKey = $value;
		
		return $this;
	}
	
	public function setSandbox($value)
	{
		$this->sandbox = (bool) $value;
		
		return $this;
	}
}