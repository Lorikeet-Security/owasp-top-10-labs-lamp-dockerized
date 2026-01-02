<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseBackup extends pjBase
{
    public function pjActionIndex()
    {
    	if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }

        if(self::isGet())
        {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('pjBaseBackup.js', $this->getConst('PLUGIN_JS_PATH'));
        }
    }

    public function pjActionBackup()
    {
    	if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }

        if (self::isPost() && $this->_post->check('backup'))
        {
            $backup_folder = PJ_WEB_PATH . 'backup/';
            if (!is_dir($backup_folder))
            {
                pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseBackup&action=pjActionIndex&err=PBU05");
            }
            if (!is_writable($backup_folder))
            {
                pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseBackup&action=pjActionIndex&err=PBU06");
            }
            if (!$this->_post->check('backup_database') && !$this->_post->check('backup_files'))
            {
                pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseBackup&action=pjActionIndex&err=PBU03");
            }

            @set_time_limit(600);
            $err = 'PBU04';
            if ($this->_post->check('backup_database'))
            {
                $app_models = array();
                pjToolkit::readDir($app_models, PJ_MODELS_PATH);

                $plugin_models = array();
                pjToolkit::readDir($plugin_models, PJ_PLUGINS_PATH);

                $sql = array();

                $err = 'PBU01';
                $file_name = PJ_WEB_PATH . 'backup/database-backup-'.time().'.sql';
                if($this->pjActionWriteSql($app_models, $file_name) == true)
                {
                    if($this->pjActionWriteSql($plugin_models, $file_name, true) == false)
                    {
                        pjUtil::redirect(sprintf("%sindex.php?controller=pjBaseBackup&action=pjActionIndex&err=%s", PJ_INSTALL_URL, 'PBU07'));
                    }
                }else{
                    pjUtil::redirect(sprintf("%sindex.php?controller=pjBaseBackup&action=pjActionIndex&err=%s", PJ_INSTALL_URL, 'PBU07'));
                }
            }
            if ($this->_post->check('backup_files'))
            {
                $files = array();
                pjToolkit::readDir($files, PJ_UPLOAD_PATH);

                $zipName = 'files-backup-'.time().'.zip';
                $zip = new pjZipStream();
                $zip->setZipFile(PJ_WEB_PATH . 'backup/' . $zipName);

                $backup_file = true;
                foreach ($files as $file)
                {
                    $handle = @fopen($file, "rb");
                    if ($handle !== false)
                    {
                        $buffer = "";
                        while (!feof($handle))
                        {
                            $buffer .= fgets($handle, 4096);
                        }
                        $zip->addFile($buffer, $file);
                        fclose($handle);
                    }else{
                        $backup_file = false;
                        break;
                    }
                }
                $zip->finalize();

                $err = 'PBU01';
                if($backup_file == false)
                {
                    pjUtil::redirect(sprintf("%sindex.php?controller=pjBaseBackup&action=pjActionIndex&err=%s", PJ_INSTALL_URL, 'PBU08'));
                }
            }

            pjUtil::redirect(sprintf("%sindex.php?controller=pjBaseBackup&action=pjActionIndex&err=%s", PJ_INSTALL_URL, $err));
        }
    }
    private function pjActionWriteSql($files, $sql_file, $is_plugin=FALSE)
    {
        $sql = array();
        foreach ($files as $filepath)
        {
            $filename = basename($filepath);
            if (preg_match('/^(\w+)\.model\.php$/', $filename, $matches))
            {
                $modelName = $matches[1] . 'Model';
                if ($is_plugin)
                {
                    if (!preg_match('/\/(\w+)\/models\/(\w+)\.model\.php$/', $filepath, $m) || !in_array($m[1], @$GLOBALS['CONFIG']['plugins']))
                    {
                        continue;
                    }
                }
                $model = new $modelName;
                
                $schema = $model->getSchema();
                if (empty($schema))
                {
                    continue;
                }
                
                $table = $model->getTable();
                if ($table == PJ_PREFIX . PJ_SCRIPT_PREFIX)
                {
                    continue;
                }
                
                $fields = array();
                $columns = array();
                $schema_index = array();
                
                foreach ($schema as $col)
                {
                    if ($col['type'] != 'blob')
                    {
                        $fields[] = sprintf("`%s`", $col['name']);
                    } else {
                        $fields[] = sprintf("LOWER(HEX(`%1\$s`)) AS `%1\$s`", $col['name']);
                    }
                    $columns[] = $col['name'];
                    $schema_index[$col['name']] = $col;
                }
                
                $result = $model->reset()->select(join(", ", $fields))->findAll()->getData();
                $sql[] = sprintf("DROP TABLE IF EXISTS `%s`;\n\n", $table);
                
                $create = $model->reset()->prepare(sprintf("SHOW CREATE TABLE `%s`", $table))->exec()->getData();
                $create = array_values($create[0]);
                $sql[] = sprintf("%s;\n\n", $create[1]);
                
                foreach ($result as $row)
                {
                    $sql[] = sprintf("INSERT INTO `%s` (`%s`) VALUES(", $table, join('`, `', $columns));
                    $insert = array();
                    foreach ($row as $key => $val)
                    {
                        if (isset($schema_index[$key], $schema_index[$key]['type']) && $schema_index[$key]['type'] == 'blob')
                        {
                            $insert[] = "'" . $val . "'";
                        } else {
                            if (isset($schema_index[$key], $schema_index[$key]['default'])
                                && $val == '')
                            {
                                $insert[] = strpos($schema_index[$key]['default'], ':') === 0
                                ? substr($schema_index[$key]['default'], 1)
                                : "'" . $schema_index[$key]['default'] . "'";
                            } else {
                                $val = str_replace('\n', '\r\n', $val);
                                $val = preg_replace("/\r\n/", '\r\n', $val);
                                $insert[] = "'" . str_replace("'", "''", stripslashes($val)) . "'";
                            }
                        }
                    }
                    $sql[] = join(", ", $insert);
                    $sql[] = ");\n";
                }
                $sql[] = "\n";
            }
            $content = join("", $sql);
            if (mb_strlen($content) >  $this->getConst('PLUGIN_BACKUP_DB_CHUNK') * 1000) 
            {
                if (($handle = fopen($sql_file, "a")) !==false) 
                {
                    fwrite($handle, $content);
                    fclose($handle);
                    $sql = array();
                    $content = '';
                }else{
                    @unlink($sql_file);
                    return false;
                }
            }
        }
        if(!empty($sql))
        {
            $content = join("", $sql);
            if (($handle = fopen($sql_file, "a")) !==false)
            {
                fwrite($handle, $content);
                fclose($handle);
            }else{
                @unlink($sql_file);
                return false;
            }
        }
        return true;
    }
    public function pjActionGet()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            $column = 'created';
            $direction = 'DESC';
            if (in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
            {
                $column = $this->_get->toString('column');
                $direction = strtoupper($this->_get->toString('direction'));
            }
            
            $data = $id = $created = $type = $size = array();
            if ($handle = opendir(PJ_WEB_PATH . 'backup'))
            {
                $i = 0;
                while (false !== ($entry = readdir($handle)))
                {
                    preg_match('/(database-backup|files-backup)-(\d{10})\.(sql|zip)/', $entry, $m);
                    if (isset($m[2]))
                    {
                        $id[$i] = $entry;
                        $created[$i] = $m[2];
                        $type[$i] = $m[1] == 'database-backup' ? __('plugin_backup_types_ARRAY_database', true) : __('plugin_backup_types_ARRAY_files', true);
                        
                        $data[$i]['id'] = $id[$i];
                        $data[$i]['created'] = $created[$i];
                        $data[$i]['type'] = $type[$i];
                        if (isset($m[0]))
                        {
                            $file_path = PJ_WEB_PATH . 'backup/' . $m[0];
                            $size[$i] = filesize($file_path);
                            $data[$i]['size'] = $size[$i];
                        }
                        $i++;
                    }
                }
                closedir($handle);
            }
            
            switch ($column)
            {
                case 'created':
                    array_multisort($created, $direction == 'ASC' ? SORT_ASC : SORT_DESC, $id, SORT_DESC, $type, SORT_ASC, $data);
                    break;
                case 'type':
                    array_multisort($type, $direction == 'ASC' ? SORT_ASC : SORT_DESC, $id, SORT_DESC, $created, SORT_DESC, $data);
                    break;
                case 'id':
                    array_multisort($id, $direction == 'ASC' ? SORT_ASC : SORT_DESC, $type, SORT_ASC, $created, SORT_DESC, $data);
                    break;
                case 'size':
                    array_multisort($size, $direction == 'ASC' ? SORT_ASC : SORT_DESC, $id, SORT_DESC, $type, SORT_ASC, $data);
                    break;
            }
            
            $total = count($data);
            $rowCount = $this->_get->toInt('rowCount') > 0 ? $this->_get->toInt('rowCount') : 10;
            $pages = ceil($total / $rowCount);
            $page = $this->_get->toInt('page') > 0 ? $this->_get->toInt('page') : 1;
            $offset = ((int) $page - 1) * $rowCount;
            if ($page > $pages)
            {
                $page = $pages;
            }
            foreach ($data as $k => $v)
            {
                $v['size'] = $this->formatSizeUnits($v['size']);
                $created = date($this->option_arr['o_date_format'] . ", H:i", $v['created']);
                if(isset($this->option_arr['o_time_format']) && !empty($this->option_arr['o_time_format']))
                {
                    $created = date($this->option_arr['o_date_format'] . ", " . $this->option_arr['o_time_format'], $v['created']);
                }
                $v['created'] = $created;
                $data[$k] = $v;
            }
            
            $data = array_slice($data, $offset, $rowCount);
            
            self::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
        }
        exit;
    }
    
    public function pjActionDelete()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if (!self::isPost())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
            }
            if (!pjAuth::factory()->hasAccess())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.'));
            }
            if ($this->_get->toInt('id') > 0)
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
            }
            $file = PJ_WEB_PATH . 'backup/' . basename($this->_get->toString('id'));
            clearstatcache();
            if (is_file($file))
            {
                @unlink($file);
                pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'File has been deleted.'));
            } else {
                pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'File not found.'));
            }
        }
        exit;
    }
    
    public function pjActionDeleteBulk()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if (!self::isPost())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
            }
            if (!pjAuth::factory()->hasAccess())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.'));
            }
            $record = $this->_post->toArray('record');
            if (empty($record))
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
            }
            
            foreach ($record as $item)
            {
                $file = PJ_WEB_PATH . 'backup/' . basename($item);
                clearstatcache();
                if (is_file($file))
                {
                    @unlink($file);
                }
            }
            pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Delete operation complete.'));
        }
        exit;
    }
    
    public function pjActionDownload()
    {
    	if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }

        $this->setAjax(true);

        if ($this->_get->toString('id'))
        {
            $id = basename($this->_get->toString('id'));
            
            $file = PJ_WEB_PATH . 'backup/'.$id;
            $buffer = "";
            @clearstatcache();
            if (is_file($file))
            {
                $handle = @fopen($file, "rb");
                if ($handle)
                {
                    while (!feof($handle))
                    {
                        $buffer .= fgets($handle, 4096);
                    }
                    fclose($handle);
                }
                pjToolkit::download($buffer, $id);
                exit;
            }
            self::jsonResponse(array('status' => 'ERR', 'text' => 'File not found.'));
        }
        self::jsonResponse(array('status' => 'ERR', 'text' => 'Missing or empty parameters.'));
        exit;
    }
    
    public function pjActionSetBackup()
    {
        $this->setAjax(true);
        if ($this->isXHR())
        {
            if (!self::isPost())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
            }
            if(!in_array($this->_post->toInt('set'), array(0, 1)))
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
            }
            $set = $this->_post->toInt('set') == 1 ? 'Yes' : 'No';
            pjBaseOptionModel::factory()
                ->where('foreign_id', $this->getForeignId())
                ->where('`key`', 'o_auto_backup')
                ->limit(1)
                ->modifyAll(array('value' => "Yes|No::{$set}"));

            pjBaseCronJobModel::factory()->setIsActive($this->_post->toInt('set'), 'pjBaseBackup', 'pjActionAutoBackup');
            
            self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
            exit;
        }
    }
    
    private function pjActionLoop(&$sql, $files, $is_plugin=FALSE)
    {
        foreach ($files as $filepath)
        {
            $filename = basename($filepath);
            if (preg_match('/^(\w+)\.model\.php$/', $filename, $matches))
            {
                $modelName = $matches[1] . 'Model';
                if ($is_plugin)
                {
                    if (!preg_match('/\/(\w+)\/models\/(\w+)\.model\.php$/', $filepath, $m) || !in_array($m[1], @$GLOBALS['CONFIG']['plugins']))
                    {
                        continue;
                    }
                }
                $model = new $modelName;
                
                $schema = $model->getSchema();
                if (empty($schema))
                {
                    continue;
                }
                
                $table = $model->getTable();
                if ($table == PJ_PREFIX . PJ_SCRIPT_PREFIX)
                {
                    continue;
                }
                
                $fields = array();
                $columns = array();
                $schema_index = array();
                
                foreach ($schema as $col)
                {
                    if ($col['type'] != 'blob')
                    {
                        $fields[] = sprintf("`%s`", $col['name']);
                    } else {
                        $fields[] = sprintf("LOWER(HEX(`%1\$s`)) AS `%1\$s`", $col['name']);
                    }
                    $columns[] = $col['name'];
                    $schema_index[$col['name']] = $col;
                }
                
                $result = $model->reset()->select(join(", ", $fields))->findAll()->getData();
                $sql[] = sprintf("DROP TABLE IF EXISTS `%s`;\n\n", $table);
                
                $create = $model->reset()->prepare(sprintf("SHOW CREATE TABLE `%s`", $table))->exec()->getData();
                $create = array_values($create[0]);
                $sql[] = sprintf("%s;\n\n", $create[1]);
                
                foreach ($result as $row)
                {
                    $sql[] = sprintf("INSERT INTO `%s` (`%s`) VALUES(", $table, join('`, `', $columns));
                    $insert = array();
                    foreach ($row as $key => $val)
                    {
                        if (isset($schema_index[$key], $schema_index[$key]['type']) && $schema_index[$key]['type'] == 'blob')
                        {
                            $insert[] = '0x' . $val;
                        } else {
                            if (isset($schema_index[$key], $schema_index[$key]['default'])
                                && $val == '')
                            {
                                $insert[] = strpos($schema_index[$key]['default'], ':') === 0
                                ? substr($schema_index[$key]['default'], 1)
                                : "'" . $schema_index[$key]['default'] . "'";
                            } else {
                                $val = str_replace('\n', '\r\n', $val);
                                $val = preg_replace("/\r\n/", '\r\n', $val);
                                $insert[] = "'" . str_replace("'", "''", $val) . "'";
                            }
                        }
                    }
                    $sql[] = join(", ", $insert);
                    $sql[] = ");\n";
                }
                $sql[] = "\n";
            }
        }
    }
    
    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        
        return $bytes;
    }

    /**
     * Cron-job for creating back-up files if auto-backup option is enabled.
     *
     * @return string
     */
    public function pjActionAutoBackup()
	{
		$this->setLayout('pjActionEmpty');

		if ($this->option_arr['o_auto_backup'] == 'Yes')
		{
		    $titles = __('plugin_base_error_titles', true);
    	    $bodies = __('plugin_base_error_bodies', true);

		    $backup_folder = PJ_WEB_PATH . 'backup/';
            if (!is_dir($backup_folder))
            {
                return $titles['PBU05'] . ' ' . $bodies['PBU05'];
            }
            if (!is_writable($backup_folder))
            {
                return $titles['PBU06'] . ' ' . $bodies['PBU06'];
            }

            $code = 'PBU01';
            $app_models = array();
            pjToolkit::readDir($app_models, PJ_MODELS_PATH);

            $plugin_models = array();
            pjToolkit::readDir($plugin_models, PJ_PLUGINS_PATH);

            $sql = array();
            
            $file_name = PJ_WEB_PATH . 'backup/database-backup-'.time().'.sql';
            if($this->pjActionWriteSql($app_models, $file_name) == true)
            {
                if($this->pjActionWriteSql($plugin_models, $file_name, true) == false)
                {
                    return $titles['PBU07'] . ' ' . $bodies['PBU07'];
                }
            }else{
                return $titles['PBU07'] . ' ' . $bodies['PBU07'];
            }

            $files = array();
            pjToolkit::readDir($files, PJ_UPLOAD_PATH);

            $zipName = 'files-backup-'.time().'.zip';
            $zip = new pjZipStream();
            $zip->setZipFile(PJ_WEB_PATH . 'backup/' . $zipName);

            $backup_file = true;
            foreach ($files as $file)
            {
                $handle = @fopen($file, "rb");
                if ($handle !== false)
                {
                    $buffer = "";
                    while (!feof($handle))
                    {
                        $buffer .= fgets($handle, 4096);
                    }
                    $zip->addFile($buffer, $file);
                    fclose($handle);
                }else{
                    $backup_file = false;
                    break;
                }
            }
            $zip->finalize();
            if($backup_file == false)
            {
                return $titles['PBU08'] . ' ' . $bodies['PBU08'];
            }
            return $titles[$code] . ' ' . $bodies[$code];
		}

		return "Automatic back-ups are disabled.";
	}
}
?>