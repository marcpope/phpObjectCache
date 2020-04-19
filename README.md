# phpObjectCache
Takes a JSON data and caches it for a period of time in a file.

Example usage of another class that queries a database and caches content for 600 seconds (10 minutes)

```
class Station extends Database {
	public function getStations() {
		$cache = new Cache;
		$stations = $cache->getCache('stations',600);
		
		if($stations == false) {
			$sql  	  = "SELECT * FROM stations";
			$stmt 	  = $this->connect()->query($sql);
			$stations = $stmt->fetchAll();
	
			$cache = new Cache;
			$cache->setCache('stations',json_encode($stations));
			
		} else {
			 $stations = json_decode($stations, true);
		}
		return $stations;
	}	
}

```
