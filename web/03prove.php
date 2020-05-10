<?php 
    session_start();
    include('cart-functions.php');
?>

<html>
    <head>
        <title>PHP Shopping Cart</title>
        <link rel="stylesheet" href="03prove.css">
    </head>
    <body>
        <!-- <?=$h?> shorthand echo-->
        <h1>* Tesla Factory Sweepstakes *</h1>
        <h2>Congratulations! You've been selected to receive 
            a store credit of $200,000!
        </h2>
        <h3>Choose from any of the options below and Add to Cart. </h3>
        
        <!-- populate products on page -->
        <ul>
            <?php
                for ($i=0; $i< count($products); $i++) {
            ?>
                <li><?=$products[$i];?>
                    <img src="images/<?=$products[$i];?>.png" alt="">
                    $ <?=$amounts[$i];?>
                    <a href="?add=<?=($i);?>">Add to cart</a>
                </li>
            <?php
                }//close for loop
            ?>
        </ul>

        <div id="cart">
            <?php
                if ( isset($_SESSION["cart"]) ) {
            //  header('Location: test2.php');
            ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
                <?php
                $total = 0;
                foreach ( $_SESSION["cart"] as $i ) {
                ?>
                    <tr>
                        <td><?=( $products[$_SESSION["cart"][$i]] ); ?></td>
                        <td><?=( $_SESSION["qty"][$i] ); ?></td>
                        <td><?=('$ '. $_SESSION["amounts"][$i] ); ?></td>
                        <td><a href="?delete=<?=($i); ?>"> -- </a> <a href="?add=<?=($i);?>"> ++ </a></td>
                    </tr>
                <?php
                    $total += $_SESSION["amounts"][$i];
                    $totalQty += $_SESSION['qty'][$i];
                }
                $_SESSION["total"] = $total; 
                $_SESSION['totalQty'] = $totalQty;
                ?>
                <tr>
                    <td></td>
                    <td>--------</td>
                    <td>--------</td>

                </tr>
                <tr>
                    <td>Total: </td>
                    <td ><?=$totalQty; ?></td>
                    <td >$ <span id="totalAmt"><?=$total;?></span></td>
                    <td><a href="cart.php">Go To Cart</a></td>
                </tr>
            </table>
            <br>
            <!-- <a href="?reset=true">Reset Cart</a> -->
            <?php
            }
            ?>
        </div>
        
        <h4>Payment may not be combined with any other source. </h4>
        <h5>Other terms and conditions apply. </h5>
        <h6>Offer expires <span id="yesterday"></span></h6>


        <script src="03prove.js"></script>
    </body>
</html>