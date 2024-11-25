<?php
include "database.php";
$username = $_GET['username'];
$selectQuery = "SELECT * FROM seller WHERE username='" . $username . "'";
$result = $conn->query($selectQuery);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="nav.css" rel="stylesheet" >
    <link href="sellerHomePage.css" rel="stylesheet" >
    <title>My profile</title>
    <style>
        body {
            background-color: beige;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 70%;
            background-color: whitesmoke;
            border-radius: 5px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="sellerHomePage.php?username=<?php echo $username ?>">My Store</a>
            <a href="uploadProduct.php?username=<?php echo $username ?>">Upload new item</a>
            <a href="soldPage.php?username=<?php echo $username ?>">Sold items</a>
            <a href="sellerSignUpPage.html">Logout</a>
        </div>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Lander Thrift Store </span>
    </nav>

    <div class="container">
        <div class="row">
            <div class="card">
                <div style="width: 100%; background-color: white; opacity: 0.925; margin: 40px auto auto auto; border-radius: 10px; padding-bottom:30px;">
                    <div style="width: 70%; margin: 20px auto;">
                        <br>
                        <form method="POST" action="updateSellerProfile.php?username=<?php echo $username; ?>">
                            <label for="username"><h4>Username:</h4></label>
                            <input type="text" name="username" id="username" value="<?php echo $row['username'] ?>" class="form-control">
                            <img src="userIcon.jpg" alt="profile" style="width: 18%;margin-left:40%; margin-right: 50%"><br>
                            <h4>Personal details:</h4>
                            <label><b>Email:</b></label>
                            <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control">
                            <label><b>Starting Date:</b></label>
                            <input type="text" name="start_date" value="<?php echo $row['start_date'] ?>" class="form-control" readonly>
                            <label><b>Number of items selling:</b></label>
                            <input type="text" name="no_selling" value="<?php echo $row['no_selling'] ?>" class="form-control" readonly>
                            <label><b>Number of items sold:</b></label>
                            <input type="text" name="no_sold" value="<?php echo $row['no_sold'] ?>" class="form-control" readonly>
                            <br>
                            <input type="hidden" name="update_seller" value="Update">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                        <form method="POST" action="deleteSellerProfile.php?username=<?php echo $username; ?>">
                            <input type="hidden" name="delete_seller" value="Delete">
                            <button type="submit" class="btn btn-danger" onclick="deleteAccount('<?php echo $username ?>')">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h3>My Items</h3>
        <section class="display">
            <?php
            $itemsQuery = "SELECT * FROM items WHERE seller='" . $username . "' ORDER BY item_status, upload_date DESC";
            $results = $conn->query($itemsQuery);
            if (mysqli_num_rows($results) > 0) {
                while ($item = mysqli_fetch_assoc($results)) {
                    echo '
                    <div class="card">
                        <form method="POST" action="updateItem.php">
                            <img src="uploads/' . $item['image'] . '" alt="product" style="width:100%">
                            <div class="container">
                                <h4 style="text-align: center"><b>' . $item['prodName'] . '</b></h4>
                                <label><b>Size:</b></label>
                                <input type="text" name="size" value="' . $item['size'] . '" class="form-control">
                                <label><b>Price:</b></label>
                                <input type="text" name="price" value="' . $item['price'] . '" class="form-control">
                                <label><b>Description:</b></label>
                                <input type="text" name="description" value="' . $item['description'] . '" class="form-control">
                                <input type="hidden" name="id" value="' . $item['id'] . '">
                                <br>
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </form>

                        <form method="POST" action="deleteItem.php">
                            <input type="hidden" name="id" value="' . $item['id'] . '">
                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                            <button type="submit" class="btn btn-danger" onclick="deleteItem(' . $item['id'] . ')">Delete</button>
                        </form>
                    </div>';
                }
            } else {
                echo '<p style="text-align:center;">You are not selling any items currently.</p>';
            }
            ?>
        </section>
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function deleteAccount(username) {
            if (confirm("Are you sure you want to delete your account?")) {
                window.location.href = "deleteSellerProfile.php?username=" + username;
            }
        }

        function deleteItem(id) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = "deleteItem.php?id=" + id;
            }
        }
    </script>
</body>
</html>
