<?php 
session_start();
include_once 'db.php';
  
  $author_id = $_SESSION['id'];

  if( isset ( $_POST[ 'post' ] ) ) {
    $post_text = $_POST[ 'post_text' ];
    $post_file = $_FILES['image'];

    date_default_timezone_set("Asia/Dhaka");
    $post_date = date("d-m-Y, h:ia");

    $file_name = $post_file[ 'name' ];
    $file_tmp_name = $post_file[ 'tmp_name' ];
    $file_loc = 'uploads/posts/' . $file_name;

    move_uploaded_file( $file_tmp_name, $file_loc );

    if( $post_text != '' && $post_file != '' ) {
      $sql = "INSERT INTO posts( author_id, post_text, post_file, post_date ) VALUES( '$author_id', '$post_text', '$file_name', '$post_date' )";
      $get_post = mysqli_query( $con, $sql );

      if( $get_post ) {
        header( 'location:home.php' );
      } else {
        header( 'location:author-profile.php' );
      }
    } else {
      echo "All Fields are Required!";
    }
  }


?>
<html>
    <head>
        <title>Crop Before Uploading Image using Cropper JS & PHP</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
        <link href="assets/css/cropper.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
        
    </style>
    <body>
        <div class="container">
            <form action="" method="POST" enctype="multipart/form-data">
              <textarea class="form-control" name="post_text" placeholder="Enter your text here...."></textarea>
              <label for="">Photo</label> <br>
              <input type="file" name="image" class="image">
              <input class="post_submit" type="submit" value="Post" name="post">
            </form>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">  
                                    <img id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/cropper.min.js" type="text/javascript"></script>
<script>

    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;
   

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "cropper.php",
                    data: {image: base64data},
                    success: function(data) { 
                        bs_modal.modal('hide');
                        alert("success upload image");
                    }
                });
            };
        });
    });

</script>
</body>
</html>