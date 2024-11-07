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
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Da Deebugers</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="Home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Browse Charity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="displaydonor.php">Donation History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="OrgName" placeholder="Enter Org Id Or Name">
        <select name="fil">
            <option value="">All</option>
            <option value="Orphanage">Orphanage</option>
            <option value="Health Clinic">Health Clinic</option>
            <option value="Food Bank">Food Bank</option>
            <option value="Community Center">Community Center</option>
            <option value="Animal Shelter">Animal Shelter</option>
        </select>
        <input type="submit" value="Search" class="btn btn-primary">
    </form>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Donate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="OId" class="form-label">Organization ID</label>
                            <input type="text" class="form-control" id="OId" name="OId" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="DonorId" class="form-label">Donor ID</label>
                            <input type="text" class="form-control" id="DonorId" name="DonorId" placeholder="GHI789JK" value="GHI789JK" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="Date" class="form-label">Donation Date</label>
                            <input type="date" class="form-control" id="Date" name="Date" required>
                        </div>
                        <div class="mb-3">
                            <label for="DonationId" class="form-label">Donation ID</label>
                            <input type="text" class="form-control" id="DonationId" name="DonationId" value="<?php echo uniqid(); ?>" required readonly></div>
                        <div class="mb-3">
                            <label for="Cname" class="form-label">Charity Name</label>
                            <input type="text" class="form-control" id="Cname" name="Cname" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="num" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="num" name="num" step=".01">
                        </div>
                        <button type="submit" class="btn btn-primary">Donate</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> 

<?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Database connection parameters
        $servername = "localhost";
        $username = "Charity";
        $password = "0617092105";
        $dbname = "charity";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if 'OrgName' and 'fil' keys exist in $_POST array
        if (isset($_POST["OrgName"]) && isset($_POST["fil"])) {
            // Retrieve values from $_POST array
            $searchKey = $_POST["OrgName"];
            $filter = $_POST["fil"];

            // Construct SQL query based on search key and filter
            $sql = "SELECT * FROM organizations";

            // Append WHERE clause if search key or filter is provided
            if (!empty($searchKey)) {
                $sql .= " WHERE CharityName LIKE '%$searchKey%' or OrganizationId LIKE '%$searchKey%'";
            }
            if (!empty($filter)) {
                if (!empty($searchKey)) {
                    $sql .= " AND ";
                } else {
                    $sql .= " WHERE ";
                }
                $sql .= " OrganizationType = '$filter'";
            }

            // Execute SQL query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output table header
                echo "<table class= 'table table-hover table-bordered table-striped'>";
                echo "<tr><th>Organization ID</th><th>Name</th><th>Type</th><th>Address</th><th>Multiple Locations</th><th>Website</th><th>Phone Number</th><th>Founding Date</th><th>Donation Received</th></tr>";

                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"populateModal('".$row["OrganizationId"]."', '".$row["CharityName"]."')\">";
                    echo "<td>" . $row["OrganizationId"] . "</td>";
                    echo "<td>" . $row["CharityName"] . "</td>";
                    echo "<td>" . $row["OrganizationType"] . "</td>";
                    echo "<td>" . $row["Address1"] . "</td>";
                    echo "<td>" . ($row["MultipleLocations"] ? "True" : "False") . "</td>";
                    echo "<td>" . $row["CharityWebsite"] . "</td>";
                    echo "<td>" . $row["PhoneNumber"] . "</td>";
                    echo "<td>" . $row["FoundingDate"] . "</td>";
                    echo "<td>" . $row["CumulativeDonationReceived"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        }

        // Check if donation form fields are submitted
        if (isset($_POST["OId"]) && isset($_POST["DonorId"]) && isset($_POST["Date"]) && isset($_POST["DonationId"]) && isset($_POST["Cname"]) && isset($_POST["num"])) {
            $OrphanageId = $_POST["OId"];
            $DonorId = "GHI789JK"; // Assuming this is a fixed value
            $Date = $_POST["Date"];
            $DonationId = $_POST["DonationId"]; // Assuming this is generated by uniqid()
            $CharityName = $_POST["Cname"];
            $Amount = $_POST["num"];

            // Prepare and execute SQL query for donation insertion
            $sql = "INSERT INTO donation (OrganizationId, DonorId, DonationId, DonationDate, Amount, CharityName)
            VALUES ('$OrphanageId', '$DonorId', '$DonationId', '$Date', '$Amount', '$CharityName')";
            if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        }

        // Close database connection
        $conn->close();
    }
?>

    <div class="col-lg-12 text-center">
        <button type="button" class="btn-primary btn" data-bs-toggle="modal" data-bs-target="#myModal">Donate</button>
    </div>
<script>
        // Function to populate modal with data from clicked row
        function populateModal(OrgId, CharityName) {
            // Populate modal fields with data from the clicked row
            document.getElementById('OId').value = OrgId;
            document.getElementById('Cname').value = CharityName;

            // Open the modal
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
        }
</script>
</body>
</html>
