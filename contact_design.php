<?php
@include('include/connect.php');
@include('functions_folder/common_function.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Adornment Emporium</title>
    <!--Bootstrap link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <!--Font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="contact.css">
    <style>
        .logo{
    width: 7%;
    height: 7%;
}
    </style>
</head>
<body>
    <!--first child-->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <img src="./images/logo.png" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="product.php">Products</a>
                    </li>
                    <?php
                        if(isset($_SESSION['username'])){
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='user_area/profile.php'>My Account</a>
                            </li>";
                        }else{
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='user_area/user_registration.php'>Register</a>
                            </li>";

                        }
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="contact_design.php">Contact</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart <i class="fa fa-shopping-cart"></i>
                        <sup>
                            <?php
                                cardItem();
                            ?>
                        </sup>
                    </a>
                    </li>
                   
                </ul>
                <form class="d-flex" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" name="search_data" aria-label="Search">
                    <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                     <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
                </form>
                </div>
        </div>
        </nav>
        <!--Second Child-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                
                <?php
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='#' name=''>Welcome Guest</a>
                        </li> ";
                    }else{
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='#' name=''>Welcome ".$_SESSION['username']."</a>
                        </li> ";
                    }
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='./user_area/user_login.php' name=''>Login</a>
                        </li> ";
                    }else{
                        echo "<li class='nav-item'>
                             <a class='nav-link' href='./user_area/logout.php' name=''>Logout</a>
                        </li> ";
                    }
                    ?>   
            </ul> 
        </nav>
    <div class="contact-container">
        <!-- Introduction Section -->
        <header>
            <h1>Adornment Emporium</h1>
            <p>Your one-stop destination for timeless jewelry. We would love to hear from you!</p>
            <p>We at Adornment Emporium are always excited to hear from you! Whether you have a question about our jewelry collections, need assistance, or just want to say hello, feel free to drop us a message.</p>
        </header>
        <!-- Contact Form Section -->
        <section class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="contact.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Enter your opinions here.." required></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>

        <!-- Store Information Section -->
        <section class="store-info">
            <h2>Our Information</h2>
            <p><strong>Address:</strong>Campus Mode, Bhadrapur</p>
            <p><strong>Email:</strong> adornmentemporium@gmail.com</p>
            <p><strong>Phone:</strong> +977 9800032123</p>
        </section>
        
    </div> 
    <?php
        @include('./include/footer.php');
        ?>

</body>
</html>
