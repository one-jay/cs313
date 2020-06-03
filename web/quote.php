<?php
require "crm-db.php";
$db = get_db();
$id = $_GET['id'];
if ($_POST) {

// update quote
if(isset($_POST['updateQuote'])) {
    try{
        $db = get_db();
        $query = 'UPDATE quote SET
                        amount  = :amount
                    WHERE id = :id';
        $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':amount', $_POST['amount']);
        $statement->execute();
    }catch (Exception $ex){
        echo "Error with DB. Details: $ex";
        die();
    }
}

// create quote line
if(isset($_POST['insertQuoteLine'])) {
    try{
        $db = get_db();
        $query = 'INSERT INTO quoteline (quote, product, price, quantity) 
                VALUES(:quote, :product, :price, :quantity)';
        $statement = $db->prepare($query);
            $statement->bindValue(':quote', $_POST['quote']);
            $statement->bindValue(':product', $_POST['product']);
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
    <h1>Quote: <?=$id?> </h1>

    <h2>Quote Details</h2>
    <table>
    <?php
        $statement = $db->prepare(" SELECT * FROM quote 
                                    WHERE id = '".$id."'
                                    LIMIT 1 ");
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $opportunity = $row['opportunity'];
            $amount = $row['amount'];
        }
        $details = array(
            'Quote ID'      => $id,
            'Opportunity'   => '<a href="opportunity.php?id='.$opportunity.'">'.$opportunity.'</a>',
            'Amount'        => $amount
        );
        foreach($details as $k => $v){
            echo "<tr><th>$k</th><td>$v</td></tr>";
        }
    ?>
    </table>

    <h2>Update Quote</h2>
    <form action="" method="post">
        <!-- <input type="text" name="id" value="<?=$id?>"> -->
        <input type="text" name="amount" value="<?=$amount?>">
        <input type="submit" name="updateQuote" value="Update Quote">
    </form>

    <h2>Create New Quote Line</h2>
    <form action="" method="post">
        <input type="text" name="quote" value="<?=$id?>" class="hide">
        <input type="text" name="product" value="Product">
        <input type="text" name="price" value="Price">
        <input type="text" name="quantity" value="quantity">
        <input type="submit" name="insertQuoteLine" value="Create New Quote Line">
    </form>

        <h2> Quote Lines:</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote Line ID</th>
                    <th>Product</th>
                    <th>List Price</th>
                    <th>Quote Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $statement = $db->prepare(" SELECT quoteline.id as quotelineid, product.id as productid, product.name, product.listprice, price, quantity
                                        FROM quoteline
                                        JOIN product ON quoteline.product = product.id
                                        WHERE quote = '".$id."' ");
            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $quoteLineId = $row['quotelineid'];
                $product = $row['name'];
                $productId = $row['productid'];
                $listPrice = $row['listprice'];
                $price = $row['price'];
                $quantity = $row['quantity'];

                echo "<tr> <td><a href=\"quoteline.php?id=$quoteLineId\">$quoteLineId</a></td> <td><a href=\"product.php?id=$productId\">$product</td> <td>$listPrice</td> <td>$price</td> <td>$quantity</td>  </tr>";
            }
        ?>
        </tbody>
        </table>

    </body>
</html>
