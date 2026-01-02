<?php
include_once dirname(__FILE__) . '/elements/header.php';
$STORE = @$_SESSION[$controller->defaultStore];
$SEARCH = @$_SESSION[$controller->defaultStore]['search'];
$passengers = !empty($SEARCH['passengers']) ? $SEARCH['passengers'] : 0;
$distance = !empty($SEARCH['distance']) ? $SEARCH['distance'] : 0;
$traveling = $SEARCH['traveling'];
$title_str = $passengers != 1 ? __('front_transfer_text', true) : __('front_transfer_text_1', true);
$title_str = str_replace("{DATE}", $SEARCH['booking_date'], $title_str);
$title_str = str_replace("{PASSENGERS}", $SEARCH['passengers'], $title_str);
$destination = '';
if($traveling == 'from')
{
	$title_str = str_replace("{FROM}", '<strong>'.pjSanitize::html($tpl['from_location']['title']).'</strong>', $title_str);
	$title_str = str_replace("{TO}", '<strong>'.pjSanitize::html($tpl['to_location']['title']).'</strong>', $title_str);
	$destination = pjSanitize::html($tpl['to_location']['title']);
}else{
	$title_str = str_replace("{FROM}", '<strong>'.pjSanitize::html($tpl['to_location']['title']).'</strong>', $title_str);
	$title_str = str_replace("{TO}", '<strong>'.pjSanitize::html($tpl['from_location']['title']).'</strong>', $title_str);
	$destination = pjSanitize::html($tpl['from_location']['title']);
}
$index = $controller->_get->toInt('index');
?>
<div class="pjSbs-body">
	<?php
	if(!empty($tpl['line_arr']))
	{ 
		?>
		<div class="pjSbs-service-info">
			<p><?php echo $title_str;?></p>
		</div><!-- /.pjSbs-service-info -->
		<?php
		foreach($tpl['line_arr'] as $k => $v)
		{
			$duration = 0;
			$duration_text = '';
			if(!empty($v['line_detail_arr']))
			{
				$line_arr = $v['line_detail_arr'];
				if($traveling == 'from')
				{
					$duration = (int) $line_arr['duration_dropoff'];
					$duration_text = (int) $line_arr['duration_dropoff'] . ' ' . __('front_minutes', true);
				}else{
					$duration = (int) $line_arr['duration_pickup'];
					$duration_text = (int) $line_arr['duration_pickup'] . ' ' . __('front_minutes', true);
				}
			}
			?>
			<div class="pjSbs-car pjSbs-box">
				<div class="row">
					<div class="col-sm-8 col-xs-12">
						<div class="pjSbs-car-title"><?php echo pjSanitize::html($v['title']);?></div><!-- /.pjSbs-car-title -->
					</div><!-- /.col-sm-8 -->
		
					<div class="col-sm-4 col-xs-12">
						<div class="pjSbs-car-actions">
							<form action="step2.php" method="post">
								<div class="pjSbs-price-holder">
									<div class="pjSbs-price"><strong><?php echo pjCurrency::formatPrice($v['price_arr']['total']);?></strong> <?php __('front_total_price');?></div><!-- /.pjSbs-price -->
								</div><!-- /.pjSbs-price-holder -->
							</form>
						</div><!-- /.pjSbs-car-actions -->	
					</div><!-- /.col-md-4 -->
				</div><!-- /.row -->
		
				<div class="row">
					<?php
					if(!empty($v['thumb_path']) && file_exists(PJ_INSTALL_PATH . $v['thumb_path']))
					{ 
						$thumb_url = PJ_INSTALL_URL . $v['thumb_path'];
						?>
						<div class="col-sm-2 col-xs-12">
							<div class="pjSbs-car-image">
								<img src="<?php echo $thumb_url;?>" alt="" class="img-responsive">
							</div><!-- /.pjSbs-car-image -->
						</div><!-- /.col-md-3 -->
						<?php
					} 
					?>
		
					<div class="<?php echo !empty($v['thumb_path']) && file_exists(PJ_INSTALL_PATH . $v['thumb_path']) ? 'col-sm-10 col-xs-12' : 'col-sm-12 col-xs-12' ?>">
						<div class="pjSbs-car-desc">
							<div class="row">
								<div class="col-sm-4 col-xs-12">
									<ul class="pjSbs-car-meta">
										<li><?php __('front_passengers');?>: <strong><?php echo pjSanitize::html($v['seats']);?></strong></li>
										<li><?php __('front_duration');?>: <strong><?php echo $duration_text;?></strong></li>
									</ul><!-- /.pjSbs-car-meta -->	
		
									<ul class="list-checked">
										<li><?php __('front_price_for_all_passengers');?></li>
		
										<li><?php __('front_includes_all_taxes');?></li>
									</ul>
								</div><!-- /.col-sm-6 -->
								<?php
								$select_title = __('front_select_departure_time', true); 
								$select_title = str_replace("{LOC}", $traveling == 'from' ? pjSanitize::html($tpl['from_location']['title']) : pjSanitize::html($tpl['to_location']['title']), $select_title);
								?>
								<div class="col-sm-8 col-xs-12">
									<label><?php echo $select_title;?></label>
		
									<ul class="list-inline hours">
										<?php
										$arriving_message = '';
										if(isset($v['timetable_arr']))
										{
											if(!empty($v['timetable_arr']))
											{
												$iso_return_date = pjDateTime::formatDate($SEARCH['booking_date'], $tpl['option_arr']['o_date_format']);
												$book_time_arr = isset($tpl['book_time_arr'][$v['id']]) ? $tpl['book_time_arr'][$v['id']] : array();
												$time_arr = explode("|", $v['timetable_arr']['time']);
												foreach($time_arr as $time)
												{
													$time_ts = strtotime($time);
													if($traveling == 'to')
													{
														$time_ts = $time_ts - ($duration * 60);
													}
													$iso_time = date('H:i', $time_ts);
													$time_ts = strtotime($iso_return_date . ' ' . $iso_time);
													
													$hour_class = ' hour-available';
													if(isset($STORE['time']) && $STORE['time'] == $iso_time && isset($STORE['line_id']) && $STORE['line_id'] == $v['id'])
													{
														$hour_class = ' hour-booked';
														$arriving_message = __('front_arriving_in_msg', true);
														$arriving_message = str_replace("{LOC}", $destination, $arriving_message);
														$arriving_message = str_replace("{TIME}", date($tpl['option_arr']['o_time_format'], $time_ts + ($duration * 60)), $arriving_message);
													}
													if((!empty($book_time_arr) && array_key_exists($iso_time, $book_time_arr) && $book_time_arr[$iso_time] + $passengers > (int) $v['seats'] ) || $time_ts < time())
													{
														?>
														<li class="hour hour-unavailable">
															<a href="#" class=pjSbsUnavailableTime><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></a>
														</li><!-- /.hour hour-unavailable -->
														<?php
													}else{
														?>
														<li class="hour<?php echo $hour_class;?> pjSbsAvailbleTime">
															<a href="#" class="pjSbsAvailableTime" data-return="0" data-line_id="<?php echo $v['id'];?>" data-duration="<?php echo $duration;?>" data-time="<?php echo $iso_time;?>" data-dest="<?php echo $destination;?>"><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></a>
														</li><!-- /.hour hour-unavailable -->
														<?php
													}
												}
											}
										}
										?>
									</ul><!-- /.list-inline hours -->
									<label class="pjSbsDestMessage pjSbsDestMessage-line-<?php echo $v['id'];?>" style="display: <?php echo !empty($arriving_message) ? '' : 'none';?>;"><?php echo $arriving_message;?></label>
								</div><!-- /.col-sm-6 -->
							</div><!-- /.row -->
						</div><!-- /.pjSbs-car-desc -->		
					</div><!-- /.col-md-3 -->
					<div class="col-sm-12 col-xs-12">
						<div class="pjSbs-car-info"><?php echo !empty($v['description']) ? nl2br(pjSanitize::html($v['description'])) : NULL;?></div><!-- /.pjSbs-car-info -->
					</div>
				</div><!-- /.row -->
			</div><!-- /.pjSbs-car -->
			<?php
		}
	}else{
		?>
		<div class="pjSbs-service-info">
			<p><?php __('front_no_available_shuttles');?></p>
		</div><!-- /.pjSbs-service-info -->
		<?php
	}
	if(isset($SEARCH['has_return']))
	{
		$traveling = $SEARCH['traveling'] == 'from' ? 'to' : 'from';
		$title_str = $passengers != 1 ? __('front_transfer_text', true) : __('front_transfer_text_1', true);
		$title_str = str_replace("{DATE}", $SEARCH['return_date'], $title_str);
		$title_str = str_replace("{PASSENGERS}", $SEARCH['passengers'], $title_str);
		$destination = '';
		if($traveling == 'from')
		{
			$title_str = str_replace("{FROM}", '<strong>'.pjSanitize::html($tpl['from_location']['title']).'</strong>', $title_str);
			$title_str = str_replace("{TO}", '<strong>'.pjSanitize::html($tpl['to_location']['title']).'</strong>', $title_str);
			$destination = pjSanitize::html($tpl['to_location']['title']);
		}else{
			$title_str = str_replace("{FROM}", '<strong>'.pjSanitize::html($tpl['to_location']['title']).'</strong>', $title_str);
			$title_str = str_replace("{TO}", '<strong>'.pjSanitize::html($tpl['from_location']['title']).'</strong>', $title_str);
			$destination = pjSanitize::html($tpl['from_location']['title']);
		}
		
		if(!empty($tpl['return_line_arr']))
		{
			?>
			<br/>
			<div class="pjSbs-service-info">
				<p><?php echo $title_str;?></p>
			</div><!-- /.pjSbs-serv-->
			<?php
			foreach($tpl['return_line_arr'] as $k => $v)
			{
				$duration = 0;
				$duration_text = '';
				if(!empty($v['line_detail_arr']))
				{
					$line_arr = $v['line_detail_arr'];
					if($traveling == 'from')
					{
						$duration = (int) $line_arr['duration_dropoff'];
						$duration_text = (int) $line_arr['duration_dropoff'] . ' ' . __('front_minutes', true);
					}else{
						$duration = (int) $line_arr['duration_pickup'];
						$duration_text = (int) $line_arr['duration_pickup'] . ' ' . __('front_minutes', true);
					}
				}
				$book_time_arr = isset($tpl['return_book_time_arr']) ?  (isset($tpl['return_book_time_arr'][$v['id']]) ? $tpl['return_book_time_arr'][$v['id']] : array()) : array();
				?>
				<div class="pjSbs-car pjSbs-box">
					<div class="row">
						<div class="col-sm-8 col-xs-12">
							<div class="pjSbs-car-title"><?php echo pjSanitize::html($v['title']);?></div><!-- /.pjSbs-car-title -->
						</div><!-- /.col-sm-8 -->
			
						<div class="col-sm-4 col-xs-12">
							<div class="pjSbs-car-actions">
								<form action="step2.php" method="post">
									<div class="pjSbs-price-holder">
										<div class="pjSbs-price"><strong><?php echo pjCurrency::formatPrice($v['price_arr']['total']);?></strong> <?php __('front_total_price');?></div><!-- /.pjSbs-price -->
									</div><!-- /.pjSbs-price-holder -->
								</form>
							</div><!-- /.pjSbs-car-actions -->	
						</div><!-- /.col-md-4 -->
					</div><!-- /.row -->
			
					<div class="row">
						<?php
						if(!empty($v['thumb_path']) && file_exists(PJ_INSTALL_PATH . $v['thumb_path']))
						{ 
							$thumb_url = PJ_INSTALL_URL . $v['thumb_path'];
							?>
							<div class="col-sm-2 col-xs-12">
								<div class="pjSbs-car-image">
									<img src="<?php echo $thumb_url;?>" alt="" class="img-responsive">
								</div><!-- /.pjSbs-car-image -->
							</div><!-- /.col-md-3 -->
							<?php
						} 
						?>
			
						<div class="<?php echo !empty($v['thumb_path']) && file_exists(PJ_INSTALL_PATH . $v['thumb_path']) ? 'col-sm-10 col-xs-12' : 'col-sm-12 col-xs-12' ?>">
							<div class="pjSbs-car-desc">
								<div class="row">
									<div class="col-sm-4 col-xs-12">
										<ul class="pjSbs-car-meta">
											<li><?php __('front_passengers');?>: <strong><?php echo pjSanitize::html($v['seats']);?></strong></li>
											<li><?php __('front_duration');?>: <strong><?php echo $duration_text;?></strong></li>
										</ul><!-- /.pjSbs-car-meta -->	
			
										<ul class="list-checked">
											<li><?php __('front_price_for_all_passengers');?></li>
			
											<li><?php __('front_includes_all_taxes');?></li>
										</ul>
									</div><!-- /.col-sm-6 -->
									<?php
									$select_title = __('front_select_pickup_time', true); 
									$select_title = str_replace("{LOC}", $traveling == 'from' ? pjSanitize::html($tpl['from_location']['title']) : pjSanitize::html($tpl['to_location']['title']), $select_title);
									?>
									<div class="col-sm-8 col-xs-12">
										<label><?php echo $select_title;?></label>
			
										<ul class="list-inline hours">
											<?php
											$arriving_message = '';
											if(isset($v['timetable_arr']))
											{
												if(!empty($v['timetable_arr']))
												{
													$iso_return_date = pjDateTime::formatDate($SEARCH['return_date'], $tpl['option_arr']['o_date_format']);
													$time_arr = explode("|", $v['timetable_arr']['time']);
													$book_time_arr = isset($tpl['return_book_time_arr']) ?  (isset($tpl['return_book_time_arr'][$v['id']]) ? $tpl['return_book_time_arr'][$v['id']] : array()) : array();
													foreach($time_arr as $time)
													{
														$time_ts = strtotime($time);
														if($traveling == 'to')
														{
															$time_ts = $time_ts - ($duration * 60);
														}
														$iso_time = date('H:i', $time_ts);
														$time_ts = strtotime($iso_return_date . ' ' . date('H:i:s', $time_ts));
														$hour_class = ' hour-available';
														if(isset($STORE['return_time']) && $STORE['return_time'] == $iso_time && isset($STORE['return_line_id']) && $STORE['return_line_id'] == $v['id'])
														{
															$hour_class = ' hour-booked';
															$arriving_message = __('front_arriving_in_msg', true);
															$arriving_message = str_replace("{LOC}", $destination, $arriving_message);
															$arriving_message = str_replace("{TIME}", date($tpl['option_arr']['o_time_format'], $time_ts + ($duration * 60)), $arriving_message);
														}
														if((!empty($book_time_arr) && array_key_exists($iso_time, $book_time_arr) && $book_time_arr[$iso_time] + $passengers > (int) $v['seats'] ) || $time_ts < time())
														{
															?>
															<li class="hour hour-unavailable">
																<a href="#" class="pjSbsUnavailableTime"><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></a>
															</li><!-- /.hour hour-unavailable -->
															<?php
														}else{
															?>
															<li class="hour hour-available<?php echo $hour_class;?> pjSbsAvailbleReturnTime">
																<a href="#" class="pjSbsAvailableTime" data-return="1" data-line_id="<?php echo $v['id'];?>" data-duration="<?php echo $duration;?>" data-time="<?php echo $iso_time;?>" data-dest="<?php echo $destination;?>"><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></a>
															</li><!-- /.hour hour-unavailable -->
															<?php
														}
													}
												}
											}
											?>
										</ul><!-- /.list-inline hours -->
										<label class="pjSbsReturnDestMessage pjSbsReturnDestMessage-line-<?php echo $v['id'];?>" style="display: <?php echo !empty($arriving_message) ? '' : 'none';?>;"><?php echo $arriving_message;?></label>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->
			
								
							</div><!-- /.pjSbs-car-desc -->		
						</div><!-- /.col-md-3 -->
						<div class="col-sm-12 col-xs-12">
							<div class="pjSbs-car-info"><?php echo !empty($v['description']) ? nl2br(pjSanitize::html($v['description'])) : NULL;?></div><!-- /.pjSbs-car-info -->
						</div>
					</div><!-- /.row -->
				</div><!-- /.pjSbs-car -->
				<?php
			}
		}
	}
	if(!empty($tpl['line_arr']) || (isset($SEARCH['has_return']) && !empty($tpl['return_line_arr'])) )
	{
		?>
		<div class="pjSbs-body-actions">
			<br>
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<a href="#" data-load="loadSearch" class="btn btn-secondary btn-block pjSbsStepLink"><?php __('front_btn_back');?></a>
				</div><!-- /.col-sm-3 -->
				<div class="col-sm-3 col-sm-offset-6 col-xs-12">
					<form id="pjSbsLinesForm_<?php echo $index;?>" action="#" method="post">
						<input type="submit" value="<?php __('front_btn_checkout');?>" class="btn btn-primary btn-block" >
					</form>
				</div><!-- /.col-sm-3 -->
			</div><!-- /.row -->
		</div><!-- /.pjSbs-body-actions -->
		<?php
	}else{
		?>
		<div class="pjSbs-body-actions">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<a href="#" data-load="loadSearch" class="btn btn-secondary btn-block pjSbsStepLink"><?php __('front_btn_back');?></a>
				</div><!-- /.col-sm-3 -->
			</div><!-- /.row -->
		</div><!-- /.pjSbs-body-actions -->
		<?php
	} 
	?>
</div><!-- /.pjSbs-body -->