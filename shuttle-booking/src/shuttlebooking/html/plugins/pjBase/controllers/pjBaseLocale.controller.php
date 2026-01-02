<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseLocale extends pjBase
{
	public $pjBaseLocaleKey = 'pjBaseLocaleKey';
	
	private $pjBaseLocaleError = 'pjBaseLocaleError';
	
	private function pjActionUpdateFieldsIndex()
	{
	    return pjBaseOptionModel::factory()
	    ->where('`key`', 'o_fields_index')
	    ->limit(1)
	    ->modifyAll(array('value' => md5(uniqid(rand(), true))))
	    ->getAffectedRows();
	}
	
	public function afterFilter()
	{
		$isFlagReady = false;
		$trace = debug_backtrace(0);
		foreach ($trace as $item)
		{
			if (isset($item['args'][0]['controller'], $item['args'][0]['action']) 
				&& $item['args'][0]['controller'] == 'pjBaseLocale' 
				&& $item['args'][0]['action'] == 'pjActionIsFlagReady')
			{
				$isFlagReady = true;
				break;
			}
		}
		
		if (!$isFlagReady)
		{
			parent::afterFilter();
		}
	}
	
	protected static function addLocale($iso, $locale_id=NULL)
	{
		$language = pjLocaleLanguageModel::factory()->where('t1.iso', $iso)->limit(1)->findAll()->getDataIndex(0);
	
		$pjLocaleModel = pjLocaleModel::factory();
	
		$pjLocaleModel->begin();
	
		$statement = sprintf("SET @sort := (SELECT MAX(`sort`) + 1 FROM `%s` LIMIT 1);", $pjLocaleModel->getTable());
		$pjLocaleModel->prepare($statement)->exec();
	
		$statement = sprintf("INSERT IGNORE INTO `%s` (`id`, `language_iso`, `name`, `dir`, `sort`, `is_default`) VALUES (NULL, :language_iso, :name, :dir, @sort, 0);", $pjLocaleModel->getTable());
		$insert_id = $pjLocaleModel
			->prepare($statement)
			->exec(array(
				'language_iso' => $iso,
				'name' => isset($language['native']) ? $language['native'] : 'NULL',
				'dir' => isset($language['dir']) ? $language['dir'] : 'NULL',
			))
			->getInsertId();
	
		if (!($insert_id !== FALSE && (int) $insert_id > 0))
		{
			return array('status' => 'ERR', 'code' => 100, 'text' => 'Locale has not been added.');
		}
	
		if (empty($locale_id))
		{
			$arr = $pjLocaleModel->reset()->findAll()->getData();
			foreach ($arr as $locale)
			{
				if ($locale['language_iso'] == 'gb')
				{
					$locale_id = $locale['id'];
					break;
				}
			}
			if (is_null($locale_id) && !empty($arr))
			{
				$locale_id = $arr[0]['id'];
			}
		}
	
		if (empty($locale_id))
		{
			$pjLocaleModel->rollback();
			return array('status' => 'ERR', 'code' => 101, 'text' => 'Locale ID is empty.');
		}
	
		$pjLocaleModel->commit();
	
		$pjMultiLangModel = pjMultiLangModel::factory();
	
		$sql = sprintf("INSERT IGNORE INTO `%1\$s` (`foreign_id`, `model`, `locale`, `field`, `content`)
			SELECT t1.foreign_id, t1.model, :insert_id, t1.field, t1.content
			FROM `%1\$s` AS t1
			WHERE t1.locale = :locale", $pjMultiLangModel->getTable());
	
		$pjMultiLangModel->prepare($sql)->exec(array(
			'insert_id' => $insert_id,
			'locale' => (int) $locale_id
		));
	
		return array('status' => 'OK', 'code' => 200, 'text' => 'Locale has been added.', 'id' => $insert_id);
	}
	
	protected static function checkDefault()
	{
		if (0 == pjLocaleModel::factory()->where('is_default', 1)->findCount()->getData())
		{
			pjLocaleModel::factory()->limit(1)->modifyAll(array('is_default' => 1));
		}
	}
	
	protected static function updateFieldsIndex()
	{
		return pjBaseOptionModel::factory()
			->where('`key`', 'o_fields_index')
			->limit(1)
			->modifyAll(array('value' => md5(uniqid(rand(), true))))
			->getAffectedRows();
	}
		
	public function pjActionIsFlagReady()
	{
		if (!isset($this->option_arr['o_multi_lang']) || (int) $this->option_arr['o_multi_lang'] === 0)
		{
			return FALSE;
		}
		
		$cnt = pjLocaleModel::factory()
			->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left')
			->where('t2.file IS NOT NULL')
			->orderBy('t1.sort ASC')
			->findCount()
			->getData();
		
		return ($cnt > 1);
	} 
	
	public function pjActionLabels()
	{
	    $this->checkLogin();
	    
	    if (!pjAuth::factory('pjBaseLocale', 'pjActionLabels')->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
	    
	    if (self::isPost())
	    {
	        if ($this->_post->check('lang_show_id'))
	        {
	        	if (pjAuth::factory('pjBaseLocale', 'pjActionLabels')->hasAccess())
                {
                    $this->session->setData('lang_show_id', $this->_post->check('show_id') ? 1 : 0);
	                self::updateFieldsIndex();
                }
	        }
	        
	        pjUtil::redirect($_SERVER['PHP_SELF'] . '?controller=pjBaseLocale&action=pjActionLabels');
	    }
	    
	    if (self::isGet())
	    {
	        $this->set('has_access_show_ids', pjAuth::factory('pjBaseLocale', 'pjActionLabels')->hasAccess());
	        $this->set('is_ids_shown', self::isIDsShown());
	        $this->appendJs('jquery.datagrid.js', $this->getConst('PLUGIN_JS_PATH'));
	        $this->appendJs('pjBaseLocale.js', $this->getConst('PLUGIN_JS_PATH'));
	    }
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();

		if (!pjAuth::factory()->hasAccess())
        {
        	if (pjAuth::factory('pjBaseLocale', 'pjActionLabels')->hasAccess())
            {
                pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseLocale&action=pjActionLabels");
            } elseif (pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess()) {
                pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseLocale&action=pjActionImportExport");
            } else {
                $this->sendForbidden();
                return;
            }
        }
		
		if (isset($this->option_arr['o_multi_lang']) && (int) $this->option_arr['o_multi_lang'] === 1)
		{
			$arr = pjLocaleLanguageModel::factory()->where('t1.file IS NOT NULL')->orderBy('t1.title ASC')->findAll()->getData();
			
			foreach ($arr as &$item)
			{
				if (!empty($item['region']))
				{
					$item['title'] = sprintf('%s (%s)', $item['title'], $item['region']);
				}
			}
			
			$this->set('language_arr', $arr);
			
			$this->appendJs('jquery-ui.min.js', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
			$this->appendJs('jquery.datagrid.js', $this->getConst('PLUGIN_JS_PATH'));
			$this->appendJs('pjBaseLocale.js', $this->getConst('PLUGIN_JS_PATH'));
		} else {
			$this->set('status', 3);
			return;
		}
	}
	
	public function pjActionSaveFields()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin())
		{
			$this->sendForbidden();
			return;
		}

		$i18n = $this->_post->toI18n('i18n');
		if (count($i18n) > 0)
		{
			$pjBaseFieldModel = pjBaseFieldModel::factory();
			$MultiLangModel = pjMultiLangModel::factory();
			$MultiLangModel->begin();
			foreach ($i18n as $locale_id => $arr)
			{
				foreach ($arr as $foreign_id => $locale_arr)
				{
					$data = array();
					$data[$locale_id] = array();
					foreach ($locale_arr as $name => $content)
					{
						$data[$locale_id][$name] = $content;
					}
					$fids = $MultiLangModel->updateMultiLang($data, $foreign_id, 'pjBaseField');
					if (!empty($fids))
					{
						$pjBaseFieldModel->reset()->whereIn('id', $fids)->limit(count($fids))->modifyAll(array('modified' => ':NOW()'));
					}
				}
			}
			$MultiLangModel->commit();
			$this->updateFieldsIndex();
		}
		pjUtil::redirect(sprintf("%sindex.php?controller=pjBaseLocale&action=%s&err=PAL01&tab=1&q=%s&locale=%u&page=%u", PJ_INSTALL_URL, $this->_post->toString('next_action'), urlencode($this->_post->toString('q')), $this->_post->toInt('locale'), $this->_post->toInt('page')));
		exit;
	}
	
	public function pjActionDeleteLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
		    if (!pjAuth::factory('pjBaseLocale', 'pjActionIndex')->hasAccess())
		    {
		        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.'));
		    }
		    if ($this->_get->toInt('id') <= 0)
		    {
		        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
		    }
		    $id = $this->_get->toInt('id');
		    
			$pjLocaleModel = pjLocaleModel::factory();
			$arr = $pjLocaleModel->find($id)->getData();
			if (empty($arr))
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Locale not found.'));
			}
			
			if ($pjLocaleModel->reset()->set('id', $id)->erase()->getAffectedRows() != 1)
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Locale has not been deleted.'));
			}
			
			if (!empty($arr['flag']) && is_file($arr['flag']))
			{
				@unlink($arr['flag']);
			}
			
			# Re-order
			$tmp = $pjLocaleModel
				->reset()
				->select('t1.id, t1.sort, @rownum := @rownum + 1 AS `row_number`')
				->join('CROSS JOIN (SELECT @rownum := 0) AS `r`')
				->orderBy('t1.sort ASC')
				->findAll()
				->getData();
			
			foreach ($tmp as $item)
			{
				if ($item['sort'] != $item['row_number'])
				{
					$pjLocaleModel->reset()->set('id', $item['id'])->modify(array('sort' => $item['row_number']));
				}
			}
			
			pjMultiLangModel::factory()->where('locale', $id)->eraseAll();
			$this->updateFieldsIndex();
			
			self::checkDefault();
			
			self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Locale has been deleted.'));
		}
		exit;
	}
	
	public function pjActionGetLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjLocaleModel = pjLocaleModel::factory();
			
			if ($this->_get->toString('q'))
			{
			    $q = $this->_get->toString('q');
				$q = str_replace(array('%', '_'), array('\%', '\_'), trim($q));
				$pjLocaleModel->where(sprintf("(t1.name LIKE '%1\$s' OR t1.language_iso LIKE '%1\$s')", "%$q%"));
			}
			
			$column = 't1.sort';
			$direction = 'ASC';
			if ($this->_get->toString('direction') && $this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
				$direction = strtoupper($this->_get->toString('direction'));
			}

			$total = $pjLocaleModel->findCount()->getData();
			$rowCount = 100;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') > 0 ? $this->_get->toInt('page') : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjLocaleModel
				->select(sprintf("t1.*, t2.title, CONCAT('%spj/img/flags/', t2.file) AS `file`", PJ_FRAMEWORK_LIBS_PATH))
				->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left')
				->orderBy("$column $direction")->findAll()->getData();
						
			self::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionGetLabels()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			$locale = $this->_get->toInt('locale_id');
			
			$default_locale = pjLocaleModel::factory()
				->select('t1.id')
				->where('t1.is_default', 1)
				->limit(1)
				->findAll()
				->getDataIndex(0);
			
			$default_locale = !empty($default_locale) ? $default_locale['id'] : $locale;
			
			$pjBaseFieldModel = pjBaseFieldModel::factory();
			
			$pjBaseFieldModel
				->join('pjBaseMultiLang', sprintf("t2.model='pjBaseField' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='title'", $locale), 'left outer')
				->join('pjBaseMultiLang', sprintf("t3.model='pjBaseField' AND t3.foreign_id=t1.id AND t3.locale='%u' AND t3.field='title'", $default_locale), 'left outer');
				
			if ($this->_get->toString('q'))
			{
			    $q = $this->_get->toString('q');
				$q = str_replace(array('%', '_'), array('\%', '\_'), trim($q));
				$pjBaseFieldModel->where(sprintf("(t1.key LIKE '%1\$s' OR t2.content LIKE '%1\$s' OR CONCAT(':', t1.id, ':') LIKE '%1\$s')", "%$q%"));
			}
			
			$column = 't1.id';
			$direction = 'ASC';
			if ($this->_get->toString('direction') && $this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
				$direction = strtoupper($this->_get->toString('direction'));
			}
		
			$total = $pjBaseFieldModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') > 0 ? $this->_get->toInt('rowCount') : 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') > 0 ? $this->_get->toInt('page') : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
			
			if (self::isIDsShown())
			{
				$fields = "t1.id, t1.`type` AS `field_type`, t1.source, t3.content AS `default_language`, t2.locale, t2.content, IF(CHAR_LENGTH(t2.content)>70,1,0) AS `expand`, CONCAT(':', t1.id, ':') AS `did`";
			} else {
				$fields = "t1.id, t1.`type` AS `field_type`, t1.source, t3.content AS `default_language`, t2.locale, t2.content, IF(CHAR_LENGTH(t2.content)>70,1,0) AS `expand`";
			}
			
			$data = $pjBaseFieldModel
				->select($fields)
				->orderBy("$column $direction")
				->limit($rowCount, $offset)
				->findAll()
				->getData();
			foreach($data as $k => $v)
			{
			    $field_type_arr = array();
			    $field_type_arr[] = __('plugin_base_locale_type_' . $v['source'], true);
			    $field_type_arr[] = __('plugin_base_locale_type_' . $v['field_type'], true);
			    $v['field_type'] = join(" / ", $field_type_arr);
			    $data[$k] = $v;
			    
			}
			self::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction', 'locale'));
		}
		exit;
	}
	
	public function pjActionSaveLabel()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (!self::isPost())
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
			}
			if (!($this->_post->check('i18n') && $this->_post->check('foreign_id') && $this->_post->toInt('foreign_id') > 0))
			{
			    self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
			}
			
			$fids = pjMultiLangModel::factory()->updateMultiLang($this->_post->toI18n('i18n'), $this->_post->toInt('foreign_id'), 'pjBaseField');
			
			self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Label has been saved.', 'f' => $fids));
		}
		exit;
	}
	
	public function pjActionSaveLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (!self::isPost())
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'HTTP method not allowed.'));
			}
			if (!pjAuth::factory('pjBaseLocale', 'pjActionIndex')->hasAccess())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.'));
            }
			
			if ($this->_get->check('id') && $this->_post->check('column') && $this->_post->check('value')
			    && $this->_post->toString('column')
				&& $this->_get->toInt('id') > 0)
			{
			    $data = array($this->_post->toString('column') => $this->_post->toString('value'));
			    if ($this->_post->toString('column') == 'language_iso')
				{
				    $tmp = pjLocaleLanguageModel::factory()->where('t1.iso', $this->_post->toString('value'))->limit(1)->findAll()->getDataIndex(0);
					
					$data['dir'] = $tmp['dir'];
					$data['name'] = $tmp['native'];
					$data['flag'] = ':NULL';
				}
					
				pjLocaleModel::factory()->set('id', $this->_get->toInt('id'))->modify($data);
				self::jsonResponse(array('status' => 'OK', 'code' => 201, 'text' => 'Locale has been updated.'));
			}
			
			$lang = pjLocaleLanguageModel::factory()
				->where(sprintf("t1.iso NOT IN (SELECT `language_iso` FROM `%s`)", pjLocaleModel::factory()->getTable()))
				->where('t1.file IS NOT NULL')
				->orderBy('t1.title ASC')
				->limit(1)
				->findAll()
				->getDataPair(null, 'iso');
			
			$result = $this->addLocale(@$lang[0]);
			if ($result['status'] === 'OK')
			{
				$this->updateFieldsIndex();
			}
			self::jsonResponse($result);
		}
		exit;
	}
	
	public function pjActionAddLocale()
	{
		$params = $this->getParams();
		
		return $this->addLocale($params['iso'], @$params['locale']);
	}
	
	public function pjActionSaveDefault()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (!self::isPost())
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
			}
			
			if ($this->_get->toInt('id') <= 0)
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
			}
			$id = $this->_get->toInt('id');
			pjLocaleModel::factory()
				->where(1,1)
				->modifyAll(array('is_default' => '0'))
				->reset()
				->set('id', $id)
				->modify(array('is_default' => 1));
				
			$this->setLocale($id);
			
			self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Default choise has been made.'));
		}
		exit;
	}
	
	public function pjActionSortLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
		    $sort_arr = $this->_post->toArray('sort');
			$LocaleModel = new pjLocaleModel();
			$arr = $LocaleModel->whereIn('id', $sort_arr)->orderBy("t1.sort ASC")->findAll()->getDataPair('id', 'sort');
			$fliped = array_flip($sort_arr);
			$combined = array_combine(array_keys($fliped), $arr);
			$LocaleModel->begin();
			foreach ($combined as $id => $sort)
			{
				$LocaleModel->setAttributes(compact('id'))->modify(compact('sort'));
			}
			$LocaleModel->commit();
		}
		exit;
	}
	
	public function pjActionGetIso()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (!self::isGet())
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
			}
			if ($this->_get->toInt('id') <= 0)
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
			}
			$id = $this->_get->toInt('id');
			$arr = pjLocaleModel::factory()->find($id)->getData();
			
			if ($arr)
			{
				self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Success', 'language_iso' => $arr['language_iso']));
			}
			
			self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Language not found.'));
		}
	}
	
	
	public function pjActionImportExport()
	{
	    $this->checkLogin();

	    $pjAuth = pjAuth::factory();
	    if (!pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }

	    $this->set('has_access_import', pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess(''));
	    $this->set('has_access_export', pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess(''));

	    $this->appendCss('jasny-bootstrap.min.css', PJ_THIRD_PARTY_PATH . 'jasny/');
	    $this->appendJs('jasny-bootstrap.min.js',  PJ_THIRD_PARTY_PATH . 'jasny/');
	    $this->appendJs('pjBaseLocale.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionImportConfirm()
	{
	    $this->checkLogin();
	    
	    if (!pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $pjLocaleModel = pjLocaleModel::factory()
    	    ->select('t1.*, t2.title, t2.region')
    	    ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso');
	    if (!isset($this->option_arr['o_multi_lang']) || (int) $this->option_arr['o_multi_lang'] === 0)
	    {
	        $pjLocaleModel->where('t1.is_default', 1);
	    }
	    $locale_arr = $pjLocaleModel->orderBy('t1.sort ASC')->findAll()->getDataPair('id');
	    
	    $columns = count($locale_arr) + 2;
	    
	    if ($this->_post->toInt('import'))
	    {
	        if (isset($_FILES['file']) && $this->_post->check('separator'))
	        {
	            $pjUpload = new pjUpload();
	            $pjUpload->setAllowedExt(array('csv', 'txt'));
	            $pjUpload->setAllowedTypes(array(
	                'text/plain',
	                'text/x-comma-separated-values',
	                'text/comma-separated-values',
	                'application/x-csv',
	                'application/csv',
	                'text/x-csv',
	                'text/csv',
	                'application/vnd.ms-excel',
	                'application/octet-stream',
	            ));
	            
	            if ($pjUpload->load($_FILES['file']))
	            {
	                if (($handle = fopen($pjUpload->getFile('tmp_name'), "rb")) !== FALSE)
	                {
	                    $separators = array(
	                        'comma' => ",",
	                        'semicolon' => ";",
	                        'tab' => "\t"
	                    );
	                    $separator = $separators[$this->_post->toString('separator')];
	                    
	                    $field_arr = pjBaseFieldModel::factory()->findAll()->getDataPair('id', 'key');
	                    
	                    $time = time();
	                    
	                    if(!$this->session->has($this->pjBaseLocaleError))
	                    {
	                        $this->session->setData($this->pjBaseLocaleError, array());
	                    }
	                    
	                    $i = 1;
	                    $prev_cnt = 0;
	                    $header = array();
	                    while (($data = fgetcsv($handle, 0, $separator)) !== FALSE)
	                    {
	                        if (!empty($data))
	                        {
	                            $nl = preg_grep('/\r\n|\n/', $data);
	                            if (!empty($nl))
	                            {
	                                $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                                $err = 'PAL14&tm=' . $time;
	                                break;
	                            }
	                            
	                            $cnt = count($data);
	                            if ($cnt <= 2)
	                            {
	                                $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                                $err = 'PAL15&tm=' . $time;
	                                break;
	                            }
	                            if ($prev_cnt > 0 && $cnt != $prev_cnt)
	                            {
	                                $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                                $err = 'PAL16&tm=' . $time;
	                                break;
	                            }
	                            
	                            if ($i > 1 && isset($id, $key) && $id !== FALSE && $key !== FALSE)
	                            {
	                                if (!preg_match('/^\d+$/', $data[$id]) || !preg_match('/^[\w\-]+$/', $data[$key]))
	                                {
	                                    $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                                    $err = 'PAL19&tm=' . $time;
	                                    break;
	                                }
	                                if (!isset($field_arr[$data[$id]]))
	                                {
	                                    continue;
	                                }
	                                if (isset($field_arr[$data[$id]]) && $data[$key] != $field_arr[$data[$id]])
	                                {
	                                    continue;
	                                }
	                            } elseif ($i == 1) {
	                                $header = $data;
	                                $id = array_search('id', $data);
	                                $key = array_search('key', $data);
	                                if ($id === FALSE || $key === FALSE)
	                                {
	                                    $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                                    $err = 'PAL18&tm=' . $time;
	                                    break;
	                                }
	                            }
	                            
	                            $prev_cnt = $cnt;
	                            $i += 1;
	                        } else {
	                            $this->session->setData($this->pjBaseLocaleError, array($time => sprintf(__('plugin_base_locale_error_line', true), $i)));
	                            $err = 'PAL17&tm=' . $time;
	                            break;
	                        }
	                    }
	                    fclose($handle);
	                } else {
	                    $err = 'PAL13';
	                }
	            } else {
	                echo $pjUpload->getErrorCode();
	                echo $pjUpload->getError();
	                exit;
	                $err = 'PAL12';
	            }
	        } else {
	            $err = 'PAL11';
	        }
	        
	        if (!isset($err))
	        {
	            $locales = array();
	            foreach ($header as $k => $col)
	            {
	                if (in_array($k, array($id, $key)))
	                {
	                    continue;
	                }
	                list($locales[],) = explode('::', $col);
	            }
	            
	            $key = md5(uniqid(rand(), true));
	            $dest = PJ_UPLOAD_PATH . $key . ".csv";
	            if ($pjUpload->save($dest))
	            {
	                $this->session->setData($key, array(
	                    'name' => $dest,
	                    'separator' => $this->_post->toString('separator'),
	                    'locales' => $locales
	                ));
	                $err = 'PAL20&key=' . $key;
	            } else {
	                $err = 'PAL20';
	            }
	        }
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseLocale&action=pjActionImportConfirm&tab=1&err=".$err);
	    }
	    $this->set('locale_arr', $locale_arr);
	    if($this->_get->toString('tm'))
	    {
	        if($this->session->has($this->pjBaseLocaleError))
	        {
	            $locale_error = $this->session->getData($this->pjBaseLocaleError);
	            if(isset($locale_error[$this->_get->toString('tm')]))
	            {
	                $this->set('tm_text', $locale_error[$this->_get->toString('tm')]);
	            }
	        }
	    }
	}
	
	public function pjActionImport()
	{
	    $this->checkLogin();
	    
	    if (!pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $this->setAjax(true);
	    $this->setLayout('pjActionEmpty');
	    
	    $err = 'PAL02';
	    if ($this->_post->toInt('import'))
	    {
	        @set_time_limit(600); //10 min

            $post = array();
            $post['key'] = $this->_post->toString('key');
            $post['locale'] = $this->_post->toArray('locale');

	        if ($post['key'] && $post['locale'] && $this->session->has($post['key']))
	        {
	            $post_key_arr = $this->session->getData($post['key']);
	            if(isset($post_key_arr['name'], $post_key_arr['separator']) && !empty($post_key_arr['name']) && !empty($post_key_arr['separator']))
	            {
    	            if (($handle = fopen($post_key_arr['name'], "rb")) !== FALSE)
    	            {
    	                $pjMultiLangModel = pjMultiLangModel::factory();
    	                
    	                $multi_lang_arr = $pjMultiLangModel
        	                ->select('t1.locale, t1.id AS `mid`, t2.id, t2.key')
        	                ->join('pjBaseField', 't2.id=t1.foreign_id', 'inner')
        	                ->where('t1.model', 'pjBaseField')
        	                ->where('t1.field', 'title')
        	                ->whereIn('t1.locale', $post['locale'])
        	                ->where('t1.source !=', 'data')
        	                ->findAll()
        	                ->getData();
    	                
    	                if (empty($multi_lang_arr))
    	                {
    	                    exit;
    	                }
    	                
    	                $import_arr = array();
    	                foreach ($multi_lang_arr as $k => $item)
    	                {
    	                    if (!isset($import_arr[$item['key']]))
    	                    {
    	                        $import_arr[$item['key']] = array(
    	                            'id' => $item['id'],
    	                            'key' => $item['key'],
    	                            'locales' => array()
    	                        );
    	                    }
    	                    $import_arr[$item['key']]['locales'][$item['locale']] = $item['mid'];
    	                }
    	                
    	                if (empty($import_arr))
    	                {
    	                    exit;
    	                }
    	                
    	                $separators = array(
    	                    'comma' => ",",
    	                    'semicolon' => ";",
    	                    'tab' => "\t"
    	                );
    	                $separator = $separators[$post_key_arr['separator']];
    	                
    	                $pjMultiLangModel->reset()->begin();
    	                
    	                $i = 1;
    	                while (($data = fgetcsv($handle, 0, $separator)) !== FALSE)
    	                {
    	                    if (!empty($data))
    	                    {
    	                        if ($i > 1 && isset($id, $key, $locales)
    	                            && !empty($locales)
    	                            && $id !== FALSE
    	                            && $key !== FALSE
    	                            && isset($import_arr[$data[$key]]))
    	                        {
    	                            foreach ($import_arr[$data[$key]]['locales'] as $locale_id => $mid)
    	                            {
    	                                if (($index = array_search($locale_id, $locales)) !== FALSE
    	                                    && $data[$key] == $import_arr[$data[$key]]['key'])
    	                                {
    	                                    $pjMultiLangModel
    	                                    ->set('id', $mid)
    	                                    ->modify(array(
    	                                        'content' => str_replace(array('\n', '\t'), array("\r\n", "\t"), $data[$index])
    	                                    ));
    	                                }
    	                            }
    	                        } elseif ($i == 1) {
    	                            $id = array_search('id', $data);
    	                            $key = array_search('key', $data);
    	                            if ($id !== FALSE && $key !== FALSE)
    	                            {
    	                                $locales = array();
    	                                foreach ($data as $k => $col)
    	                                {
    	                                    if (in_array($k, array($id, $key)))
    	                                    {
    	                                        continue;
    	                                    }
    	                                    list($loc,) = explode('::', $col);
    	                                    $locales[$k] = $loc;
    	                                }
    	                            }
    	                        }
    	                        $i += 1;
    	                    }
    	                }
    	                fclose($handle);
    	                @unlink($post_key_arr['name']);
    	                
    	                if ($i > 1)
    	                {
    	                    $pjMultiLangModel->commit();
    	                    $this->pjActionUpdateFieldsIndex();
    	                    $err = 'PAL03';
    	                } else {
    	                    $err = 'PAL04';
    	                }
    	            } else {
    	                $err = 'PAL05';
    	            }
	            }
	        }
	    }
	    pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseLocale&action=pjActionImportExport&err=".$err);
	}
	
	public function pjActionExport()
	{
	    $this->checkLogin();
	    
	    if (!pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $this->setAjax(true);
	    $this->setLayout('pjActionEmpty');
	    
	    if ($this->_post->toInt('export') && $this->_post->toString('separator'))
	    {
	        @set_time_limit(600); //10 min
	        
	        $name = 'pjBaseLocale-'.time();

	        $pjMultiLangModel = pjMultiLangModel::factory();
	        
	        $pjLocaleModel = pjLocaleModel::factory()
    	        ->select('t1.*, t2.title, t2.region')
    	        ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso');
	        if (!isset($this->option_arr['o_multi_lang']) || (int) $this->option_arr['o_multi_lang'] === 0)
	        {
	            $pjLocaleModel->where('t1.is_default', 1);
	        }
	        
	        $locale_arr = $pjLocaleModel->orderBy('t1.sort ASC')->findAll()->getDataPair('id');
	        
	        if (empty($locale_arr))
	        {
	            exit;
	        }
	        
	        $multi_lang_arr = $pjMultiLangModel
    	        ->select('t1.locale, t1.content, t2.id, t2.key')
    	        ->join('pjBaseField', 't2.id=t1.foreign_id', 'left outer')
    	        ->where('t1.model', 'pjBaseField')
    	        ->where('t1.field', 'title')
    	        ->whereIn('t1.locale', array_keys($locale_arr))
    	        ->where('t1.source !=', 'data')
    	        ->findAll()
    	        ->getData();
	        
	        if (empty($multi_lang_arr))
	        {
	            exit;
	        }
	        
	        $export_arr = array();
	        foreach ($multi_lang_arr as $k => $item)
	        {
	            if (!isset($export_arr[$item['id']]))
	            {
	                $export_arr[$item['id']] = array(
	                    'key' => $item['key'],
	                    'locales' => array()
	                );
	            }
	            $export_arr[$item['id']]['locales'][$item['locale']] = $item['content'];
	        }
	        
	        $csv = array();
	        
	        $separators = array(
	            'comma' => ",",
	            'semicolon' => ";",
	            'tab' => "\t"
	        );
	        $separator = $separators[$this->_post->toString('separator')];
	        
	        $header = array('id', 'key');
	        foreach ($locale_arr as $id => $data)
	        {
	            $title = $data['title'] . (!empty($data['region']) ? sprintf(' (%s)', $data['region']) : NULL);
	            $title = str_replace(array(',', ';'), ' ', $title);
	            $title = preg_replace('/\t/', ' ', $title);
	            $header[] = $id . '::' . $title;
	        }
	        $csv[] = join($separator, $header);
	        
	        foreach ($export_arr as $id => $data)
	        {
	            if(!empty($id))
	            {
	                $cells = array();
	                $cells[] = '"' . (int) $id . '"';
	                $cells[] = '"' . str_replace(array("\r\n", "\n", "\t", '"'), array('\n', '\n', '\t', '""'), $data['key']) . '"';
	                foreach ($locale_arr as $locale_id => $item)
	                {
	                    if (isset($data['locales'][$locale_id]))
	                    {
	                        $cells[] = '"' . str_replace(array("\r\n", "\n", "\t", '"'), array('\n', '\n', '\t', '""'), $data['locales'][$locale_id]) . '"';
	                    } else {
	                        $cells[] = '""';
	                    }
	                }
	                
	                $csv[] = "\n";
	                $csv[] = join($separator, $cells);
	            }
	        }
	        
	        $content = join("", $csv);
	        pjToolkit::download($content, $name.'.csv');
	    }
	    exit;
	}
}
?>