<h2?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<action="view_details.php" method="get">
    Search: <input type="text" name="query">
    <input type="submit" value="Search">

    
<!-- sort button adde here -->
<h4>Sort :</h4>
    <form action="view_details.php" method="get">
    <button type="submit" name="sort" value="name">Name</button>
    <button type="submit" name="sort" value="usn">USN</button>
    <button type="submit" name="sort" value="phone">Phone Number</button>
</form>


     
</form>
    <h2>View Details</h2>

    <!-- Display Records -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>USN</th>
            <th>Phone Number</th>
            <th>Delete Record</th>
            <th>Update Record</th>
        </tr>

        <?php
        $conn = new mysqli('localhost', 'root', '', 'wshop');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $search_query = "";
        if (isset($_GET['query'])) {
            $search_query = $_GET['query'];
        }

        $sort_by = "name";
        if (isset($_GET['sort'])) {
            $sort_by = $_GET['sort'];
        }

        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);

        $search_query = "";
        if (isset($_GET['query'])) {
            $search_query = $_GET['query'];
            }

        $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR usn LIKE '%$search_query%' OR phone LIKE '%$search_query%'";

        $sort_by = "name";
        if (isset($_GET['sort'])) {
            $sort_by = $_GET['sort'];
        }

        $sql = "SELECT * FROM students ORDER BY $sort_by";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["usn"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td><form action='delete.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Delete'>
                            </form> </td> <td>
                            <form action='update.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Update'>
                            </form>
                            </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
