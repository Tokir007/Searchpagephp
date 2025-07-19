<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thread Details - iDiscuss!</title>
</head>

<body>

    <?php
include 'partials/_header.php';
include 'partials/_dbconnect.php';

$thread_id = isset($_GET['threadid']) ? intval($_GET['threadid']) : 0;

// Fetch the thread
$sql = "SELECT * FROM `threads` WHERE thread_id = $thread_id";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $title = htmlspecialchars($row['thread_title']);
    $desc = htmlspecialchars($row['thread_desc']);
    $catid = $row['thread_cat_id'];
} else {
    echo "<div class='container my-5'><div class='alert alert-danger'>Thread not found.</div></div>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $sql = "INSERT INTO `comments` (`comments_content`, `threads_id`, `comments_time`, `comments_by`) 
            VALUES ('$comment', $thread_id, current_timestamp(), 0)";
    $inserted = mysqli_query($conn, $sql);
    if ($inserted) {
        echo "<div class='container'><div class='alert alert-success'>Your answer has been posted.</div></div>";
    } else {
        echo "<div class='container'><div class='alert alert-danger'>Failed to post answer.</div></div>";
    }
}
?>

    <!-- Jumbotron -->
    <div class="container my-4">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold"><?php echo $title; ?></h1>
                <p class="col-md-8 fs-4"><?php echo $desc; ?></p>
            </div>
        </div>
    </div>


   <!-- Answer Form -->
<div class="container my-5">
    <h2>Post Your Answer</h2>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <div class="form-group mb-3">
            <label for="comment">Your Answer</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post Answer</button>
    </form>
</div>

<!-- Display Comments -->
<div class="container my-5">
    <h2>Answers</h2>
    <?php
    
    $noResult = true;
    $sql = "SELECT * FROM `comments` WHERE 	threads_id = $thread_id ORDER BY comments_time DESC";      
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $comment_content = htmlspecialchars($row['comments_content']);
        $timestamp = $row['comments_time'];

        echo '
        <div class="d-flex align-items-start mb-4">
        <img src="img/user.jpg" alt="User" width="64" height="64" class="me-3 rounded-circle">
        <div>
            <h6 class="mb-1 fw-bold">Anonymous user</h6>
            <p class="mb-1">' . $comment_content . '</p>
            <small class="text-muted">Posted on ' . $timestamp . '</small>
        </div>
    </div>';
    }

    if ($noResult) {
        echo "<p class='text-muted'>No answers yet. Be the first to respond!</p>";
    }
    ?>
</div>

       <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>