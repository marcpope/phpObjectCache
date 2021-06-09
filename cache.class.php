<?php

/**
* SimpleObjectPHPCache
* Takes data, serializes it and caches it with the number of seconds specified.
* Make sure to create the cache directory in the document root (or modify to your needs)
* Requires File Permissions, fopen, fputs, fclose, filemtime, unlink in PHP to be enabled

note: if your cache names are based on user input, the cache names should be sanitized. 
I do not recommend this practice for obvious reasons.
 */

class Cache {

	public function getCache($cacheName, int $cacheTime) {
		
		$file = $_SERVER["DOCUMENT_ROOT"] . '/cache/' . $cacheName . '.cache';
		
		if (@filemtime($file) < (time() - $cacheTime)) {
			return false;
		} else {
			$result = file_get_contents($file);
			return unserialize($result);
		}
		
	}
	
	public function setCache($cacheName, $data) {
		
		$file = $_SERVER["DOCUMENT_ROOT"] . '/cache/' . $cacheName . '.cache';
		$fp = fopen($file,"w");
		fputs($fp,serialize($data));
		fclose($fp);
		
		return true;
	}


	public function deleteCache($cacheName) {
		
		$file = $_SERVER["DOCUMENT_ROOT"] . '/cache/' . $cacheName . '.cache';
		unlink($file);
		return true;
	}
	
	
}

?>	
