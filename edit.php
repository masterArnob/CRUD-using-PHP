<?php
include('config/config.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$id";
    try{
        $query = mysqli_query($con, $sql);
        if($data = mysqli_fetch_assoc($query)){
            $id = $data['id'];
            $name=$data['name'];
            $price=$data['price'];
            $desc=$data['description'];
            $img = $data['image'];
            $pic = "images/$img";
            $oldImage = "<img src='$pic' width=70px>";

        }
    }catch(mysqli_sql_exception $e){
        echo $e->getMessage();
    }
}

if(isset($_POST['update'])){
    $id = $_GET['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $oldImg = $img;
    $newImg = $_FILES['upfile']['name'];
    $newImgOldLocation = $_FILES['upfile']['tmp_name'];
    $newImgNewLocation = "images/$newImg";
    
    if($newImg != ''){
        $update_fileName = $newImg;
        if(move_uploaded_file($newImgOldLocation, $newImgNewLocation)){
            header('location: index.php');
            unlink("images/$oldImg");
        }
    }else{
        $update_fileName = $oldImg;
    }

 

    $sql = "UPDATE products SET name='$name', price='$price', description='$desc', image='$update_fileName' WHERE id=$id";
    try{
        mysqli_query($con, $sql);
        header('location: index.php');
        echo "Updated";
    }catch(mysqli_sql_exception $e){
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>


<section class="update-section">
    <div class="container">
        <div class="text-center">
            <h2 class="display-6 mb-3">Update Product</h2>
            <?php echo $oldImage?>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data" >
        

<label for="Image" class="form-label">Image:</label>
        <input type="file" name="upfile" class="form-control" accept=".jpg, .jpeg, .png, .JPG, .JPEG, .PNG">


        <br>

        <label for="Name" class="form-label">Product Name:</label>
        <div class="input-group">
            <div class="input-group-text">
            <i class="bi bi-box2-fill"></i>
            </div>
            <input type="text" name="name" value="<?php echo $name?>" class="form-control">

        </div>
       
      
       
        <br>
        <label for="price" class="form-label">Product Price:</label>
        <div class="input-group">
            <div class="input-group-text">
            <i class="bi bi-tag-fill"></i>
            </div>
            <input type="number" name="price" value="<?php echo $price?>" class="form-control">
        </div>

       
       
       


        <div class="form-floating my-3">
        <textarea name="description" style="height: 140px;" class="form-control"><?php echo $desc?></textarea>
        <label for="description" class="form-label">Description:</label>
        </div>

       
       <div class="text-center my-3">
       <button name="update" class="btn btn-outline-danger">Update</button>
       </div>
       
    </form>

            </div>
        </div>
    </div>
</section>







    
</body>
</html>