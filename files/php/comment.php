<!DOCTYPE html>

<head>
    <title>Comment Output</title>
</head>

<body>

    <?php
        $name = $_POST["name"];
        $body = $_POST["body"];
        print $name . "<br><br>" . $body;

        /*
        if (isset($_POST['attatchment']))
        {

        }
        */

    ?>

</body>

</html>