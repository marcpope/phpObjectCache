# phpObjectCache
Takes a JSON data and caches it for a period of time in a file.

Example usage of another class that queries a database and caches content for 600 seconds (10 minutes)

```
class Station extends Database {
	
	public function getStations() {
		 
		$cache = new Cache;
		$stations = $cache->getCache('stations',600);
		
		if($stations == false) {
			
			$sql  		= "SELECT * FROM stations";
			$stmt 		= $this->connect()->query($sql);
			$stations   = $stmt->fetchAll();
			
			$cache = new Cache;
			$cache->setCache('stations',json_encode($stations));
			
		} else {
			 $stations = json_decode($stations, true);
		}

		return $stations;
	}
	
	
}

```

Simple PDO Database Class
```
class Database {
	
	private $host = "localhost";
	private $user = "myUser";
	private $pass = 'myPassword';
	private $db   = 'myDatabase';
	
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

```
