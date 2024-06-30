<?php
//database connection
$connection = new mysqli('localhost','root','','bill_calculation');

//Displaying Data
// making a datas variable and selecting all data from tbl_bill table
$datas = $connection->query("Select * from tbl_bill");
$result =[];
//while loop until row = no. of rows from table tbl_bill
while($row = $datas->fetch_array()){
    //$result = where to store and $row = what to store
    array_push($result, $row);   
}

//Form valadation
if(isset($_POST['btnsubmit'])){
    if(isset($_POST['name']) && !empty($_POST['name'])){
        $name = $_POST['name'];
    }
    else{
        $error_name = "Name field is required";
    }

    if(isset($_POST['item1']) && !empty($_POST['item1'])){
        if(is_numeric($_POST['item1'])){
            $item1 = $_POST['item1'];
        }
        else{
            $error_item1 = "Enter numeric value only!";
        }
    }
    else{
        $error_item1 = "Enter the value of Item 1!";
    }

    if(isset($_POST['item2']) && !empty($_POST['item2'])){
        if(is_numeric($_POST['item2'])){
            $item2 = $_POST['item2'];
        }
        else{
            $error_item2 = "Enter numeric value only!";
        }
    }
    else{
        $error_item2 = "Enter the value of Item 2!";
    }

    if(isset($_POST['item3']) && !empty($_POST['item3'])){
        if(is_numeric($_POST['item3'])){
            $item3 = $_POST['item3'];
        }
        else{
            $error_item3 = "Enter numeric value only!";
        }
    }
    else{
        $error_item3 = "Enter the value of Item 3!";
    }

    if(isset($_POST['discount_percent']) && !empty($_POST['discount_percent'])){
        if(is_numeric($_POST['discount_percent'])){
            if($_POST['discount_percent']<=100){
                $discount_percent = $_POST['discount_percent'];
            }
            else{
                $error_discount_percent = "Enter the discount percent less than 100";
            }
        }
        else{
            $error_discount_percent = "Enter numberic value only!";
        }
    }
    else{
        $error_discount_percent = "Enter the discount percent";
    }
    
    //Calculation of total,discount and total after discount
    if(
        isset($name) &&
        isset($item1) &&
        isset($item2) &&
        isset($item3) &&
        isset($discount_percent)
    ){
        $total = $item1 + $item2 + $item3;
        $discount_amount = ($discount_percent/100) * $total;
        $total_after_discount = $total - $discount_amount;
    }

    //inserting into database
    if(
        isset($name) &&
        isset($item1) &&
        isset($item2) &&
        isset($item3) &&
        isset($discount_percent) &&
        isset($total) &&
        isset($discount_amount) &&
        isset($total_after_discount)
    ){
        $sql = "INSERT INTO tbl_bill
        (name,item1,item2,item3,discount_percent,discount_amount,total,total_after_discount)
        values ('$name',$item1,$item2,$item3,$discount_percent,$discount_amount,$total,$total_after_discount)";
        $connection->query($sql);
    }
    //Just at the biginning before connecting to database to check the value
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill Calculation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 align ="center">Bill Calculation</h1>
        <Form action="" method ="Post">
            <label for="">Recipient Name</label>
            <input type="text" class="form-control" name="name">
            <?php
                if(isset($error_name)){
                    echo $error_name;
                }
            ?>
            <br>
            <label for="">Item 1</label>
            <input type="number" class="form-control" name="item1">
            <?php
                if(isset($error_item1)){
                    echo $error_item1;
                }
            ?>
            <br>
            <label for="">Item 2</label>
            <input type="number" class="form-control" name="item2">
            <?php
                if(isset($error_item2)){
                    echo $error_item2;
                }
            ?>
            <br>
            <label for="">Item 3</label>
            <input type="number" class="form-control" name="item3">
            <?php
                if(isset($error_item3)){
                    echo $error_item3;
                }
            ?>
            <br>
            <label for="">Discount Percent</label>
            <input type="percentage" class="form-control" name="discount_percent">
            <?php
                if(isset($error_discount_percent)){
                    echo $error_discount_percent;
                }
            ?>
            <br>
            <button type="submit" class="btn btn-success" name="btnsubmit" >Calculate</button>
        </Form>
    
        <hr>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Recipient Name</td>
                        <td>Item 1</td>
                        <td>Item 2</td>
                        <td>Item 3</td>
                        <td>Discount Percent</td>
                        <td>Discount Amount</td>
                        <td>Total</td>
                        <td>Total After Discount</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- Applying foreach loop to fetch data from result
                    And creating a new variable $Recipient to display -->
                    <?php foreach($result as $Recipient){ ?>
                        <tr>
                            <td><?php echo $Recipient['id']; ?></td>
                            <td><?php echo $Recipient['name']; ?></td>
                            <td><?php echo $Recipient['item1']; ?></td>
                            <td><?php echo $Recipient['item2']; ?></td>
                            <td><?php echo $Recipient['item3']; ?></td>
                            <td><?php echo $Recipient['discount_percent']; ?></td>
                            <td><?php echo $Recipient['discount_amount']; ?></td>
                            <td><?php echo $Recipient['total']; ?></td>
                            <td><?php echo $Recipient['total_after_discount']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
    </div>
</body>
</html>