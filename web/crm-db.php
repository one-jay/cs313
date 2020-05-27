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

// if(isset($_POST['submit'])) {

//     print_r ($_POST);

//     $db = get_db();

//     try
//     {
//         // Add the Scripture

//         // We do this by preparing the query with placeholder values
//         $query = 'UPDATE account SET ';
//             // foreach($_POST as $col=>$val){
//             //     $query .= $col. '=' .$val. ',';
//             // }
//             $query .= 'name = ' .$_POST['account_name'];
//         //book, chapter, verse, content
//             // $query .= ') VALUES(';
//             // foreach($_POST as $col=>$val){
//             //     $query .= ':'.$col.',';
//             // }
//         //  :book, :chapter, :verse, :content
//             $query .= ' WHERE id = ' .$_GET['id'];
//         echo $query;
//         $statement = $db->prepare($query);

//         // Now we bind the values to the placeholders. This does some nice things
//         // including sanitizing the input with regard to sql commands.
//         foreach($_POST as $col=>$val){
//             $statement->bindValue($col, $val);
//         }
//         // $statement->bindValue(':book', $book);
//         // $statement->bindValue(':chapter', $chapter);
//         // $statement->bindValue(':verse', $verse);
//         // $statement->bindValue(':content', $content);

//         echo $statement;
//         //$statement->execute();

//         // get the new id
//         //$scriptureId = $db->lastInsertId("scripture_id_seq");
//     }
//     catch (Exception $ex)
//     {
//         // Please be aware that you don't want to output the Exception message in
//         // a production environment
//         echo "Error with DB. Details: $ex";
//         die();
//     }
//}

?>

<!doctype html>
<html>
    <head>
    <link rel="stylesheet" href="crm.css">
        <style>
            
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