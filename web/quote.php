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

// insert quotelines
if(isset($_POST['insertQuoteLines'])) {
    try{
        $db = get_db();
        print_r($_POST);
        
        $query = 'INSERT INTO quoteline (quote, product, price, quantity) VALUES ';
            for($i = 0; $i < (count($_POST)-2) / (4+1) ; $i++){
                $query.= '(:quote,'
                        .':product'.$i.','
                        .':price'.$i.','
                        .':quantity'.$i.'),';
            };
            echo '<br>'.$query.'<br> i: '.$i.'<br>';
        $statement = $db->prepare($query);

        $statement->bindValue(':quote', $id);
        for($j = 0; $j <= $i; $j++){
            $statement->bindValue(':product'.$j, $_POST['productid'.$j]);
            $statement->bindValue(':price'.$j, $_POST['quoteprice'.$j]);
            $statement->bindValue(':quantity'.$j, $_POST['quantity'.$j]);
        }
        $statement->execute();
        // $newQuoteId = $pdo->lastInsertId('quote_id_seq');
        // echo "<h1>new quote id: $newQuoteId</h1>";
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
    </div>

    <div class="container">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Quote Builder</button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog  modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Quote Builder</h4>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post">
                            <input type="text" name="quote" value="<?=$id?>" class="hide">
                            <!-- <input type="text" name="product" value="Product">
                            <input type="text" name="price" value="Price">
                            <input type="text" name="quantity" value="quantity"> -->
                        
                            <table id="productsTable">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>List Price</th>
                                        <th>Quote Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                <?php
                                    $sql = 'SELECT *
                                            FROM product';
                                    $statement = $db->prepare($sql);
                                    $statement->execute();

                                    $rowNum = 0;
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $productId = $row['id'];
                                        $product = $row['name'];
                                        $desc = $row['description'];
                                        $listPrice = $row['listprice'];

                                        echo 
                                            '<tr>'
                                                .'<td class="hide"> <input type="text" name="productid'.$rowNum.'" value="'.$productId.'" readonly> </td>'
                                                .'<td> <input type="text" name="product'.$rowNum.'" value="'.$product.'" readonly> </td>'
                                                .'<td> <input type="text" name="listprice'.$rowNum.'" value="'.$listPrice.'" readonly> </td>'
                                                .'<td> <input type="text" name="quoteprice'.$rowNum.'"> </td>'
                                                .'<td> <input type="text" name="quantity'.$rowNum.'"> </td>'
                                            .'</tr>';
                                        $rowNum++;
                                    }
                                ?>
                                </tbody>
                            </table>
                            
                            <input type="submit" name="insertQuoteLines" value="Add Products to Quote">
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="related">
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
        </div>
    </body>
</html>
