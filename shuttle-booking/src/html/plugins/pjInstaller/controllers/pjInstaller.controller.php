<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjInstaller extends pjInstallerAppController
{
	public $defaultInstaller = 'Installer';

	public $defaultErrors = 'Errors';

	public $defaultCaptcha = 'Captcha';

	public function beforeFilter()
	{
	    $cssPath = $this->getConstant('pjBase', 'PLUGIN_CSS_PATH');

        $dm = $this->getDependencyManager();

        $this->appendCss('css/bootstrap.min.css', $dm->getPath('bootstrap'), false, false);
        $this->appendCss('css/font-awesome.min.css', $dm->getPath('font_awesome'), false, false);
        $this->appendCss('jquery.steps.css', $dm->getPath('steps'), false, false);
        $this->appendCss('style.css', $cssPath);
        $this->appendCss('custom.css', $cssPath);
        $this->appendCss('animate.css', $cssPath);

        $this->appendJs('jquery.min.js', $dm->getPath('jquery'), false, false);
        $this->appendJs('js/bootstrap.min.js', $dm->getPath('bootstrap'), false, false);
        $this->appendJs('jquery.validate.min.js', $dm->getPath('validate'), false, false);
        $this->appendJs('spin.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('ladda.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('ladda.jquery.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('jquery.steps.min.js', $dm->getPath('steps'), false, false);
        
        return true;
	}

	private static function pjActionImportSQL($dbo, $file, $prefix, $scriptPrefix=NULL)
	{
		if (!is_object($dbo))
		{
			return array('status' => 'ERR', 'text' => 'DBO object has not been initialized yet');
		}
		ob_start();
		readfile($file);
		$string = ob_get_contents();
		ob_end_clean();
		if ($string !== false)
		{
		    $string = preg_replace_callback(
				'/(INSERT\s+INTO|INSERT\s+IGNORE\s+INTO|DROP\s+TABLE|DROP\s+TABLE\s+IF\s+EXISTS|DROP\s+VIEW|DROP\s+VIEW\s+IF\s+EXISTS|CREATE\s+TABLE|CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS|UPDATE|UPDATE\s+IGNORE|FROM|ALTER\s+TABLE|ALTER\s+IGNORE\s+TABLE|DELETE\s+(?:(?:LOW_PRIORITY\s+)?(?:QUICK\s+)?(?:IGNORE\s+)?){2}?FROM)\s+`\b(.*)\b`/U',
					function ($match) use ($prefix, $scriptPrefix) {
						$tableName = $match[2];
						if(in_array($tableName, array('fields', 'multi_lang', 'locale', 'locale_languages')))
                        {
                            $tableName = 'plugin_base_' . $tableName;
                        }
						return $match[1] . " `" . $prefix . $scriptPrefix . $tableName . "`";
					},
					$string);

			# Get locales
			$statement = sprintf("SHOW TABLES LIKE '%s%splugin_base_locale';", $prefix, $scriptPrefix);
			$query = $dbo->query($statement);
			if ($query->num_rows > 0) {			
				$statement = sprintf("SELECT `id` FROM `%s%splugin_base_locale` WHERE 1 ORDER BY `id`", $prefix, $scriptPrefix);
				if (FALSE !== $dbo->query($statement))
				{
					$dbo->fetchAssoc();
					$locales = $dbo->getData();
				}
			}

			if (!isset($locales) || empty($locales))
			{
				# Define default locales
				$locales = array(
					array('id' => 1),
				);
			}

			$arr = preg_split('/;(\s+)?\n/', $string);

			$tmp = array();
			$needle = '::LOCALE::';
			# Search/replace language token
			foreach ($arr as $statement)
			{
			    if (strpos($statement, 'pjField') !== FALSE)
				{
                    $statement = str_replace('pjField', 'pjBaseField', $statement);
				}

				if (strpos($statement, $needle) !== FALSE)
				{
					foreach ($locales as $locale)
					{
						$tmp[] = str_replace($needle, $locale['id'], $statement);
					}
				} else {
					$tmp[] = $statement;
				}
			}

			$arr = $tmp;

			$dbo->query("START TRANSACTION;");
			foreach ($arr as $statement)
			{
				$statement = trim($statement);
				if (!empty($statement))
				{
					if (!$dbo->query($statement))
					{
						$error = $dbo->error();
						$dbo->query("ROLLBACK");
						return array('status' => 'ERR', 'text' => $error . $file . $statement);
					}
				}
			}
			$dbo->query("COMMIT;");

			$name = basename($file);
			$text = sprintf("File '%s' have been executed.", $name);
			return array('status' => 'OK', 'text' => $text);
		}
		return array('status' => 'ERR', 'text' => 'File not found (can not be open/read)');
	}

	private static function isSecure()
	{
		$isSecure = false;
		if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		{
			$isSecure = true;
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			$isSecure = true;
		}

		return $isSecure;
	}

	private static function pjActionGetPaths()
	{
		$absolutepath = str_replace("\\", "/", dirname(realpath(basename(getenv("SCRIPT_NAME")))));
		$localpath = str_replace("\\", "/", dirname(getenv("SCRIPT_NAME")));

		$localpath = str_replace("\\", "/", $localpath);
		$localpath = preg_replace('/^\//', '', $localpath, 1) . '/';
		$localpath = !in_array($localpath, array('/', '\\')) ? $localpath : NULL;

		$protocol = self::isSecure() ? 'https' : 'http';

		return array(
			'install_folder' => '/' . $localpath,
			'install_path' => $absolutepath . '/',
			'install_url' => $protocol . '://' . $_SERVER['SERVER_NAME'] . '/' . $localpath
		);
	}

	public function pjActionIndex()
	{
		pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep0&install=1");
	}

	private static function pjActionCheckConfig($redirect=true)
	{
		$filename = 'app/config/config.inc.php';
		$content = @file_get_contents($filename);
		if (strpos($content, 'PJ_HOST') === false && strpos($content, 'PJ_INSTALL_URL') === false)
		{
			//Continue with installation
			return true;
		} else {
			if ($redirect)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep0&install=1");
			}
			return false;
		}
	}

	private function pjActionCheckSession()
	{
		if (!isset($_SESSION[$this->defaultInstaller]))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}
	}

	private function pjActionCheckTables(&$dbo)
	{
		if (!is_object($dbo))
		{
			return FALSE;
		}
		ob_start();
		readfile('app/config/database.sql');
		$string = ob_get_contents();
		ob_end_clean();

		preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
		if (count($match[0]) > 0)
		{
			$arr = array();
			foreach ($match[2] as $k => $table)
			{
				$result = $dbo->query(sprintf("SHOW TABLES FROM `%s` LIKE '%s'",
					$_SESSION[$this->defaultInstaller]['database'],
					$_SESSION[$this->defaultInstaller]['prefix'] . $table
				));
				if ($result !== FALSE && $dbo->numRows() > 0)
				{
					$row = $dbo->fetchAssoc()->getData();
					$row = array_values($row);
					$arr[] = $row[0];
				}
			}
			return count($arr) === 0;
		}
		return TRUE;
	}

	private function pjActionCheckVars()
	{
	    $this->_get->reassign_post_get();
	    $this->_post->reassign_post_get();

		if (!isset($_GET['install']))
		{
			return array('status' => 'ERR', 'code' => 100, 'text' => 'Missing \'install\' parameter in the URL address.');
		}

		if (!isset($_SESSION[$this->defaultInstaller]))
		{
			return array('status' => 'ERR', 'code' => 101, 'text' => 'Session not found, please start over.');
		}

		$indexes = array(
			'hostname' => 'MySQL Hostname',
			'username' => 'MySQL Username',
			'password' => 'MySQL Password',
			'database' => 'MySQL Database',
			'prefix' => 'MySQL Table prefix',
			'admin_email' => 'Administrator Login: E-Mail',
			'admin_password' => 'Administrator Login: Password',
			'install_folder' => 'Folder Name',
			'install_path' => 'Server Path',
			'install_url' => 'Full URL'
		);

		foreach ($indexes as $index => $label)
		{
			if (!isset($_SESSION[$this->defaultInstaller][$index]))
			{
				return array('status' => 'ERR', 'code' => 102, 'text' => sprintf("'%s' is not set, please go back to fix it.", $label));
			}
		}

		if (!isset($_SESSION[$this->defaultInstaller]['private_key']))
		{
			return array('status' => 'ERR', 'code' => 103, 'text' => "'Private Key' is not valid, please go back to fix it.");
		}

		return array('status' => 'OK', 'code' => 200, 'text' => 'Success');
	}

	private function pjActionCheckTableLength()
	{
		ob_start();
		readfile('app/config/database.sql');
		$string = ob_get_contents();
		ob_end_clean();

		preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
		if (count($match[0]) > 0)
		{
			$arr = array();
			foreach ($match[2] as $k => $table)
			{
				$table_name = $_SESSION[$this->defaultInstaller]['prefix'] . $table;

				if(strlen($table_name) > 64)
				{
					return $table_name;
				}
			}
		}
		require 'app/config/options.inc.php';

		if (isset($CONFIG['plugins']))
		{
			if (!is_array($CONFIG['plugins']))
			{
				$CONFIG['plugins'] = array($CONFIG['plugins']);
			}
			foreach ($CONFIG['plugins'] as $plugin)
			{
				$file = PJ_PLUGINS_PATH . $plugin . '/config/database.sql';
				if (is_file($file))
				{
					ob_start();
					readfile($file);
					$string = ob_get_contents();
					ob_end_clean();

					preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
					if (count($match[0]) > 0)
					{
						$arr = array();
						foreach ($match[2] as $k => $table)
						{
							$table_name = $_SESSION[$this->defaultInstaller]['prefix'] . PJ_SCRIPT_PREFIX . $table;
							if(strlen($table_name) > 64)
							{
								return $table_name;
							}
						}
					}

					$update_folder = PJ_PLUGINS_PATH . $plugin . '/config/updates';
					if (is_dir($update_folder))
					{
						$files = array();
						pjToolkit::readDir($files, $update_folder);
						foreach ($files as $path)
						{
							if (preg_match('/\.sql$/', basename($path)) && is_file($path))
							{
								ob_start();
								readfile($path);
								$string = ob_get_contents();
								ob_end_clean();

								preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
								if (count($match[0]) > 0)
								{
									$arr = array();
									foreach ($match[2] as $k => $table)
									{
										$table_name = $_SESSION[$this->defaultInstaller]['prefix'] . PJ_SCRIPT_PREFIX . $table;
										if(strlen($table_name) > 64)
										{
											return $table_name;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return '';
	}

	public function pjActionStep0()
	{
		if (self::pjActionCheckConfig(false))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}

		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep1()
	{
	    @set_time_limit(600); //10 minutes

		self::pjActionCheckConfig();

		if (!isset($_SESSION[$this->defaultInstaller]))
		{
			$_SESSION[$this->defaultInstaller] = array();
		}
		if (!isset($_SESSION[$this->defaultErrors]))
		{
			$_SESSION[$this->defaultErrors] = array();
		}

		# PHP Session check -------------------
		if (!headers_sent())
		{
			@session_start();
			$_SESSION['PJ_SESSION_CHECK'] = 1;
			@session_write_close();

			$_SESSION = array();
			@session_start();

			$session_check = isset($_SESSION['PJ_SESSION_CHECK']);
			$this->set('session_check', $session_check);
			if ($session_check)
			{
				$_SESSION['PJ_SESSION_CHECK'] = NULL;
				unset($_SESSION['PJ_SESSION_CHECK']);
			}
		}

		ob_start();
		phpinfo(INFO_MODULES);
		$content = ob_get_contents();
		ob_end_clean();

		# MySQL version -------------------
		if (!PJ_DISABLE_MYSQL_CHECK)
		{
			$drivers = array('mysql', 'mysqli');
			$mysql_version = NULL;
			foreach ($drivers as $driver)
			{
				$mysql_content = explode('name="module_'.$driver.'"', $content);
				if (count($mysql_content) > 1)
				{
					$mysql_content = explode("Client API", $mysql_content[1]);
					if (count($mysql_content) > 1)
					{
						preg_match('/<td class="v">(.*)<\/td>/', $mysql_content[1], $m);
						if (count($m) > 0)
						{
							$mysql_version = trim($m[1]);

							if (preg_match('/(\d+\.\d+\.\d+)/', $mysql_version, $m))
							{
								$mysql_version = $m[1];
							}
						}
					}
				}

				$mysql_check = true;
				if (is_null($mysql_version) || version_compare($mysql_version, '5.0.0', '<'))
				{
					$mysql_check = false;
				}
			}
			$this->set('mysql_check', $mysql_check);
		}

		# PHP version -------------------
		$php_check = true;
		if (version_compare(phpversion(), '5.4.0', '<'))
		{
			$php_check = false;
		}
		$this->set('php_check', $php_check);

		# File permissions
		$filename = 'app/config/config.inc.php';
		$err_arr = array();
		if (!is_writable($filename))
		{
		    $err_arr[] = sprintf('%1$s \'<span class="bold">%2$s</span>\' is not writable. %3$s \'<span class="bold">%2$s</span>\'', 'File', $filename, 'You need to set write permissions (chmod 777) to options file located at');
		}

		# Folder permissions
		$folders = array();
		foreach ($folders as $dir)
		{
			if (!is_writable($dir))
			{
				$err_arr[] = sprintf('%1$s \'<span class="bold">%2$s</span>\' is not writable. %3$s \'<span class="bold">%2$s</span>\'', 'Folder', $dir, 'You need to set write permissions (chmod 777) to directory located at');
			}
		}

        # Script (file/folder) permissions
		$result = pjAppController::init()->pjActionCheckInstall();
		if ($result !== NULL && isset($result['status'], $result['info']) && $result['status'] == 'ERR')
		{
			$err_arr = array_merge($err_arr, $result['info']);
		}

		$dependencies_check = TRUE;
		$dependencies_arr = array();
		
		if (method_exists('pjDependencyManager', 'setBaseDir'))
		{
			$pjDependencyManager = new pjDependencyManager(NULL, PJ_THIRD_PARTY_PATH);
		} else {
			$pjDependencyManager = new pjDependencyManager(PJ_THIRD_PARTY_PATH);
		}

		$result_map = $pjDependencyManager
			->load(PJ_CONFIG_PATH . 'dependencies.php')
			->resolve()
			->getResult();

		if (in_array(FALSE, $result_map))
		{
			$dependencies_check = FALSE;
			$dependencies = $pjDependencyManager->getDependencies();
			foreach ($result_map as $key => $value)
			{
				if (!$value)
				{
					$dependencies_arr[] = sprintf('Unresolved dependency check. <span class="bold">Script</span> require <span class="bold">%s %s</span>', $key, $dependencies[$key]);
				}
			}
		}

		# Check for certain functions
		$fn_arr = array();
		if (!function_exists('file_get_contents'))
		{
			$fn_arr[] = 'The function <span class="bold">file_get_contents</span> was not found.';
		}
		
		$requirements_filename = PJ_CONFIG_PATH . 'requirements.inc.php';
		if (is_file($requirements_filename))
		{
			$requirements = include $requirements_filename;
			if (is_array($requirements))
			{
				foreach ($requirements as $requirement_type => $requirement_elements)
				{
					foreach ($requirement_elements as $el_name => $el_warning)
					{
						switch ($requirement_type)
						{
							case 'function':
								if (!function_exists($el_name))
								{
									$fn_arr[] = $el_warning;
								}
								break;
							case 'extension':
								if (!extension_loaded($el_name))
								{
									$fn_arr[] = $el_warning;
								}
								break;
							case 'class':
								if (!class_exists($el_name))
								{
									$fn_arr[] = $el_warning;
								}
								break;
						}
					}
				}
			}
		}
		
		$fn_check = !$fn_arr;
		$this->set('fn_check', $fn_check);
		$this->set('fn_arr', $fn_arr);
		
		# Plugin (file/folder) permissions
		$filename = 'app/config/options.inc.php';
		$options = @file_get_contents($filename);
		if ($options !== FALSE)
		{
			preg_match('/\$CONFIG\s*\[\s*[\'\"]plugins[\'\"]\s*\](.*);/sxU', $options, $match);
			if (!empty($match))
			{
				eval($match[0]);

				if (isset($CONFIG['plugins']))
				{
					if (!is_array($CONFIG['plugins']))
					{
						$CONFIG['plugins'] = array($CONFIG['plugins']);
					}
					foreach ($CONFIG['plugins'] as $plugin)
					{
					    if(!in_array($plugin, array('pjBase', 'pjAuth')))
                        {
                            $result = $plugin::init()->pjActionCheckInstall();
                            if ($result !== NULL && isset($result['status'], $result['info']) && $result['status'] == 'ERR')
                            {
                                $err_arr = array_merge($err_arr, $result['info']);
                            }
                        }

						$result_map = $pjDependencyManager
							->reset()
							->load(PJ_PLUGINS_PATH . $plugin . '/config/dependencies.php')
							->resolve()
							->getResult();

						if (in_array(FALSE, $result_map))
						{
							$dependencies_check = FALSE;
							$dependencies = $pjDependencyManager->getDependencies();
							foreach ($result_map as $key => $value)
							{
								if (!$value)
								{
									$dependencies_arr[] = sprintf('Unresolved dependency check. <span class="bold">%s</span> require <span class="bold">%s %s</span>', $plugin, $key, $dependencies[$key]);
								}
							}
						}
					}
				}
			}
		}

		$this->set('folder_check', count($err_arr) === 0);
		$this->set('folder_arr', $err_arr);

		$this->set('dependencies_check', $dependencies_check);
		$this->set('dependencies_arr', $dependencies_arr);

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep2()
	{
		self::pjActionCheckConfig();

		$this->pjActionCheckSession();

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();
		
		if (isset($_POST['step1']))
		{
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
		}

		if (!isset($_SESSION[$this->defaultInstaller]['step1']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}
		
		$key = sha1(uniqid());		
		$private_key = hash_hmac('sha256', pjUtil::getRandomPassword(36), $key);
		$pj_installation = hash_hmac('sha256', pjUtil::getRandomPassword(36), $key);
		$_SESSION[$this->defaultInstaller]['private_key'] = strtoupper($private_key);
		$_SESSION[$this->defaultInstaller]['pj_installation'] = strtoupper($pj_installation);

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep3()
	{
		self::pjActionCheckConfig();

		$this->pjActionCheckSession();

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		if (isset($_POST['step2']))
		{
			$_POST = array_map('trim', $_POST);
			$_POST = pjSanitize::clean($_POST, array('encode' => false));
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);

			$err = NULL;

			if (!isset($_POST['hostname']) || !isset($_POST['username']) || !isset($_POST['database']) ||
				!pjValidation::pjActionNotEmpty($_POST['hostname']) ||
				!pjValidation::pjActionNotEmpty($_POST['username']) ||
				!pjValidation::pjActionNotEmpty($_POST['database']))
			{
				$err = "Hostname, Username and Database are required and can't be empty.";
			} else {

				$params = array(
					'hostname' => $_POST['hostname'],
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'database' => $_POST['database']
				);
				if (strpos($params['hostname'], ":") !== FALSE)
				{
					list($hostname, $value) = explode(":", $params['hostname'], 2);
					if (preg_match('/\D/', $value))
					{
						$params['socket'] = $value;
					} else {
						$params['port'] = $value;
					}
					$params['hostname'] = $hostname;
				}
				$dbo = pjSingleton::getInstance(self::getDbDriver(), $params);
				if (!$dbo->init())
				{
					$err = $dbo->connectError();
					if (empty($err))
					{
						$err = $dbo->error();
					}
				} else {
					$table_name = $this->pjActionCheckTableLength();
					if ($table_name != '')
					{
						$err = "Invalid table name! '".$table_name . "' cannot be longer than 64 characters.";
					}else{
						if (!$this->pjActionCheckTables($dbo))
						{
							$this->set('warning', 1);
						}

						$tempTable = 'phpjabbers_temp_install';

						$dbo->query("DROP TABLE IF EXISTS `$tempTable`;");

						if (!$dbo->query("CREATE TABLE IF NOT EXISTS `$tempTable` (`created` datetime DEFAULT NULL);"))
						{
							$err .= "CREATE command denied to current user<br />";
						} else {
							if (!$dbo->query("INSERT INTO `$tempTable` (`created`) VALUES (NOW());"))
							{
								$err .= "INSERT command denied to current user<br />";
							}
							if (!$dbo->query("SELECT * FROM `$tempTable` WHERE 1=1;"))
							{
								$err .= "SELECT command denied to current user<br />";
							}
							if (!$dbo->query("UPDATE `$tempTable` SET `created` = NOW();"))
							{
								$err .= "UPDATE command denied to current user<br />";
							}
							if (!$dbo->query("DELETE FROM `$tempTable` WHERE 1=1;"))
							{
								$err .= "DELETE command denied to current user<br />";
							}
						}
						if (!$dbo->query("DROP TABLE IF EXISTS `$tempTable`;"))
						{
							$err .= "DROP command denied to current user<br />";
						}
					}
				}
			}
			if (!is_null($err))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = $err;
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep2&install=1&err=" . $time);
			}
			
			$_SESSION[$this->defaultInstaller]['use_iv'] = self::isInitVectorRequired($dbo);

			$this->set('paths', self::pjActionGetPaths());

			$this->set('status', 'ok');
		}

		if (!isset($_SESSION[$this->defaultInstaller]['step2']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep2&install=1");
		}

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep4()
	{
		self::pjActionCheckConfig();

		$this->pjActionCheckSession();

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		if (isset($_POST['step3']))
		{
			$_POST = array_map('trim', $_POST);

			if (!isset($_POST['install_folder']) || !isset($_POST['install_url']) || !isset($_POST['install_path']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_folder']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_url']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_path']))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = "Folder Name, Full URL and Server Path are required and can't be empty.";
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep3&install=1&err=" . $time);
			} else {
				$_POST = pjSanitize::clean($_POST, array('encode' => false));
				$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
			}
		}

		if (!isset($_SESSION[$this->defaultInstaller]['step3']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep3&install=1");
		}

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep5()
	{
		self::pjActionCheckConfig();

		$this->pjActionCheckSession();

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		if (isset($_POST['step4']))
		{
			$_POST = array_map('trim', $_POST);

			if (!isset($_POST['admin_email']) || !isset($_POST['admin_password']) ||
				!pjValidation::pjActionNotEmpty($_POST['admin_email']) ||
				!pjValidation::pjActionEmail($_POST['admin_email']) ||
				!pjValidation::pjActionNotEmpty($_POST['admin_password']))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = "E-Mail and Password are required and can't be empty.";
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep4&install=1&err=" . $time);
			} else {
				$_POST = pjSanitize::clean($_POST, array('encode' => false));
				$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
			}
		}

		if (!isset($_SESSION[$this->defaultInstaller]['step4']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep4&install=1");
		}

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep6()
	{
		$this->pjActionCheckSession();

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		if (isset($_POST['step5']))
		{
			$_POST = pjSanitize::clean($_POST, array('encode' => false));
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
		}

		if (!isset($_SESSION[$this->defaultInstaller]['step5']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep5&install=1");
		}

		unset($_SESSION[$this->defaultInstaller]);
		unset($_SESSION[$this->defaultErrors]);

		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
        $this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionSetDb()
	{
		$this->setAjax(true);

		if ($this->isXHR())
		{
			$vars = self::pjActionCheckVars();
			if ($vars['status'] === 'ERR')
			{
				pjAppController::jsonResponse($vars);
			}
			@set_time_limit(600); //10 minutes

			$resp = array();

			$params = array(
				'hostname' => $_SESSION[$this->defaultInstaller]['hostname'],
				'username' => $_SESSION[$this->defaultInstaller]['username'],
				'password' => $_SESSION[$this->defaultInstaller]['password'],
				'database' => $_SESSION[$this->defaultInstaller]['database']
			);
			if (strpos($params['hostname'], ":") !== FALSE)
			{
				list($hostname, $value) = explode(":", $params['hostname'], 2);
				if (preg_match('/\D/', $value))
				{
					$params['socket'] = $value;
				} else {
					$params['port'] = $value;
				}
				$params['hostname'] = $hostname;
			}
			$dbo = pjSingleton::getInstance(self::getDbDriver(), $params);
			if (!$dbo->init())
			{
				$err = $dbo->connectError();
				if (!empty($err))
				{
					$resp['code'] = 100;
				    $resp['text'] = 'Could not connect: ' . $err;
				    self::pjActionDbError($resp);
				} else {
					$resp['code'] = 101;
				    $resp['text'] = $dbo->error();
				    self::pjActionDbError($resp);
				}
			} else {
				require 'app/config/config.inc.php';
				$pjOptionModel = pjBaseOptionModel::factory()->setPrefix($_SESSION[$this->defaultInstaller]['prefix']);
				require 'app/config/options.inc.php';

			    // NB. Executing pjBase and pjAuth's database.sql files is required before running script installation as we need pjBaseField, pjBaseMultiLang, pjBaseOption, pjAuthUser models to run the other code.
                $result = self::pjActionImportSQL($dbo, PJ_PLUGINS_PATH . 'pjBase/config/database.sql', $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
                if ($result['status'] == "ERR")
                {
                    self::pjActionDbError($result);
                }

				// Executing pjBase updates
				if (!empty($CONFIG['plugins_base_auth_updates']) && (bool) $CONFIG['plugins_base_auth_updates'] === true) {
					$result = $this->pjActionInstallPlugin($pjOptionModel, $dbo, 'pjBase', $_SESSION[$this->defaultInstaller]['prefix'], FALSE);
					if ($result['status'] === 'ERR') {
						self::pjActionDbError($result);
					}
				}

                $result = self::pjActionImportSQL($dbo, PJ_PLUGINS_PATH . 'pjAuth/config/database.sql', $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
                if ($result['status'] == "ERR")
                {
                    self::pjActionDbError($result);
                }

				// Executing pjAuth updates
                if (!empty($CONFIG['plugins_base_auth_updates']) && (bool) $CONFIG['plugins_base_auth_updates'] === true) {
					$result = $this->pjActionInstallPlugin($pjOptionModel, $dbo, 'pjAuth', $_SESSION[$this->defaultInstaller]['prefix'], FALSE);
					if ($result['status'] === 'ERR') {
						self::pjActionDbError($result);
					}
				}

				$idb = self::pjActionImportSQL($dbo, 'app/config/database.sql', $_SESSION[$this->defaultInstaller]['prefix']);
				if ($idb['status'] == 'OK')
				{
					$_GET['install'] = 2;
					require 'app/config/options.inc.php';

					$result = pjAppController::init()->pjActionBeforeInstall();
					if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
					{
						$resp['text'] = join("<br>", $result['info']);
						$resp['code'] = 104;
						self::pjActionDbError($resp);
					}

					$statement = sprintf("INSERT IGNORE INTO `%s`(`foreign_id`,`key`,`tab_id`,`value`,`type`) VALUES (:foreign_id, :key, :tab_id, NOW(), :type);", $pjOptionModel->getTable());
					$data = array(
						'foreign_id' => $this->getForeignId(),
						'tab_id' => 99,
						'type' => 'string'
					);

					if (isset($CONFIG['plugins']))
					{
						if (!is_array($CONFIG['plugins']))
						{
							$CONFIG['plugins'] = array($CONFIG['plugins']);
						}
						foreach ($CONFIG['plugins'] as $plugin)
						{
							// Skip pjBase and pjAuth updates execute
							if (!empty($CONFIG['plugins_base_auth_updates']) && (bool) $CONFIG['plugins_base_auth_updates'] === true) {
								if (in_array($plugin, array('pjAuth', 'pjBase'))) {
									continue;
								}
							}

							$result = $this->pjActionInstallPlugin($pjOptionModel, $dbo, $plugin, $_SESSION[$this->defaultInstaller]['prefix'], FALSE);
							if ($result['status'] === 'ERR')
							{
								self::pjActionDbError($result);
							}
						}
					}

					$updates = self::pjActionGetUpdates();
					foreach ($updates as $record)
					{
						$file_path = $record['path'];
						$response = self::pjActionExecuteSQL($dbo, $file_path, $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
						if ($response['status'] == "ERR")
						{
							self::pjActionDbError($response);
						} else if ($response['status'] == "OK") {
							$data['key'] = sprintf('o_%s_%s', basename($file_path), md5($file_path));
							$pjOptionModel->prepare($statement)->exec($data);
						}
					}

					if (defined("PJ_TEMPLATE_PATH"))
					{
						$updates = self::pjActionGetUpdates(PJ_TEMPLATE_PATH);
						foreach ($updates as $record)
						{
							$file_path = $record['path'];
							$response = self::pjActionExecuteSQL($dbo, $file_path, $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
							if ($response['status'] == "ERR")
							{
								self::pjActionDbError($response);
							} else if ($response['status'] == "OK") {
								$data['key'] = sprintf('o_%s_%s', basename($file_path), md5($file_path));
								$pjOptionModel->prepare($statement)->exec($data);
							}
						}
					}

					if (isset($CONFIG['locales']) && !empty($CONFIG['locales']))
					{
						if (!is_array($CONFIG['locales']))
						{
							$CONFIG['locales'] = array($CONFIG['locales']);
						}

						$languages = pjLocaleLanguageModel::factory()
							->setPrefix($_SESSION[$this->defaultInstaller]['prefix'])
							->whereIn('t1.iso', array_map('strtolower', $CONFIG['locales']))
							->findAll()
							->getDataPair('iso');

						foreach ($CONFIG['locales'] as $locale)
						{
							if (!isset($languages[$locale]) || $locale == 'gb')
							{
								continue;
							}

							pjLocale::init(array('iso' => $locale))->pjActionAddLocale();
						}
					}

					$result = pjAppController::init()->pjActionAfterInstall();
					if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
					{
						$resp['text'] = join("<br>", $result['info']);
						$resp['code'] = 105;
						self::pjActionDbError($resp);
					}

					pjAuthUserModel::factory()
						->setPrefix($_SESSION[$this->defaultInstaller]['prefix'])
						->setAttributes(array(
							'email' => $_SESSION[$this->defaultInstaller]['admin_email'],
							'password' => $_SESSION[$this->defaultInstaller]['admin_password'],
							'role_id' => 1,
							'name' => "Administrator",
							'ip' => $_SERVER['REMOTE_ADDR']
						))
						->insert();

					pjBaseOptionModel::factory()
						->setPrefix($_SESSION[$this->defaultInstaller]['prefix'])
						->setAttributes(array(
							'foreign_id' => $this->getForeignId(),
							'key' => 'private_key',
							'tab_id' => 99,
							'value' => $_SESSION[$this->defaultInstaller]['private_key'],
							'type' => 'string'
						))
						->insert();

					if (!isset($resp['code']))
					{
						$resp['code'] = 200;
						$resp['text'] = 'Success';
					}
				} else {
					$resp['code'] = 103; //MySQL error
					$resp['text'] = $idb['text'];
					self::pjActionDbError($resp);
				}
			}

			if (isset($resp['code']) && $resp['code'] != 200)
			{
				self::pjActionDbError($resp);
			}
			pjAppController::jsonResponse($resp);
		}
		exit;
	}

	private static function pjActionDbError($resp)
	{
		@file_put_contents('app/config/config.inc.php', '');
		pjAppController::jsonResponse($resp);
	}

	public function pjActionSetConfig()
	{
		$this->setAjax(true);

		if ($this->isXHR())
		{
			if (!self::pjActionCheckConfig(false))
			{
				$result = array('code' => 107, 'text' => 'Product is already installed. If you need to re-install it empty app/config/config.inc.php file.');
				pjAppController::jsonResponse($result);
			}
			$sample = 'app/config/config.sample.php';
			$filename = 'app/config/config.inc.php';
			ob_start();
			readfile($sample);
			$string = ob_get_contents();
			ob_end_clean();
			if ($string === FALSE)
			{
				$result = array('status' => 'ERR', 'code' => 100, 'text' => "An error occurs while reading 'app/config/config.sample.php'");
				pjAppController::jsonResponse($result);
			}
			if (!self::pjActionCheckVars())
			{
				$result = array('status' => 'ERR', 'code' => 108, 'text' => 'Missing, empty or invalid parameters.');
				pjAppController::jsonResponse($result);
			}
			if (!is_writable($filename))
			{
				$result = array('status' => 'ERR', 'code' => 101, 'text' => "'app/config/config.inc.php' do not exists or not writable");
				pjAppController::jsonResponse($result);
			}
			if (!$handle = @fopen($filename, 'wb'))
			{
				$result = array('status' => 'ERR', 'code' => 103, 'text' => "'app/config/config.inc.php' open fails");
				pjAppController::jsonResponse($result);
			}

			$string = self::pjActionReplaceConfigTokens($string, $_SESSION[$this->defaultInstaller]);

			if (fwrite($handle, $string) === FALSE)
			{
				$result = array('status' => 'ERR', 'code' => 102, 'text' => "An error occurs while writing to 'app/config/config.inc.php'");
				pjAppController::jsonResponse($result);
			}

			fclose($handle);
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Success'));
		}
		exit;
	}

	public function pjActionVersion()
	{
		if ($this->isLoged() && $this->isAdmin())
		{
			printf('PJ_SCRIPT_ID: %s<br>', PJ_SCRIPT_ID);
			printf('PJ_SCRIPT_BUILD: %s<br><br>', PJ_SCRIPT_BUILD);

			$plugins = pjRegistry::getInstance()->get('plugins');
			foreach ($plugins as $plugin => $whtvr)
			{
				printf("%s: %s<br>", $plugin, pjObject::getConstant($plugin, 'PLUGIN_BUILD'));
			}
			if (method_exists('pjObject', 'getFrameworkBuild'))
			{
				printf("<br>Framework: %s<br>", pjObject::getFrameworkBuild());
			}
		}
		exit;
	}

	public function pjActionHash()
	{
		@set_time_limit(0);

		if (!function_exists('md5_file'))
		{
			die("Function <b>md5_file</b> doesn't exists");
		}

		require 'app/config/config.inc.php';

		# Origin hash -------------
		if (!is_file(PJ_CONFIG_PATH . 'files.check'))
		{
			die("File <b>files.check</b> is missing");
		}
		$json = @file_get_contents(PJ_CONFIG_PATH . 'files.check');
		$Services_JSON = new pjServices_JSON();
		$data = $Services_JSON->decode($json);
		if (is_null($data))
		{
			die("File <b>files.check</b> is empty or broken");
		}
		$origin = get_object_vars($data);

		# Current hash ------------
		$data = array();
		pjUtil::readDir($data, PJ_INSTALL_PATH);
		$current = array();
		foreach ($data as $file)
		{
			$current[str_replace(PJ_INSTALL_PATH, '', $file)] = md5_file($file);
		}

		$html = '<style type="text/css">
		table{border: solid 1px #000; border-collapse: collapse; font-family: Verdana, Arial, sans-serif; font-size: 14px}
		td{border: solid 1px #000; padding: 3px 5px; background-color: #fff; color: #000}
		.diff{background-color: #0066FF; color: #fff}
		.miss{background-color: #CC0000; color: #fff}
		</style>
		<table cellpadding="0" cellspacing="0">
		<tr><td><strong>Filename</strong></td><td><strong>Status</strong></td></tr>
		';
		foreach ($origin as $file => $hash)
		{
			if (isset($current[$file]))
			{
				if ($current[$file] == $hash)
				{

				} else {
					$html .= '<tr><td>'. $file . '</td><td class="diff">changed</td></tr>';
				}
			} else {
				$html .= '<tr><td>'. $file . '</td><td class="miss">missing</td></tr>';
			}
		}
		$html .= '<table>';
		echo $html;
		exit;
	}

	private static function pjActionSortUpdates($haystack)
	{
		$_time = array();
		$_name = array();
		# Set some timezone just to prevent E_NOTICE/E_WARNING message
		date_default_timezone_set('America/Chicago');
		foreach ($haystack as $key => $item)
		{
			if (preg_match('/(20\d\d)_(0[1-9]|1[012])_(0[1-9]|[12][0-9]|3[01])_([01][0-9]|[2][0-3])_([0-5][0-9])_([0-5][0-9]).sql$/', $item['name'], $m))
			{
				$_time[$key] = mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1]);
				$_name[$key] = $item['name'];
			}
		}

		if (!empty($haystack))
		{
			array_multisort($_time, SORT_ASC, SORT_NUMERIC, $_name, SORT_ASC, SORT_STRING, $haystack);
		}

		return $haystack;
	}

	private static function pjActionGetUpdates($update_folder='app/config/updates', $override_data=array())
	{
		if (!is_dir($update_folder))
		{
			return array();
		}

		$files = array();
		pjToolkit::readDir($files, $update_folder);

		$data = array();
		foreach ($files as $path)
		{
			$name = basename($path);
			if (preg_match('/(20\d\d)_(0[1-9]|1[012])_(0[1-9]|[12][0-9]|3[01])_([01][0-9]|[2][0-3])_([0-5][0-9])_([0-5][0-9]).sql$/', $name))
			{
				$data[] = array_merge(array(
					'name' => $name,
					'path' => $path
				), $override_data);
			}
		}

		return self::pjActionSortUpdates($data);
	}

	private static function pjActionExecuteSQL($dbo, $file_path, $prefix=PJ_PREFIX, $scriptPrefix=PJ_SCRIPT_PREFIX)
	{
		$name = basename($file_path);
		$pdb = self::pjActionImportSQL($dbo, $file_path, $prefix, $scriptPrefix);
		if ($pdb['status'] === 'ERR') {
			return array('status' => 'ERR', 'code' => 103, 'text' => $pdb['text']);
		} else {
			$text = sprintf("File '%s' have been executed.", $name);
			return array('status' => 'OK', 'code' => 200, 'text' => $text);	
		}
	}

	public function pjActionSecureSetUpdate()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			# Next will init dbo
			pjAppModel::factory();

			$dbo = NULL;
			$registry = pjRegistry::getInstance();
			if ($registry->is('dbo'))
			{
				$dbo = $registry->get('dbo');
			}

			if (!isset($_REQUEST['module']))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Module parameter is missing.'));
			}

			$this->_get->reassign_post_get();
			$this->_post->reassign_post_get();

			if (isset($_POST['path']) && !empty($_POST['path']))
			{
                switch ($_REQUEST['module'])
                {
                    case 'template':
                            $pattern = defined('PJ_TEMPLATE_PATH') ? sprintf('|^%s(.*)/updates|', PJ_TEMPLATE_PATH) : '|^templates/(.*)/updates|';
                        break;
                    case 'plugin':
                        $pattern = '|^'.str_replace('\\', '/', PJ_PLUGINS_PATH).'|';
                        break;
                    case 'script':
                    default:
                        $pattern = '|^app/config/updates|';
                        break;
                }

				if (preg_match($pattern, str_replace('\\', '/', $_POST['path'])))
				{
					$response = self::pjActionExecuteSQL($dbo, $_POST['path']);
					if ($response['status'] == "OK")
					{
						$key = sprintf('o_%s_%s', basename($_POST['path']), md5($_POST['path']));
						$pjOptionModel = pjBaseOptionModel::factory()
							->where('t1.foreign_id', $this->getForeignId())
							->where('t1.key', $key);
						if (0 != $pjOptionModel->findCount()->getData())
						{
							$pjOptionModel
								->reset()
								->where('foreign_id', $this->getForeignId())
								->where('`key`', $key)
								->modifyAll(array('value' => ':NOW()'));
						} else {
							$pjOptionModel
								->reset()
								->setAttributes(array(
									'foreign_id' => $this->getForeignId(),
									'key' => $key,
									'tab_id' => 99,
									'value' => ':NOW()',
									'type' => 'string'
								))
								->insert();
						}
					}
					pjAppController::jsonResponse($response);
				} else {
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Filename pattern doesn\'t match.'));
				}
			}

			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				$pjOptionModel = pjBaseOptionModel::factory();
				foreach ($_POST['record'] as $k => $record)
				{
					switch ($_REQUEST['module'][$k])
					{
						case 'template':
							$pattern = defined('PJ_TEMPLATE_PATH') ? sprintf('|^%s(.*)/updates|', PJ_TEMPLATE_PATH) : '|^templates/(.*)/updates|';
							break;
						case 'plugin':
							$pattern = '|^'.str_replace('\\', '/', PJ_PLUGINS_PATH).'|';
							break;
						case 'script':
						default:
							$pattern = '|^app/config/updates|';
							break;
					}

					if (!preg_match($pattern, str_replace('\\', '/', $record)))
					{
						continue;
					}
					$response = self::pjActionExecuteSQL($dbo, $record);
					if ($response['status'] == 'ERR')
					{
						pjAppController::jsonResponse($response);
					} elseif ($response['status'] == 'OK') {
						$key = sprintf('o_%s_%s', basename($record), md5($record));
						$pjOptionModel
							->reset()
							->where('t1.foreign_id', $this->getForeignId())
							->where('t1.key', $key);
						if (0 != $pjOptionModel->findCount()->getData())
						{
							$pjOptionModel
								->reset()
								->where('foreign_id', $this->getForeignId())
								->where('`key`', $key)
								->modifyAll(array('value' => ':NOW()'));
						} else {
							$pjOptionModel
								->reset()
								->setAttributes(array(
									'foreign_id' => $this->getForeignId(),
									'key' => $key,
									'tab_id' => 99,
									'value' => ':NOW()',
									'type' => 'string'
								))
								->insert();
						}
					}
				}

				pjAppController::jsonResponse($response);
			}
		}
		exit;
	}

	public function pjActionSecureGetUpdate()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			# Build data
			$data = self::pjActionBuildUpdates();

			# Sort data
			$data = self::pjActionSortUpdates($data);

			$keys = array();

			foreach ($data as &$item)
			{
				$item['base'] = base64_encode($item['path']);
				$keys[] = sprintf('o_%s_%s', $item['name'], md5($item['path']));
			}

			if (!empty($keys))
			{
				$options = pjBaseOptionModel::factory()
					->select('t1.key, t1.value')
					->where('t1.foreign_id', $this->getForeignId())
					->whereIn('t1.key', $keys)
					->findAll()
					->getDataPair('key', 'value');

				# Set some timezone just to prevent E_NOTICE/E_WARNING message
				date_default_timezone_set('America/Chicago');
				foreach ($data as &$item)
				{
					$index = sprintf('o_%s_%s', $item['name'], md5($item['path']));
					if (isset($options[$index]) && !empty($options[$index]))
					{
						$item['date'] = date("d/m/Y, H:i a", strtotime($options[$index]));
						$item['is_new'] = 0;
					} else {
						$item['date'] = "new DB update";
						$item['is_new'] = 1;
					}
				}
			}

			$total = count($data);
			$rowCount = $total;
			$pages = 1;
			$page = 1;
			$offset = 0;

			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}

	public function pjActionSecureUpdate()
	{
		if ($this->isLoged() && $this->isAdmin())
		{
	    	$this->appendJs('jquery-ui.min.js', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
			$this->appendCss('jquery-ui.min.css', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
			$this->appendCss('pj-table.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');

			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjInstallerUpdate.js', $this->getConst('PLUGIN_JS_PATH'));
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', "");
		} else {
			$this->set('status', 2);
		}

		$this->appendCss('secure.css', $this->getConst('PLUGIN_CSS_PATH'));
	}

	public function pjActionSecureView()
	{
		if (!($this->isLoged() && $this->isAdmin()))
		{
			exit('Not logged or hasn\'t permissions to view.');
		}

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		if (!(isset($_GET['p']) && !empty($_GET['p'])))
		{
			exit('Missing, empty or invalid URL parameters.');
		}
		$path = base64_decode($_GET['p']);
		if ($path === FALSE)
		{
			exit('Data could not be decoded.');
		}
		if (!preg_match('/\.sql$/', $path))
		{
			exit('An .sql extension could not be found.');
		}
		$data = self::pjActionBuildUpdates();
		$in_array = FALSE;
		foreach ($data as $item)
		{
			if ($item['path'] == $path)
			{
				$in_array = TRUE;
				break;
			}
		}
		if (!$in_array)
		{
			exit('File not found in allowed list.');
		}
		if (!is_file($path))
		{
			exit('File not exists.');
		}

		$handle = fopen($path, 'rb');
		header("Content-Type: text/plain; charset=utf-8");
		while (!feof($handle))
		{
			$buffer = fread($handle, 4096);
			echo $buffer;
			ob_flush();
			flush();
		}
		fclose($handle);
		exit;
	}

	private static function pjActionBuildUpdates()
	{
		# Script
		$data1 = self::pjActionGetUpdates('app/config/updates', array('module' => 'script', 'label' => 'script'));

		# Plugins
		$data2 = array();
		if (isset($GLOBALS['CONFIG']['plugins']))
		{
			if (!is_array($GLOBALS['CONFIG']['plugins']))
			{
				$GLOBALS['CONFIG']['plugins'] = array($GLOBALS['CONFIG']['plugins']);
			}
			foreach ($GLOBALS['CONFIG']['plugins'] as $plugin)
			{
				$data2 = array_merge($data2, self::pjActionGetUpdates(PJ_PLUGINS_PATH . $plugin . '/config/updates', array('module' => 'plugin', 'label' => 'plugin '.$plugin)));
			}
		}

		# Templates
		$data3 = array();
		if (defined('PJ_TEMPLATE_PATH'))
		{
			$data3 = self::pjActionGetUpdates(PJ_TEMPLATE_PATH, array('module' => 'template'));
			foreach ($data3 as &$item)
			{
				$item['label'] = basename(dirname(dirname($item['path'])));
			}
		}

		return array_merge($data1, $data2, $data3);
	}

	public function pjActionCheckCaptcha()
	{
		$this->setAjax(true);

		if ($this->isXHR())
		{
		    $this->_get->reassign_post_get();
		    $this->_post->reassign_post_get();

			echo isset($_SESSION[$this->defaultCaptcha], $_GET['captcha'])
				&& pjCaptcha::validate($_GET['captcha'], $_SESSION[$this->defaultCaptcha]) ? 'true' : 'false';
		}
		exit;
	}

	public function pjActionCaptcha()
	{
		$this->setAjax(true);
		$this->setLayout('pjActionEmpty');

		header("Cache-Control: max-age=3600, private");

		require 'app/config/config.inc.php';
		
		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		$pjCaptcha = new pjCaptcha(PJ_INSTALL_PATH . $this->getConst('PLUGIN_FONTS_PATH') . 'Anorexia.ttf', $this->defaultCaptcha, 6);
		$pjCaptcha
			->setImage(PJ_INSTALL_PATH . $this->getConst('PLUGIN_IMG_PATH') . 'button.png')
			->init(@$_GET['rand']);
		exit;
	}

	public function pjActionChange()
	{
		if (self::pjActionCheckConfig(FALSE))
		{
			$this->set('status', 1);
			return;
		}

		require 'app/config/config.inc.php';

		$sessionVar = 'ChangeLogin';

		$this->_get->reassign_post_get();
		$this->_post->reassign_post_get();

		# Login processing
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['do_login']))
		{
			$time = time();

			# Form validation
			if (!(isset($_POST['email'], $_POST['captcha'], $_SESSION[$this->defaultCaptcha])
				&& !empty($_POST['email'])
				&& !empty($_POST['captcha'])
				&& pjValidation::pjActionEmail($_POST['email'])
				&& pjCaptcha::validate($_POST['captcha'], $_SESSION[$this->defaultCaptcha])
			))
			{
				$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => 'Missing, empty or invalid form data.');
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
			}

			$_SESSION[$sessionVar] = array(
				'email' => $_POST['email'],
				'login_string' => sha1($_POST['email'] . PJ_SALT)
			);

			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange");
		}

		$isLoged = isset($_SESSION[$sessionVar], $_SESSION[$sessionVar]['email'], $_SESSION[$sessionVar]['login_string'])
			&& sha1($_SESSION[$sessionVar]['email'] . PJ_SALT) == $_SESSION[$sessionVar]['login_string'];

		if (!$isLoged)
		{
			$this->set('status', 3);
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$time = time();

			# Form validation
			$required = array('do_change', 'change_domain', 'change_db', 'change_paths', 'new_domain', 'hostname', 'username', 'password', 'database');
			foreach ($required as $index)
			{
				if (!isset($_POST[$index]))
				{
					$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => 'Missing form parameters.');
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
					break;
				}
			}

			$string = @file_get_contents('app/config/config.sample.php');
			$STORE = array();
			$isThereSmthngToChange = FALSE;
			$isNewInstall = FALSE;
			
			if ($_POST['change_db'] == 1 && !empty($_POST['hostname']) && !empty($_POST['username']) && !empty($_POST['database']))
			{
				$isThereSmthngToChange = TRUE;

				$STORE['hostname'] = $_POST['hostname'];
				$STORE['username'] = $_POST['username'];
				$STORE['password'] = $_POST['password'];
				$STORE['database'] = $_POST['database'];
			} else {
				$STORE['hostname'] = PJ_HOST;
				$STORE['username'] = PJ_USER;
				$STORE['password'] = PJ_PASS;
				$STORE['database'] = PJ_DB;
			}

			if ($_POST['change_paths'] == 1)
			{
				$isThereSmthngToChange = TRUE;

				# Get paths
				$paths = self::pjActionGetPaths();

				$STORE['install_folder'] = $paths['install_folder'];
				$STORE['install_path'] = $paths['install_path'];
				$STORE['install_url'] = $paths['install_url'];
			} else {
				$STORE['install_folder'] = PJ_INSTALL_FOLDER;
				$STORE['install_path'] = PJ_INSTALL_PATH;
				$STORE['install_url'] = PJ_INSTALL_URL;
			}

			if ($isThereSmthngToChange && $string !== FALSE)
			{
				$params = $STORE;
				if (strpos($params['hostname'], ":") !== FALSE)
				{
					list($hostname, $value) = explode(":", $params['hostname'], 2);
					if (preg_match('/\D/', $value))
					{
						$params['socket'] = $value;
					} else {
						$params['port'] = $value;
					}
					$params['hostname'] = $hostname;
				}
				$dbo = pjSingleton::getInstance(self::getDbDriver(), $params);
				if ($dbo->init())
				{
					$STORE['use_iv'] = self::isInitVectorRequired($dbo);
				}
				
				$STORE['salt'] = PJ_SALT;
				$STORE['prefix'] = PJ_PREFIX;

				$string = self::pjActionReplaceConfigTokens($string, $STORE, FALSE);

				$filename = 'app/config/config.inc.php';
				if (is_writable($filename))
				{
					if (!$handle = @fopen($filename, 'wb'))
					{
						$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => "'app/config/config.inc.php' open fails");
						pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
					} else {
						if (fwrite($handle, $string) === FALSE)
						{
							$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => "An error occurs while writing to 'app/config/config.inc.php'");
							pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
						} else {
							fclose($handle);

							$_SESSION[$this->defaultErrors][$time] = array('status' => 'OK', 'text' => "Installation has been changed successfully.");
							pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
						}
					}
				} else {
					$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => "'app/config/config.inc.php' do not exists or not writable");
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
				}
			}

			$_SESSION[$this->defaultErrors][$time] = array('status' => 'ERR', 'text' => 'There is nothing to change.');
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionChange&err=" . $time);
		}

		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$paths = self::pjActionGetPaths();

			$areTheSamePaths = ($paths['install_folder'] == PJ_INSTALL_FOLDER
				&& $paths['install_url'] == PJ_INSTALL_URL
				&& $paths['install_path'] == PJ_INSTALL_PATH);

			$this->set('areTheSamePaths', $areTheSamePaths);

			$this->set('domain', pjUtil::getDomain(PJ_INSTALL_URL));

			if (!$areTheSamePaths)
			{
				$this->set('paths', $paths);
			} else {
				$this->set('status', 2);
			}

			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
		}
	}

	private static function pjActionReplaceConfigTokens($string, $data, $random_salt=TRUE)
	{
		if (isset($data['hostname']))
		{
			$string = str_replace('[hostname]', $data['hostname'], $string);
		}
		if (isset($data['username']))
		{
			$string = str_replace('[username]', $data['username'], $string);
		}
		if (isset($data['password']))
		{
			$string = str_replace('[password]', str_replace(
					array('\\', '$', '"'),
					array('\\\\', '\$', '\"'),
					$data['password']
			), $string);
		}
		if (isset($data['database']))
		{
			$string = str_replace('[database]', $data['database'], $string);
		}
		if (isset($data['prefix']))
		{
			$string = str_replace('[prefix]', $data['prefix'], $string);
		}
		if (isset($data['use_iv']))
		{
			$string = str_replace('[use_iv]', $data['use_iv'], $string);
		}
		if (isset($data['install_folder']))
		{
			$string = str_replace('[install_folder]', $data['install_folder'], $string);
		}
		if (isset($data['install_path']))
		{
			$string = str_replace('[install_path]', $data['install_path'], $string);
		}
		if (isset($data['install_url']))
		{
			$string = str_replace('[install_url]', $data['install_url'], $string);
		}
		if ($random_salt)
		{
			$string = str_replace('[salt]', pjUtil::getRandomPassword(8), $string);
		} else {
			if (isset($data['salt']))
			{
				$string = str_replace('[salt]', $data['salt'], $string);
			}
		}

		if (isset($data['pj_installation']))
		{
			$string = str_replace('[pj_installation]', $data['pj_installation'], $string);
		}

		return $string;
	}

	public function pjActionSecurePlugins()
	{
		if ($this->isLoged() && $this->isAdmin())
		{
			$this->appendJs('jquery-ui.min.js', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
			$this->appendCss('jquery-ui.min.css', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
			$this->appendCss('pj-table.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');

			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjInstallerPlugins.js', $this->getConst('PLUGIN_JS_PATH'));
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', "");
		} else {
			$this->set('status', 2);
		}

		$this->appendCss('secure.css', $this->getConst('PLUGIN_CSS_PATH'));
	}

	public function pjActionSecureGetPlugins()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			$data = array();

			$plugins = $GLOBALS['CONFIG']['plugins'];
			if (!is_array($plugins))
			{
				$plugins = array($plugins);
			}

			$name = array();
			foreach ($plugins as $plugin)
			{
				$data[] = array(
					'name' => $plugin
				);

				$name[] = $plugin;
			}

			array_multisort($name, SORT_STRING, $data);

			$keys = array();

			foreach ($data as &$item)
			{
				$keys[] = sprintf('o_plugin_%s', $item['name']);
			}

			if (!empty($keys))
			{
				$options = pjBaseOptionModel::factory()
					->select('t1.key, t1.value')
					->where('t1.foreign_id', $this->getForeignId())
					->whereIn('t1.key', $keys)
					->findAll()
					->getDataPair('key', 'value');

				# Set some timezone just to prevent E_NOTICE/E_WARNING message
				date_default_timezone_set('America/Chicago');
				foreach ($data as &$item)
				{
					$index = sprintf('o_plugin_%s', $item['name']);
					if (isset($options[$index]) && !empty($options[$index]))
					{
						$item['date'] = date("d/m/Y, H:i a", strtotime($options[$index]));
						$item['is_new'] = 0;
					} else {
						$item['date'] = "new plugin";
						$item['is_new'] = 1;
					}
				}
			}

			$total = count($data);
			$rowCount = $total;
			$pages = 1;
			$page = 1;
			$offset = 0;

			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}

	public function pjActionSecureInstallPlugin()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
		    $this->_get->reassign_post_get();
		    $this->_post->reassign_post_get();

			# Next will init dbo
			pjAppModel::factory();

			$dbo = NULL;
			$registry = pjRegistry::getInstance();
			if ($registry->is('dbo'))
			{
				$dbo = $registry->get('dbo');
			}

			$pjOptionModel = pjBaseOptionModel::factory();

			$result = $this->pjActionInstallPlugin($pjOptionModel, $dbo, basename($_POST['name']), PJ_PREFIX);

			pjAppController::jsonResponse($result);
		}
		exit;
	}

	private function pjActionInstallPlugin($pjOptionModel, $dbo, $plugin, $prefix, $dependencyCheck=TRUE)
	{
		# Dependency check
		if ($dependencyCheck)
		{
			if (method_exists('pjDependencyManager', 'setBaseDir'))
			{
				$pjDependencyManager = new pjDependencyManager(NULL, PJ_THIRD_PARTY_PATH);
			} else {
				$pjDependencyManager = new pjDependencyManager(PJ_THIRD_PARTY_PATH);
			}

			$result = $pjDependencyManager
				->load(PJ_PLUGINS_PATH . $plugin . '/config/dependencies.php')
				->resolve()
				->getResult();

			if (in_array(FALSE, $result))
			{
				$text = 'Unresolved dependency check.';
				$dependencies = $pjDependencyManager->getDependencies();
				foreach ($result as $library => $value)
				{
					if (!$value)
					{
						$text .= sprintf('<br><span class="bold">%s</span> require <span class="bold">%s %s</span>', $plugin, $library, $dependencies[$library]);
					}
				}
				return array('status' => 'ERR', 'code' => 100, 'text' => $text);
			}
		}

		# Proceed to install
		$pjOptionModel->setPrefix($prefix);
		$statement = sprintf("INSERT IGNORE INTO `%s`(`foreign_id`,`key`,`tab_id`,`value`,`type`) VALUES (:foreign_id, :key, :tab_id, NOW(), :type);", $pjOptionModel->getTable());
		$data = array(
			'foreign_id' => $this->getForeignId(),
			'tab_id' => 99,
			'type' => 'string'
		);

		$file = PJ_PLUGINS_PATH . $plugin . '/config/database.sql';
		if (is_file($file))
		{
		    // SQL queries from database.sql files from these plugins files were already executed in the beginning so just ignore them and install only their updates.
		    if(!in_array($plugin, array('pjBase', 'pjAuth')))
            {
                $response = self::pjActionExecuteSQL($dbo, $file, $prefix, PJ_SCRIPT_PREFIX);
                if ($response['status'] == "ERR")
                {
                    return $response;
                }
            }

			$updates = self::pjActionGetUpdates(PJ_PLUGINS_PATH . $plugin . '/config/updates');
			foreach ($updates as $record)
			{
				$path = $record['path'];
				$response = self::pjActionExecuteSQL($dbo, $path, $prefix, PJ_SCRIPT_PREFIX);
				if ($response['status'] == "ERR")
				{
					return $response;
				} else if ($response['status'] == "OK") {
					$data['key'] = sprintf('o_%s_%s', basename($path), md5($path));
					$pjOptionModel->prepare($statement)->exec($data);
				}
			}
		}
		$modelName = pjObject::getConstant($plugin, 'PLUGIN_MODEL');
		if ($modelName != '' && class_exists($modelName) && method_exists($modelName, 'pjActionSetup'))
		{
			$pluginModel = new $modelName;
			$pluginModel->begin();
			$pluginModel->pjActionSetup();
			$pluginModel->commit();
		}

		$result = $plugin::init()->pjActionBeforeInstall();
		if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
		{
			return array('status' => 'ERR', 'code' => 104, 'text' => join("<br>", $result['info']));
		}

		$data['key'] = sprintf('o_plugin_%s', $plugin);
		$pjOptionModel->prepare($statement)->exec($data);

		return array('status' => 'OK', 'code' => 200, 'text' => 'Plugin has been installed');
	}

	private static function pjActionJsonDecode($value)
	{
		if (function_exists('json_decode'))
		{
			return json_decode($value, TRUE);
		}

		if (class_exists('pjServices_JSON') && method_exists('pjServices_JSON', 'decode'))
		{
			$pjServices_JSON = new pjServices_JSON(SERVICES_JSON_LOOSE_TYPE|SERVICES_JSON_SUPPRESS_ERRORS);

			return $pjServices_JSON->decode($value);
		}

		return NULL;
	}

	private static function pjActionBuildQuery($query_data)
	{
		if (version_compare(PHP_VERSION, '5.1.2', '>='))
		{
			return http_build_query($query_data, '', '&');
		}

		return http_build_query($query_data);
	}

	protected static function getBlockEncryptionMode($dbo)
	{
		if (FALSE !== $dbo->query("SHOW VARIABLES LIKE 'block_encryption_mode'"))
		{
			$dbo->fetchAssoc();
			$data = $dbo->getData();
			
			if (isset($data[0]['Value']))
			{
				return $data[0]['Value'];
			}
		}
		
		return NULL;
	}
	
	protected static function isInitVectorRequired($dbo)
	{
		# aes-128-ebc
		# aes-192-cbc
		# aes-256-cbc
		$block_encryption_mode = self::getBlockEncryptionMode($dbo);
		
		if (empty($block_encryption_mode))
		{
			return 0;
		}
		
		list(, $keylen, $mode) = explode('-', $block_encryption_mode);
		
		if ($mode == 'ecb')
		{
			return 0;
		}
		
		return 1;
	}
	
	protected static function getDbDriver()
	{
		return function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';
	}
}
?>