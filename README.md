# phpObjectCache Class
Accepts JSON data and caches it for a period of time in a file.

The Cache Class stores data in the webroot/cache/ fodler. Make sure to create a /cache/ folder and chmod +x the folder so that it is writeable by the php user. 


In this example, This class below will first check if cache exists with a 10 minute limit. If not cached, it will query a database (connection handled by a database.class) and then write new cache from the mysql results.

```
include 'cache.class.php';

class Database {
	
	private $host = "localhost";
	private $user = "INSERTUSERNAMEHERE";
	private $pass = 'INSERTPASSWORDHERE';
	private $db   = 'INSERTDATABASEHERE';
	
	public function connect() {
		try {
			$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8mb4';
			$pdo = new PDO($dsn, $this->user, $this->pass);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $pdo;	
		}
		catch (PDOException $e) {
			echo "Connection failed: ".$e->getMessage();
		}
		
	}
}


class Station extends Database {
	public function getStations() {
	
		//check cache object called 'stations' with 10 minute limit
		$cache = new Cache;
		$stations = $cache->getCache('stations',600);
		
		// if stations is false, then the cache not exists or is expired
		if($stations == false) {
			$sql  	  = "SELECT * FROM stations";
			$stmt 	  = $this->connect()->query($sql);
			$stations = $stmt->fetchAll();
	
			// write the cache as a json object
			$cache = new Cache;
			$cache->setCache('stations',json_encode($stations));
			
		} else {
			// decode the json back into an assoc array
			 $stations = json_decode($stations, true);
		}
		return $stations;
	}	
}

// call the station class with getStations method to get cache and query database

$stations = new Station();
	$stations = $stations->getStations();
	
	foreach($stations as $station) {
	   echo $station['location'] . '<br />';
	}


```
