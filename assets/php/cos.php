<?php 
    session_start();
    require_once("conn.php");

    $favorites = array();
    $cart = array();

    if(isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $conn->query($sql);
        if($result->num_rows == 0)
            header("Location: /Proiect/../php/logout.php");
        else {
            $row = $result->fetch_assoc();
            if($row['favorite'] != "")
                $favorites = unserialize($row['favorite']);
            if($row['cart'] != "")
                $cart = unserialize($row['cart']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Google Fonts Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

        <!-- CSS -->
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/swiper.css" />

        <!-- JavaScript -->
        <script src="../js/swiper.js"></script>
        <script src="../js/scrollReveal.js"></script>
        <script src="../js/script.js" defer type="module"></script>
        <title>FashionParty</title>
    </head>
    <body>
        <!-- <div class="dark-mode-toggle-btn">
            <button id="dark-mode-toggle" class="btn btn-border btn-border-black">
                <span class="material-symbols-rounded">brightness_4</span>
            </button>
        </div> -->
        <!-- ============= Header ============= -->
        <header class="header">
            <nav class="header__container container">
                <div class="header__logo">
                    <h1><a href="/Proiect">FashionParty</a></h1>
                </div>
                <ul class="header__links">
                    <li class="header__link">
                        <a href="/Proiect">home</a>
                    </li>
                    <li class="header__link">
                        <a href="/Proiect/index.php#new">new</a>
                    </li>
                    <li class="header__link">
                        <a href="/Proiect/index.php#shop">magazin</a>
                    </li>
                    <li class="header__link">
                        <a href="/Proiect/index.php#trending">trending</a>
                    </li>
                    <!-- <li class="header__link">
                        <a href="#incarcare-poze">incarcare poze</a>
                    </li> -->
                    <li class="header__link">
                        <a href="favorite.php">favorite</a>
                    </li>
                    <li class="header__link">
                        <a href="cos.php" class="active">Cos de cumparaturi</a>
                    </li>
                    <?php if(isset($_SESSION["email"])): ?>
                        <li class="header__link">
                            <a href="../php/cont.php">Cont</a>
                        </li>
                    <?php else: ?>
                        <li class="header__link">
                            <a href="../php/login.php">Login</a>
                        </li>
                    <?php endif;?>
                    <li>
                </ul>
                <div class="header__btn">
                    <span style="--i: 0"></span>
                    <span style="--i: 10"></span>
                    <span style="--i: 20"></span>
                </div>
            </nav>
        </header>

        <section class="section home" id="favorites">
        <?php 
        if(count($cart) > 0) {
            $sql = "SELECT * FROM products WHERE ";
            // var_dump($cart);

            $sql .= "id=" . implode(" OR id=", $cart);

            // echo $sql;
            
            $result = $conn->query($sql);
        }
            // $row = $result->fetch_assoc();
        ?>
        <div class="shop__products products">
            <?php if(count($cart) > 0): ?>
            <?php 
                $sum = 0;  
            ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="swiper-slide product-card" id="product-<?php echo $row['id'];?>" data-id="<?php echo $row['id'] ?>" data-category="<?php echo $row['categorie'];?>" data-image1="<?php echo "../images/" . $row['image_path'] ?>">
                    <div class="product-card__image">
                        <img src="<?php echo "../images/" . $row['image_path'] ?>" alt="<?php echo $row['title'] ?>" />
                    </div>
                    <div class="product-card__description">
                        <form action="../php/productFunctions.php?product=<?php echo $row['id']?>" method="POST">
                        <div class="row">
                            <div class="product-card__title"><?php echo $row['title'] ?></div>
                            <button name="<?php if(in_array($row['id'], $favorites)) echo "removeFromFavorites"; else echo "addToFavorites";?>" class="product-card__btn btn">
                                <span class="material-symbols-rounded" style="<?php if(in_array($row['id'], $favorites)) echo 'color: red';?>">favorite</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="product-card__price"><?php echo $row['price'] . " RON" ?></div>
                            <button name="removeFromCart" class="explore-more btn">Remove from cart</button>
                        </div>
                        </form>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                    </div>
                </div>
                <?php $sum += $row['price'];?>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="display: flex; width: 100%; height: 100vh; justify-content: center; align-items: center">
                    <h1>No products in cart</h1>    
                </div>
            <?php endif; ?>
            </div>
            <div class="display: flex; width: 100%; justify-content: center; align-items: center">
                <h1>Total: <?php echo $sum . " RON";?></h1>
                <button onclick="alert('Comanda plasata')" class="shop__category btn btn-border btn-border-black">Finalizeaza comanda</button>
            </div>
        </section>
    
        <!-- ============= Scroll UP ============= -->
        <button class="scroll-up btn btn-border btn-border-black"><span class="material-symbols-rounded"> arrow_upward </span></button>
    </body>
</html>