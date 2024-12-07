<?php
include 'header.php';
include '../db/connection.php';

// Query to fetch all orders
$query = "SELECT * FROM orders";  // Assuming orders table is already available
$result = mysqli_query($conn, $query);
?>

<style>
    .center {
        align-items: flex-start;
    }
    table {
        font-family: "sans";
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    td, th {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<main>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Address</th>
            <th>Payment Type</th>
            <th>Actions</th>
        </tr>

        <?php
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($data['name']) . "</td>";
            echo "<td>" . htmlspecialchars($data['quantity']) . "</td>";
            echo "<td>&#8377;" . htmlspecialchars($data['totalPrice']) . "</td>";
            echo "<td>" . htmlspecialchars($data['address']) . "</td>";
            echo "<td>" . htmlspecialchars($data['paymentType']) . "</td>";
            echo "<td>
                    <form action='order/confirmOrder.php' method='post'>
                        <input type='hidden' name='name' value='" . $data['name'] . "'>
                        <button class='btn btn-outline-success' type='submit' name='confirmOrder'>Confirm Order</button>
                    </form>
                    <form action='order/rejectOrder.php' method='post' onsubmit='return confirm(\"Are you sure you want to reject and delete this order?\");'>
                        <input type='hidden' name='name' value='" . $data['name'] . "'>
                        <button class='btn btn-outline-danger' type='submit' name='rejectOrder'>Reject Order</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
</main>

<?php
mysqli_close($conn);
?>
