<?php
require "crm-db.php";
$db = get_db();

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    try{
        $db = get_db();
        $query = 'INSERT INTO account (name, street, city, state, zip) 
                VALUES(:name, :street, :city, :state, :zip)';
        $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':street', $street);
            $statement->bindValue(':city', $city);
            $statement->bindValue(':state', $state);
            $statement->bindValue(':zip', $zip);
        $statement->execute();
    }catch (Exception $ex){
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

        <!-- <form action="" method="post">
            <input type="text" name="name" >
            <input type="text" name="street" >
            <input type="text" name="city" >
            <input type="text" name="state" >
            <input type="text" name="zip" >
            <input type="submit" name="submit" value="Create New Account">
        </form> -->

        <table>
            <thead>
                <form action="" method="post"></form>
                <tr>
                    <td><input type="text" name="name" ></td>
                    <td><input type="text" name="street" ></td>
                    <td><input type="text" name="city" ></td>
                    <td><input type="text" name="state" ></td>
                    <td><input type="text" name="zip" ></td>
                    <td><input type="submit" name="submit" value="Create New Account"></td>
                </tr>
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
