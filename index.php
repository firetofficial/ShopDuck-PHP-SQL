<?php
session_start();
require_once ("config.php");

if (isset($_POST["add_to_cart"]))
{
    if (isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Bạn đã thêm sản phẩm này vào giỏ hàng rồi")</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"]))
{
    if ($_GET["action"] == "delete")
    {
        foreach ($_SESSION["shopping_cart"] as $keys => $values)
        {
            if ($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Đã xoá sản phẩm ra khỏi giỏ hàng ")</script>';
                echo '<script>window.location="order.php"</script>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
	<head>
	   <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SHOPDUCK</title>
		<link rel="icon" type="image/x-icon" href="https://firet.io/shopduck/favicons/vitshop.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
	<header><?php include ("nav2.html"); ?></header>
	<?php include ("slider.html"); ?>

		<br />
		<div id='Iphone' class="container">
			<br />
			<br />
			<br />
			<h3> IPhone </h3>
			<?php
$query = "SELECT * FROM tbl_product ORDER BY id ASC";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
?>
			<div class="col-md-3">
				
				<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
				<div class="glass-panel">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["name"]; ?></h4>

						<h4 class="text-danger"><?php echo $row["price"]; ?> ₫</h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Thêm vào giỏ hàng" />

					</div>
				</form>
			</div>
			<?php
    }
}
?>
			<div style="clear:both"></div>
			<br />
			
			
		</div>
	</div>
	<br />
	<footer><?php include ("footer.html"); ?></footer>
	</body>
</html>
