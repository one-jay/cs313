<?php
require "crm-db.php";
$db = get_db();

?>

<html>
    <head>

    </head>
    <body>
        <h2>Accounts:</h2>

        <form action="" method="post">
            <input type="text" name="name" >
            <input type="text" name="street" >
            <input type="text" name="city" >
            <input type="text" name="state" >
            <input type="text" name="zip" >
            <input type="submit" name="submit" value="Create New Account">
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
