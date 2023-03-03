<?php
    $con = mysqli_connect("localhost", "user1", "1100", "mysqldb1");

    if (!$con) {
        die("ERROR".mysqli_connect_error());
    }else {
        // echo "ENTRANCE";
    }
    if(isset($_GET['selectType'])) {
        $select = $_GET['selectType'];
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MYSQL HOMEWORK 3</title>
    <link rel="stylesheet" href="index.css?">
</head>
  <body>
    <div class="container">
      <div class="selectHolder">
        <form action="" method="GET">
            <select name="selectType">
                <option value="">Choose Product By</option>
                <option value="brand" <?php echo isset($select) && $select == 'brand' ? 'selected' : ''; ?>>Brand</option>
                <option value="type" <?php echo isset($select) && $select == 'type' ? 'selected' : ''; ?>>Type</option>
                <option value="price" <?php echo isset($select) && $select == 'price' ? 'selected' : '' ?>>Price</option>
            </select>
        
            <?php
                if (isset($select) && !empty($select)) {
                    
                    $query1 = "SELECT DISTINCT(". $select .") FROM `products`";
                    $query1_run = mysqli_query($con, $query1);
                    if ($select != 'price') {
                ?>
                    <select name="select">
                    <option value="">Choose <?php echo $select ?></option>
                <?php   
                    foreach($query1_run as $key => $items) {
                        $value = array_values($items)[0];
                        ?>
                    <option value="<?= $value; ?>" > <?= $value; ?> </option>
                <?php
                    }
                    ?>
                    </select>
                    <?php
                } else {
                    ?>
                    <input type="number" name="from">
                    <input type="number" name="to">
                    <?php
                }
            }
            ?>
            <input type="submit" value="GO">
        </form>
        </div>
        <div class="output">
            <?php
                if (isset($select)) {
                    if ( (isset($_GET['select'])) || (isset($_GET['from']) && isset($_GET['to']) && !empty($_GET['from']) && !empty($_GET['to'])) ) {
                        if($select != 'price'){
                            $filtervalues = $_GET['select'];
                            $filter = $select ." = '". $filtervalues ."'";
                        }else{
                            $from = (empty($_GET['from'])) ? 0 : $_GET['from'] ;
                            $to = (empty($_GET['to'])) ? 0 : $_GET['to'] ;
                            $filter = $select ." > ". $from ." AND ". $select ." < ". $to;
                        }
                        $query2 = "SELECT * FROM `products` WHERE ". $filter;
                        $query2_run = mysqli_query($con, $query2);
                        if (mysqli_num_rows($query2_run) > 0) {
                            foreach($query2_run as $items) { 
                                ?>
                                <div class="itemHolder" id="<?= $items['id']; ?>">
                                    <div class="brand"><?= $items['brand']; ?></div>
                                    <div class="name"><?= $items['name']; ?></div>
                                    <div class="img" style="background: url('<?= $items['img']; ?>');background-size: cover;"></div>
                                    <div class="type"><?= $items['type']; ?></div>
                                    <div class="price"><?= "$".$items['price']; ?></div>
                                    <div class="qty"><?= $items['qty']; ?></div>
                                </div>
                            <?php
                            }
                        }
                    }
                }else {
                    $select = 0;
                    
                }
            ?>  
        </div>
      <div class="addHolder">

      </div>
    </div>
  </body>
</html>
