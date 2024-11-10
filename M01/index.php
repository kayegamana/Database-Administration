<?php
include("connect.php");

date_default_timezone_set('Asia/Manila');
$currentDateTime = date("H:i Y-m-d");
if(isset($_POST['btnSubmit'])){
    $content = $_POST['content'];
    $privacy = $_POST['privacy'];
    $postQuery = "INSERT INTO posts(userID, content, dateTime, privacy, isDeleted, attachment, cityID, provinceID) VALUES (1, '$content', '$currentDateTime', '$privacy', 'no', '', 1, 1)";
    executeQuery($postQuery); 
    }

$users = [];

$query = "SELECT 
            users.userID, users.userName, users.email, users.phoneNumber, users.isOnline,
            userinfo.userInfoID, userinfo.firstName, userinfo.lastName, userinfo.birthDay,
            addresses.addressID, addresses.cityID, addresses.provinceID, 
            addressCities.name AS addressCityName, addressProvinces.name AS addressProvinceName,
            posts.postID, posts.content AS postContent, posts.dateTime AS postDateTime,
            posts.privacy, posts.isDeleted, posts.attachment AS postAttachment, 
            posts.cityID, posts.provinceID, postCities.name AS postCityName, postProvinces.name AS postProvinceName
          FROM users
          LEFT JOIN userinfo ON users.userInfoID = userinfo.userInfoID
          LEFT JOIN addresses ON addresses.userInfoID = userinfo.userInfoID
          LEFT JOIN cities AS addressCities ON addressCities.cityID = addresses.cityID
          LEFT JOIN provinces AS addressProvinces ON addressProvinces.provinceID = addresses.provinceID
          LEFT JOIN posts ON posts.userID = users.userID
          LEFT JOIN cities AS postCities ON postCities.cityID = posts.cityID
          LEFT JOIN provinces AS postProvinces ON postProvinces.provinceID = posts.provinceID
          ";

$result = executeQuery($query);

if ($result) {
    // Store user details in an associative array to avoid redundancy
    while ($row = mysqli_fetch_assoc($result)) {
        $userID = $row['userID'];

        // Only add the user details if they are not already in the array
        if (!isset($users[$userID])) {
            $users[$userID] = [
                'firstName' => $row['firstName'],
                'lastName' => $row['lastName'],
                'userName' => $row['userName'],
                'email' => $row['email'],
                'birthDay' => $row['birthDay'],
                'addressCityName' => $row['addressCityName'],
                'addressProvinceName' => $row['addressProvinceName'],
                'isOnline' => $row['isOnline']
            ];
        }
    }
} else {
    // Handle query failure
    echo "<p>Error executing query: " . mysqli_error($connection) . "</p>";
}
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

        .header, .footer {
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
            <div class = "col-12">
                <div class="card p-4 rounded-3 shadow">
                    <form method="post" class="col-12 d-flex flex-column">
                        <input class="form-control form-control-lg mb-3" type="text" name="content" placeholder="What's on your mind?" required>
                        <input class="form-control form-control-lg mb-3" type="text" name="privacy" placeholder="Public or Friends" required>

                        <button type="submit" name="btnSubmit" class="mt-2 btn btn-primary align-self-end">Post</button>
                    </form>
                </div>
            </div>

            <!-- All Users Column -->
            <div class="col-lg-6 mt-5 mb-4 px-5">
                <h3 class="mb-3">Users</h3>
                <?php foreach ($users as $userID => $user): ?>
                    <?php
                    $badgeClass = $user['isOnline'] === "Yes" ? "bg-success" : "bg-secondary";
                    $badgeText = $user['isOnline'] === "Yes" ? "Online" : "Offline";
                    ?>
                    <div class="card rounded-4 shadow mb-3 border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2"> 
                                <span class="badge rounded-pill <?php echo $badgeClass; ?> me-2">
                                    <?php echo $badgeText; ?>
                                </span>
                                <h5 class="card-title mb-0">
                                    <?php echo $user["userName"]; ?>
                                </h5>
                                <button class="ms-auto status-badge" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#userDetails<?php echo $userID; ?>" 
                                    onclick="this.textContent = this.textContent === 'Hide Details' ? 'View Details' : 'Hide Details'">
                                    View Details
                                </button>
                            </div>

                            <div class="collapse" id="userDetails<?php echo $userID; ?>">
                                <p class="card-text mb-1"><strong>Name:</strong>
                                    <?php echo $user["firstName"] . " " . $user["lastName"]; ?>
                                </p>
                                <p class="card-text mb-1"><strong>Email:</strong>
                                    <?php echo $user["email"]; ?>
                                </p>
                                <p class="card-text mb-1"><strong>Birthday:</strong>
                                    <?php echo $user["birthDay"]; ?>
                                </p>
                                <p class="card-text mb-1"><strong>Address:</strong>
                                    <?php 
                                    echo (!empty($user["addressCityName"]) && !empty($user["addressProvinceName"])) ?
                                        $user["addressCityName"] . ", " . $user["addressProvinceName"] : "<i>No address available</i>";
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <p class='text-center text-muted'>No users available.</p>
                <?php endif; ?>
            </div>

            <!-- Newsfeed Column -->
            <div class="col-lg-6 mt-5 mb-4 px-5">
                <h3 class="mb-3">Newsfeed</h3>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if (!empty($row["postID"])) { ?>
                            <div class="card rounded-4 shadow mb-4 border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold"><?php echo $row["userName"]; ?></h5>
                                            <small class="text-muted"><?php echo $row["postDateTime"]; ?></small>
                                        </div>
                                        <span class="badge <?php echo ($row["privacy"] === "Public") ? 'badge-public' : 'badge-friends'; ?>">
                                            <?php echo ($row["privacy"] === "Public") ? "Public" : "Friends"; ?>
                                        </span>
                                    </div>
                                    <p class="card-text mt-3 post-content">
                                        <?php echo !empty($row["postContent"]) ? htmlspecialchars($row["postContent"]) : "<i>No content</i>"; ?>
                                    </p>
                                    <?php if (!empty($row["postAttachment"])): ?>
                                        <div class="mt-3">
                                            <img src="<?php echo $row["postAttachment"]; ?>" alt="Attachment" class="img-fluid rounded-3 shadow">
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <strong>Posted from:</strong>
                                            <?php 
                                            echo (!empty($row["postCityName"]) && !empty($row["postProvinceName"])) ?
                                                $row["postCityName"] . ", " . $row["postProvinceName"] : "<i>Location not available</i>";
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php }
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
