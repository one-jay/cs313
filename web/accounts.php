<?php
require "crm-db.php";
$db = get_db();
if ($_POST) {
        
    if(isset($_POST['submit'])) {
        try{
            $db = get_db();
            $query = 'INSERT INTO account (name, street, city, state, zip) 
                    VALUES(:name, :street, :city, :state, :zip)';
            $statement = $db->prepare($query);
                $statement->bindValue(':name', $_POST['name']);
                $statement->bindValue(':street', $_POST['street']);
                $statement->bindValue(':city', $_POST['city']);
                $statement->bindValue(':state', $_POST['state']);
                $statement->bindValue(':zip', $_POST['zip']);
            $statement->execute();
        }catch (Exception $ex){
            echo "Error with DB. Details: $ex";
            die();
        }
    }

header("Location: " . $_SERVER['REQUEST_URI']);
exit();
}
?>

<html>
    <head>

    </head>
    <body>
    <main>
        <h2>Accounts:</h2>

        <form action="" method="post">
            <input type="text" name="name" value="Account Name">
            <input type="text" name="street" value="Street">
            <input type="text" name="city" value="City">
            <input type="text" name="state" value="State">
            <input type="text" name="zip" value="Zip">
            <input type="submit" name="submit" value="Create New Account">
        </form>

        <table id="acctsTable">
            <thead>
                <tr>
                    <th onclick="sortTable(acctsTable,0)">Account Name</th>
                    <th onclick="sortTable(acctsTable,1)">Address</th>
                    <th onclick="sortTable(acctsTable,2)">City</th>
                    <th onclick="sortTable(acctsTable,3)">State</th>
                    <th onclick="sortTable(acctsTable,4)">Zip</th>
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
        </main>
        <script>
            var acctsTable = document.getElementById("acctsTable");
        </script>
    </body>
</html>
