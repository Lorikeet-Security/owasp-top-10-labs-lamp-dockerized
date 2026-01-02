<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminReports extends pjAdmin
{
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if (isset($_POST['generate_report']))
			{
				if($_POST['date_from'] != '' || $_POST['date_to'] != '' || $_POST['location_id'] != '' || $_POST['fleet_id'] != '')
				{
					$date_from = (isset($_POST['date_from']) && $_POST['date_from'] != '') ? pjUtil::formatDate($_POST['date_from'], $this->option_arr['o_date_format']) : null;
					$date_to = (isset($_POST['date_to']) && $_POST['date_to'] != '') ? pjUtil::formatDate($_POST['date_to'], $this->option_arr['o_date_format']) : null;
					$location_id = (isset($_POST['location_id']) && $_POST['location_id'] != '') ? $_POST['location_id'] : null;
					$fleet_id = (isset($_POST['fleet_id']) && $_POST['fleet_id'] != '') ? $_POST['fleet_id'] : null;
					
					$type = 'general';
					if($location_id == null && $fleet_id == null)
					{
						$this->set('general_report', $this->pjGenerateGeneral($date_from, $date_to));
					}else if($location_id != null && $fleet_id == null){
						$type = 'location';
						$this->set('location_report', $this->pjGeneratePickup($date_from, $date_to, $location_id));
					}else if($location_id == null && $fleet_id != null){
						$type = 'vehicle';
						$this->set('vehicle_report', $this->pjGenerateVehicle($date_from, $date_to, $fleet_id));
					}
					
					$this->set('type', $type);
				}else{
					$this->set('ERR', 'AR01');
				}
			}
			$pickup_arr = pjLocationModel::factory()
				->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='pickup_location' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->select(" t1.id, t1.status, t2.content as pickup_location")
				->orderBy("pickup_location ASC")
				->findAll()
				->getData();
				
			$fleet_arr = pjFleetModel::factory()
				->join('pjMultiLang', "t2.model='pjFleet' AND t2.foreign_id=t1.id AND t2.field='fleet' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->select('t1.id, t1.thumb_path, t2.content as fleet, t1.passengers, t1.status, t1.luggage')
				->orderBy("fleet ASC")
				->findAll()->getData();
			
			$this->set('pickup_arr', $pickup_arr);
			$this->set('fleet_arr', $fleet_arr);
							 				
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminReports.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionPrint()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$this->setLayout("pjActionReport");
			
			$date_from = !empty($_POST['date_from']) ? pjUtil::formatDate($_POST['date_from'], $this->option_arr['o_date_format']) : null;
			$date_to = !empty($_POST['date_to']) ? pjUtil::formatDate($_POST['date_to'], $this->option_arr['o_date_format']) : null;
			$location_id = !empty($_POST['location_id']) ? $_POST['location_id'] : null;
			$fleet_id = !empty($_POST['fleet_id']) ? $_POST['fleet_id'] : null;
			
			$type = 'general';
			if($location_id == null && $fleet_id == null)
			{
				$this->set('general_report', $this->pjGenerateGeneral($date_from, $date_to));
			}else if($location_id != null && $fleet_id == null){
				$type = 'location';
				echo $date_from;
				$this->set('location_report', $this->pjGeneratePickup($date_from, $date_to, $location_id));
			}else if($location_id == null && $fleet_id != null){
				$type = 'vehicle';
				$this->set('vehicle_report', $this->pjGenerateVehicle($date_from, $date_to, $fleet_id));
			}
			
			$this->set('type', $type);
			
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjGenerateGeneral($date_from, $date_to)
	{
			
		$date_from = isset($_POST['date_from']) ? pjUtil::formatDate($_POST['date_from'], $this->option_arr['o_date_format']) : null;
		$date_to = isset($_POST['date_to']) ? pjUtil::formatDate($_POST['date_to'], $this->option_arr['o_date_format']) : null;
		
		$pjBookingModel = pjBookingModel::factory();
		
		$reservations = array();
		$passengers = array();
		$luggage = array();
		$amount = array();
		
		$clause = "(t1.return_id IS NULL)";
		if($date_from != null && $date_to != null)
		{
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from' AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}else if($date_from != null && $date_to == null){
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from')";
		}else if($date_from == null && $date_to != null){
			$clause .= " AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}
		
		$arr = $pjBookingModel
			->reset()
			->where($clause)
			->findAll()
			->getData();

		$reservations['total'] = 0;
		$reservations['confirmed'] = 0;
		$reservations['cancelled'] = 0;
		
		$passengers['total'] = 0;
		$passengers['confirmed'] = 0;
		$passengers['cancelled'] = 0;
		
		$luggage['total'] = 0;
		$luggage['confirmed'] = 0;
		$luggage['cancelled'] = 0;
		
		$amount['total'] = 0;
		$amount['confirmed'] = 0;
		$amount['cancelled'] = 0;
		foreach($arr as $v)
		{
			if($v['status'] == 'confirmed')
			{
				$reservations['confirmed'] += 1;
				$passengers['confirmed'] += $v['passengers'];
				$luggage['confirmed'] += $v['luggage'];
				$amount['confirmed'] += $v['total'];
			}
			if($v['status'] == 'cancelled')
			{
				$reservations['cancelled'] += 1;
				$passengers['cancelled'] += $v['passengers'];
				$luggage['cancelled'] += $v['luggage'];
				$amount['cancelled'] += $v['total'];
			}
			$reservations['total'] += 1;
			$passengers['total'] += $v['passengers'];
			$luggage['total'] += $v['luggage'];
			$amount['total'] += $v['total'];
		}
		
		$one_way = array();
		$round_trip = array();
					
		$one_way_arr = $pjBookingModel
			->reset()
			->where("(t1.return_date IS NULL)")
			->where("(t1.status='confirmed')")
			->where($clause)
			->findAll()
			->getData();
		$round_trip_arr = $pjBookingModel
			->reset()
			->where("(t1.return_date IS NOT NULL)")
			->where("(t1.status='confirmed')")
			->where($clause)
			->findAll()
			->getData();
			
		$one_way['reservations'] = count($one_way_arr);
		$round_trip['reservations'] = count($round_trip_arr);
		$_total = $one_way['reservations'] + $round_trip['reservations'];
		$one_way['rerv_percentage'] = $_total > 0 ? number_format(($one_way['reservations'] * 100) / $_total, 2) : 0.00;
		$round_trip['rerv_percentage'] = $_total > 0 ? number_format(($round_trip['reservations'] * 100) / $_total, 2) : 0.00;
		
		$one_way['amount'] = 0;
		$round_trip['amount'] = 0;
		foreach($one_way_arr as $v)
		{
			$one_way['amount'] += $v['total'];
		}
		foreach($round_trip_arr as $v)
		{
			$round_trip['amount'] += $v['total'];
		}
		$_total = $one_way['amount'] + $round_trip['amount'];
		$one_way['amount_percentage'] = $_total > 0 ? number_format(($one_way['amount'] * 100) / $_total, 2) : 0.00;
		$round_trip['amount_percentage'] = $_total > 0 ? number_format(($round_trip['amount'] * 100) / $_total, 2) : 0.00;

		$per_arr = array();
		$total_amount = 0;
		$total_reservations = $pjBookingModel
			->reset()
			->where("(t1.status='confirmed')")
			->where($clause)
			->findCount()
			->getData(); 
		$_total_amount = $pjBookingModel
			->reset()
			->select("SUM(t1.total) AS total_amount")
			->where("(t1.status='confirmed')")
			->where($clause)
			->limit(1)
			->findAll()
			->getData();
		if(count($_total_amount) > 0)
		{
			$total_amount = $_total_amount[0]['total_amount'];
		}
		
		$reservations_arr = $pjBookingModel
			->reset()
			->where("(t1.status='confirmed')")
			->where($clause)
			->findAll()
			->getData(); 
		foreach($reservations_arr as $k => $v)
		{
			if($v['passengers'] > 10)
			{
				$per_arr[11]['reservations'] = isset($per_arr[11]['reservations']) ? $per_arr[11]['reservations'] + 1 : 1;
				$per_arr[11]['amount'] = isset($per_arr[11]['amount']) ? $per_arr[11]['amount'] + $v['total'] : $v['total'];
			}else{
				$per_arr[$v['passengers']]['reservations'] = isset($per_arr[$v['passengers']]['reservations']) ? $per_arr[$v['passengers']]['reservations'] + 1 : 1;
				$per_arr[$v['passengers']]['amount'] = isset($per_arr[$v['passengers']]['amount']) ? $per_arr[$v['amount']]['reservations'] + $v['total'] : $v['total'];
			}
			
		}
		foreach($per_arr as $k => $v)
		{
			$per_arr[$k]['percentage1'] = $total_reservations > 0 ? (number_format(($per_arr[$k]['reservations'] * 100) / $total_reservations, 2)) : 0.00;
			$per_arr[$k]['percentage2'] = $total_amount > 0 ? (number_format(($per_arr[$k]['amount'] * 100) / $total_amount, 2)) : 0.00;
		}
				
		return compact('reservations', 'passengers', 'luggage', 'amount', 'one_way', 'round_trip', 'per_arr');	
	}
	
	public function pjGeneratePickup($date_from, $date_to, $location_id)
	{
		$pjBookingModel = pjBookingModel::factory();
		
		$location = pjLocationModel::factory()
			->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='pickup_location' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->select(" t1.id, t1.status, t2.content as pickup_location")
			->find($location_id)
			->getData();
			
		$dropoff_arr = pjDropoffModel::factory()
			->join('pjMultiLang', "t2.model='pjDropoff' AND t2.foreign_id=t1.id AND t2.field='location' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->select(" t1.*, t2.content as dropoff_location")
			->where('t1.location_id', $location_id)
			->findAll()
			->getData();
		$fleet_arr = pjFleetModel::factory()
			->join('pjMultiLang', "t2.model='pjFleet' AND t2.foreign_id=t1.id AND t2.field='fleet' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->select(" t1.*, t2.content as fleet")
			->findAll()
			->getData();
			
		$table_fleet_arr = array();
		$k = 0;	
		for($i = 1; $i <= count($fleet_arr); $i++)
		{
			$table_fleet_arr[$k][] = $fleet_arr[$i-1];
			if($i % 5 == 0)
			{
				$k++;
			} 
		}
		
		$reservations = array();
		$passengers = array();
		$luggage = array();
		$amount = array();
		
		$clause = "(t1.return_id IS NULL)";
		if($date_from != null && $date_to != null)
		{
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from' AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}else if($date_from != null && $date_to == null){
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from')";
		}else if($date_from == null && $date_to != null){
			$clause .= " AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}
		
		$arr = $pjBookingModel
			->reset()
			->where("(t1.location_id='$location_id')")
			->where($clause)
			->findAll()
			->getData();

		$reservations['total'] = 0;
		$reservations['confirmed'] = 0;
		$reservations['cancelled'] = 0;
		
		$passengers['total'] = 0;
		$passengers['confirmed'] = 0;
		$passengers['cancelled'] = 0;
		
		$luggage['total'] = 0;
		$luggage['confirmed'] = 0;
		$luggage['cancelled'] = 0;
		
		$amount['total'] = 0;
		$amount['confirmed'] = 0;
		$amount['cancelled'] = 0;
		foreach($arr as $v)
		{
			if($v['status'] == 'confirmed')
			{
				$reservations['confirmed'] += 1;
				$passengers['confirmed'] += $v['passengers'];
				$luggage['confirmed'] += $v['luggage'];
				$amount['confirmed'] += $v['total'];
			}
			if($v['status'] == 'cancelled')
			{
				$reservations['cancelled'] += 1;
				$passengers['cancelled'] += $v['passengers'];
				$luggage['cancelled'] += $v['luggage'];
				$amount['cancelled'] += $v['total'];
			}
			$reservations['total'] += 1;
			$passengers['total'] += $v['passengers'];
			$luggage['total'] += $v['luggage'];
			$amount['total'] += $v['total'];
		}
		
		$one_way = array();
		$round_trip = array();
					
		$one_way_arr = $pjBookingModel
			->reset()
			->where("(t1.location_id='$location_id')")
			->where("(t1.return_date IS NULL)")
			->where("(t1.status='confirmed')")
			->where($clause)
			->findAll()
			->getData();
		$round_trip_arr = $pjBookingModel
			->reset()
			->where("(t1.location_id='$location_id')")
			->where("(t1.return_date IS NOT NULL)")
			->where("(t1.status='confirmed')")
			->where($clause)
			->findAll()
			->getData();
			
		$one_way['reservations'] = count($one_way_arr);
		$round_trip['reservations'] = count($round_trip_arr);
		$_total = $one_way['reservations'] + $round_trip['reservations'];
		$one_way['rerv_percentage'] = $_total > 0 ? number_format(($one_way['reservations'] * 100) / $_total, 2) : 0.00;
		$round_trip['rerv_percentage'] = $_total > 0 ? number_format(($round_trip['reservations'] * 100) / $_total, 2) : 0.00;
		
		$one_way['amount'] = 0;
		$round_trip['amount'] = 0;
		foreach($one_way_arr as $v)
		{
			$one_way['amount'] += $v['total'];
		}
		foreach($round_trip_arr as $v)
		{
			$round_trip['amount'] += $v['total'];
		}
		$_total = $one_way['amount'] + $round_trip['amount'];
		$one_way['amount_percentage'] = $_total > 0 ? number_format(($one_way['amount'] * 100) / $_total, 2) : 0.00;
		$round_trip['amount_percentage'] = $_total > 0 ? number_format(($round_trip['amount'] * 100) / $_total, 2) : 0.00;
		
		$dest_arr = array();
		$vehicle_arr = array();
		$total_amount = 0;
		$total_reservations = $pjBookingModel
			->reset()
			->where("(t1.status='confirmed')")
			->where("(t1.location_id='$location_id')")
			->where($clause)
			->findCount()
			->getData(); 
		$_total_amount = $pjBookingModel
			->reset()
			->select("SUM(t1.total) AS total_amount")
			->where("(t1.status='confirmed')")
			->where("(t1.location_id='$location_id')")
			->where($clause)
			->limit(1)
			->findAll()
			->getData();
		if(count($_total_amount) > 0)
		{
			$total_amount = $_total_amount[0]['total_amount'];
		}
		
		$dropoff_ids = array();
		foreach($dropoff_arr as $k => $v)
		{
			$dropoff_ids[] = $v['id'];
		}
		
		if(!empty($dropoff_ids))
		{
			$arr = $pjBookingModel
				->reset()
				->where("(t1.status='confirmed')")
				->where("(t1.location_id='$location_id')")
				->where("(t1.dropoff_id IN(".join(',', $dropoff_ids)."))")
				->where($clause)
				->findAll()
				->getData();
			
			foreach($arr as $k => $v)
			{
				$dest_arr[$v['dropoff_id']]['reservations'] = isset($dest_arr[$v['dropoff_id']]['reservations']) ? $dest_arr[$v['dropoff_id']]['reservations'] + 1 : 1;
				$dest_arr[$v['dropoff_id']]['amount'] = isset($dest_arr[$v['dropoff_id']]['amount']) ? $dest_arr[$v['dropoff_id']]['amount'] + $v['total'] : $v['total'];
				
				if(isset($vehicle_arr[$v['dropoff_id']][$v['fleet_id']]))
				{
					$vehicle_arr[$v['dropoff_id']][$v['fleet_id']] += 1;
				}else{
					$vehicle_arr[$v['dropoff_id']][$v['fleet_id']] = 1;
				}
			}
			foreach($dest_arr as $k => $v)
			{
				$dest_arr[$k]['percentage1'] = $total_reservations > 0 ? (number_format(($dest_arr[$k]['reservations'] * 100) / $total_reservations, 2)) : 0.00;
				$dest_arr[$k]['percentage2'] = $total_amount > 0 ? (number_format(($dest_arr[$k]['amount'] * 100) / $total_amount, 2)) : 0.00;
			}
		}
		
		return compact('reservations', 'passengers', 'luggage', 'amount', 'one_way', 'round_trip', 'dest_arr', 'vehicle_arr', 'location', 'dropoff_arr', 'table_fleet_arr');
	}
	
	public function pjGenerateVehicle($date_from, $date_to, $fleet_id)
	{
		$fleet_arr = pjFleetModel::factory()
			->join('pjMultiLang', "t2.model='pjFleet' AND t2.foreign_id=t1.id AND t2.field='fleet' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->select(" t1.*, t2.content as fleet")
			->find($fleet_id)
			->getData();
		
		$pjBookingModel = pjBookingModel::factory();
		
		$reservations = array();
		$passengers = array();
		$luggage = array();
		$amount = array();
		$distance = array();
		
		$clause = "(t1.return_id IS NULL)";
		if($date_from != null && $date_to != null)
		{
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from' AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}else if($date_from != null && $date_to == null){
			$clause .= " AND (DATE_FORMAT(t1.created, '%Y-%m-%d')>='$date_from')";
		}else if($date_from == null && $date_to != null){
			$clause .= " AND DATE_FORMAT(t1.created, '%Y-%m-%d')<='$date_to')";
		}
		
		$arr = $pjBookingModel
			->reset()
			->join('pjDropoff', 't1.dropoff_id=t2.id AND t1.location_id=t2.location_id', 'inner')
			->select('t1.*, t2.distance')
			->where($clause)
			->where("(t1.fleet_id='$fleet_id')")
			->findAll()
			->getData();

		$reservations['total'] = 0;
		$reservations['confirmed'] = 0;
		$reservations['cancelled'] = 0;
		
		$passengers['total'] = 0;
		$passengers['confirmed'] = 0;
		$passengers['cancelled'] = 0;
		
		$luggage['total'] = 0;
		$luggage['confirmed'] = 0;
		$luggage['cancelled'] = 0;
		
		$amount['total'] = 0;
		$amount['confirmed'] = 0;
		$amount['cancelled'] = 0;
		
		$distance['total'] = 0;
		$distance['confirmed'] = 0;
		$distance['cancelled'] = 0;
		
		foreach($arr as $v)
		{
			if($v['status'] == 'confirmed')
			{
				$reservations['confirmed'] += 1;
				$passengers['confirmed'] += $v['passengers'];
				$luggage['confirmed'] += $v['luggage'];
				$amount['confirmed'] += $v['total'];
				$distance['confirmed'] += $v['distance'];
			}
			if($v['status'] == 'cancelled')
			{
				$reservations['cancelled'] += 1;
				$passengers['cancelled'] += $v['passengers'];
				$luggage['cancelled'] += $v['luggage'];
				$amount['cancelled'] += $v['total'];
				$distance['cancelled'] += $v['distance'];
			}
			$reservations['total'] += 1;
			$passengers['total'] += $v['passengers'];
			$luggage['total'] += $v['luggage'];
			$amount['total'] += $v['total'];
			$distance['total'] += $v['distance'];
		}
		
		$per_arr = array();
		$total_amount = 0;
		$total_reservations = $pjBookingModel
			->reset()
			->where("(t1.status='confirmed')")
			->where($clause)
			->where("(t1.fleet_id='$fleet_id')")
			->findCount()
			->getData(); 
		$_total_amount = $pjBookingModel
			->reset()
			->select("SUM(t1.total) AS total_amount")
			->where("(t1.status='confirmed')")
			->where($clause)
			->where("(t1.fleet_id='$fleet_id')")
			->limit(1)
			->findAll()
			->getData();
		if(count($_total_amount) > 0)
		{
			$total_amount = $_total_amount[0]['total_amount'];
		}
		if(!empty($fleet_arr['passengers']))
		{
			$arr = $pjBookingModel
				->reset()
				->where("(t1.status='confirmed')")
				->where($clause)
				->where("(t1.fleet_id='$fleet_id')")
				->where("(t1.passengers <= ".$fleet_arr['passengers'].")")
				->findAll()
				->getData();
			foreach($arr as $k => $v)
			{
				$per_arr[$v['passengers']]['reservations'] = isset($per_arr[$v['passengers']]['reservations']) ? $per_arr[$v['passengers']]['reservations'] + 1 : 1;
				$per_arr[$v['passengers']]['amount'] = isset($per_arr[$v['passengers']]['amount']) ? $per_arr[$v['amount']]['reservations'] + $v['total'] : $v['total'];
			}
			foreach($per_arr as $k => $v)
			{
				$per_arr[$k]['percentage1'] = $total_reservations > 0 ? (number_format(($per_arr[$k]['reservations'] * 100) / $total_reservations, 2)) : 0.00;
				$per_arr[$k]['percentage2'] = $total_amount > 0 ? (number_format(($per_arr[$k]['amount'] * 100) / $total_amount, 2)) : 0.00;
			}
		}
		
		return compact('reservations', 'passengers', 'luggage', 'amount', 'distance', 'per_arr', 'fleet_arr');	
	}
}
?>