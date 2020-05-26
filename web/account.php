<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
?>

<html>
    <head>

    </head>
    <body>
        <h1>Account: <?=$id?> </h1>

        <h2>Account Details</h2>
        <table>
        <?php
            $statement = $db->prepare(" SELECT * FROM account 
                                        WHERE id = '".$id."'
                                        LIMIT 1 ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                // $contactId = $row['contactid'];
                // $firstName = $row['firstname'];
                // $lastName = $row['lastname'];
                // $phone = $row['phone'];
                // $email = $row['email'];

                //echo "<tr> <td><a href=\"contact.php?id=$contactId\">$firstName</a></td> <td><a href=\"contact.php?id=$contactId\">$lastName</a></td> <td>$phone</td> <td>$email</td> </tr>";
            }
        ?>
            <tr>
                <th>Account ID</th>
                <td><?=$row['id']?> </td>
            </tr>
            <tr>
                <th>Account Name</th>
                <td><?=$row['name']?> </td>
            </tr>
            <tr>
                <th>Street</th>
                <td><?=$row['street']?> </td>
            </tr>
            <tr>
                <th>City</th>
                <td><?=$row['city']?> </td>
            </tr>
            <tr>
                <th>State</th>
                <td><?=$row['state']?> </td>
            </tr>
            <tr>
                <th>Zip</th>
                <td><?=$row['zip']?> </td>
            </tr>
        </table>

        <h2>Related Contacts:</h2>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT id as contactid, firstname, lastname, phone, email FROM contact
                                        WHERE account = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $contactId = $row['contactid'];
                $firstName = $row['firstname'];
                $lastName = $row['lastname'];
                $phone = $row['phone'];
                $email = $row['email'];

                echo "<tr> <td><a href=\"contact.php?id=$contactId\">$firstName</a></td> <td><a href=\"contact.php?id=$contactId\">$lastName</a></td> <td>$phone</td> <td>$email</td> </tr>";
            }
        ?>
        </tbody>
        </table>

        <h2>Related Opportunities:</h2>
        <table>
            <thead>
                <tr>
                    <th>Opportunity ID</th>
                    <th>Stage</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT id as oppid, stage FROM opportunity
                                        WHERE account = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $oppId = $row['oppid'];
                $stage = $row['stage'];

                echo "<tr> <td><a href=\"opportunity.php?id=$oppId\">$oppId</a></td> <td>$stage</td> </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
