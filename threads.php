<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Welcome to iDiscuss!</title>
    <style>
    .carousel,
    .carousel-inner,
    .carousel-item,
    .carousel-item img {
        height: 100vh;
    }

    .carousel-item img {
        object-fit: cover;
        width: 100%;
    }
    </style>
</head>

<body>
    <?php
    include 'partials/_header.php';
    include 'partials/_dbconnect.php';

    $id = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
    $carname = "Unknown Category";
    $catdesc = "No description available.";

    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $carname = $row['category_name'];
        $catdesc = $row['category_discription'];
    }
    ?>

    <!-- Jumbotron -->
    <div class="container my-4">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to <?php echo htmlspecialchars($carname); ?></h1>
                <p class="col-md-8 fs-4"><?php echo htmlspecialchars($catdesc); ?></p>
                <button class="btn btn-primary btn-lg" type="button">Learn more</button>
            </div>
        </div>
    </div>

    <!-- Browse Questions Section -->
    <div class="container my-5">
        <h1 class="mb-4">Browse Questions</h1>
        <?php
        $noResult = true;
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";      
        $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
       $noResult = false;
       $thread_id = $row['thread_id'];
       $title = htmlspecialchars($row['thread_title']);
       $desc = htmlspecialchars($row['thread_desc']);
       $thread_user_id = $row['thread_user_id'];

    // Fetch user email
     $sql2 = "SELECT user_email FROM `user` WHERE sno = $thread_user_id";
        $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_assoc($result2);
    $user_email = isset($row2['user_email']) ? htmlspecialchars($row2['user_email']) : 'Anonymous';

    echo '
    <div class="d-flex align-items-start mb-4">
        <img src="img/user.jpg" alt="User" width="64" height="64" class="me-3 rounded-circle">
        <div>
            <h5 class="mb-1"><a href="threads1.php?threadid=' . $thread_id . '">' . $title . '</a></h5>
            <p class="mb-1">' . $desc . '</p>
            <small class="text-muted">Posted by ' . $user_email . '</small>
        </div>
    </div>';
}


        if ($noResult) {
            echo "<p class='text-muted'>No threads found in this category.</p>";
        }
        ?>
    </div>

    <!-- Ask a Question Form -->
    <div class="container my-5">
        <h2>Ask a Question</h2>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <div class="form-group mb-3">
                <label for="thread_title">Threads Title</label>
                <input type="text" class="form-control" id="thread_title" name="thread_title" required>
            </div>
            <div class="form-group mb-3">
                <label for="thread_desc">Threads Description</label>
                <textarea class="form-control" id="thread_desc" name="thread_desc" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <?php 
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    $th_title = mysqli_real_escape_string($conn, $_POST['thread_title']);
    $th_desc = mysqli_real_escape_string($conn, $_POST['thread_desc']);

   $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `timestamp`) 
        VALUES ('$th_title', '$th_desc', '$id', current_timestamp())";
 
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        echo '<div class="alert alert-success" role="alert">
                Your thread has been posted successfully.
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Something went wrong. Please try again.
              </div>';
    }
}
?>


    <?php include 'partials/_footer.php'; ?>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>