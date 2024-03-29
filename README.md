# phpObjectCache Class
A super-lightweight php disk-based cache class with 3 methods:

**getCache('cacheName',X)**
Returns any cache that is X seconds (integer) old or newer. If older, it's returned as false

**setCache('cacheName', $data)**
Stores an object into cache, by your choice of name. Accepts name, and data variable. Data is stored serialized .

**deleteCache('cacheName')**
Deletes cache data by name. Accepts only name parameter.

**Information**
The Cache Class stores data in the webroot/cache/ fodler. Make sure to create a /cache/ folder and chmod +x the folder so that it is writeable by the php user executing the script.

# Example #
In this example, we query a Radio Station DB and return the results in an assoc array. You will include the cache.class.php or use an autoloader. The Database class shows how we connect to the database which is used in the Station class.  

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
			$cache->setCache('stations',$stations);
			
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
