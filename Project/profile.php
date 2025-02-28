<?php 
include('Partial-Files/header.php');
if(!isset($_SESSION['user_id'])){
    header("Location: login.php?error=notloggedin");
}
else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user->updateUser($_SESSION['user_id'], $_POST['user-name'], $_POST['user-mail'], $_POST['user-address'], $_POST['user-city'], $_POST['user-phone-number']);
    }
}

$profile = $user->getUser($_SESSION['user_id']);
$orders = $order->getOrders($_SESSION['user_id']);
?>
<body>
    <?php include('Partial-Files/nav.php')?>
    <div class="container-fluid">
        <section class="profile-settings"> 
            <div class="col-12">
                <div class="col-6 no-gutters">   
                    <div class="col-6 no-gutters">
                        <form class="no-gutters" method="post">
                            <?php
                            if(isset($_GET['save']))
                            {
                                echo '<p class="success">Porfile Updated Successfully!</p>';
                            }
                            ?>
                            <p class="page-head-tag" style="margin-left: 0px;">Profile Settings</p>
                            <div class="user-name">
                                <label for="user-name" class="text-field-text">Full Name: </label><br>
                                <input type="text" id="user-name" name="user-name" class="text-field-input" value="<?php echo $profile['name']?>"><br>
                            </div> 
                            <div class="user-mail">
                                <label for="user-mail" class="text-field-text">Email: </label><br>
                                <input type="text" id="user-mail" name="user-mail" class="text-field-input" value="<?php echo $profile['email']?>"><br>
                            </div> 
                            <div class="user-phone-number">
                                <label for="user-phone-number" class="text-field-text">Phone Number: </label><br>
                                <input type="text" id="user-phone-number" name="user-phone-number" class="text-field-input" value="<?php echo $profile['phone']?>"><br>
                            </div>
                            <div class="user-phone-number">
                                <label for="user-city" class="text-field-text">City: </label><br>
                                <input type="text" id="user-city" name="user-city" class="text-field-input" value="<?php echo $profile['city']?>"><br>
                            </div>  
                            <div class="user-address">
                                <label for="user-address" class="text-field-text">Address: </label><br>
                                <input type="text" id="user-address" name="user-address" class="text-field-input" value="<?php echo $profile['address']?>"><br>
                            </div>

                            <div class="col-12 checkout-button no-gutters" style="padding-bottom: 0px;">
                                <button class="complete-checkout" type="submit">Update Changes</button>
                            </div>
                        </form>
                        <form action="DatabasePHP/Logout.db.php" method="post" class="col-12 checkout-button no-gutters" style="margin-top: 0px;">
                            <button class="complete-checkout" type="submit" style ="background:red; margin-top: 15px;">Log out</button>
                        </form>
                    </div>    
                </div>
            </div>
        </section>

        <section class="previous-orders">
            <div class="col-12">
                <p class="page-head-tag">Previous Orders</p>  
                <table class="checkout-table">
                    <tr id="first-row">
                      <th>Order ID</th>
                      <th>Food</th>
                      <th>Order Date</th>
                      <th>Sum</th>
                      <th></th>
                    </tr>
                    <?php foreach($orders as $userOrder) {
                            $items = $cart->getCart($userOrder['cart_id']);
                    ?>
                    <tr class="white-bordered-table-row">
                      <td><?php echo "#" . $userOrder['order_id']?></td>
                      <td><?php 
                        for($i = 0; $i < count($items); $i++){
                            echo $items[$i]['quantity'] . "x " . $products->getProduct($items[$i]['product_id'])['product_name'] . ($i != count($items) - 1 ? ", " : "");
                        }
                      ?></td>
                      <td><?php echo $userOrder['date_created']?></td>
                      <td><?php echo $userOrder['total']?></td>
                      <td><a class="link-redirector feedback-link" href="#">Give Feedback</button></td>
                    </tr>

                    <?php }?>
                  </table>
            </div>
        </section>

    </div>
              
    
    
</body>
</html>