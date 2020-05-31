<?php
    require "crm-db.php";
    $db = get_db();
?>

<html>
    <head>

    </head>
    <body>
        <h2>Contacts:</h2>

        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
                
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT id as contactid, account.id as accountid, account.name, firstname, lastname, phone, email 
                        FROM contact
                        JOIN account ON contact.account = account.id';
                $statement = $db->prepare($sql);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $contactid = $row['contactid'];
                    $accountid = $row['accountid'];
                    $account = $row['name'];
                    $firstName = $row['firstname'];
                    $lastName = $row['lastname'];
                    $phone = $row['phone'];
                    $email = $row['email'];

                    echo "<tr> <td><a href=\"account.php?id=$accountid\"> $account </a></td> <td><a href=\"contact.php?id=$contactid\"> $firstname </a></td> <td><a href=\"contact.php?id=$contactid\"> $lastname </a></td> <td>$phone</td> <td>$email</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
