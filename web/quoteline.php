<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id']; 
if ($_POST) {

    // update contact
    if(isset($_POST['updateQuoteLine'])) {
        try{
            $db = get_db();
            $query = 'UPDATE quoteline SET
                            price    = :price,
                            quantity   = :quantity
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':price', $_POST['price']);
                $statement->bindValue(':quantity', $_POST['quantity']);
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

        <h2>Quote Line Details</h2>
        <table>
        <?php
            $statement = $db->prepare(" SELECT * FROM quoteline 
                                        WHERE id = '".$id."'
                                        LIMIT 1 ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quote = $row['quote'];
                $product = $row['product'];
                $price = $row['price'];
                $quantity = $row['quantity'];
            }

            $details = array(
                'Quote Line ID' => $id,
                'Quote'         => $quote,
                'Product'       => $product,
                'Price'         => $price,
                'Quantity'      => $quantity
            );

            foreach($details as $k => $v){
                echo "<tr><th>$k</th><td>$v</td></tr>";
            }
        ?>
           
        </table>

        <h2>Update Quote Line</h2>
        <form action="" method="post">
            <!-- <input type="text" name="id" value="<?=$id?>"> -->
            <!-- <input type="text" name="firstname" value="<?=$firstname?>">
            <input type="text" name="lastname" value="<?=$lastname?>"> -->
            <input type="text" name="price" value="<?=$price?>">
            <input type="text" name="quantity" value="<?=$quantity?>">
            <input type="submit" name="updateQuoteLine" value="Update Quote Line">
        </form>


    </body>
</html>
