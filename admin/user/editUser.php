<?php
include '../header.php';
include '../../db/connection.php';

// Check if email is provided in the POST request
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Query to fetch the user details based on the email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user exists, fetch the user data
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found!'); window.location.href = '../users.php';</script>";
        exit;
    }

    // Update user details if form is submitted
    if (isset($_POST['updateBTN'])) {
        $name = $_POST['name'];
        $password = $_POST['password']; // For simplicity, using plaintext password, not recommended in production.

        // If password is not provided, we don't update it, keep the current one
        if (empty($password)) {
            $password = $user['password']; // Keep the current password if not updated
        }

        // Query to update the user details in the database
        $updateQuery = "UPDATE users SET name = ?, password = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sss", $name, $password, $email);

        if ($updateStmt->execute()) {
            echo "<script>alert('User details updated successfully!'); window.location.href = '../users.php';</script>";
        } else {
            echo "<p>Error updating user: " . $updateStmt->error . "</p>";
        }
    }
} else {
    echo "<script>alert('No email provided!'); window.location.href = '../users.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User Details</h2>
        <form action="editUser.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <small class="form-text text-muted">Leave blank to keep the current password.</small>
            </div>

            <button type="submit" name="updateBTN" class="btn btn-primary">Update User</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    