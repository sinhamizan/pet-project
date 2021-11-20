<?php 

  session_start();

  if( !isset( $_SESSION['email'] ) ) {
    header( 'location: index.php' );
  }

  include_once 'partials/header-primary.php';
  include_once 'db.php';

  $sql = "SELECT * FROM adopt_pets ORDER BY id DESC";
  $get_ads = mysqli_query( $con, $sql );

?>


  <section class="buy_top buy_sell">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12">
          <div class="buy_icon">
            <img src="assets/imgs/cart.svg" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="buy_sell_page">
    <section class="tips_middle">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-xl-12 col-md-12">
            <div class="buy_title">
              <h3>adopt a pets</h3>
            </div>
          </div>
          <div class="col-lg-12 col-xl-12 col-md-12">
            <div class="new_ads">
              <a href="adoption-form.php"><i class="fas fa-plus"></i> adopt pets</a>
            </div>
          </div>
          <?php while( $ads = mysqli_fetch_assoc( $get_ads ) ): ?>
            <div class="col-lg-3 col-xl-3 col-md-3">
              <div class="buy_pets">
                <div class="single-item">
                  <div class="single_ads adoption">
                    <div class="img-outer">
                      <a href="single-adoption.php?id=<?php echo $ads['id']; ?>"><img src="uploads/adopts/<?php echo $ads['pet_img']; ?>" alt="Pet Image"></a>
                    </div>
                    <a href="single-adoption.php?id=<?php echo $ads['id']; ?>"><?php echo $ads['pet_name']; ?></a>
                    <p><i class="fas fa-map-marker-alt"></i><?php echo $ads['location']; ?></p>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
      </div>
    </section>
  </div>


<?php include_once 'partials/footer.php'; ?>