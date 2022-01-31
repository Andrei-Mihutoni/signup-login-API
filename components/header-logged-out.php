<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title><?= $_title ?? 'Company' ?></title>
    <link rel="icon" type="image/x-icon" href="./media/favicon.ico">
    <link rel="stylesheet" href="./css/forms.css">
    <link rel="stylesheet" href="./css/navbar.css">
    
</head>


<header>

    <nav id="topNav">
        <div id="top-nav-left">
            <div id="logo-topnav">
                <a href="homepage.php"><img src="./media/amazon-logo-white.jpg" alt="logo image" /></a>
            </div>
            <ul>
                <li id="deliver-nav">
                    <p>Deliver to Denmark</p>
                    <p class="bold">Copenhagen 2300</p>
                </li>

            </ul>
        </div>
        <div class="search-container">
            <form action="sort.html">
                <input type="text" placeholder="Search here..." name="search" />
                <button type="submit">
                    <img src="./media/search-small-icon.svg" alt="" />
                </button>
            </form>
        </div>

        <div id="top-nav-right">
            <ul>
                <li class="min-width">
                    <a href="user-profile.php">Hello there
                    </a>

                </li>
                <li class="min-width">
                    <a href="">
                        <p>Returns</p>
                        <p class="bold">& Orders</p>
                    </a>
                </li>
                <li id="shopping-cart-li">
                    <a href="">
                        <img src="./media/shopping_cart.png" alt="" />
                    </a>
                </li>
            </ul>
        </div>
    </nav>




    <!-- 
    <nav id="top-nav-bar">
        <div id="logo-nav-bar">
            <img src="/media/amazon_logo.png" alt="">
        </div>
        <div id="deliver-nav">
            <p>Deliver to Denmark</p>
            <p>Copenhagen 2300</p>
        </div>
        
        <a href="homepage.php">Home</a>
        <a href="upload-item.php">Upload item</a>
        <a href="user-profile.php">Profile</a>
        <a href="vendor-shop.php">Vendor shop</a>
        <a href="logout.php">Logout</a>
    </nav> -->


    <!-- <nav id="top-nav-bar">
        <a href="homepage.php">Home</a>
        <a href="upload-item.php">Upload item</a>
        <a href="user-profile.php">Profile</a>
        <a href="update-user.php">Update Profile</a>
        <a href="vendor-shop.php">Vendor shop</a>
        <a href="logout.php">Logout</a>
    </nav> -->
</header>