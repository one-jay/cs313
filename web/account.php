<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id']; 
if ($_POST) {

    // update account
    if(isset($_POST['updateAccount'])) {
        try{
            $db = get_db();
            $query = 'UPDATE account SET
                            name    = :name,
                            street  = :street,
                            city    = :city,
                            state   = :state,
                            zip     = :zip
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
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

    // create contact
    if(isset($_POST['insertContact'])) {
        try{
            $db = get_db();
            $query = 'INSERT INTO contact (firstname, lastname, phone, email, account) 
                    VALUES(:firstname, :lastname, :phone, :email, :account)';
            $statement = $db->prepare($query);
                $statement->bindValue(':firstname', $_POST['firstname']);
                $statement->bindValue(':lastname', $_POST['lastname']);
                $statement->bindValue(':phone', $_POST['phone']);
                $statement->bindValue(':email', $_POST['email']);
                $statement->bindValue(':account', $_POST['account']);
            $statement->execute();
        }catch (Exception $ex){
            echo "Error with DB. Details: $ex";
            die();
        }
    }

    // create opportunity
    if(isset($_POST['insertOpp'])) {
        try{
            $db = get_db();
            $query = 'INSERT INTO opportunity (account, stage) 
                    VALUES(:account, :stage)';
            $statement = $db->prepare($query);
                $statement->bindValue(':account', $_POST['account']);
                $statement->bindValue(':stage', $_POST['stage']);
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
        <br>
        <div class="related">
            <h1>Account Details</h1>
            <table>
            <?php
                $statement = $db->prepare(" SELECT * FROM account 
                                            WHERE id = '".$id."'
                                            LIMIT 1 ");
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $name = $row['name'];
                    $street = $row['street'];
                    $city = $row['city'];
                    $state = $row['state'];
                    $zip = $row['zip'];
                }

                $details = array(
                    'Account ID'    => $id,
                    'Account Name'  => $name,
                    'Street'        => $street,
                    'City'          => $city,
                    'State'         => $state,
                    'Zip'           => $zip
                );

                foreach($details as $k => $v){
                    echo "<tr><th>$k</th><td>$v</td></tr>";
                }
            ?>
            
            </table>

            <h3>Update Account</h3>
            <form action="" method="post">
                <!-- <input type="text" name="id" value="<?=$id?>"> -->
                <input type="text" name="name" value="<?=$name?>">
                <input type="text" name="street" value="<?=$street?>">
                <input type="text" name="city" value="<?=$city?>">
                <input type="text" name="state" value="<?=$state?>">
                <input type="text" name="zip" value="<?=$zip?>">
                <input type="submit" name="updateAccount" value="Update Account">
            </form>
        </div>

        <div class="related">
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

            <h3>Create New Contact</h3>
            <form action="" method="post">
                <input type="text" name="account" value="<?=$id?>" class="hide">
                <input type="text" name="firstname" value="First Name">
                <input type="text" name="lastname" value="Last Name">
                <input type="text" name="phone" value="Phone">
                <input type="text" name="email" value="Email">
                <input type="submit" name="insertContact" value="Create New Contact">
            </form>
        </div>

        <div class="related">
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

            <h3>Create New Opportunity</h3>
            <form action="" method="post">
                <input type="text" name="account" value="<?=$id?>" class="hide">
                <input type="text" name="stage" value="New">
                <input type="submit" name="insertOpp" value="Create New Opportunity">
            </form>
        </div>

    </body>
</html>
