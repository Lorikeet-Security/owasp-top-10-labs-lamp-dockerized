<?php
class pjSmsApi extends pjBase
{
	private $apiUsername;
	
	private $apiKey;
	
	private $number;
	
	private $numbers = array();
	
	private $text;
	
	private $type = "";
	
	private $sender = "";
	
	private $url = 'https://rest.clicksend.com/v3/sms/send';
	
	public function __construct()
    {
        
    }
    
	public function getNumber()
	{
		return $this->number;
	}
	
	public function getNumbers()
	{
		return $this->numbers;
	}
	
	public function getText()
	{
		return $this->text;
	}
	
	public function send()
	{
		if (empty($this->apiUsername) || empty($this->apiKey)) {
            $base_option_arr = pjBaseOptionModel::factory()->getPairs($this->getForeignId());
            $this->apiUsername = $base_option_arr['plugin_sms_api_username'];
            $this->apiKey = $base_option_arr['plugin_sms_api_key'];            
		}
		if (empty($this->apiUsername) || empty($this->apiKey)) {
			return FALSE;
		}
		$text = $this->getText();
		
		$isUnicode = FALSE;
		if (preg_match('/[^\x20-\x7f]/', $text))
		{
			$isUnicode = TRUE;
		}
		
		if ($isUnicode)
		{
			if (pjMultibyte::strlen($text) > 70)
			{
				$this->setType('longunicode');
			} else {
				$this->setType('unicode');
			}
			$text = self::toUnicode($text);
		} else {
			if (strlen($text) > 160)
			{
				$this->setType('LongSMS');
			} else {
				$this->setType('SMS');
			}
		}
		$headers = array(
			"Content-type: application/json",
		  	"Authorization: Basic ".base64_encode($this->apiUsername . ":" . $this->apiKey)
		);
		$numbers = $this->getNumbers();
		$message_arr = array();
		if ($numbers) {
			foreach ($numbers as $number) {
				$message_arr[] = array(
				'source' => 'php',
					'body' => $text,
					'to' => $number
				);
			}
		} else {
			$message_arr[] = array(
				'source' => 'php',
				'body' => $text,
				'to' => $this->getNumber()
			);
		}
		$data = array('messages' => $message_arr);
		
		$http = new pjHttp();
		$response = $http->setHeaders($headers)
			->setMethod('POST')
			->setData(json_encode($data), false)
			->request($this->url)
			->getResponse();		
		if (function_exists('json_decode'))
        {
            $response = json_decode($response, true);
        } else {        
	        $Services_JSON = new pjServices_JSON(SERVICES_JSON_LOOSE_TYPE);
	        $response = $Services_JSON->decode($response);
        }
        return $response['response_code'] == 'SUCCESS' ? 1 : $response['response_code'];
	}
	
	public function setApiUsername($str)
	{
		$this->apiUsername = $str;
		return $this;
	}
	
	public function setApiKey($str)
	{
		$this->apiKey = $str;
		return $this;
	}
	
	public function setNumber($str)
	{
		$str = preg_replace('/^00/', '', $str);
		$str = preg_replace('/\D/', '', $str);
		
		$this->number = $str;
		return $this;
	}
	
	public function setNumbers($array)
	{
		$arr = array();
		foreach ($array as $number) {
			$number = preg_replace('/^00/', '', $number);
			$number = preg_replace('/\D/', '', $number);	
			$arr[] = $number;
		}
		$this->numbers = $arr;
		return $this;
	}
	
	public function setText($str)
	{
		$str = strip_tags($str);
		$str = htmlspecialchars_decode($str, ENT_QUOTES);
		
		$this->text = $str;
		return $this;
	}

	public function setType($str)
	{
		$this->type = $str;
		return $this;
	}
	
	public function setSender($str)
	{
		$this->sender = $str;
		return $this;
	}

	static public function toUnicode($str)
	{
		$encoding = pjMultibyte::detect_encoding($str);
		
		$charsets = array(
			'ISO-8859-1', 'ISO8859-1',
			'ISO-8859-5', 'ISO8859-5',
			'ISO-8859-15', 'ISO8859-15',
			'UTF-8',
			'cp866', 'ibm866', '866',
			'cp1251', 'Windows-1251', 'win-1251', '1251',
			'cp1252', 'Windows-1252', '1252',
			'KOI8-R', 'koi8-ru', 'koi8r',
			'BIG5', '950',
			'GB2312', '936',
			'BIG5-HKSCS',
			'Shift_JIS', 'SJIS', 'SJIS-win', 'cp932', '932',
			'EUC-JP', 'EUCJP', 'eucJP-win',
			'MacRoman',
			'',
		);
		
		if (!in_array($encoding, $charsets))
		{
			$encoding = 'UTF-8';
		}
		
		$string = html_entity_decode($str, ENT_QUOTES, $encoding);
		$string = pjMultibyte::convert_encoding($string, 'UCS-2');
		$result = "";
		$iCnt = strlen($string);
		for ($i = 0; $i < $iCnt; $i++)
		{
			$result .= strtoupper(bin2hex($string[$i]));
		}

		return $result;
	}
}
?>