<?php
$username = $_GET['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Seller Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .review-form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .review-form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .stars {
            display: flex;
            gap: 10px;
        }
        .stars input {
            display: none;
        }
        .stars label {
            font-size: 24px;
            cursor: pointer;
        }
        .stars input:checked ~ label {
            color: gold;
        }
        .stars label:hover,
        .stars label:hover ~ label {
            color: gold;
        }
        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="review-form-container">
        <h1>Submit Your Review</h1>
        <form action="submitReview.php?username=<?php echo $username; ?>" method="POST">
            <div class="form-group">
                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="stars">Rating:</label>
                <div class="stars">
                    <input type="radio" id="star5" name="stars" value="5">
                    <label for="star5">&#9733;</label>
                    <input type="radio" id="star4" name="stars" value="4">
                    <label for="star4">&#9733;</label>
                    <input type="radio" id="star3" name="stars" value="3">
                    <label for="star3">&#9733;</label>
                    <input type="radio" id="star2" name="stars" value="2">
                    <label for="star2">&#9733;</label>
                    <input type="radio" id="star1" name="stars" value="1">
                    <label for="star1">&#9733;</label>
                </div>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div><br>
    <section class="display">
    <?php
        include "database.php";
        $selectQuery = "SELECT * FROM reviews";
        $result = $conn->query($selectQuery);
        $row = mysqli_fetch_assoc($result);
    ?>
    <?php
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo '
              <div class="card">
                        ';
                            echo'
                          <div class="container">
                              <h4 style="text-align: center"><b>' . $row['seller'] .'</b></h4>
                              <p><b>Stars:</b> '.$row['stars'].'</p>
                              <p><b>Comment:</b> ' . $row['review'] . '</p>
                          </div style="margin: bottom 20px;">
                      </div>';
          }
      } else {
          echo '<p style="text-align:center;">There are no reviews to show.</p>';
      }

      ?>
    </section>
</body>
</html>
