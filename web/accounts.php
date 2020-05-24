<?php
require "crm-db.php";
$db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Accounts:</h2>

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
                $name = $row['name'];
                $street = $row['street'];
                $city = $row['city'];
                $state = $row['state'];
                $zip = $row['zip'];

                echo "<tr> <td>$name</td> <td>$street</td> <td>$city</td> <td>$state</td> <td>$zip</td> </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
