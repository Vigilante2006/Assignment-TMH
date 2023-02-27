<?php

//Establish  the connection between mysql  and php
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die('connection to this database failed due to :' . mysqli_connect_error());
} else {

    if (isset($_POST["name"]) && !empty($_POST["name"])) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];

        //Insert the data from user input to database
        if ($name != '') {
            $sql = "INSERT INTO `student`.`student` (`name`, `gender`, `phone`, `city`) VALUES ('$name', '$gender','$phone','$city');";
        }
        if ($conn->query($sql) == true) {
            header('Location: index.php');
        } else {
            echo "<script>alert($conn->error)</script>";
        }
    }

    //Delete the specifi data from the database 
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM `student`.`student` WHERE s_no = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>console.log('Record deleted successfully')</script>";
        } else {
            echo "<script>alert($conn->error)</script>";
        }
    }


    // Retrieve the data from the database
    $sql = "SELECT * FROM `student`.`student` ";
    $result = $conn->query($sql);

    // Create an array to hold the data
    $data = array();

    // Loop through the result set and add each row to the array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert the data to a JSON object
    $json_data = json_encode($data);


}
?>

<!-- HTMl Code  -->

<!DOCTYPE html>
<html lang="en" title="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo Project</title>
    <link rel="stylesheet" href="index.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <main>
        <form id="formToggle" method="post" action="index.php">
            <h1>Studend Form</h1>
            <input id="name" name="name" type="text" placeholder="Full name">
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <input id="phone" name="phone" type="text" placeholder="Phone number">
            <input id="city" name="city" type="text" placeholder="City">
            <button>Submit</button>
        </form>
        <div class="mainTable">
            <section class="tableHeader">
                <h1>Student's Detail</h1>
            </section>
            <section class="tableBody">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Student Name</th>
                            <th>Gender</th>
                            <th>phone</th>
                            <th>City</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyList">
                    </tbody>
                </table>
            </section>
        </div>
    </main>

    <!-- Javascript -->

    <script>
        var data = <?php echo $json_data ?>
            // console.log(data);
        var tableList = ''
        data.map(
            (item, index) =>
            (tableList += `<tr>
    <td>${index + 1}</td>
    <td>${item.name}</td>
    <td>${item.gender}</td>
    <td>${item.phone}</td>
    <td>${item.city}</td>
    <td>
      <button class="deleteStudent" name='delete' onclick="deleteData(${item.s_no})"><ion-icon name="trash-outline"></ion-icon></button>
    </td>
  </tr>`
            ),
        )

        document.getElementById('tableBodyList').innerHTML = tableList
    </script>
    <script src="index.js"></script>
</body>

</html>