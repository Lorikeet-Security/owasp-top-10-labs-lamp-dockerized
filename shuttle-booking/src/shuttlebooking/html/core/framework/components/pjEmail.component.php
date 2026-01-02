<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
/**
 * PHP Framework
 *
 * @copyright Copyright 2018, PHPJabbets, Ltd.
 * @link      https://www.phpjabbers.com/
 * @package   framework.components
 * @version   2.1.0
 */
/**
 * Email class
 *
 * @package framework.components
 * @since 1.0.0
 */
class pjEmail
{
/**
 * Attachments
 *
 * @var array
 * @access private
 */
	private $attachments = array();
/**
 * Email regular expression
 *
 * @var string
 * @access private
 */
	private $emailRegExp = '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i';
/**
 * End of line
 *
 * @var string
 * @access private
 */
	private $eol = "\r\n";
/**
 * Content type
 *
 * @var string
 * @access private
 */
	private $contentType = "text/plain";
/**
 * Charset
 *
 * @var string
 * @access private
 */
	private $charset = "utf-8";
/**
 * Header 'Content-Transfer-Encoding:'
 *
 * @var array
 * @access private
 */
	private $charset8bit = array('UTF-8', 'SHIFT_JIS');
/**
 * Headers
 *
 * @var array
 * @access private
 */
	private $headers = array();
/**
 * Header 'From:' (Sender)
 *
 * @var string
 * @access private
 */
	private $from = NULL;
/**
 * Header 'From:' (Sender name)
 *
 * @var string
 * @access private
 */
	private $fromName = NULL;
/**
 * Header 'To:' (Recipient)
 *
 * @var string
 * @access private
 */
	private $to = NULL;
/**
 * Header 'To:' (Recipient name)
 *
 * @var string
 * @access private
 */
	private $toName = NULL;
/**
 * Header 'Subject:'
 *
 * @var string
 * @access private
 */
	private $subject = NULL;
/**
 * Used for multipart messages
 *
 * @var array Accept next indexes: 'mimetype', 'charset', 'content'
 * @access private
 */
	private $part = NULL;
/**
 * Unique ID
 *
 * @var string
 * @access private
 */
	private $uid = NULL;
/**
 * HTTP transport used for sending mails
 *
 * @var string Accept two values: 'mail' and 'smtp'
 * @access private
 */
	private $transport = 'mail'; //mail or smtp
/**
 * SMTP hostname
 *
 * @var string
 * @access private
 */
	private $smtpHost = NULL;
/**
 * SMTP port number
 *
 * @var int
 * @access private
 */
	private $smtpPort = 25;
/**
 * SMTP username
 *
 * @var string
 * @access private
 */
	private $smtpUser = NULL;
/**
 * SMTP password
 *
 * @var string
 * @access private
 */
	private $smtpPass = NULL;
	
/**
 * SMTP secure
 *
 * @var string
 * @access private
 */
    private $smtpSecure = '';
    
/**
 * SMTP Auth Type
 *
 * @var string
 * @access private
 */
    private $smtpAuthType = '';
    
/**
 * 
 * @var object
 */
    private $debugger = NULL;
    
/**
 * Array for errors:
 * key will be error code
 * value will be corresponding error message.
 * 
 * @var array
 */
    private $codes = array(
        100 => 'To email address is not valid.',
        101 => 'From email address is not valid.',
        102 => 'Header is not valid.',
        103 => 'Content type given does not exist.',
        104 => 'Email could not be sent.',
    );
    
/**
 * 
 * @var string
 */
    private $errorCode = NULL;
    
/**
 * Keep the error message with unknown code
 * 
 * @var string
 */
    private $errorMessage = NULL;
    
/**
 * Constructor - automatically called when you create a new instance of a class with new
 *
 * @access public
 * @return self
 */
	public function __construct()
	{
		$this->uid = md5(uniqid(rand(), true));
	}
/**
 * Attach a file
 *
 * Example:
 * <code>
 * $pjEmail = new pjEmail();
 * $pjEmail
 *     ->attach('2013/09/3d5d32c134911623e025fbdf7edb1edf.pdf', 'FancyDocName.pdf', 'application/pdf')
 *     ->attach('2013/09/68cdcb5abcace851631df9eddefc4131.psd', 'myDesign.psd', 'image/vnd.adobe.photoshop');
 * </code>
 *
 * @param string $filename
 * @param string $name
 * @param string $mimetype
 * @access public
 * @return self
 */
	public function attach($filename, $name=NULL, $mimetype='application/octet-stream')
	{
		$this->attachments[] = array(
			'filename' => $filename,
			'name' => !is_null($name) ? $name : basename($filename),
			'mimetype' => $mimetype
		);
		return $this;
	}
/**
 * Detach previously attached file
 *
 * Example:
 * <code>
 * $pjEmail = new pjEmail();
 * $pjEmail
 *     ->attach('2013/09/3d5d32c134911623e025fbdf7edb1edf.pdf', 'FancyDocName.pdf', 'application/pdf')
 *     ->attach('2013/09/68cdcb5abcace851631df9eddefc4131.psd', 'myDesign.psd', 'image/vnd.adobe.photoshop');
 * //...
 * //send email or do something else
 * //...
 * $pjEmail->detach('2013/09/3d5d32c134911623e025fbdf7edb1edf.pdf'); //Detach 1st attachmend
 * $pjEmail->detach(NULL, 1); //Detach 2nd attachmend (indexes starts from 0)
 * </code>
 *
 * @param string $filename
 * @param int $index
 * @access public
 * @return self
 */
	public function detach($filename=NULL, $index=-1)
	{
		if (!empty($filename))
		{
			foreach ($this->attachments as $key => $attachment)
			{
				if ($attachment['filename'] == $filename)
				{
					$this->attachments[$key] = NULL;
					unset($this->attachments[$key]);
				}
			}
		}
		
		if ($index > -1 && array_key_exists($index, $this->attachments))
		{
			$this->attachments[$index] = NULL;
			unset($this->attachments[$index]);
		}
		
		if (is_null($filename) && $index == -1)
		{
			$this->attachments = array();
		}

		return $this;
	}
/**
 * Encode and return given value
 *
 * @param string $value
 * @access private
 * @static
 * @return
 */
	private static function encode($value)
	{
		if (empty($value))
		{
			return;
		}
		
		return '=?UTF-8?B?' . base64_encode($value) . '?=';
	}
/**
 * Get content transfer encoding
 *
 * @access private
 * @return string
 */
	private function getContentTransferEncoding()
	{
		$charset = strtoupper($this->charset);
		if (in_array($charset, $this->charset8bit))
		{
			return '8bit';
		}
		return '7bit';
	}
/**
 * Get header by given name
 *
 * @param string $name
 * @access public
 * @return string|false
 */
	public function getHeader($name)
	{
		foreach ($this->getHeaders() as $header)
		{
			list($key,) = explode(":", $header);
			if (strtolower($name) == strtolower(trim($key)))
			{
				return $header;
			}
		}
		return FALSE;
	}
/**
 * Get all headers
 *
 * @access public
 * @return array
 */
	public function getHeaders()
	{
		return $this->headers;
	}

/**
 * Send email
 *
 * @param string $body
 * @access public
 * @return boolean
 */
	public function send($body)
	{
		if (!preg_match($this->emailRegExp, $this->to))
		{
		    $this->errorCode = 100;
		    $this->log(100);
			return false;
		}

		if (!preg_match($this->emailRegExp, $this->from))
		{
		    $this->errorCode = 101;
		    $this->log(101);
			return false;
		}
		
		if ($this->contentType === 'text/plain')
		{
			$body = html_entity_decode($body, ENT_QUOTES, $this->charset);
		}
		
		$mail = new pjPHPMailer();
		$mail->set('CharSet', $this->charset);
		$mail->set('ContentType', $this->contentType);
		if($this->transport == 'mail')
		{
		    $mail->isMail();
		}else{
		    $mail->isSMTP();
		}
		try {
		    if($this->transport == 'smtp')
		    {
		        $mail->Host = $this->smtpHost;
		        $mail->Port = $this->smtpPort;
		        if(in_array($this->smtpSecure, array('ssl', 'tls')))
                {
                    $mail->SMTPSecure = $this->smtpSecure;
                    $mail->Host = str_ireplace(array('ssl://', 'tls://'), array('', ''), $mail->Host);
                }
		        if (!empty($this->smtpUser))
		        {
		            $mail->SMTPAuth = true;
		            $mail->AuthType = $this->smtpAuthType;
		            $mail->Username = $this->smtpUser;
		            $mail->Password = $this->smtpPass;
		        }
		    }
		    $sender = $this->getHeader('Sender');
		    if ($sender !== FALSE)
		    {
		        list(, $string) = explode(':', $sender);
		        $mail->Sender = trim($string);
		        $mail->addCustomHeader('Sender', $mail->Sender);
		    }
		    $mail->addAddress($this->to, $this->toName);
		    $mail->setFrom($this->from, $this->fromName, false);
		    
		    $mail->clearReplyTos();
		    $mail->addReplyTo($this->from, $this->fromName);
		    # Fix for Reply-To header
		    $reply_to = $this->getHeader('Reply-To');
		    if ($reply_to !== FALSE)
		    {
		        $mail->clearReplyTos();
		        list(, $string) = explode(':', $reply_to);
		        $string = trim($string);
		        if (preg_match('|^(.*)\s<(.*)>$|', $string, $m))
		        {
		            $mail->addReplyTo($m[2], $m[1]);
		        } else {
		            $mail->addReplyTo($string);
		        }
		    }
		    $mail->Subject = $this->subject;
		    $mail->Body = $body;
		    if (!empty($this->part))
		    {
		        $mail->AltBody = $this->part['content'];
		    }
		    if ($this->contentType == 'text/html')
		    {
		        $mail->isHTML(true);
		    }
		    foreach ($this->attachments as $attachment)
		    {
		        if (!empty($attachment['filename']) && is_file($attachment['filename']))
		        {
		            $mail->addAttachment($attachment['filename']);
		        }
		    }
		    if (!$mail->send())
		    {
		        $this->errorCode = 104;
		        $this->log(104);
		        return false;
		    } else {
		        return true;
		    }
		}catch (pjException $e) {
		    $this->errorMessage = $e->errorMessage();
		    $this->log($e->errorMessage());
		    return false;
		} catch (Exception $e) {
		    $this->errorMessage = $e->errorMessage();
		    $this->log($e->errorMessage());
		    return false;
		}
	}
/**
 * Add multi-part (multipart messages)
 *
 * Example:
 * <code>
 * $pjEmail = new pjEmail();
 * $pjEmail->addPart('<html><head><title></title></head><body><strong>Some html</strong> text.<p>New paragraph goes here</p></body></html>', 'text/html');
 * //or
 * $pjEmail->setContentType('text/html')->addPart('Some simple plain text', 'text/plain');
 * </code>
 *
 * @param string $content
 * @param string $mimetype
 * @param string $charset
 * @access public
 * @return self
 */
	public function addPart($content, $mimetype, $charset=NULL)
	{
		$this->part = compact('content', 'mimetype', 'charset');
		
		return $this;
	}
/**
 * Add custom header
 *
 * @param string $header
 * @access public
 * @return self
 */
	public function setHeader($header)
	{
		if (strpos($header, ":") === FALSE)
		{
		    $this->errorCode = 102;
		    $this->log(102);
			return FALSE;
		}
		list($name,) = explode(":", $header);
		$name = strtolower(trim($name));
		foreach ($this->getHeaders() as $i => $h)
		{
			list($key,) = explode(":", $h);
			if ($name == strtolower(trim($key)))
			{
				$this->headers[$i] = NULL;
				unset($this->headers[$i]);
				break;
			}
		}
		array_push($this->headers, $header);
		$this->headers = array_values($this->headers);
		return $this;
	}
/**
 * Set charset
 *
 * @param string $charset
 * @access public
 * @return self
 */
	public function setCharset($charset)
	{
		$this->charset = $charset;
		return $this;
	}
/**
 * Set content type
 *
 * @param string $contentType
 * @access public
 * @return self
 */
	public function setContentType($contentType)
	{
		if (!in_array($contentType, array('text/plain', 'text/html', 'multipart/mixed', 'multipart/alternative')))
		{
		    $this->errorCode = 103;
		    $this->log(103);
			return false;
		}
		$this->contentType = $contentType;
		return $this;
	}
/**
 * Set end of line
 *
 * @param string $eol
 * @access public
 * @return self
 */
	public function setEol($eol)
	{
		$this->eol = $eol;
		return $this;
	}
/**
 * Set header 'Bcc:'
 *
 * @param string $email
 * @param string $name
 * @access public
 * @return self
 */
	public function setBcc($email, $name=NULL)
	{
		if (!is_null($name))
		{
			$name = trim(preg_replace('/[\r\n]+/', '', $name));
			$email = sprintf("%s <%s>", self::encode($name), $email);
		}
		$this->setHeader("Bcc: $email");
		return $this;
	}
/**
 * Set header 'Cc:'
 *
 * @param string $email
 * @param string $name
 * @access public
 * @return self
 */
	public function setCc($email, $name=NULL)
	{
		if (!is_null($name))
		{
			$name = trim(preg_replace('/[\r\n]+/', '', $name));
			$email = sprintf("%s <%s>", self::encode($name), $email);
		}
		$this->setHeader("Cc: $email");
		return $this;
	}
/**
 * Set header 'From:'
 *
 * @param string $email
 * @param string $name
 * @access public
 * @return self
 */
	public function setFrom($email, $name=NULL)
	{
		if (!is_null($name))
		{
			$name = trim(preg_replace('/[\r\n]+/', '', $name));
		}
		$this->from = $email;
		$this->fromName = self::encode($name);
		return $this;
	}
/**
 * Set header 'Reply-To:'
 *
 * @param string $email
 * @param string $name
 * @access public
 * @return self
 */
	public function setReplyTo($email, $name=NULL)
	{
		if (!is_null($name))
		{
			$name = trim(preg_replace('/[\r\n]+/', '', $name));
			$email = sprintf("%s <%s>", self::encode($name), $email);
		}
		$this->setHeader("Reply-To: $email");
		return $this;
	}
/**
 * Set header 'Return-Path:'
 *
 * @param string $email
 * @access public
 * @return self
 */
	public function setReturnPath($email)
	{
		$this->setHeader("Return-Path: $email");
		return $this;
	}
/**
 * Set header 'Sender:'
 * 
 * @param string $email
 * @access public
 * @return self
 */
	public function setSender($email)
	{
		$this->setHeader("Sender: $email");
		return $this;
	}
/**
 * Set header 'Subject:'
 *
 * @param string $subject
 * @access public
 * @return self
 */
	public function setSubject($subject)
	{
		$this->subject = self::encode($subject);
		return $this;
	}
/**
 * Set SMTP host
 *
 * @param string $host
 * @access public
 * @return self
 */
	public function setSmtpHost($host)
	{
		$this->smtpHost = $host;
		return $this;
	}
/**
 * Set SMTP port number
 *
 * @param int $port
 * @access public
 * @return self
 */
	public function setSmtpPort($port)
	{
		$this->smtpPort = $port;
		return $this;
	}
/**
 * Set SMTP username
 *
 * @param string $username
 * @access public
 * @return self
 */
	public function setSmtpUser($username)
	{
		$this->smtpUser = $username;
		return $this;
	}
/**
 * Set SMTP password
 *
 * @param string $password
 * @access public
 * @return self
 */
	public function setSmtpPass($password)
	{
		$this->smtpPass = $password;
		return $this;
	}
/**
 * Set header 'To:'
 *
 * @param string $email
 * @param string $name
 * @access public
 * @return self
 */
	public function setTo($email, $name=NULL)
	{
		if (!is_null($name))
		{
			$name = trim(preg_replace('/[\r\n]+/', '', $name));
		}
		$this->to = $email;
		$this->toName = self::encode($name);
		return $this;
	}
/**
 * Set HTTP transport
 *
 * @param string $transport
 * @access public
 * @return self
 */
	public function setTransport($transport)
	{
		if (in_array($transport, array('mail', 'smtp')))
		{
			$this->transport = $transport;
		}
		return $this;
	}
	
/**
 * Set SMTP Secure tls or ssl
 *
 * @param string $value
 * @access public
 * @return self
 */
    public function setSmtpSecure($value)
    {
    	if (in_array($value, array('', 'ssl', 'tls')))
    	{
    		$this->smtpSecure = $value;
    	}
        return $this;
    }
    
/**
 * Set SMTP Auth Type
 *
 * @param int $method
 * @access public
 * @return self
 */
    public function setSmtpAuthType($type)
    {
    	if (in_array($type, array('CRAM-MD5', 'LOGIN', 'PLAIN', 'XOAUTH2')))
    	{
        	$this->smtpAuthType = $type;
    	}
        return $this;
    }
    
/**
 * Set Debugger
 *
 * @param object $debugger
 * @access public
 * @return self
 */
    public function setDebugger($debugger)
    {
        $this->debugger = $debugger;
        return $this;
    }

/**
 * Return the errorCode
 *
 * @return string
 */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    
/**
 * Return the error message
 *
 * @return string
 */
    public function getErrorMessage()
    {
        if(!is_null($this->errorCode))
        {
            if(isset($this->codes[$this->errorCode]))
            {
                return $this->codes[$this->errorCode];
            }else{
                return $this->errorMessage;
            }
        }else{
            return $this->errorMessage;
        }
    }
/**
 * Write log using pjBase plugin, before then we need to set logger.
 * From the controller we should set like
 * $pjEmail->setDebugger($this); 
 * to save logs
 * 
 * If the $code is not found the codes array,
 * it will consider $code as message to be logged.
 * 
 * @param string $code
 * @access protected
 * @return void
 */    
    protected function log($code)
    {
        if(!is_null($this->debugger))
        {
            if(isset($this->codes[$code]))
            {
                $this->debugger->log($this->codes[$code]);
            }else{
                $this->debugger->log($code);
            }
        }
    }
}
?>