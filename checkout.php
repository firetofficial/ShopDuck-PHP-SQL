<?php
session_start();
require_once("config.php");

if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count                             = count($_SESSION["shopping_cart"]);
            $item_array                        = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Bạn đã thêm sản phẩm này vào giỏ hàng rồi")</script>';
        }
    } else {
        $item_array                   = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            $tensp = $values["item_name"];
            
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Đã xoá")</script>';
                echo '<script>window.location="order.php"</script>';
            }
        }
    }
}



//Khai báo giá trị ban đầu, nếu không có thì khi chưa submit câu lệnh insert sẽ báo lỗi
$name   = "";
$diachi = "";
$sdt    = "";
$email  = "";
//$time = Now();

//$values["item_name"] = $sanpham;
////print_r($sanpham);
//Lấy giá trị POST từ form vừa submit

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"])) {
        $name = $_POST['name'];
    }
    if (isset($_POST["diachi"])) {
        $diachi = $_POST['diachi'];
    }
    if (isset($_POST["sdt"])) {
        $sdt = $_POST['sdt'];
    }
    if (isset($_POST["email"])) {
        $email = $_POST['email'];
    }
    
    //$sanpham = $_POST['item_name'];
    //Code xử lý, insert dữ liệu vào table
    echo $values["item_name"][10];
    sleep(10);
    $fl_suc = true;
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        $tensp    = $values["item_name"];
        $sl       = $values["item_quantity"];
        $total    = $values["item_price"];
        $tongtien = $total;
        $sql      = "INSERT INTO ttdh (name, diachi, sdt, email, sl, sanpham, tongtien,time)
    VALUES ('$name', '$diachi', '$sdt', '$email', '$sl' , '$tensp','$tongtien', Now())";
        if ($connect->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $connect->error;
            $fl_suc = false;
            break;
        }
    }
    if($fl_suc){
    echo '<script>alert("Đặt Hàng Thành Công")</script>';
    echo '<script>window.location="index.php"</script>';
    }
    else{
        echo '<script>alert("Đặt Hàng Thất bại")</script>';
    echo '<script>window.location="index.php"</script>';
    }
}


//Đóng database
$connect->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>SHOPDUCK</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
			<link rel="stylesheet" href="https://firet.io/shopduck/css/style2.css" />
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
<?php include("nav2.html"); ?>
		<br />
<div class="container">
			<br />
			<br />
			<br />
		
			
			
			
			<br />
		<fieldset class="border m-2 p-3">
   		
		   <form action="" method="post" style="float: center;">
		   <legend class="text-primary fw-bold">Thông tin người nhận hàng</legend>	<br />
<div class="form-group row mb-3">
    <label class="col-sm-2 col-form-label">Họ tên</label>
<div class="col-sm-10"><input type="text" class="form-control" name="name" value="" required> </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Địa Chỉ Chính Xác:</label>
<div class="col-sm-10"> <input class="form-control" type="text" name="diachi" value=""required> </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Số Điện Thoại:</label>
    <div class="col-sm-10"> <input class="form-control" type="text" name="sdt" value=""required> </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Email:</label>
    <div class="col-sm-10"> <input class="form-control" type="email" name="email" value=""required> </div>
</div>
</fieldset>
<div class="m-2 d-flex">
   <fieldset class="border p-3 mr-2 ">    
   
      <div class="form-group row">
	  <legend class="small text-primary fw-bold">Phương thức thanh toán</legend>
       <div style="padding-left: 71px" class="col-sm-10"> <input  type="radio"name="phuongthuctt" value="ghtietkiem" > Chuyển khoản </div>
        <div style="padding-left: 71px" class="col-sm-10"><input type="radio" name="phuongthuctt" value="khinhan"> Khi nhận hàng</div>
        <div style="padding-left: 30px" class="col-sm-10"><input type="radio" name="phuongthuctt" value="onepay"> Onepay</div>
        <div style="padding-left: 60px" class="col-sm-10"><input type="radio" name="phuongthuctt" value="nganluong"> Ngân Lượng</div>
      </div>
    </fieldset>
    <fieldset class="border p-3 ml-3 col-6">    
      
       <div class="form-group row">
	   <legend class="small text-primary fw-bold">Phương thức nhận hàng</legend>

          <div style="padding-left: 90px" class="col-sm-10"><input type="radio"name="phuongthuctt" value="ghtietkiem" > Nhận tại cửa hàng</div>
         <div style="padding-left: 51px" class="col-sm-10"><input type="radio" name="phuongthuctt" value="ghtietkiem"> Giao tận nơi</div>
         <!--
         <p><input type="radio" name="phuongthuctt" value="vnpost"> VN Post</p>
         <p><input type="radio" name="phuongthuctt" value="viettel"> Viettel</p>
         -->
       </div>
    </fieldset>    
</div>   
    <button class="btn btn-success" type="submit">Xác nhận đặt hàng</button>

</form>

			
			
				</br>
	</div>
	<br />
	<?php include("footer.html"); ?>
	</body>
</html>
