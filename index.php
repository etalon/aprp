<?php

include("classes/ArrayPrintRParser.php");

if (isset($_POST["printrstring"])) {
    $aprp = new ArrayPrintRParser($_POST["printrstring"]);
    $phpString = '$a = ' . $aprp->PhpString();
} else {
    $phpString = "not available";
}

?>

<html>
<head>
    <title>Array-Print_R-Parser</title>
</head>

<body style="font-family: 'Courier New';background-color: lavender">

<h1>Array-Print_R-Parser</h1>

<h2>&copy;2015 by <a href="http://blog.hantschel.info">Jens Hantschel</a></h2>

<form name="aprp" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

    <p>Put your Array-Output (via Print_R) here:</p>
    <textarea name="printrstring" rows="10" cols="100">Array ( [foo] => Array ( [0] => Array ( [0] => aa [1] => bb [2] => cc ) [1] => Array ( [0] => 3 [1] => 4 [2] => 5 ) ) )</textarea><br/>
    <input type="submit" name="send" value="Convert"/><br/>

    <p>The result you can use in PHP:</p>
    <textarea name="phpstring" rows="10" cols="100"><?= $phpString ?></textarea><br/>

</form>
</body>
</html>
