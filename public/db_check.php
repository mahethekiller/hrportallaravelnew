<?php
$conn = mysqli_connect("localhost", "root", "", "hrsale");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
$result = mysqli_query($conn, "DESCRIBE leave_applications");
while($row = mysqli_fetch_array($result)) {
    echo $row['Field'] . "\n";
}
mysqli_close($conn);
