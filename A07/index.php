<?php
include("connect.php");

date_default_timezone_set('Asia/Manila');
$currentDateTime = date("h:i a Y-m-d");

// (INSERT) Create Post
if (isset($_POST['btnSubmit'])) {
    $content = $_POST['content'];
    $privacy = $_POST['privacy'];
    $postQuery = "INSERT INTO posts(userID, content, dateTime, privacy, isDeleted, attachment, cityID, provinceID) 
                  VALUES (1, '$content', '$currentDateTime', '$privacy', 'No', '', 1, 1)";
    executeQuery($postQuery);
}

// (DELETE) Delete Post
if (isset($_POST['btnDelete'])) {
    $deletePostId = $_POST['deletePostId'];
    $deleteQuery = "DELETE FROM posts WHERE postID = $deletePostId";
    executeQuery($deleteQuery);
}


// (SELECT) Get users and posts
$queryUsers = "SELECT 
                users.*, userinfo.*,
                addresses.cityID AS addressCityID, addresses.provinceID AS addressProvinceID, 
                addressCities.name AS addressCityName, addressProvinces.name AS addressProvinceName
              FROM users
              LEFT JOIN userinfo ON users.userInfoID = userinfo.userInfoID
              LEFT JOIN addresses ON addresses.userInfoID = userinfo.userInfoID
              LEFT JOIN cities AS addressCities ON addressCities.cityID = addresses.cityID
              LEFT JOIN provinces AS addressProvinces ON addressProvinces.provinceID = addresses.provinceID";

$queryPosts = "SELECT posts.*, users.*, posts.dateTime AS postDateTime,
                      addressCities.name AS cityName, addressProvinces.name AS provinceName
               FROM posts
               LEFT JOIN users ON posts.userID = users.userID
               LEFT JOIN cities AS addressCities ON addressCities.cityID = posts.cityID
               LEFT JOIN provinces AS addressProvinces ON addressProvinces.provinceID = posts.provinceID";

$resultUsers = executeQuery($queryUsers);
$resultPosts = executeQuery($queryPosts);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Media Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/socialMediaLogo.png" type="image/png">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .header,
        .footer {
            background-color: #4A90E2;
            box-shadow: 0px 4px 5px 2px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .footer {
            box-shadow: 0px -4px 5px -2px rgba(0, 0, 0, 0.3);
        }

        .status-badge {
            background: transparent;
            border: 3px solid #0d6efd;
            color: #0d6efd;
            border-radius: 10px;
        }

        .card-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-container {
            position: relative;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .delete-button-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-delete {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            width: auto;
        }

        .badge-public {
            background-color: #007bff;
            color: white;
        }

        .badge-friends {
            background-color: #ffc107;
            color: black;
        }

        .post-content {
            font-size: 1.1em;
        }
    </style>
</head>

<body id="body">

    <!-- Header -->
    <div class="d-flex flex-wrap text-center py-2 mb-5 header">
        <h1 class="col-12 mt-4">Social Media Dashboard</h1>
        <p class="col-12 mt-2">Overview of User Engagement and Profiles</p>
    </div>

    <div class="container">
        <div class="row">

            <!-- Form for creating posts -->
            <div class="col-12">
                <div class="card p-4 rounded-3 shadow">
                    <form method="post" class="col-12 d-flex flex-column">
                        <input class="form-control form-control-lg mb-3" type="text" name="content"
                            placeholder="What's on your mind?" required>
                        <input class="form-control form-control-lg mb-3" type="text" name="privacy"
                            placeholder="Public or Friends" required>

                        <button type="submit" name="btnSubmit" class="mt-2 btn btn-primary align-self-end">Post</button>
                    </form>
                </div>
            </div>

            <!-- All Users Column -->
            <div class="col-lg-6 mt-5 mb-4 px-5">
                <h3 class="mb-3">Users</h3>
                <?php
                if (mysqli_num_rows($resultUsers) > 0) {
                    while ($user = mysqli_fetch_assoc($resultUsers)) {
                        $badgeClass = $user['isOnline'] == "Yes" ? "bg-success" : "bg-secondary";
                        $badgeText = $user['isOnline'] == "Yes" ? "Online" : "Offline";
                        ?>
                        <div class="card rounded-4 shadow mb-3 border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge rounded-pill <?php echo $badgeClass; ?> me-2">
                                        <?php echo $badgeText; ?>
                                    </span>
                                    <h5 class="card-title mb-0">
                                        <?php echo $user['userName']; ?>
                                    </h5>
                                    <button class="ms-auto status-badge" data-bs-toggle="collapse"
                                        data-bs-target="#userDetails<?php echo $user['userID']; ?>"
                                        onclick="this.textContent = this.textContent == 'Hide Details' ? 'View Details' : 'Hide Details'">
                                        View Details
                                    </button>
                                </div>

                                <div class="collapse" id="userDetails<?php echo $user['userID']; ?>">
                                    <p class="card-text mb-1"><strong>Name:</strong>
                                        <?php echo $user['firstName'] . " " . $user['lastName']; ?>
                                    </p>
                                    <p class="card-text mb-1"><strong>Email:</strong>
                                        <?php echo $user['email']; ?>
                                    </p>
                                    <p class="card-text mb-1"><strong>Birthday:</strong>
                                        <?php echo $user['birthDay']; ?>
                                    </p>
                                    <p class="card-text mb-1"><strong>Address:</strong>
                                        <?php
                                        echo (!empty($user['addressCityName']) && !empty($user['addressProvinceName'])) ?
                                            $user['addressCityName'] . ", " . $user['addressProvinceName'] : "<i>No address available</i>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center text-muted'>No users available.</p>";
                }
                ?>
            </div>

            <!-- Newsfeed Column -->
            <div class="col-lg-6 mt-5 mb-4 px-5">
                <h3 class="mb-3">Newsfeed</h3>
                <?php
                if (mysqli_num_rows($resultPosts) > 0) {
                    while ($post = mysqli_fetch_assoc($resultPosts)) {
                        ?>
                        <div class="post-container rounded-4 shadow mb-4 border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0 fw-bold"><?php echo $post["userName"]; ?></h5>
                                        <small class="text-muted"><?php echo $post["postDateTime"]; ?></small>
                                        <span
                                            class="badge <?php echo ($post['privacy'] == 'Public') ? 'badge-public' : 'badge-friends'; ?>">
                                            <?php echo $post['privacy']; ?>
                                        </span>
                                    </div>

                                    <!-- Delete Functionality -->
                                    <?php if ($post["userID"] == 1) { ?>
                                        <div class="delete-button-container">
                                            <form method="post">
                                                <input type="hidden" value="<?php echo $post['postID'] ?>" name="deletePostId">
                                                <button class="btn-delete btn btn-danger" name="btnDelete">Delete</button>
                                            </form>
                                            <!-- Edit Functionality -->
                                            <a href="edit.php?id=<?php echo $post['postID'] ?>">
                                                <button class="my-2 py-1 btn btn-primary">Edit</button>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>

                                <p class="post-content mt-4"><?php echo $post['content']; ?></p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong>Posted from:</strong>
                                        <?php echo $post['cityName']; ?>, <?php echo $post['provinceName']; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center text-muted'>No posts found.</p>";
                }
                ?>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="d-flex flex-wrap text-center py-2 mb-0 footer">
        <p class="col-12 mb-0">© 2024 Kaye Gamana | Social Media Dashboard</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>