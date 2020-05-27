<?php
require "crm-db.php";
$db = get_db();

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    try
    {
        // Add the Scripture

        // We do this by preparing the query with placeholder values
        $query = 'INSERT INTO account (name, street, city, state, zip)
                VALUES(:name, :street, :city, :state, :zip)';
        $statement = $db->prepare($query);

        // Now we bind the values to the placeholders. This does some nice things
        // including sanitizing the input with regard to sql commands.
        $statement->bindValue(':name', $name);
        $statement->bindValue(':street', $street);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);
        $statement->bindValue(':zip', $zip);

        $statement->execute();

        // get the new id
        $accountId = $db->lastInsertId("account_id_seq");

        // Now go through each topic id in the list from the user's checkboxes
        // foreach ($topicIds as $topicId)
        // {
        // 	echo "account id: $accountId";

        // 	// Again, first prepare the statement
        // 	$statement = $db->prepare('INSERT INTO scripture_topic(scriptureId, topicId) VALUES(:scriptureId, :topicId)');

        // 	// Then, bind the values
        // 	$statement->bindValue(':scriptureId', $scriptureId);
        // 	$statement->bindValue(':topicId', $topicId);

        // 	$statement->execute();
        // }
    }
    catch (Exception $ex)
    {
        // Please be aware that you don't want to output the Exception message in
        // a production environment
        echo "Error with DB. Details: $ex";
        die();
    }
}
?>

<html>
    <head>

    </head>
    <body>
        <h2>Accounts:</h2>

        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="text" name="name" >
            <input type="text" name="street" >
            <input type="text" name="city" >
            <input type="text" name="state" >
            <input type="text" name="zip" >
            <input type="submit" value="Submit">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                </tr>
                
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare("SELECT * FROM account");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                // The variable "row" now holds the complete record for that
                // row, and we can access the different values based on their name
                $id = $row['id'];
                $name = $row['name'];
                $street = $row['street'];
                $city = $row['city'];
                $state = $row['state'];
                $zip = $row['zip'];

                echo "<tr>  <td> <a href=\"account.php?id=$id\"> $name </a> </td> <td>$street</td> <td>$city</td> <td>$state</td> <td>$zip</td> </tr> ";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
