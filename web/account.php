<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];

if(isset($_POST['submit'])) {
  $rowToUpdate = array('id'=>$id);
  $res = pg_update($db, 'account', $_POST, $rowToUpdate);
  if ($res) {
      echo "Data is updated: $res\n";
  } else {
      echo "User must have sent wrong inputs\n";
  }

// if(isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $street = $_POST['street'];
//     $city = $_POST['city'];
//     $state = $_POST['state'];
//     $zip = $_POST['zip'];
//     try{
//         $db = get_db();
//         $query = 'INSERT INTO account (name, street, city, state, zip) 
//                 VALUES(:name, :street, :city, :state, :zip)';
//         $statement = $db->prepare($query);
//             $statement->bindValue(':name', $name);
//             $statement->bindValue(':street', $street);
//             $statement->bindValue(':city', $city);
//             $statement->bindValue(':state', $state);
//             $statement->bindValue(':zip', $zip);
//         $statement->execute();
//     }catch (Exception $ex){
//         echo "Error with DB. Details: $ex";
//         die();
//     }
}

?>

<html>
    <head>

    </head>
    <body>

        <h2>Account Details</h2>
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

        <h2>Account Details (form)</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="number" name="id" value="<?=$id?>">
            <input type="text" name="Account Name" value="<?=$name?>">
            <input type="text" name="Street" value="<?=$street?>">
            <input type="submit" name="submit" value="Save Changes">
        </form>

        <form action="" method="post">
            <input type="text" name="id" value="<?=$id?>">
            <input type="text" name="name" >
            <input type="text" name="street" >
            <input type="text" name="city" >
            <input type="text" name="state" >
            <input type="text" name="zip" >
            <input type="submit" name="submit" value="Create New Account">
        </form>

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
