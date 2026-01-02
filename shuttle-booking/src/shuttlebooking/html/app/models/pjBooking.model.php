<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBookingModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'bookings';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'uuid', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'locale_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'client_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'line_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'traveling', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'distance', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'location_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'dropoff_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'booking_date', 'type' => 'date', 'default' => ':NULL'),
		array('name' => 'booking_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'duration', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'has_return', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'return_date', 'type' => 'date', 'default' => ':NULL'),
		array('name' => 'return_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'return_line_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'return_duration', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'passengers', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'luggage', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'sub_total', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'tax', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'total', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'deposit', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'payment_method', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'processed_on', 'type' => 'datetime', 'default' => ':NULL'),
		array('name' => 'created', 'type' => 'datetime', 'default' => ':NOW()'),
		array('name' => 'ip', 'type' => 'varchar', 'default' => ':NULL'),
		
		array('name' => 'c_title', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_fname', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_lname', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_phone', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_email', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_company', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_notes', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'c_address', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_city', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_state', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_country', 'type' => 'int', 'default' => ':NULL'),
		
		array('name' => 'c_airline_company', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_flight_number', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_flight_time', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_departure_flight_number', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_departure_flight_time', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_destination_address', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'c_cruise_ship', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'c_terminal', 'type' => 'varchar', 'default' => ':NULL'),
		
		array('name' => 'cc_type', 'type' => 'blob', 'default' => ':NULL', 'encrypt' => 'AES'),
		array('name' => 'cc_num', 'type' => 'blob', 'default' => ':NULL', 'encrypt' => 'AES'),
		array('name' => 'cc_exp_month', 'type' => 'blob', 'default' => ':NULL', 'encrypt' => 'AES'),
		array('name' => 'cc_exp_year', 'type' => 'blob', 'default' => ':NULL', 'encrypt' => 'AES'),
		array('name' => 'cc_code', 'type' => 'blob', 'default' => ':NULL', 'encrypt' => 'AES')
	);
	
	public static function factory($attr=array())
	{
		return new pjBookingModel($attr);
	}
}
?>