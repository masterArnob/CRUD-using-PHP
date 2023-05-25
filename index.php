<?php
include('config/config.php');

if (isset($_POST['submit'])) {
    $productName = $_POST['name'];
    $porductPrice = $_POST['price'];
    $productDesc = $_POST['description'];
    $fileName = $_FILES['upfile']['name'];
    $oldLocation = $_FILES['upfile']['tmp_name'];
    $newLocation = "images/$fileName";
    $sql = "INSERT INTO products(name, price, description, image)
     VALUES('$productName', '$porductPrice',  '$productDesc', '$fileName')";

    try {

        if (move_uploaded_file($oldLocation, $newLocation) == true) {
            mysqli_query($con, $sql);
            echo "saved";
        }
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
    }
}

//delete 

if (isset($_GET['deleteid']) && isset($_GET['picture'])) {
    $id = $_GET['deleteid'];
    $pic = $_GET['picture'];
    $sql = "DELETE FROM products WHERE id = $id";
    try {
        mysqli_query($con, $sql);
        unlink("images/$pic");
        echo "Deleted";
        header('location:index.php');
    } catch (mysqli_sql_exception $e) {
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
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <section class="add-product">
        <div class="container">
            <div class="text-center">
                <h2>Arnob Store</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                        <label for="Image" class="form-label">Image:</label>
                        <input type="file" name="upfile" class="form-control" required accept=".jpg, .jpeg, .png, .JPG, .JPEG, .PNG">
                        <small class="invalid-feedback">*Image is required</small>

                        <br>
                        <label for="Name" class="form-label">Product Name:</label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="bi bi-box2-fill"></i>
                            </div>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <small class="invalid-feedback">*Product Name is required</small>


                        <br>
                        <label for="price" class="form-label">Product Price:</label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="bi bi-tag-fill"></i>
                            </div>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <small class="invalid-feedback">*Product Price is required</small>



                        <br>
                        <div class="form-floating my-3">
                            <textarea name="description" style="height: 140px;" class="form-control" required></textarea>
                            <label for="description" class="form-label">Description:</label>
                        </div>
                        <small class="invalid-feedback">*Product description is required</small>



                        <div class="text-center">
                            <button name="submit" class="btn btn-outline-danger">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>




    <!--Table Section-->

    <section class="table-section">
        <div class="row justify-content-center">
            <div class="col-lg-10">
            <table class="table text-center table-dark">
        <thead>
            <tr>
                <th scope="col">Product ID</th> <br>
                <th scope="col">Product Name</th><br>
                <th scope="col">Product Price</th><br>
                <th scope="col">Product Description</th><br>
                <th scope="col">Image</th><br>
                <th scope="col">Launch Date</th><br>
                <th scope="col">Action</th><br>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM products";

            try {
                $query = mysqli_query($con, $sql);
                while ($data = mysqli_fetch_assoc($query)) {
                    $id = $data['id'];
                    $name = $data['name'];
                    $price = $data['price'];
                    $desc = $data['description'];
                    $img = $data['image'];
                    $launch_Date = $data['launch_date'];
                    $pic = "images/$img";
                    $image = "<img src='$pic' width=100px>";

                    echo ' <tr class="align-middle text-center">
        <td>' . $id . '</td>
        <td>' . $name . '</td>
        <td>' . $price . '</td>
        <td>' . $desc . '</td>
        <td>' . $image . '</td>
        <td>' . $launch_Date . '</td>
        <td>
          <a href="edit.php?id=' . $id . '" class="btn btn-outline-success text-white">Edit</a>
          <a href="index.php?deleteid=' . $id . '&picture=' . $img . '" class="btn btn-outline-danger text-white">Delete</a>
        </td>
        
      </tr>';
                }
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
            ?>


        </tbody>
    </table>
            </div>
        </div>
    </section>


   




    <script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>