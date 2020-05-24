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
                $statement = $db->prepare("SELECT * FROM contact");
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $account = $row['account'];
                    $firstName = $row['firstname'];
                    $lastName = $row['lastname'];
                    $phone = $row['phone'];
                    $email = $row['email'];

                    echo "<tr> <td>$account</td> <td>$firstName</td> <td>$lastName</td> <td>$phone</td> <td>$email</td> </tr>";
                }
            ?>
            </tbody>
        </table>

    </body>
</html>
