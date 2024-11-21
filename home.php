<!--This is home button at topNavigation-->

<?php require_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Carousel and General Styles -->
<style>
    /* Carousel Styles */
    #carouselExampleControls {
      margin-top: 130px; /* Remove the top margin from the carousel */
      margin-bottom: 30px; /* Add space below carousel */
    }

    /* Optional: Styles for the carousel */
    .carousel-item img {
      width: 100%; /* Full width */
      height: 500px; /* Maintain aspect ratio */
      object-fit: contain; /* Ensure images cover the container without distortion */
    }

    /* Optional: If you want to make the carousel more visually appealing */
    .carousel-inner {
      height: 500px; /* Adjust carousel height */
    }

    /* Products Section Styles */
    .products-section {
      margin-top: -50px; /* Add space between carousel and products */
    }

    .card-body {
      padding: 15px; /* Adjust padding for a cleaner look */
    }

    .product-img-holder img {
      width: 100%; /* Make sure images take full width */
      height: 200px; /* Set a fixed height for images */
      object-fit: cover; /* Ensure images fill container */
    }
</style>
</head>
<body class="layout-top-nav layout-fixed layout-navbar-fixed" style="height: auto;">
  <div class="wrapper">

    <!-- Carousel -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./uploads/1.jpg" class="d-block w-100" alt="Image 1">
        </div>
        <div class="carousel-item">
          <img src="./uploads/2.jpg" class="d-block w-100" alt="Image 2">
        </div>
        <div class="carousel-item">
          <img src="./uploads/3.jpg" class="d-block w-100" alt="Image 3">
        </div>
        <div class="carousel-item">
          <img src="./uploads/4.jpg" class="d-block w-100" alt="Image 4">
        </div>
        <div class="carousel-item">
          <img src="./uploads/5.jpg" class="d-block w-100" alt="Image 5">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <!-- Products Section -->
    <div class="col-lg-12 py-5 products-section">
      <div class="container-fluid">
        <hr style="height: 5px; background-color: #ff7200;">
        <div class="clear-fix mb-3"></div>
        <h3 class="text-center"><b>Products </b></h3>
        <center><hr class="w-25"></center>
        <div class="row" id="product_list">
          <?php 
            $products = $conn->query("SELECT p.*, v.shop_name as vendor, c.name as `category` FROM `product_list` p inner join vendor_list v on p.vendor_id = v.id inner join category_list c on p.category_id = c.id where p.delete_flag = 0 and p.`status` =1 order by RAND() limit 4");
            while($row = $products->fetch_assoc()):
          ?>
          <div class="col-lg-3 col-md-6 col-sm-12 product-item">
            <a href="./?page=products/view_product&id=<?= $row['id'] ?>" class="card shadow rounded-0 text-reset text-decoration-none">
              <div class="product-img-holder position-relative">
                <img src="<?= validate_image($row['image_path']) ?>" alt="Product-image" class="img-top product-img bg-gradient-gray">
              </div>
              <div class="card-body border-top border-gray">
                <h5 class="card-title text-truncate w-100"><b><?= $row['name'] ?></b></h5>
                <div class="d-flex w-100">
                  <div class="col-auto px-0"><small class="text-muted">Vendor: </small></div>
                  <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="text-truncate m-0"><small class="text-muted"><?= $row['vendor'] ?></small></p></div>
                </div>
                <div class="d-flex">
                  <div class="col-auto px-0"><small class="text-muted">Category: </small></div>
                  <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="text-truncate m-0"><small class="text-muted"><?= $row['category'] ?></small></p></div>
                </div>
                <div class="d-flex">
                  <div class="col-auto px-0"><small class="text-muted">Price: </small></div>
                  <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><?= format_num($row['price']) ?></small></p></div>
                </div>
                <p class="card-text truncate-3 w-100"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
              </div>
            </a>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="clear-fix mb-2"></div>
        <div class="text-center">
          <a href="./?page=products" class="btn btn-large btn-primary rounded-pill col-lg-3 col-md-5 col-sm-12">Explore More Products</a>
        </div>
      </div>
    </div>

  </div>
</body>
</html>
