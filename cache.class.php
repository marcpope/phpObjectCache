<?php

/**
* SimpleObjectPHPCache
* Takes data, serializes it and caches it using a timecondition.
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
