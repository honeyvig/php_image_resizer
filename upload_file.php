    <?php 
    session_start();
    // creating the upload directory if doesn't exists
    if(!is_dir('./upload'))
    mkdir('./upload');
    // Extracting the POST Data into variables
    extract($_POST);
    if(isset($_FILES['image']) && !empty($_FILES['image'])){
        //Image File Uploaded
        $upload = $_FILES['image'];
        // Identifing File Mime Type
        $type = mime_content_type($upload['tmp_name']);
        // Valid File types
        $valid_type = array('image/png','image/jpeg');
        if(!in_array($type,$valid_type)){
            $_SESSION['flashdata']['type']="danger";
            $_SESSION['flashdata']['msg']="Image File type is invalid.";
        }else{
            // new size variables
            $new_height = $height; // $height :: $_POST['height']
            $new_width = $width; // $width :: $_POST['width']
     
            // Get the original size
            list($width, $height) = getimagesize($upload['tmp_name']);
     
            // creating a black image as representaion for the image new size
            $t_image = imagecreatetruecolor($new_width, $new_height);
     
            // Creating the GD Image from uploaded image file
            $gdImg = ($type =='image/png') ? imagecreatefrompng($upload['tmp_name']) : imagecreatefromjpeg($upload['tmp_name']);
     
            //Resizing the imgage
            imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
     
            // The following scripts are just for saving the image files in a directory only
     
            //Remove the existing resized file
            if(is_file('./upload/resized.png'))
            unlink('./upload/resized.png');
     
            // saving the resized file in a directory as a PNG file
            imagepng($t_image,__DIR__.'/upload/resized.png');
            // destroying the created image after saving
            imagedestroy($t_image);
     
     
            //Remove the previous uploaded original file
            if(is_file('./upload/original.png'))
            unlink('./upload/original.png');
     
            // saving the original file in a directory as a PNG file
            imagepng($gdImg,__DIR__.'/upload/original.png');
            // destroying the created image after saving
            imagedestroy($gdImg);
     
     
            $_SESSION['flashdata']['type']="success";
            $_SESSION['flashdata']['msg']="Image convertion is successfull.";
     
        }
     
    }else{
        $_SESSION['flashdata']['type']="danger";
        $_SESSION['flashdata']['msg']="Image File is required.";
    }
    header("location:./");
    exit;