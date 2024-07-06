<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>swap</title>
</head>
<body>
    <?php
    $num1 = 6;
    $num2 = 9;
    $num3 = 5;
    echo "<pre><b>original values:</b>
        num1 = $num1
        num2 = $num2
        num3 = $num3
                </pre><br>";
           
    $temp = $num1;
    $num1 = $num3;
    $num3 = $num2;
    $num2 = $temp;
    echo "<pre><b>swapped values:</b>
        num1 = $num1
        num2 = $num2
        num3 = $num3
                </pre><br>";
    $prod = $num1 * $num2 * $num3;
    echo "$num1 * $num2 * $num3 = $prod<br>";
    $ave = $prod / 3;
    echo "<br>the <b>average <b>is : $ave";
    ?>
</body>
</html>