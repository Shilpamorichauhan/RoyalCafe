<?php
session_start();
include '../../db/connection.php';

    $name = $_POST['name'];

    $query = "SELECT * FROM products WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found!'); window.location.href = '../product.php';</script>";
        exit;
    }

    // Check if the form is submitted to update the product
    if (isset($_POST['updateBTN'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $type = $_POST['type'];
        $image = $_FILES['image'];

        // Handle the image upload
        if ($image['error'] == 0) {
            $imageName = $image['name'];
            $imageTmpName = $image['tmp_name'];
            $imageSize = $image['size'];
            $imageType = $image['type'];

            // Allowed image file types
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            if (in_array($imageExt, $allowed)) {
                if ($imageSize < 5000000) { // Max size 5MB
                    // Generate a unique name for the image
                    $newImageName = uniqid('', true) . "." . $imageExt;
                    $imageDestination = "../../public/imgs/" . $newImageName;

                    // Move the uploaded file to the server
                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        // If a new image is uploaded, delete the old image file
                        if (file_exists("../../public/imgs/" . $product['imgname'])) {
                            unlink("../../public/imgs/" . $product['imgname']);
                        }
                    } else {
                        echo "<p>Error moving the uploaded image.</p>";
                    }
                } else {
                    echo "<p>Image size too large. Max size is 5MB.</p>";
                }
            } else {
                echo "<p>Invalid file type. Only JPG, PNG, and GIF images are allowed.</p>";
            }
        } else {
            // If no new image is uploaded, retain the old image name
            $newImageName = $product['imgname'];
        }

        // Update the product details in the database
        $stmt = $conn->prepare("UPDATE products SET imgname = ?, name = ?, description = ?, price = ?, type = ? WHERE name = ?");
        $stmt->bind_param("ssssss", $newImageName, $name, $description, $price, $type, $product['name']);

        if ($stmt->execute()) {
            echo "<script>alert('Product updated successfully!'); window.location.href = '../product.php';</script>";
        } else {
            echo "<p>Error updating product: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>
        <form action="editProduct.php?name=<?php echo urlencode($product['name']); ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Product Price</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Product Type</label>
                <input type="text" id="type" name="type" class="form-control" value="<?php echo htmlspecialchars($product['type']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" id="image" name="image" class="form-control">
                <small class="form-text text-muted">Leave blank to keep the existing image.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="../../public/imgs/<?php echo $product['imgname']; ?>" alt="Current Image" style="max-width: 200px;">
            </div>

            <button type="submit" class="btn btn-primary" name="updateBTN">Update Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
