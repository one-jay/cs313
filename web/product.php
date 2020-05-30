<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
if ($_POST) {

    // update opportunity
    if(isset($_POST['updateOpp'])) {
        try{
            $db = get_db();
            $query = 'UPDATE opportunity SET
                            stage  = :stage
                        WHERE id = :id';
            $statement = $db->prepare($query);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':stage', $_POST['stage']);
            $statement->execute();
        }catch (Exception $ex){
            echo "Error with DB. Details: $ex";
            die();
        }
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
?>

<html>
    <head>

    </head>
    <body>
        <h1>Product: <?=$id?> </h1>

        <h2>Product Details</h2>
        <table>
        <?php
            $statement = $db->prepare(" SELECT * FROM product 
                                        WHERE id = '".$id."'
                                        LIMIT 1 ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $name = $row['name'];
                $description = $row['description'];
                $listprice = $row['listprice'];
            }
            $details = array(
                'Product ID'    => $id,
                'Product Name'  => $name,
                'Description'  => $description,
                'List Price'        => $listprice
            );
            foreach($details as $k => $v){
                echo "<tr><th>$k</th><td>$v</td></tr>";
            }
        ?>
        </table>

        <h2>Update Product</h2>
        <form action="" method="post">
            <!-- <input type="text" name="id" value="<?=$id?>"> -->
            <input type="text" name="name" value="<?=$name?>">
            <input type="text" name="description" value="<?=$description?>">
            <input type="text" name="listprice" value="<?=$listprice?>">
            <input type="submit" name="updateProduct" value="Update Product">
        </form>

        <h2> Related Quote Lines:</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote Line ID</th>
                    <th>Quote</th>
                    <th>Quote Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT quoteline.id as quotelineid, quote, price, quantity
                                        FROM quoteline
                                        --JOIN product ON quoteline.product = product.id
                                        WHERE product = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quoteLineId = $row['quotelineid'];
                $quote = $row['quote'];
                $price = $row['price'];
                $quantity = $row['quantity'];

                echo "<tr> <td><a href=\"quoteline.php?id=$quoteLineId\">$quoteLineId</a></td> <td><a href=\"quote.php?id=$quote\">$quote</td> <td>$price</td> <td>$quantity</td>  </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
