<?php
 include_once("includes/logged.php");

// getting selected car id 
if (isset($_GET["car_id"])) {
    include_once("includes/conn.php");
    $carid = $_GET["car_id"];
    try{
        $sql = "DELETE FROM `cars` WHERE `id`= ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$carid]);
        echo "deleted";
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();}
}else{
        echo "INVALID REQUEST";
    }

   ?>