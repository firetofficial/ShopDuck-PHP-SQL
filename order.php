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
            echo '<script>alert("Item Already Added")</script>';
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
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>SHOPDUCK</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php include ("nav2.html"); ?>
		<br />
		<div class="container">
			<br />
			<br />
			<br />
			<h3> IPhone </h3>

			<h3>Chi tiết đặt hàng</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Tên sản phẩm</th>
						<th width="10%">Số lượng</th>
						<th width="20%">Giá</th>
						<th width="15%">Tổng cộng</th>
						<th width="7%">Lựa chọn</th>
					</tr>
					<?php
if (!empty($_SESSION["shopping_cart"]))
{
    $total = 0;
    foreach ($_SESSION["shopping_cart"] as $keys => $values)
    {
?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td><?php echo $values["item_price"]; ?> ₫</td>
						<td><?php echo number_format($values["item_quantity"] * $values["item_price"], 3, ',000', '.000'); ?> ₫</td>
						<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Xoá</span></a></td>
					</tr>
					<?php
        $total = $total + ($values["item_quantity"] * $values["item_price"]);
    }
?>
					<tr>
						<td colspan="3" align="right">Tổng cộng</td>
						<td align="right"><?php echo number_format($total, 3, ',000', '.000'); ?> ₫</td>
						<td></td>
					</tr>
					<?php
}
?>
						
				</table>
			
			</div>
		</div>
	
		<a style="margin-top:5px;" class="btn btn-success" href="/shopduck/checkout.php"  > Chốt đơn </a>	
		
				</br>
	</div>
	<br />
	<?php include ("footer.html"); ?>
	</body>
</html>
