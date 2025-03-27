<?php
$serverName = "localhost";
$userName= "root";
$password = "";
$conn = mysqli_connect($serverName, $userName, $password);
if($conn){
    // echo "Connection Successful <br>";
}
else{
    // echo "Failed to connect".mysqli_connect_error();
}


$createDatabase = "CREATE DATABASE IF NOT EXISTS prototype2";
if (mysqli_query($conn, $createDatabase)) {
    // echo "Database Created or already Exists <br>";
} else {
    // echo "Failed to create database <br>" . mysqli_connect_error();
}

// Select the created database
mysqli_select_db($conn, 'prototype2');


$createTable = "CREATE TABLE IF NOT EXISTS weather (
    city VARCHAR(255) NOT NULL,
    humidity FLOAT NOT NULL,
    wind FLOAT NOT NULL,
    pressure FLOAT NOT NULL,
    temperature FLOAT NOT NULL,
    icon VARCHAR(255) NOT NULL
);";
if (mysqli_query($conn, $createTable)) {
    //echo "Table Created or already Exists <br>";
} else {
    //echo "Failed to create table <br>" . mysqli_error($conn);
}

   
   if(isset($_GET['q'])){
    $cityName = $_GET['q'];
    //echo $cityName;
    }else{
    $cityName = "Kathmandu";
    }

    $selectAllData = "SELECT * FROM weather where city = '$cityName' ";
    $result = mysqli_query($conn, $selectAllData);
    if (mysqli_num_rows($result) == 0) {
         $url = "https://api.openweathermap.org/data/2.5/weather?&units=metric&appid=eb136d8cad8d35b06b3708919c4936a2&q=".$cityName;
        $response = file_get_contents($url);
        $data = json_decode($response, true); 
        $humidity = $data['main']['humidity'];
        $wind = $data['wind']['speed'];
        $pressure = $data['main']['pressure'];
        $temperature = $data['main']['temp'];
        $icon = $data['weather'][0]['icon'];
    

     $insertData = "INSERT INTO weather (city, humidity, wind, pressure, temperature, icon)
     VALUES ('$cityName', '$humidity', '$wind', '$pressure', '$temperature', '$icon')";


    if (mysqli_query($conn, $insertData)) {
        //echo "Data inserted Successfully";
    } else {
        //echo "Failed to insert data" . mysqli_error($conn);
    }
}

// Fetching data from weather table based on city name again after insertion
$result = mysqli_query($conn, $selectAllData);
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Encoding fetched data to JSON and sending as response
$json_data = json_encode($rows);
header('Content-Type: application/json');
echo $json_data;


?>
