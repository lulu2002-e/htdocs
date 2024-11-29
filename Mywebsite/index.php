<?php

//define the API URL with query parameters
$url ="https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

//decode the json response into php associative array and fetch the API response as json string
$response = file_get_contents($url);
$data = json_decode($response, true);

//data should be valid and contains the results key
if(!$data || !isset($data["results"])){
    die("Error fetching the data from API"); 
    //stop execution and display error if the data is invalid
}

//extract the results arra from decoded data
$result = $data['results'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--title-->
        <title>Assignment2</title>
        <!--picp css for styling-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

</head>
<body>
    <table>
        <thead>
            <tr>
                <!--define table header-->
                <th>Year</th>
                <th>Semester</th>
                <th>The Programs</th>
                <th>Nationality</th>
                <th>Colleges</th>
                <th>Number Of Students</th>
</tr>
</thead>
<tbody>
    <?php
    //loop thro each record in the array
    foreach($result as $student){
        ?>
        <tr>
            <!--display each data point in the table-->
            <td><?php echo $student["year"]; ?></td>
            <td><?php echo $student["semester"]; ?></td>
            <td><?php echo $student["the_programs"]; ?></td>
            <td><?php echo $student["nationality"]; ?></td>
            <td><?php echo $student["colleges"]; ?></td>
            <td><?php echo $student["number_of_students"]; ?></td>
    </tr>
    <?php     
    }
    ?>
    </tbody>
</table>
</body>
</html>
