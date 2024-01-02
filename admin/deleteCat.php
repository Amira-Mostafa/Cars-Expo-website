<?php
 include_once("includes/logged.php");

// getting category id 
 if(isset($_GET["cat_id"])){
    include_once("includes/conn.php");
    $catid = $_GET["cat_id"];

// deleting selected category if it doesn't contain any cars
        try{
            $sql = "DELETE FROM categories WHERE not exists(Select * From cars WHERE cars.cat_id = categories.id) AND categories.id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$catid]);
            if($stmt->rowCount() > 0){
            echo "deleted";
            }else{
             echo "YOU CANNOT DELETE THIS CATEGORY";
            }
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();}               
}else{
        echo "INVALID REQUEST";
    }
   ?>