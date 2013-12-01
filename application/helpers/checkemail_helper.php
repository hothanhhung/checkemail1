 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if(! function_exists('postPage'))
 {
	 function postPage($url,$pvars,$referer=null,$timeout=null){
		if(!isset($timeout) || $timeout==null)
			$timeout=30;
		$curl = curl_init();
		$post = http_build_query($pvars);
		if(isset($referer) && $referer!=null){
			curl_setopt ($curl, CURLOPT_REFERER, $referer);
		}
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt ($curl, CURLOPT_HEADER, 0);
		//curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 0);//
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
		curl_setopt ($curl, CURLOPT_HTTPHEADER,
			array("Content-type: application/x-www-form-urlencoded"));
		$html = curl_exec ($curl);
		curl_close ($curl);
		return $html;
	}
}

 if(! function_exists('sendEmailToContact'))
 {
	function sendEmailToContact($from, $namefrom, $to, $sub, $cont){
		

//		echo $this->email->print_debugger();
	}
 }

 
 if(! function_exists('getRemoteIPAddress'))
 {
	function getRemoteIPAddress(){
	    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	    return $ip;
	}
 }


/* If your visitor comes from proxy server you have use another function
	to get a real IP address: */

if(! function_exists('getRealIPAddress'))
{
	function getRealIPAddress(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //check ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //to check ip is pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
}

if(! function_exists('getListEmails'))
{
	function getListEmails($file){
	    
		$allowedExts = array("txt");
		$temp = explode(".", $file["name"]);
		$extension = end($temp);
		if (in_array($extension, $allowedExts))
		{
			if ($_FILES["flEmail"]["error"] > 0)
			{
			  return null;
			}
			else
			{
			  //echo "Upload: " . $_FILES["flEmail"]["name"] . "<br>";
			  //echo "Type: " . $_FILES["flEmail"]["type"] . "<br>";
			  //echo "Size: " . ($_FILES["flEmail"]["size"] / 1024) . " kB<br>";
			  //echo "Stored in: " . $_FILES["flEmail"]["tmp_name"];

			  $stringEmail='';
			  $f=fopen($file["tmp_name"],"r") or exit("Unable to open file!");
			  while (!feof($f))
			  {
				$x=fgets($f);
				// The line above stores a character in $x.
				if(strpos($x,'@')>0)
					$stringEmail=$stringEmail.";".$x;

			  }
			  fclose($f);
			}
			$stringEmail=str_replace(array(" ","\0","\t","\n","\x0B","\r" ),";", $stringEmail);

			$arrayEmail=explode(';', $stringEmail);
			return $arrayEmail;
		}
		else
		{
			return null;
		}

		
	}
}


if(! function_exists('jValidateEmailUsingSMTP'))
{
	function jValidateEmailUsingSMTP($sToEmail)
	{
		$sFromDomain = "lampart.com.vn";
		$sFromEmail = "dienql@gmail.com";
		$bIsDebug = false;

		$sToEmail=trim($sToEmail);
		$bIsValid = true; // assume the address is valid by default..
		$aEmailParts = explode("@", $sToEmail); // extract the user/domain..
		getmxrr($aEmailParts[1], $aMatches); // get the mx records..

		if (sizeof($aMatches) == 0) {
			return false; // no mx records..
		}

		foreach ($aMatches as $oValue) {

			if ($bIsValid && !isset($sResponseCode)) {

				// open the connection..
				$oConnection = @fsockopen($oValue, 25, $errno, $errstr, 30);
				$oResponse = @fgets($oConnection);

				if (!$oConnection) {

					$aConnectionLog['Connection'] = "ERROR";
					$aConnectionLog['ConnectionResponse'] = $errstr;
					$bIsValid = false; // unable to connect..

				} else {

					$aConnectionLog['Connection'] = "SUCCESS";
					$aConnectionLog['ConnectionResponse'] = $errstr;
					$bIsValid = true; // so far so good..

				}

				if (!$bIsValid) {

					if ($bIsDebug) print_r($aConnectionLog);
					return false;

				}

				// say hello to the server..
				fputs($oConnection, "HELO $sFromDomain\r\n");
				$oResponse = fgets($oConnection);
				$aConnectionLog['HELO'] = $oResponse;

				// send the email from..
				fputs($oConnection, "MAIL FROM: <$sFromEmail>\r\n");
				$oResponse = fgets($oConnection);
				$aConnectionLog['MailFromResponse'] = $oResponse;

				// send the email to..
				fputs($oConnection, "RCPT TO: <$sToEmail>\r\n");
				$oResponse = fgets($oConnection);
				$aConnectionLog['MailToResponse'] = $oResponse;

				// get the response code..
				$sResponseCode = substr($aConnectionLog['MailToResponse'], 0, 3);
				$sBaseResponseCode = substr($sResponseCode, 0, 1);

				// say goodbye..
				fputs($oConnection,"QUIT\r\n");
				$oResponse = fgets($oConnection);

				// get the quit code and response..
				$aConnectionLog['QuitResponse'] = $oResponse;
				$aConnectionLog['QuitCode'] = substr($oResponse, 0, 3);

				if ($sBaseResponseCode == "5") {
					$bIsValid = false; // the address is not valid..
				}

				// close the connection..
				@fclose($oConnection);

			}

		}

		if ($bIsDebug) {
			print_r($aConnectionLog); // output debug info..
		}

		return $bIsValid;

	}
}
?>