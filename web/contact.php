<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id']; 
if ($_POST) {

    // update contact
    if(isset($_POST['updateContact'])) {
        try{
            $db = get_db();
            $query = 'UPDATE contact SET
                            firstname    = :firstname,
                            lastname  = :lastname,
                            phone    = :phone,
                            email   = :email
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':firstname', $_POST['firstname']);
                $statement->bindValue(':lastname', $_POST['lastname']);
                $statement->bindValue(':phone', $_POST['phone']);
                $statement->bindValue(':email', $_POST['email']);
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

        <h2>Contact Details</h2>
        <table>
        <?php
            $statement = $db->prepare(" SELECT * FROM contact 
                                        WHERE id = '".$id."'
                                        LIMIT 1 ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $account = $row['account'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $phone = $row['phone'];
                $email = $row['email'];
            }

            $details = array(
                'Contact ID'    => $id,
                'Account' => '<a href="account.php?id='.$account.'">'.$account.'</a>',
                'First Name'  => $firstname,
                'Last Name'        => $lastname,
                'Phone'         => $phone,
                'Email'         => $email
            );

            foreach($details as $k => $v){
                echo "<tr><th>$k</th><td>$v</td></tr>";
            }
        ?>
           
        </table>

        <h2>Update Contact</h2>
        <form action="" method="post">
            <!-- <input type="text" name="id" value="<?=$id?>"> -->
            <input type="text" name="firstname" value="<?=$firstname?>">
            <input type="text" name="lastname" value="<?=$lastname?>">
            <input type="text" name="phone" value="<?=$phone?>">
            <input type="text" name="email" value="<?=$email?>">
            <input type="submit" name="updateContact" value="Update Contact">
        </form>


    </body>
</html>
