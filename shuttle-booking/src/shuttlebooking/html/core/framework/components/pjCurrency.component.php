<?php
/**
 * PHP Framework
 *
 * @copyright Copyright 2018, PHPJabbets, Ltd.
 * @link      https://www.phpjabbers.com/
 * @package   framework.components
 * @version   2.1.0
 */
/**
 * pjCurrency class
 *
 * @package framework.components
 * @since 2.0.0
 */
class pjCurrency
{
    /**
     * Name of session variable
     *
     * @var string
     * @access private
     */
    private $sessionVariable = 'pjCurrency_data';
    
    /**
     * The Factory pattern allows for the instantiation of objects at runtime.
     *
     * @static
     * @access public
     * @return self
     */
    public static function factory()
    {
        return new pjCurrency();
    }
    
    /**
     * Return a sign for given currency
     *
     * @param string $currency
     * @access public
     * @static
     * @return string
     */
    public static function getCurrencySign($currency, $html=TRUE)
    {
        $sign = pjCurrency::factory()->getCurrencySymbol($currency);
        if ($sign !== FALSE)
        {
            return $sign;
        }
        return $html ? '<span class="pj-form-field-icon-text-small">' . $currency . '</span>' : $currency;
    }
    
    /**
     * Format price based on the given price format
     * 
     * @param float $price
     * @param int $price_format
     * @return string
     */
    public static function formatPriceOnly($price, $price_format = null)
    {
    	if (is_null($price)) {
    		return $price;
    	}
        $options = pjRegistry::getInstance()->get('options');

        $price_format = $price_format ?: (int) $options['o_price_format'];
        switch ($price_format)
        {
            case 1:
                $price = number_format($price, 0, '.', '');
                break;
            case 2:
                $price = number_format($price, 2, '.', '');
                break;
            case 3:
                $price = number_format($price, 0, '.', ',');
                break;
            case 4:
                $price = number_format($price, 2, '.', ',');
                break;
            case 5:
                $price = number_format($price, 0, '.', ' ');
                break;
            case 6:
                $price = number_format($price, 2, '.', ' ');
                break;
        }
        
        return $price;
    }
    
    public static function formatPrice($price, $separator = " ", $price_format = null)
    {
        $options = pjRegistry::getInstance()->get('options');
        
        $price = self::formatPriceOnly($price, $price_format);
        
        $currency = $options['o_currency'];
       
        $sign = pjCurrency::factory()->getCurrencySymbol($currency);
        
        $currencySign = $sign !== FALSE ? $sign : self::getCurrencySign($currency, false);
        
        switch ($options['o_currency_place'])
        {
            case 'front':
                return $currencySign . $separator . $price;
                break;
            case 'back':
            default:
                return $price . $separator . $currencySign;
                break;
        }
        
        return $price . $separator . self::getCurrencySign($currency);
    }
    
    /**
     * The setter to set the pair of currency CODE and system to session variable.
     * For example: USD => $
     * 
     * This method should be called at the beforeFilter method in pjAppController.
     * 
     * @param array $data
     * @return void
     */
    public function setCurrencyData()
    {
        if(!isset($_SESSION[$this->sessionVariable]))
        {
            if (class_exists('pjBaseCurrencyDataModel')) 
            {
                $data = pjBaseCurrencyDataModel::factory()->findAll()->getDataPair('code', 'sign');
                $_SESSION[$this->sessionVariable] = $data;
            }
        }
    }
    
    /**
     * Get array of currency symbols based on the input CODE.
     * It will return FALSE if not found.
     * 
     * @param string $code
     * @return mixed
     */
    public function getCurrencyData($code)
    {
        if(isset($_SESSION[$this->sessionVariable]))
        {
            return $_SESSION[$this->sessionVariable];
        }else{
            return FALSE;
        }
    }
    
    /**
     * Get currency symbol based on the input CODE. It will return FALSE if not found.
     * For example $code = "USD". The result will be "$".
     *
     * @param string $code
     * @return mixed
     */
    public function getCurrencySymbol($code)
    {
        if(isset($_SESSION[$this->sessionVariable]))
        {
            if(isset($_SESSION[$this->sessionVariable][$code]))
            {
                return $_SESSION[$this->sessionVariable][$code];
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
}
?>