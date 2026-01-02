<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminLines extends pjAdmin
{
	public function pjActionCreate()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    $post_max_size = pjUtil::getPostMaxSize();
	    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $post_max_size)
	    {
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminLines&action=pjActionIndex&err=ALN05");
	    }
	    if (self::isPost() && $this->_post->toInt('action_create'))
	    {
	        $post_data = $this->_post->raw();
	        $pjLineModel = pjLineModel::factory();
	        $id = $pjLineModel->setAttributes($post_data)->insert()->getInsertId();
	        if ($id !== false && (int) $id > 0)
	        {
	            $i18n_arr = $this->_post->toI18n('i18n');
	            if (!empty($i18n_arr))
	            {
	                pjMultiLangModel::factory()->saveMultiLang($i18n_arr, $id, 'pjLine');
	            }
	            $pd_ids = $this->_post->toArray('pd_id');
	            if(!empty($pd_ids))
	            {
	                $pjLineDetailModel = pjLineDetailModel::factory();
	                $pjLineDetailModel->begin();
	                foreach($pd_ids as $k => $location_id)
	                {
	                    $pjLineDetailModel
	                    ->reset()
	                    ->set('line_id', $id)
	                    ->set('location_id', $location_id)
	                    ->set('duration_pickup', $post_data['duration_pickup'][$k])
	                    ->set('duration_dropoff', $post_data['duration_dropoff'][$k])
	                    ->set('price_pickup', $post_data['price_pickup'][$k])
	                    ->set('price_dropoff', $post_data['price_dropoff'][$k])
	                    ->insert();
	                }
	                $pjLineDetailModel->commit();
	            }
	            if (isset($_FILES['image']))
	            {
	                if($_FILES['image']['error'] == 0)
	                {
	                    $image_size = getimagesize($_FILES['image']['tmp_name']);
	                    if(!empty($image_size))
	                    {
	                        $Image = new pjImage();
	                        if ($Image->getErrorCode() !== 200)
	                        {
	                            $Image->setAllowedTypes(array('image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg'));
	                            if ($Image->load($_FILES['image']))
	                            {
	                                $resp = $Image->isConvertPossible();
	                                if ($resp['status'] === true)
	                                {
	                                    $hash = md5(uniqid(rand(), true));
	                                    $source_path = PJ_UPLOAD_PATH . 'lines/source/' . $id . '_' . $hash . '.' . $Image->getExtension();
	                                    $thumb_path = PJ_UPLOAD_PATH . 'lines/thumb/' . $id . '_' . $hash . '.' . $Image->getExtension();
	                                    if ($Image->save($source_path))
	                                    {
	                                        $Image->loadImage($source_path);
	                                        $Image->resizeSmart(150, 100);
	                                        $Image->saveImage($thumb_path);
	                                        
	                                        $data['source_path'] = $source_path;
	                                        $data['thumb_path'] = $thumb_path;
	                                        $data['image_name'] = $_FILES['image']['name'];
	                                        $pjLineModel->reset()->where('id', $id)->limit(1)->modifyAll($data);
	                                    }
	                                }
	                            }
	                        }
	                    }else{
	                        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionUpdate&id=$id&err=ALN11");
	                    }
	                }else if($_FILES['image']['error'] != 4){
	                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionUpdate&id=$id&err=ALN09");
	                }
	            }
	            $err = 'ALN03';
	        }else{
	            $err = 'ALN04';
	        }
	        
	        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionIndex&err=$err");
	    }
	    if (self::isGet())
	    {
	        $this->setLocalesData();
	        
	        $pjLocationModel = pjLocationModel::factory();
	        $da_arr = $pjLocationModel
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'DA')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('da_arr', $da_arr);
	        
	        $pd_arr = $pjLocationModel
	        ->reset()
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'PD')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('pd_arr', $pd_arr);
	        
	        $this->appendCss('jasny-bootstrap.min.css', PJ_THIRD_PARTY_PATH . 'jasny/');
	        $this->appendJs('jasny-bootstrap.min.js',  PJ_THIRD_PARTY_PATH . 'jasny/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('pjAdminLines.js');
	    }
	}
	
	public function pjActionDeleteLine()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
	    }
	    if (!($this->_get->toInt('id')))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    $pjLineModel = pjLineModel::factory();
	    $arr = $pjLineModel->find($this->_get->toInt('id'))->getData();
	    if (!$pjLineModel->reset()->set('id', $this->_get->toInt('id'))->erase()->getAffectedRows())
	    {
	        if(file_exists(PJ_INSTALL_PATH . $arr['source_path']))
	        {
	            @unlink(PJ_INSTALL_PATH . $arr['source_path']);
	        }
	        if(file_exists(PJ_INSTALL_PATH . $arr['thumb_path']))
	        {
	            @unlink(PJ_INSTALL_PATH . $arr['thumb_path']);
	        }
	        pjMultiLangModel::factory()->where('model', 'pjLine')->where('foreign_id', $this->_get->toInt('id'))->eraseAll();
	        pjLineDetailModel::factory()->where('line_id', $this->_get->toInt('id'))->eraseAll();
	    }
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Line has been deleted'));
	    exit;	
	}
	
	public function pjActionDeleteLineBulk()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
	    }
	    if (!$this->_post->has('record'))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    $record = $this->_post->toArray('record');
	    if (empty($record))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    
	    $pjLineModel = pjLineModel::factory();
	    $arr = $pjLineModel
	    ->reset()
	    ->whereIn('id', $record)
	    ->findAll()
	    ->getData();
	    foreach($arr as $v)
	    {
	        if(file_exists(PJ_INSTALL_PATH . $v['source_path']))
	        {
	            @unlink(PJ_INSTALL_PATH . $v['source_path']);
	        }
	        if(file_exists(PJ_INSTALL_PATH . $v['thumb_path']))
	        {
	            @unlink(PJ_INSTALL_PATH . $v['thumb_path']);
	        }
	    }
	    $pjLineModel->reset()->whereIn('id', $record)->eraseAll();
	    pjLineDetailModel::factory()->whereIn('line_id', $record)->eraseAll();
	    pjMultiLangModel::factory()->where('model', 'pjLine')->whereIn('foreign_id', $record)->eraseAll();	    
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Line(s) has been deleted.'));
	    exit;
	}
	
	public function pjActionExportLine()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    $record = $this->_post->toArray('record');
	    if (count($record))
	    {
	        $arr = pjLineModel::factory()
	        ->select("t1.*, t2.content as line, t3.content as description")
	        ->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t3.model='pjLine' AND t3.foreign_id=t1.id AND t3.field='description' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
	        ->whereIn('t1.id', $record)
	        ->findAll()->getData();
	        $csv = new pjCSV();
	        $csv
	        ->setHeader(true)
	        ->setName("Lines-".time().".csv")
	        ->process($arr)
	        ->download();
	    }
	    exit;	    
	}
	
	public function pjActionGetLine()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjLineModel = pjLineModel::factory();
			
			$pjLineModel
			->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->join('pjMultiLang', "t3.model='pjLine' AND t3.foreign_id=t1.id AND t3.field='description' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
			->join('pjMultiLang', "t4.model='pjLocation' AND t4.foreign_id=t1.location_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer');
			if ($q = $this->_get->toString('q'))
			{
			    $pjLineModel->where("(t2.content LIKE '%$q%' OR t3.content LIKE '%$q%')");
			}
	
			$column = 'title';
			$direction = 'ASC';
			if ($this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
			    $direction = strtoupper($this->_get->toString('direction'));
			}

			$total = $pjLineModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
			$data = $pjLineModel
				->select('t1.*, t2.content as title, t4.content as location')
				->orderBy("$column $direction")
				->limit($rowCount, $offset)
				->findAll()->getData();
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
		
	    $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	    $this->appendJs('pjAdminLines.js');
	}
	
	public function pjActionSaveLine()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    
	    $arr = pjLocationModel::factory()->find($this->_get->toInt('id'))->getData();
	    if (!$arr)
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Line not found.'));
	    }
	    
	    $pjLineModel = pjLineModel::factory();
	    if (!in_array($this->_post->toString('column'), $pjLineModel->getI18n()))
	    {
	        $pjLineModel->where('id', $this->_get->toInt('id'))->limit(1)->modifyAll(array($this->_post->toString('column') => $this->_post->toString('value')));
	    } else {
	        pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($this->_post->toString('column') => $this->_post->toString('value'))), $this->_get->toInt('id'), 'pjLine', 'data');
	    }
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Line has been updated.'));
	    exit;
	}
	
	public function pjActionStatusLine()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    $record = $this->_post->toArray('record');
	    if (count($record) > 0)
	    {
	        pjLineModel::factory()->whereIn('id', $record)->modifyAll(array(
	            'status' => ":IF(`status`='F','T','F')"
	        ));
	    }
		exit;
	}
	
	public function pjActionUpdate()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    $post_max_size = pjUtil::getPostMaxSize();
	    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $post_max_size)
	    {
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminLines&action=pjActionIndex&err=ALN05");
	    }
	    if (self::isPost() && $this->_post->toInt('action_update'))
	    {
	        $pjLineModel = pjLineModel::factory();
	        
	        $id = $this->_post->toInt('id');
	        $arr = $pjLineModel->find($id)->getData();
	        if (empty($arr))
	        {
	            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionIndex&err=ALN08");
	        }
	        
	        $data = array();
	        if (isset($_FILES['image']))
	        {
	            if($_FILES['image']['error'] == 0)
	            {
	                $image_size = getimagesize($_FILES['image']['tmp_name']);
	                if(!empty($image_size))
	                {
	                    if(!empty($arr['source_path']))
	                    {
	                        $source_path = PJ_INSTALL_PATH . $arr['source_path'];
	                        $thumb_path = PJ_INSTALL_PATH . $arr['thumb_path'];
	                        @unlink($source_path);
	                        @unlink($thumb_path);
	                    }
	                    
	                    $Image = new pjImage();
	                    if ($Image->getErrorCode() !== 200)
	                    {
	                        $Image->setAllowedTypes(array('image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg'));
	                        if ($Image->load($_FILES['image']))
	                        {
	                            $resp = $Image->isConvertPossible();
	                            if ($resp['status'] === true)
	                            {
	                                $hash = md5(uniqid(rand(), true));
	                                $source_path = PJ_UPLOAD_PATH . 'lines/source/' . $id . '_' . $hash . '.' . $Image->getExtension();
	                                $thumb_path = PJ_UPLOAD_PATH . 'lines/thumb/' . $id . '_' . $hash . '.' . $Image->getExtension();
	                                if ($Image->save($source_path))
	                                {
	                                    $Image->loadImage($source_path);
	                                    $Image->resizeSmart(150, 100);
	                                    $Image->saveImage($thumb_path);
	                                    
	                                    $data['source_path'] = $source_path;
	                                    $data['thumb_path'] = $thumb_path;
	                                    $data['image_name'] = $_FILES['image']['name'];
	                                }
	                            }
	                        }
	                    }
	                }else{
	                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionUpdate&id=".$id."&err=ALN11");
	                }
	            }else if($_FILES['image']['error'] != 4){
	                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLines&action=pjActionUpdate&id=".$id."&err=ALN10");
	            }
	        }
	        $pjLineModel->reset()->where('id', $id)->limit(1)->modifyAll(array_merge($this->_post->raw(), $data));
	        $i18n_arr = $this->_post->toI18n('i18n');
	        if (!empty($i18n_arr))
	        {
	            pjMultiLangModel::factory()->updateMultiLang($i18n_arr, $this->_post->toInt('id'), 'pjLine');
	        }
	        
	        $pjLineDetailModel = pjLineDetailModel::factory();
	        $line_detail_id_arr = $pjLineDetailModel->where('t1.line_id', $id)->findAll()->getDataPair(null, 'id');
	        
	        $pd_id_arr = $this->_post->toArray('pd_id');
	        if(!empty($pd_id_arr))
	        {
	            $post = $this->_post->raw();
	            $update_id_arr = array();
	            $pjLineDetailModel->reset();
	            $pjLineDetailModel->begin();
	            foreach($pd_id_arr as $k => $location_id)
	            {
	                if(strpos($k, 'new') !== FALSE)
	                {
	                    $pjLineDetailModel
	                    ->reset()
	                    ->set('line_id', $id)
	                    ->set('location_id', $location_id)
	                    ->set('duration_pickup', $post['duration_pickup'][$k])
	                    ->set('duration_dropoff', $post['duration_dropoff'][$k])
	                    ->set('price_pickup', $post['price_pickup'][$k])
	                    ->set('price_dropoff', $post['price_dropoff'][$k])
	                    ->insert();
	                }else{
	                    if(in_array($k, $line_detail_id_arr))
	                    {
	                        $update_id_arr[] = $k;
	                    }
	                }
	            }
	            $pjLineDetailModel->commit();
	            
	            $remove_id_arr = array();
	            if(!empty($update_id_arr))
	            {
	                foreach($update_id_arr as $line_detail_id)
	                {
	                    $update_data = array();
	                    $update_data['line_id'] = $id;
	                    $update_data['location_id'] = $post['pd_id'][$line_detail_id];
	                    $update_data['duration_pickup'] = $post['duration_pickup'][$line_detail_id];
	                    $update_data['duration_dropoff'] = $post['duration_dropoff'][$line_detail_id];
	                    $update_data['price_pickup'] = $post['price_pickup'][$line_detail_id];
	                    $update_data['price_dropoff'] = $post['price_dropoff'][$line_detail_id];
	                    $pjLineDetailModel->reset()->where('id', $line_detail_id)->limit(1)->modifyAll($update_data);
	                }
	                $remove_id_arr=array_diff($line_detail_id_arr,$update_id_arr);
	            }else{
	                $remove_id_arr = $line_detail_id_arr;
	            }
	            if(!empty($remove_id_arr))
	            {
	                $pjLineDetailModel->reset()->whereIn('id', $remove_id_arr)->eraseAll();
	            }
	        }
	        
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminLines&action=pjActionIndex&err=ALN01");
	    }
	    if (self::isGet())
	    {
	        $this->setLocalesData();
	        
	        $pjMultiLangModel = pjMultiLangModel::factory();
	        
	        $arr = pjLineModel::factory()->find($this->_get->toInt('id'))->getData();
	        if (count($arr) === 0)
	        {
	            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminLines&action=pjActionIndex&err=ALN08");
	        }
	        $arr['i18n'] = $pjMultiLangModel->getMultiLang($arr['id'], 'pjLine');
	        $this->set('arr', $arr);
	        
	        $pjLocationModel = pjLocationModel::factory();
	        $da_arr = $pjLocationModel
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'DA')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('da_arr', $da_arr);
	        
	        $pd_arr = $pjLocationModel
	        ->reset()
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'PD')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('pd_arr', $pd_arr);
	        
	        $line_detail_arr = pjLineDetailModel::factory()->where('t1.line_id', $this->_get->toInt('id'))->findAll()->getData();
	        $this->set('line_detail_arr', $line_detail_arr);
	        
	        $this->appendCss('jasny-bootstrap.min.css', PJ_THIRD_PARTY_PATH . 'jasny/');
	        $this->appendJs('jasny-bootstrap.min.js',  PJ_THIRD_PARTY_PATH . 'jasny/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('pjAdminLines.js');
	    }
	}
	
	public function pjActionDeleteImage()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
	    }
	    
	    if ($this->_get->check('id') && $this->_get->toInt('id'))
	    {
	        $pjLineModel = pjLineModel::factory();
	        $arr = $pjLineModel->find($this->_get->toInt('id'))->getData();
	        if (!empty($arr))
	        {
	            if(!empty($arr['source_path']))
	            {
	                $source_path = PJ_INSTALL_PATH . $arr['source_path'];
	                $thumb_path = PJ_INSTALL_PATH . $arr['thumb_path'];
	                @unlink($source_path);
	                @unlink($thumb_path);
	            }
	            
	            $data = array();
	            $data['source_path'] = ':NULL';
	            $data['thumb_path'] = ':NULL';
	            $data['image_name'] = ':NULL';
	            $pjLineModel->reset()->where(array('id' => $this->_get->toInt('id')))->limit(1)->modifyAll($data);
	            
	            self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
	        }
	    }
	    self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
	}
}
?>