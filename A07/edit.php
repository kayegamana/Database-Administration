<?php
include('connect.php');

$id = $_GET['id'];

if (isset($_POST['btnEdit'])) {
  $content = $_POST['content'];
  $privacy = $_POST['privacy'];

  $editQuery = "UPDATE posts SET content='$content', privacy='$privacy' WHERE postID='$id'";
  executeQuery($editQuery);

  header('Location: ./');
}

$queryPosts = "SELECT posts.*, users.*, posts.dateTime AS postDateTime,
                      addressCities.name AS cityName, addressProvinces.name AS provinceName
               FROM posts
               LEFT JOIN users ON posts.userID = users.userID
               LEFT JOIN cities AS addressCities ON addressCities.cityID = posts.cityID
               LEFT JOIN provinces AS addressProvinces ON addressProvinces.provinceID = posts.provinceID
               WHERE postID='$id'";

$resultPosts = executeQuery($queryPosts);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMD | Edit Post</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="images/socialMediaLogo.png" type="image/png">

</head>

<body style="font-family: 'Montserrat', sans-serif;">
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <div class="card shadow rounded-5 p-5">
          <div class="h3 text-center">
            <b>EDIT POST</b>
          </div>

          <?php
          if (mysqli_num_rows($resultPosts) > 0) {
            while ($post = mysqli_fetch_assoc($resultPosts)) {
              ?>

              <form method="post">
                <textarea class="mt-3 form-control" name="content" placeholder="Content"
                  required><?php echo $post['content'] ?></textarea>
                <input value="<?php echo $post['privacy'] ?>" class="mt-3 form-control" type="text" name="privacy"
                  placeholder="Privacy" required>
                <button class="mt-5 btn btn-primary" type="submit" name="btnEdit">
                  Save
                </button>
              </form>

              <?php
            }
          }
          ?>

        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>