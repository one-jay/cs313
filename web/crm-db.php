<?php
/**********************************************************
* connect using either local
* OR Heroku credentials, depending on whether the code
* is executing at heroku.
***********************************************************/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function get_db() {
	$db = NULL;

	try {
		// default Heroku Postgres configuration URL
		$dbUrl = getenv('DATABASE_URL');

		if (!isset($dbUrl) || empty($dbUrl)) {
			// example localhost configuration URL with user: "ta_user", password: "ta_pass"
			// and a database called "scripture_ta"
			$dbUrl = "postgres://ta_user:ta_pass@localhost:5432/scripture_ta";

			// NOTE: It is not great to put this sensitive information right
			// here in a file that gets committed to version control. It's not
			// as bad as putting your Heroku user and password here, but still
			// not ideal.
			
			// It would be better to put your local connection information
			// into an environment variable on your local computer. That way
			// it would work consistently regardless of whether the application
			// were running locally or at heroku.
		}

		// Get the various parts of the DB Connection from the URL
		$dbopts = parse_url($dbUrl);

		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');

		// Create the PDO connection
		$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

		// this line makes PDO give us an exception when there are problems, and can be very helpful in debugging!
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch (PDOException $ex) {
		// If this were in production, you would not want to echo
		// the details of the exception.
		echo "Error connecting to DB. Details: $ex";
		die();
	}

	return $db;
}

function debugQuery(){
    $db = get_db();
    $sql = 'SELECT account.id as acctId, account.name, opportunity.id, stage 
            FROM opportunity
            JOIN account ON opportunity.account = account.id';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $allTables = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $allTables;
}

?>

<!doctype html>
<html>
    <head>
    <link rel="stylesheet" href="crm.css">

        <style>
            
            body{
                margin: 0;
            }
            ul {
                display: flex;
                
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
                
                top: 0;
                width: 100%;
            }


            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            /* Change the link color to #111 (black) on hover */
            li a:hover {
                background-color: #111;
            }
            .active {
                background-color: #4CAF50;
            }
        </style>
    </head>
    <body>
        <?php
            //print_r (debugQuery());
        ?>

        <ul>
            <li><a href="accounts.php">
                Accounts</a>
            </li>
            <li><a href="contacts.php">
                Contacts</a>
            </li>
            <li><a href="opportunities.php">
                Opportunties</a>
            </li>
            <li><a href="quotes.php">
                Quotes</a>
            </li>
            <li><a href="products.php">
                Products</a>
            </li>
        </ul>
    </body>
</html>