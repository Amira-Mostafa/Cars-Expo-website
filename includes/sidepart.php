<?php
      try{
            $sql = "SELECT categories.id, COUNT(*) as count, categories.category FROM categories JOIN cars ON cars.cat_id = categories.id WHERE cars.activity='Yes' GROUP BY cars.cat_id;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    
    ?>




<div class="col-md-4 sidebar">
            <div class="sidebar-box">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                </div>
              </form>
            </div>

            <div class="sidebar-box">
              <div class="categories">
                <h3>Categories</h3>
                <?php
            foreach ($stmt -> fetchAll() as $result) {
                $id = $result["id"];
                $category = $result["category"];
                $count = $result["count"];
                ?>

                <li><a href="#"><?php echo $category ?> <span>(<?php echo $count;?>)</span></a></li>

            <?php
            }
            ?>
              </div>
            </div>
            <div class="sidebar-box">
              <img src="images/person_1.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid mb-4 w-50 rounded-circle">
              <h3 class="text-black">About The Author</h3>
              <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
              <p><a href="#" class="btn btn-primary btn-md text-white">Read More</a></p>
            </div>

            <div class="sidebar-box">
              <h3 class="text-black">Paragraph</h3>
              <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
            </div>
          </div>
        </div>
      </div>
    </div>