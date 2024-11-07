
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Da Deebugers</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link "  href="Home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="display_table.php">Browse Charity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"  aria-current="page" href="#"> History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="mb-3">
        <label for="OId" class="form-label">Donor ID</label>
        <input type="text" class="form-control" id="OId" name="OId" placeholder="GHI789JK" value="GHI789JK" required readonly>
        <button type="submit" class="btn btn-primary">View Donation History</button>
    </div>
</form>
<?php
$servername = "localhost";
$username = "Charity";
$password = "0617092105";
$dbname = "charity";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Grab donor ID from post array
    $donorId = $_POST["OId"];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement to fetch donation history for the given donor ID
    $donationSql = "SELECT * FROM donation WHERE DonorId = ?";
    $stmt = $conn->prepare($donationSql);
    $stmt->bind_param("s", $donorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output donation history table
        echo "<h1>Donation History for Donor ID: $donorId</h1>";
        echo "<table class= 'table table-bordered table-striped'>";
        echo "<tr><th>Date</th><th>Amount</th><th>Charity Name</th><th>Donation ID</th><th>Donor ID</th><th>Organization ID</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["DonationDate"] . "</td>";
            echo "<td>" . $row["Amount"] . "</td>";
            echo "<td>" . $row["CharityName"] . "</td>";
            echo "<td>" . $row["DonationId"] . "</td>";
            echo "<td>" . $row["DonorId"] . "</td>";
            echo "<td>" . $row["OrganizationId"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No donation history found for Donor ID: $donorId</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
  

</body>
</html>
