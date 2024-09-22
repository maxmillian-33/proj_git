<?php 
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }
    include("./auth/functions.php");
    include ("./auth/auth.php");
    $c_id = $_SESSION["c_id"];
// echo $c_id;
?>
<!DOCTYPE html>
<html>
<head>
    <title>document</title>
    <link rel="stylesheet" type="text/css" href="styles4.css">
    
</head>
<body>
    <header>
        <h1 style="display:flex;">c A f e A R o </h1>
        <a href="cart.php"><button id="hero_bt">GO TO  CART</button></a> 
        <a href="detail.php"><button id="hero_bt">STAFF DETAILS</button></a>
        <a href="orderdetails.php"><button id="hero_bt">ORDERDETAILS</button></a>
        <a href="logout.php"><button id="hero_bt">LOGOUT</button></a> 
    </header>
    </ul>

    <section class="menu">
        <h2>Menu</h2>
        <ul>
            <?php 
                $sql = $conn->query("select * from product");
                while($ProductResult = $sql->fetch_assoc()){
            ?>
            <li>
            <form method="POST">
                <div class="item">
                    <img style="height:200px;width:200px;"src="./<?php echo $ProductResult['photo'] ?>" alt="Food 1">
                    <h3><?php echo $ProductResult['productname']; ?></h3>
                    <p><?php echo $ProductResult['type']?></p>
                    <?php 
                        if($ProductResult['quantity'] > 0){
                            ?>
                                <p>quantity:<?php echo $ProductResult['quantity']?></p>
                    <p></p>
                    <p>Price: ₹<?php echo $ProductResult['price']?></p>
                    <button type="submit" class="order-button" name="addtoCart" value="<?php echo $ProductResult['productid']; ?>">Add to Cart</button>
                            <?php 
                            }else{
                        ?>
                        <span style="color:red;">Product is out of stock</span>
                        <?php 
                            }
                        ?>
                    
                </div>
                </form>
            </li>
            <?php 

                }
            ?>
            
            
            <!-- Add more menu items as needed -->
        </ul>
    </section>

   
    <footer>
        <p>&copy;c A f e A R o 2 0 2 3 </p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php 
//     if(isset($_POST['addtoCart'])){
//         $productId = $_POST['addtoCart'];
//         // echo $productId;
//         // die();
//         $cartMasterCheck = $conn->query("select * from cartmaster where user_id='$c_id' and cart_status=1");
//         if($cartMasterCheck->num_rows > 0){
//             $MasterId = $cartMasterCheck->fetch_assoc()["cm_id"];
//             $productfind = $conn->query("select * from cartchild cc inner join cartmaster cm on cc.mt_id = cm.cm_id where cc.f_id='$productId' AND cc.mt_id='$MasterId' AND cm.cart_status=1");
//             if($productfind->num_rows > 0){
//                 $ccid = $productfind->fetch_assoc()["ch_id"];
//                 $sql = $conn->query("update cartchild set quantity=quantity+1 where ch_id='$ccid'");
//             }else{
//                 $childInsert = $conn->query("insert into cartchild (mt_id,f_id,quantity) values ('$MasterId','$productId','1')");
//             }
//         }else{
//             $conn->query("insert into cartmaster(user_id) values($c_id)");
//             $masterId = $conn->insert_id;
//             $childInsert = $conn->query("insert into cartchild (mt_id,f_id,quantity) values ('$masterId','$productId','1')");
//         }
//         echo "<script>alert('Product Added to Cart')</script>";
//     }
?>