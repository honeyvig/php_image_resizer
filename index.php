<?php  
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Resize in PHP</title>
    <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <style>
        :root{
            --bs-success-rgb:71, 222, 152 !important;
        }
        html,body{
            height:100%;
            width:100%;
        }
        .display-img{
            object-fit:scale-down;
            object-position:center center;
            height:35vh;
        }
    </style>
</head>
<body>
    <main>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient" id="topNavBar">
        <div class="container">
            <a class="navbar-brand" href="./">
            Image Resize in PHP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($page == 'home')? 'active' : '' ?>" aria-current="page" href="./">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-3" id="page-container">
        <?php 
            if(isset($_SESSION['flashdata'])):
        ?>
        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
        <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
            <?php echo $_SESSION['flashdata']['msg'] ?>
        </div>
        <?php 
            unset($_SESSION['flashdata']);
            endif;
        ?>
        <h3 class="fw-bold">Image Resize in PHP using GD Library</h3>
        <hr>
        <small>This is a simple web-application that saving and resizing the size of uploaded image file.</small>
 
        <div class="col-12 row row-cols-2 gx-5 py-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="upload_file.php" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image to Upload</label>
                                <input class="form-control form-control-sm rounded-0" type="file" name="image" id="formFile" accept="image/png,image/jpeg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="height" class="control-label">Height</label>
                            <input type="number" name="height" id="height" value="50" class="form-control form-control-sm rounded-0 text-end" required>
                        </div>
                        <div class="form-group">
                            <label for="width" class="control-label">Width</label>
                            <input type="number" name="width" id="width" value="50" class="form-control form-control-sm rounded-0 text-end" required>
                        </div>
                        <div class="form-group d-flex justify-content-end my-3">
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary rounded-0" type="submit">Upload</button>
                                <button class="btn btn-sm btn-dark rounded-0" type="reset">Reset</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
 
            </div>
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-body h-100 d-flex justiy-content-center align-items-center">
                        <?php 
                            $original_file = "./upload/original.png";
                            $resized_file = "./upload/resized.png";
                        ?>
                        <?php if(!is_file($original_file) && !is_file($resized_file)): ?>
                            <div class="text-center w-100 lh-1">
                                <h3 class="fw-bolder">Please Upload Image First</h3>
                                <center><hr style="width:30% !important;height:3px !important" class="bg-primary rounded-pill bg-opacity-100"/></center>
                                <span class="fs-6 fw-light">Image file will be displayed here.</span>
                            </div>
                        <?php else: ?>
                            <?php
                            list($o_img_width,$o_img_height) = getimagesize($original_file);
                            list($r_img_width,$r_img_height) = getimagesize($resized_file);
                            ?>
                            <div class="w-100 row row-cols-2 gx-5 mx-0">
                                <div class="col-md-6">
                                    <div class="card">
                                        <img src="<?php echo $original_file."?".time() ?>" class='img-top display-img bg-dark' alt="Original Image File">
                                        <div class="card-body">
                                            <div class="rounded-pill px-3 bg-primary text-light fs-5 fw-bolder">Original</div>
                                            <p class="lh-1 mt-2">
                                                <span class="fs-6">Width: </span>
                                                <span class="fs-5 fw-bold"><?php echo $o_img_width ?></span>
                                                <br>
                                                <span class="fs-6">Height: </span>
                                                <span class="fs-5 fw-bold"><?php echo $o_img_height ?></span>
                                            </p>
                                            <center><a class="btn btn-sm btn-primary rounded-pill px-4" href='<?php echo $original_file."?".time() ?>' target='_blank'>View</a></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <img src="<?php echo $resized_file."?".time() ?>" class='img-top display-img bg-dark' alt="Resized Image File">
                                        <div class="card-body">
                                            <div class="rounded-pill px-3 bg-success text-light fs-5 fw-bolder">Resized</div>
                                            <p class="lh-1 mt-2">
                                                <span class="fs-6">Width: </span>
                                                <span class="fs-5 fw-bold"><?php echo $r_img_width ?></span>
                                                <br>
                                                <span class="fs-6">Height: </span>
                                                <span class="fs-5 fw-bold"><?php echo $r_img_height ?></span>
                                            </p>
                                            <center><a class="btn btn-sm btn-primary rounded-pill px-4" href='<?php echo $resized_file."?".time() ?>' target='_blank'>View</a></center>
                                        </div>
                                    </div>
                                </div>
 
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</body>
</html>