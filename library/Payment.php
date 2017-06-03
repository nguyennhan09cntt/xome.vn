<?php
class Payment
{
	const SECURE_HASH_CORRECT = 0;
	const SECURE_HASH_INVALID = 1;
	const SECURE_SECRET_EMPTY = -1;
	private $secureSecret;
	private $virtualPaymentClientURL;
	private $isValidSecureHash;
	private $isEmptySecureSecret;
	
	public function setSecureSecret($secureSecret) {
		$this->secureSecret = $secureSecret;
	}
	
	public function setVirtualPaymentUrl($url) {
		$this->virtualPaymentClientURL = $url;
	}
	
	public function getParameter($name) {
		$data = isset($_GET[$name]) ? $_GET[$name] : (isset($HTTP_GET_VARS[$name]) ? $HTTP_GET_VARS[$name] : null);
	    if ($data == null || $data == "") {
	        return "No Value Returned";
	    } else {
	        return $data;
	    }
	}
	
	public function redirect($parameters) {
		$vpcURL = $this->virtualPaymentClientURL . "?";
		$md5HashData = $this->secureSecret;
		
		ksort($parameters);
		
		// set a parameter to show the first pair in the URL
		$appendAmp = 0;
		
		foreach($parameters as $key => $value) {
		
		    // create the md5 input and URL leaving out any fields that have no value
		    if (strlen($value) > 0) {
		        
		        // this ensures the first paramter of the URL is preceded by the '?' char
		        if ($appendAmp == 0) {
		            $vpcURL .= urlencode($key) . '=' . urlencode($value);
		            $appendAmp = 1;
		        } else {
		            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
		        }
		        $md5HashData .= $value;
		    }
		}
		
		// Create the secure hash and append it to the Virtual Payment Client Data if
		// the merchant secret has been provided.
		if (strlen($this->secureSecret) > 0) {
		    $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
		}
		header("Location: ".$vpcURL);
	}
	
	public function checkSum($parameters) {
		$vpc_Txn_Secure_Hash = $this->getParameter("vpc_SecureHash");
		
		if (strlen($this->secureSecret) > 0) {
		    $md5HashData = $this->secureSecret;
		    // sort all the incoming vpc response fields and leave out any with no value
		    ksort($parameters);
		    foreach($parameters as $key => $value) {
		        if ($key != "vpc_SecureHash" and strlen($value) > 0) {
		            $md5HashData .= urldecode ($value);
		        }
		    }
		    
		    // Validate the Secure Hash (remember MD5 hashes are not case sensitive)
			// This is just one way of displaying the result of checking the hash.
			// In production, you would work out your own way of presenting the result.
			// The hash check is all about detecting if the data has changed in transit.
		    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData))) {
		        // Secure Hash validation succeeded, add a data field to be displayed later.
		        $this->isValidSecureHash = true;
		    } else {
		        // Secure Hash validation failed, add a data field to be displayed later.
		        $this->isValidSecureHash = false;
		    }
		} else {
		    // Secure Hash was not validated, add a data field to be displayed later.
		    $this->isEmptySecureSecret = true;
		}
	}
	
	public function isEmptySecureSecret() {
		return $this->isEmptySecureSecret;
	}
	
	public function isValidSecureHash() {
		return $this->isValidSecureHash;
	}
	
	function getResponseDescription($responseCode) {
	    switch ($responseCode) {
	        case "0" : $result = "Giao dich thanh cong"; break;
	        case "1" : $result = "Ngan hang tu choi thanh toan: the/tai khoan bi khoa"; break;
	        case "2" : $result = "Loi so 2"; break;
	        case "3" : $result = "The het han"; break;
	        case "4" : $result = "Qua so lan giao dich cho phep. (Sai OTP, qua han muc trong ngay)"; break;
	        case "5" : $result = "Khong co tra loi tu Ngan hang"; break;
	        case "6" : $result = "Loi giao tiep voi Ngan hang"; break;
	        case "7" : $result = "Tai khoan khong du tien"; break;
	        case "8" : $result = "Loi du lieu truyen"; break;
	        case "9" : $result = "Kieu giao dich khong duoc ho tro"; break;
	        default  : $result = "Loi khong xac dinh"; 
	    }
	    return $result;
	}
}
?>