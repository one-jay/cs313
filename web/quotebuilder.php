<?php
//require "crm-db.php";
//$db = get_db();
//$id = $_GET['id']; 
if ($_POST) {

    // insert quotelines
    if(isset($_POST['insertQuoteLines'])) {
        try{
            $db = get_db();
            $query = 'INSERT INTO quoteline (quote, product, price, quantity) 
                    VALUES(:quote, :product, :price, :quantity)';
            $statement = $db->prepare($query);
                $statement->bindValue(':quote', $id);
                $statement->bindValue(':product', $_POST['product0']);
                $statement->bindValue(':price', $_POST['quoteprice0']);
                $statement->bindValue(':quantity', $_POST['quantity0']);
            $statement->execute();
            // $newQuoteId = $pdo->lastInsertId('quote_id_seq');
            // echo "<h1>new quote id: $newQuoteId</h1>";
        }catch (Exception $ex){
            echo "Error with DB. Details: $ex";
            die();
        }
    }

    //header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>

<html>
    <head>

    </head>
    <body>
    
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
                            .'<td class="hide"> <input type="text" name="productId'.$rowNum.'" value="'.$productId.'" readonly> </td>'
                            .'<td> <input type="text" name="product'.$rowNum.'" value="'.$product.'" readonly> </td>'
                            .'<td> <input type="text" name="listPrice'.$rowNum.'" value="'.$listPrice.'" readonly> </td>'
                            .'<td> <input type="text" name="quotePrice'.$rowNum.'"> </td>'
                            .'<td> <input type="text" name="quantity'.$rowNum.'"> </td>'
                        .'</tr>';
                    $rowNum++;
                }
            ?>
            </tbody>
        </table>
        
        <input type="submit" name="insertQuoteLines" value="Add Products to Quote">
    </form>

    </body>
</html>