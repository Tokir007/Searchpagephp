<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Welcome to Idisscuss!</title>
    <!-- to manage the full screen  -->
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
</head>

<body>
    <?php  include 'partials/_header.php'; ?>
    <?php  include 'partials/_dbconnect.php'; ?>


    <div class="container my-4">
        <h1>iDiscuss - Categories</h1>

        <!-- Fullscreen Carousel -->
        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
            data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/slide 1.avif" class="d-block w-100" alt="Random Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="img/slide 2.avif" class="d-block w-100" alt="Random Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="img/slide 3.jpg" class="d-block w-100" alt="Random Slide 3">
                </div>
            </div>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row">
            <!-- fetch all the categories   -->
            <!-- for loop to iterate the categories  -->
            <?php
         $sql = "SELECT * FROM `categories`";
         $result = mysqli_query($conn, $sql);
         while ($row = mysqli_fetch_assoc($result)) {           
    // card to display the categories
    $id = $row['category_id'];
    $cat = $row['category_name'];
    $desc = $row['category_discription'];
    $randomImageId = rand(1, 1000); // generate random number

    echo '
    <div class="card m-2" style="width: 18rem;">
        <img src="https://picsum.photos/300?random=' . $cat . '" class="card-img-top" alt="Random Image">
        <div class="card-body">
            <h5 class="card-title"><a href="threads.php?catid=' . $id . '">' . $cat . '</a></h5>
            <p class="card-text">' . substr(htmlspecialchars($desc), 0, 90) . '...</p>
            <a href="thread.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
        </div>
    </div>';
}
        ?>

        </div>
    </div>

    <?php  include 'partials/_footer.php';
     ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>