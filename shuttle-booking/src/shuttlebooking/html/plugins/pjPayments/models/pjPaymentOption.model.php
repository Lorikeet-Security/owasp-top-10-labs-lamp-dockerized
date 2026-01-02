<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPaymentOptionModel extends pjPaymentsAppModel
{
	protected $primaryKey = 'id';

	protected $table = 'plugin_payment_options';

	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'payment_method', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'merchant_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'merchant_email', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'public_key', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'private_key', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'tz', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'success_url', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'failure_url', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'description', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'is_active', 'type' => 'tinyint', 'default' => 0),
        array('name' => 'is_hold_on', 'type' => 'tinyint', 'default' => 0),
		array('name' => 'is_test_mode', 'type' => 'tinyint', 'default' => 0),
		array('name' => 'test_merchant_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'test_merchant_email', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'test_public_key', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'test_private_key', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'test_tz', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'type', 'type' => 'enum', 'default' => 'online'),
	);

    public static function factory($attr=array())
    {
        return new pjPaymentOptionModel($attr);
    }

    /**
     * Find the settings for the used payment methods
     *
     * @param int|null $foreign_id Used if different settings are used for each different entry (property, listing etc.). NULL is for the default script options.
     * @return array
     */
    public function getOptions($foreign_id = null, $payment_method = null)
    {
        if ($payment_method)
        {
            $this->where('payment_method', $payment_method);
        }
        
        if ($foreign_id === null || $foreign_id == '')
        {
        	$this->where('foreign_id IS NULL');
        } else {
	        $this->where('foreign_id', $foreign_id);
        }
        if (!defined("PJ_ENABELE_OFFLINE_PAYMENTS"))
        {
            $this->where('type', 'online');
        }
        $this->findAll();

        return $payment_method ? $this->getDataIndex(0) : $this->getDataPair('payment_method');
    }

    public function getPaymentMethods()
    {
        if (!defined("PJ_ENABELE_OFFLINE_PAYMENTS"))
        {
            $this->where('type', 'online');
        }
        return $this
            ->select('DISTINCT payment_method')
            ->findAll()
            ->getDataPair('payment_method', 'payment_method');
    }
    
    public function getActivePaymentMethods($foreign_id = null)
    {
        if (!defined("PJ_ENABELE_OFFLINE_PAYMENTS"))
        {
            $this->where('type', 'online');
        }
    	return $this
        	->select('DISTINCT payment_method')
        	->where('foreign_id', $foreign_id)
        	->where('is_active', 1)
        	->findAll()
        	->getDataPair('payment_method', 'payment_method');
    }
    
    public function saveOptions($data, $foreign_id = null)
    {
        $options = $this->getOptions($foreign_id);

        foreach ($data as $payment_method => $updateData)
        {
            $this->reset();
            if (array_key_exists($payment_method, $options))
            {
                $this->set('id', $options[$payment_method]['id'])->modify($updateData);
            } else {
                unset($updateData['id']);
                $updateData['foreign_id'] = is_null($foreign_id)? ':NULL': $foreign_id;
                $updateData['payment_method'] = $payment_method;
                $this->setAttributes($updateData)->insert();
            }
        }

        return $this;
    }

    public function copyOptions($from_foreign_id = null, $to_foreign_id = null)
    {
        $payment_option_arr = $this->getOptions($from_foreign_id);
        $this->saveOptions($payment_option_arr, $to_foreign_id);

        return $this;
    }

    public function deleteOptions($foreign_id = null)
    {
        if (!is_array($foreign_id))
        {
            $foreign_id = array($foreign_id);
        }
        $this->whereIn('foreign_id', $foreign_id)->eraseAll();

        return $this;
    }
}