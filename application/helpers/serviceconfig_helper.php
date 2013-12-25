<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 if(! class_exists('ServiceConfigClass'))
 {
	class ReadAndWriteClass
	{
		public static function read($filename)
		{
			$config = include $filename;
			return $config;
		}
		public static function write($filename, array $config)
		{
			$config = var_export($config, true);
			file_put_contents($filename, "<?php return $config ;");
		}
	}

	class ServiceListClass {
		static $_filename = "service\listRunning";
		static $_listRunning;
		
		public static function read()
		{
			if(file_exists(self::$_filename)){
				self::$_listRunning = ReadAndWriteClass::read(self::$_filename);
			}else self::$_listRunning = array();
		}
		
		public static function getList()
		{
			self::read();
			return self::$_listRunning;
		}
		
		public static function add($ID, $time, $sleeptime, $status)
		{
			self::read();
			$ser = array("ID"=>$ID, "RunAt"=>$time, "Cycle"=>$sleeptime, "Status"=>$status, "StatusChangeAt"=>date('Y-m-d H:i:s'));
			
			if(isset(self::$_listRunning)){
				array_push(self::$_listRunning,$ser);
				if(count (self::$_listRunning) > 10) array_shift(self::$_listRunning);
			}
			else {
				self::$_listRunning = array();
				array_push(self::$_listRunning,$ser);
			}
			
			ReadAndWriteClass::write(self::$_filename, self::$_listRunning);
		}
		
		public static function wait($ID)
		{
			 self::changeStatus($ID, "Waiting");
		}
		
		public static function stop($ID)
		{
			 self::changeStatus($ID, "Stopped");
		}
		
		public static function sleep($ID)
		{
			 self::changeStatus($ID, "Sleeping");
		}
		
		public static function run($ID)
		{
			 self::changeStatus($ID, "Running");
		}
		
		public static function changeStatus($ID, $status)
		{
			self::read();
			
			if(isset(self::$_listRunning))
				for($i = 0; $i<count(self::$_listRunning); $i++)
					if(self::$_listRunning[$i]["ID"]==$ID)
					{
						self::$_listRunning[$i]["Status"]=$status;
						self::$_listRunning[$i]["StatusChangeAt"]=date('Y-m-d H:i:s');				
						break;						
					}
			
			ReadAndWriteClass::write(self::$_filename, self::$_listRunning);
		}
		
	}
	class ServiceConfigClass {
		static $_filename = "service\config";
		static $_filenameRunLog = "run.log";
		static $_isRunning;
		static $_isSleeping;
		static $_timeSleep;
		static $_lastUpdateConfig;
		
		public static function getLogFile()
		{
			return self::$_filenameRunLog;
		}
		
		public static function writeLogRun($content, $step=1)
		{
			//error_log(date('Y-m-d H:i:s').': '.$content."]\n", 3, self::getLogFile());
			file_put_contents (self::getLogFile(), date('Y-m-d H:i:s').': '.$content."]\n", FILE_APPEND);
		}
		
		public static function read()
		{
			if(file_exists(self::$_filename)){
				$config = ReadAndWriteClass::read(self::$_filename);
				if(isset($config)){
					self::$_isRunning = isset($config['isRunning'])? $config['isRunning'] : 'false';
					self::$_isSleeping = isset($config['isSleeping'])? $config['isSleeping'] : 'true';
					self::$_timeSleep = isset($config['timeSleep'])? $config['timeSleep'] : '600';
					self::$_lastUpdateConfig = isset($config['lastUpdateConfig'])? $config['lastUpdateConfig'] : date("Y-m-d H:i:s");
				
				}else{
					 self::$_isRunning = false;
					 self::$_isSleeping = true;
					 self::$_timeSleep = 600;
					 self::$_lastUpdateConfig = date("Y-m-d H:i:s");
					 self::save();
				 }
			}
			else
			{
				self::save();
			}
		}
		
		public static function reset()
		{
			$config['isRunning'] = false;
			$config['isSleeping'] = true;
			//$config['timeSleep'] = 600;
			$config['lastUpdateConfig'] = date("Y-m-d H:i:s");
			
			ReadAndWriteClass::write(self::$_filename,$config);
		}
		
		public static function save()
		{
			if(!isset(self::$_isRunning)) self::$_isRunning = false;
			$config['isRunning'] = self::$_isRunning;
			
			if(!isset(self::$_isSleeping)) self::$_isSleeping = true;
			$config['isSleeping'] = self::$_isSleeping;
			
			if(!isset(self::$_timeSleep)) self::$_timeSleep = 600;
			$config['timeSleep'] = self::$_timeSleep;
			
			if(!isset(self::$_lastUpdateConfig)) self::$_lastUpdateConfig = date("Y-m-d H:i:s");
			$config['lastUpdateConfig'] = self::$_lastUpdateConfig;
			
			ReadAndWriteClass::write(self::$_filename,$config);
		}
		
		 public static function isTakingAction()
		 {
			self::read();
			return self::$_isSleeping==false;
		 }
		 
		 public static function goToSleep()
		 {
			self::read();
			self::$_isSleeping = true;
			self::save();
		 }
		 
		 public static function takeAction()
		 {
			self::read();
			self::$_isSleeping = false;
			self::save();
		 }
		 
		 public static function getLastUpdateConfig()
		 {
			self::read();
			return self::$_lastUpdateConfig;
		 }
		 
		 public static function IsRunning()
		 {		 
			self::read();
			return self::$_isRunning;
		 }
		 
		 public static function wantToStop()
		 {
			self::read();
			self::$_isRunning = false; //update
			self::$_lastUpdateConfig = date("Y-m-d H:i:s"); //update
			self::save();
		 }
		 
		 public static function wantToRun()
		 {
			self::read();
			self::$_isRunning = true; //update
			self::$_lastUpdateConfig = date("Y-m-d H:i:s"); //update
			self::save();
		 }
		 
		 public static function getTimeSleep()
		 {			
			self::read();
			return self::$_timeSleep;
		 }
		 
		 public static function setTimeSleep($second)
		 {
			if(is_int($second))
			{
				self::read();
				self::$_timeSleep = $second;
				self::$_lastUpdateConfig = date("Y-m-d H:i:s"); //update
				self::save();
			}
		 }
     }
 }

