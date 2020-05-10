<?php 
    session_start();
    include('cart-functions.php');
 
    $products = $_SESSION['products'];
    $amounts = $_SESSION['amounts'];
?>
 
<html>
    <head>
        <link rel="stylesheet" href="03prove.css">
        <style>
            #cart{
                position: relative;
                border: 1px solid red;
                width: 70%;
                margin: 0 auto;
            }
            table *{
                font-size: larger;
            }
            img{
                width: 150px;
            }
            td, th{
                align-items: center;
                height: 1em;
                padding: .5em;
                background-color: #eee;
            }
            a{
                border: 1px solid white;
            }
        </style>
    </head>
    <body>
    <a href="03prove.php"> Continue Shopping</a>

    <div id="cart">
    
    <table>
        <tr>
            <td></td>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Remove / Add</th>
        </tr>
    <?php
        if ( isset($_SESSION["cart"]) ) {
        $total = 0;
        foreach ( $_SESSION["cart"] as $i ) {
    ?>
            <tr>
                <td><img src="images/<?=$products[$i];?>.png" alt=""></td>
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
            <td></td>
            <td>--------</td>
            <td>--------</td>
            <td></td>

        </tr>
        <tr>
            <td>Total: </td>
            <td></td>
            <td ><?=$totalQty; ?></td>
            <td >$ <span id="totalAmt"><?=$total;?></span></td>
            <td><a id="checkoutButton" href="checkout.php">Continue to Checkout</a></td>
        </tr>
    </table>
    <br>

    <a href="?reset=true">Reset Cart</a>

    <?php
    }else echo "You don't have any items in your Cart";
    ?>
    </div>
    <script src="03prove.js"></script>
    </body>
</html>