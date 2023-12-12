<?php
    require_once("conn.php");
    session_start();

    if(isset($_POST["addToCart"])) {

        $email = $_SESSION['email'];

        $product = isset($_GET['product']) ? $_GET['product'] : "";
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $array = array();
            if($row['cart'] != "")
                $array = unserialize($row['cart']);
            
            if(!in_array($product, $array))
                array_push($array, $product);

            $serialized = serialize($array);
            $sql = "UPDATE users SET cart='$serialized' WHERE email='$email'";
            $conn->query($sql);

            header("Location: /Proiect/index.php#product-$product");
        }
    }

    if(isset($_POST["removeFromCart"])) {
        $email = $_SESSION['email'];

        $product = isset($_GET['product']) ? $_GET['product'] : "";
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $array = array();
            if($row['cart'] != "")
                $array = unserialize($row['cart']);
            $array = array_diff($array, array($product));

            $serialized = serialize($array);
            $sql = "UPDATE users SET cart='$serialized' WHERE email='$email'";
            $conn->query($sql);

            header("Location: /Proiect/assets/php/cos.php");
        }
    }

    if(isset($_POST["addToFavorites"])) {
        $email = $_SESSION['email'];

        $product = isset($_GET['product']) ? $_GET['product'] : "";
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $array = array();
            if($row['favorite'] != "")
                $array = unserialize($row['favorite']);

            if(!in_array($product, $array))
                array_push($array, $product);

            $serialized = serialize($array);
            $sql = "UPDATE users SET favorite='$serialized' WHERE email='$email'";
            $conn->query($sql);

            header("Location: /Proiect/index.php#product-$product");
        }
    }

    if(isset($_POST["removeFromFavorites"])) {
        $email = $_SESSION['email'];

        $product = isset($_GET['product']) ? $_GET['product'] : "";
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $array = array();
            if($row['favorite'] != "")
                $array = unserialize($row['favorite']);

            $array = array_diff($array, array($product));

            $serialized = serialize($array);
            $sql = "UPDATE users SET favorite='$serialized' WHERE email='$email'";
            $conn->query($sql);

            header("Location: /Proiect/index.php#product-$product");
        }
    }
?>