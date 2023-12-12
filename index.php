<?php 
    session_start();
    require_once("./assets/php/conn.php");

    $favorites = array();

    if(isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $conn->query($sql);
        if($result->num_rows == 0)
            header("Location: /Proiect/assets/php/logout.php");
        else {
            $row = $result->fetch_assoc();
            if($row['favorite'] != "")
                $favorites = unserialize($row['favorite']);
        }
    }

    $filter = '';
    if(isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    }

    $sort = '';
    if(isset($_GET['sort'])) {
        $sort = $_GET['sort'];
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
        <link rel="stylesheet" href="assets/css/style.css" />
        <link rel="stylesheet" href="assets/css/swiper.css" />

        <!-- JavaScript -->
        <script src="assets/js/swiper.js"></script>
        <script src="assets/js/scrollReveal.js"></script>
        <script src="assets/js/script.js" defer type="module"></script>
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
                    <h1><a href="./">FashionParty</a></h1>
                </div>
                <ul class="header__links">
                    <li class="header__link">
                        <a href="#home" class="active">home</a>
                    </li>
                    <li class="header__link">
                        <a href="#new">new</a>
                    </li>
                    <li class="header__link">
                        <a href="#shop">magazin</a>
                    </li>
                    <li class="header__link">
                        <a href="#trending">trending</a>
                    </li>
                    <!-- <li class="header__link">
                        <a href="#incarcare-poze">incarcare poze</a>
                    </li> -->
                    <?php if(isset($_SESSION['email'])):?>
                    <li class="header__link">
                        <a href="assets/php/favorite.php">favorite</a>
                    </li>
                    <li class="header__link">
                        <a href="assets/php/cos.php">Cos de cumparaturi</a>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION["email"])): ?>
                        <li class="header__link">
                            <a href="assets/php/cont.php">Cont</a>
                        </li>
                    <?php else: ?>
                        <li class="header__link">
                            <a href="assets/php/login.php">Login</a>
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

        <!-- ============= Home Section ============= -->

        <section class="section home" id="home">
            <div class="home__content swiper">
                <div class="swiper-wrapper">
                    <div class="home__slide swiper-slide">
                        <div class="home__image">
                            <img src="./assets/images/h1.png" alt="home1" />
                        </div>
                        <div class="home__description">
                            <p class="home__sub-heading"></p>
                            <h1 class="home__heading"></h1>
                        </div>
                    </div>
                    <div class="home__slide swiper-slide">
                        <div class="home__image">
                            <img src="./assets/images/h2.png" alt="home2" />
                        </div>
                        <div class="home__description">
                            <p class="home__sub-heading">colecții noi</p>
                            <h1 class="home__heading">desing-uri moderne</h1>
                        </div>
                    </div>
                    <div class="home__slide swiper-slide">
                        <div class="home__image">
                            <img src="./assets/images/h3.png" alt="home3" />
                        </div>
                        <div class="home__description">
                            <p class="home__sub-heading">colecții noi la toate categoriile</p>
                            <h1 class="home__heading"></h1>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#shop" class="home__btn btn shop-btn">achiziționează acum</a>
            <a href="#new" class="home__btn btn go-down-btn">
                <span class="material-symbols-rounded icon">arrow_downward</span>
                <p class="circle-text">Explore more</p>
            </a>
        </section>

        <!-- ============= New Section ============= -->

        <section class="section new" id="new">
            <div class="section__title">
                <h1>noutăți</h1>
            </div>
            <div class="new__container container">
                <!-- <div class="new__btns swiper-btns">
                    <button class="swiper-btn swiper-button-prev btn btn-border btn-border-black" id="arrow-left">
                        <span class="material-symbols-rounded"> arrow_back_ios_new </span>
                    </button>
                    <button class="swiper-btn swiper-button-next btn btn-border btn-border-black" id="arrow-right">
                        <span class="material-symbols-rounded"> arrow_forward_ios </span>
                    </button>
                </div> -->
                <div class="new__content swiper">
                    <div class="new__products products swiper-wrapper"></div>
                </div>
            <?php 
                $sql = "SELECT * FROM products WHERE isNew=1";
                $result = $conn->query($sql);
                // $row = $result->fetch_assoc();
            ?>

            <div class="shop__products products">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="swiper-slide product-card" id="product-<?php echo $row['id'];?>" data-id="<?php echo $row['id'] ?>" data-category="<?php echo $row['categorie'];?>" data-image1="<?php echo "assets/images/" . $row['image_path'] ?>">
                    <div class="product-card__image">
                        <img src="<?php echo "assets/images/" . $row['image_path'] ?>" alt="<?php echo $row['title'] ?>" />
                    </div>
                    <div class="product-card__description">
                        <form action="assets/php/productFunctions.php?product=<?php echo $row['id']?>" method="POST">
                        <div class="row">
                            <div class="product-card__title"><?php echo $row['title'] ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="<?php if(in_array($row['id'], $favorites)) echo "removeFromFavorites"; else echo "addToFavorites";?>" class="product-card__btn btn">
                                <span class="material-symbols-rounded" style="<?php if(in_array($row['id'], $favorites)) echo 'color: red';?>">favorite</span>
                            </button>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="product-card__price"><?php echo $row['price'] . " RON" ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="addToCart" class="explore-more btn">Add to cart +</button>
                            <?php endif; ?>
                        </div>
                        </form>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
            </div>
        </section>

        <!-- ============= Shop Section ============= -->
        <section class="section shop" id="shop">
            <div class="section__title">
                <h1>shop</h1>
            </div>
            <div class="shop__container container">
                <div class="shop__content">
                    <div class="shop__categories">
                        <a href="/Proiect/index.php#shop"><button class="shop__category btn btn-border btn-border-black <?php if($filter == "") echo "selected";?>" data-category="all">tot</button></a>
                        <a href="/Proiect/index.php?filter=barbati#shop"><button class="shop__category btn btn-border btn-border-black <?php if($filter == "barbati") echo "selected";?>" data-category="men">bărbați</button></a>
                        <a href="/Proiect/index.php?filter=femei#shop"><button class="shop__category btn btn-border btn-border-black <?php if($filter == "femei") echo "selected";?>" data-category="women">femei</button></a>
                    </div>
                    <?php if($filter == ""):?>
                    <div class="shop__sorting">
                        <a href="/Proiect/index.php?sort=asc#shop"><button class="shop__category btn btn-border btn-border-black <?php if($sort == "" || $sort == "asc") echo "selected";?>">Sortează ascendent</button></a>
                        <a href="/Proiect/index.php?sort=desc#shop"><button class="shop__category btn btn-border btn-border-black <?php if($sort == "desc") echo "selected";?>">Sortează descendent</button></a>
                    </div>
                    <?php endif;?>
                    <div class="shop__products products">
                    <?php
                $sql = "SELECT * FROM products ORDER BY price ASC";
                if($sort == "desc") {
                    $sql = "SELECT * FROM products ORDER BY price DESC";
                }
                if($filter == "barbati")
                    $sql = "SELECT * FROM products WHERE categorie='men' ORDER BY price ASC";
                else if($filter == "femei")
                    $sql = "SELECT * FROM products WHERE categorie='women' ORDER BY price ASC";
                $result = $conn->query($sql);
                // $row = $result->fetch_assoc();
            ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="swiper-slide product-card" id="product-<?php echo $row['id'];?>" data-id="<?php echo $row['id'] ?>" data-category="<?php echo $row['categorie'];?>" data-image1="<?php echo "assets/images/" . $row['image_path'] ?>">
                    <div class="product-card__image">
                        <img src="<?php echo "assets/images/" . $row['image_path'] ?>" alt="<?php echo $row['title'] ?>" />
                    </div>
                    <div class="product-card__description">
                        <form action="assets/php/productFunctions.php?product=<?php echo $row['id']?>" method="POST">
                        <div class="row">
                            <div class="product-card__title"><?php echo $row['title'] ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="<?php if(in_array($row['id'], $favorites)) echo "removeFromFavorites"; else echo "addToFavorites";?>" class="product-card__btn btn">
                                <span class="material-symbols-rounded" style="<?php if(in_array($row['id'], $favorites)) echo 'color: red';?>">favorite</span>
                            </button>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="product-card__price"><?php echo $row['price'] . " RON" ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="addToCart" class="explore-more btn">Add to cart +</button>
                            <?php endif; ?>
                        </div>
                        </form>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
                </div>
            </div>
        </section>

        <!-- ============= Brands Section ============= -->

        <section class="section brands">
            <div class="section__title">
                <h1>branduri</h1>
            </div>
            <div class="brands__container container">
                <div class="brands__logo">
                    <img src="./assets/images/br1.png" alt="Puma" />
                </div>
                <div class="brands__logo">
                    <img src="./assets/images/br2.png" alt="Balenciaga" />
                </div>
                <div class="brands__logo">
                    <img src="./assets/images/br3.png" alt="Adidas" />
                </div>
                <div class="brands__logo">
                    <img src="./assets/images/br4.png" alt="Nike" />
                </div>
                <div class="brands__logo">
                    <img src="./assets/images/br5.png" alt="Chanel" />
                </div>
            </div>
        </section>

        <!-- ============= Trending Section ============= -->

        <section class="section trending" id="trending">
            <div class="section__title">
                <h1>trenduri</h1>
            </div>
            <div class="trending__container container">
                <div class="trending__content swiper">
                <?php 
                $sql = "SELECT * FROM products WHERE isTrending=1";
                $result = $conn->query($sql);
                // $row = $result->fetch_assoc();
            ?>

            <div class="shop__products products">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="swiper-slide product-card" id="product-<?php echo $row['id'];?>" data-id="<?php echo $row['id'] ?>" data-category="<?php echo $row['categorie'];?>" data-image1="<?php echo "assets/images/" . $row['image_path'] ?>">
                    <div class="product-card__image">
                        <img src="<?php echo "assets/images/" . $row['image_path'] ?>" alt="<?php echo $row['title'] ?>" />
                    </div>
                    <div class="product-card__description">
                        <form action="assets/php/productFunctions.php?product=<?php echo $row['id']?>" method="POST">
                        <div class="row">
                            <div class="product-card__title"><?php echo $row['title'] ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="<?php if(in_array($row['id'], $favorites)) echo "removeFromFavorites"; else echo "addToFavorites";?>" class="product-card__btn btn">
                                <span class="material-symbols-rounded" style="<?php if(in_array($row['id'], $favorites)) echo 'color: red';?>">favorite</span>
                            </button>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="product-card__price"><?php echo $row['price'] . " RON" ?></div>
                            <?php if(isset($_SESSION['email'])):?>
                            <button name="addToCart" class="explore-more btn">Add to cart +</button>
                            <?php endif; ?>
                        </div>
                        </form>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                        <span class="border-animation"></span>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
            </div>
            </div>
            
        </section>
        
        <!-- ============= Footer ============= -->

        <footer class="footer">
            <div class="footer__container container">
                <div class="footer__col">
                    <div class="footer__logo">
                        <h1>
                            <a href="./">FashionParty</a>
                        </h1>
                    </div>
                    <div class="footer__description">
                        <p></p>
                    </div>
                </div>
                <div class="footer__col">
                    <div class="footer__title">
                        <h3>Companie</h3>
                        <ul class="footer__links">
                            <li class="footer__link"><a href="#home">Home</a></li>
                            <li class="footer__link"><a href="#new">New</a></li>
                            <li class="footer__link"><a href="#shop">Shop</a></li>
                            <li class="footer__link"><a href="#trending">Trending</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer__col">
                    <div class="footer__title">
                        <h3>Informații</h3>
                        <ul class="footer__links">
                            <li class="footer__link">
                                <a href="#">
                                    <span class="material-symbols-rounded"> location_on </span>
                                    <p>București, România, Strada Panseluței, nr 106</p>
                                </a>
                            </li>
                            <li class="footer__link">
                                <a href="#">
                                    <span class="material-symbols-rounded"> schedule </span>
                                    <p>
                                        Luni - Vineri:  08:00 - 16:00  <br />
                                        
                                        Sâmbătă-Duminică:   Închis <br />
                                        Online: Non-Stop <br />
                                    </p>
                                </a>
                            </li>
                            <li class="footer__link">
                                <a href="tel:+12334567775">
                                    <span class="material-symbols-rounded"> call </span>
                                    <p>0724 126 965</p>
                                </a>
                            </li>
                            <li class="footer__link">
                                <a href="mailto:fashionparty@gmail.com">
                                    <span class="material-symbols-rounded"> mail </span>
                                    <p>fashionparty@gmail.com</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer__col">
                    <div class="footer__title">
                        <h3>social media</h3>
                    </div>
                    <ul class="footer__links">
                        <li class="footer__link"><a href="">Instagram</a></li>
                        <li class="footer__link"><a href="">Facebook</a></li>
                        <li class="footer__link"><a href="">Whatsapp</a></li>
                    </ul>
                </div>
            </div>
        </footer>



        <!-- ============= Scroll UP ============= -->
        <button class="scroll-up btn btn-border btn-border-black"><span class="material-symbols-rounded"> arrow_upward </span></button>
    </body>
</html>
