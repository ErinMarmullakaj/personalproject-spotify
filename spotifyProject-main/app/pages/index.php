<?php
    require '../config/sessions.inc.php';

    $user_id = $_SESSION['userId'];

    // if(isset($_SERVER['HTTP_REFERER'])){
    //     $the_prev = $_SERVER['HTTP_REFERER'];

    //     if($the_prev == 'payment.php'){
    //         echo 'Payment completed';
    //     }
    // }


    function userPayments(){
        global $user_id;
        try{
            require '../config/db.inc.php';

            $query = 'SELECT * FROM payments WHERE user_id = :user_id;';
            $the_prep = $pdo->prepare($query);
            $the_prep->bindparam(':user_id',$user_id);

            $the_prep->execute();

            $fetched_payment = $the_prep->fetch(PDO::FETCH_ASSOC);

            return $fetched_payment ? $fetched_payment : false;
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }

        
    }


    $user_payments = userPayments();

    function all_artists(){
        try{
            require '../config/db.inc.php';
            $query = 'SELECT * FROM artists';

            $the_prep = $pdo->prepare($query);
            $the_prep->execute();
            $all_artists = $the_prep->fetchAll(PDO::FETCH_ASSOC);

            return $all_artists;
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }
    }

    $artists = all_artists();

    function all_artists_for_user(){
        global $user_id;
        try{
            require '../config/db.inc.php';
            $query = 'SELECT * FROM artists_added INNER JOIN artists ON artists_added.artist_added = artists.artist_id WHERE user_added = :user_id;';
            $the_prep = $pdo->prepare($query);
            $the_prep->bindParam(':user_id',$user_id);

            $the_prep->execute();

            $fetched_artists = $the_prep->fetchAll(PDO::FETCH_ASSOC);

            return $fetched_artists;
        } catch(PDOException $e){
            echo 'Failed ' . $e->getMessage();
        }
    }

    

    $all_artists_for_user = all_artists_for_user();

    $artists_names = [];

    if($all_artists_for_user){
        foreach($all_artists_for_user as $artist){
            $artists_names[] = $artist['artist_name'];
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='user_id' content="<?php echo $user_id ?>">
    <meta name="payment_done" content="<?php echo $user_payments ? 'Done' : 'Not Done' ?>">
    <link rel="stylesheet" href="./styles/style.css?v=2.9">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Quicksand|Anaheim|Roboto Slab">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="navigation">
            <div class="logo-search-bar">
                <div class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M248 8C111.1 8 0 119.1 0 256s111.1 248 248 248 248-111.1 248-248S384.9 8 248 8zm100.7 364.9c-4.2 0-6.8-1.3-10.7-3.6-62.4-37.6-135-39.2-206.7-24.5-3.9 1-9 2.6-11.9 2.6-9.7 0-15.8-7.7-15.8-15.8 0-10.3 6.1-15.2 13.6-16.8 81.9-18.1 165.6-16.5 237 26.2 6.1 3.9 9.7 7.4 9.7 16.5s-7.1 15.4-15.2 15.4zm26.9-65.6c-5.2 0-8.7-2.3-12.3-4.2-62.5-37-155.7-51.9-238.6-29.4-4.8 1.3-7.4 2.6-11.9 2.6-10.7 0-19.4-8.7-19.4-19.4s5.2-17.8 15.5-20.7c27.8-7.8 56.2-13.6 97.8-13.6 64.9 0 127.6 16.1 177 45.5 8.1 4.8 11.3 11 11.3 19.7-.1 10.8-8.5 19.5-19.4 19.5zm31-76.2c-5.2 0-8.4-1.3-12.9-3.9-71.2-42.5-198.5-52.7-280.9-29.7-3.6 1-8.1 2.6-12.9 2.6-13.2 0-23.3-10.3-23.3-23.6 0-13.6 8.4-21.3 17.4-23.9 35.2-10.3 74.6-15.2 117.5-15.2 73 0 149.5 15.2 205.4 47.8 7.8 4.5 12.9 10.7 12.9 22.6 0 13.6-11 23.3-23.2 23.3z"/></svg>
                </div>
                <div class="home-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                </div>
                <div class="search-bar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                    <input type="text" placeholder="Search for artists...">

                    <div class="search-results">
                        <?php foreach($artists as $artist): ?>
                            <form action="add.php" method='post'>
                                <input type="hidden" name="artist_id" value="<?php echo $artist['artist_id'] ?>">
                                <div class="artist-search-result">
                                    <div class="artist-name">
                                        <p><?php echo $artist['artist_name'] ?></p>
                                    </div>
                                    <div class="artist-button">
                                        <?php if(in_array($artist['artist_name'],$artists_names)): ?>
                                            <button class='added'>Added</button>
                                        <?php else: ?>
                                            <button class='add' type='submit'>Add</button>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </form>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="details-part">
                <div class="important-links">
                    <ul>
                        <li><a href="">Premium</a></li>
                        <li><a href="">Support</a></li>
                        <li><a href="">Download</a></li>
                    </ul>
                </div>
                <div class="buttons-">
                    <div class="download">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg><a href="">Install App</a>
                    </div>
                    <div class="button">
                        <button><a href="logout.php" style='text-decoration:none;color:#333;'>Log Out</a></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="seperate-line"></div>
    </header>

    <main>
        <div class="container">
            <div class="library">
                <div class="library-content">
                    <div class="library-part">
                        <div class="title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                            <h1>Your Library</h1>
                        </div>
                        <div class="addition">
                            <a href="seeArtists.php"><i class='fa fa-plus'></i></a>
                        </div>
                    </div>
                    <div class="payment-options">
                        <div class="payment">
                            <h3>Monthly</h3>
                            <p>This is an great option allows you to<br> listen one month</p>
                            <p id='price'>9&euro;</p>
                            <span id='span'>Get Now</span>
                        </div>
                        <div class="payment">
                            <h3>Yearly</h3>
                            <p>This is the best option allows you to<br> listen one year</p>
                            <p id='price'>22&euro;</p>
                            <span id='span'>Get Now</span> 
                        </div>
                    </div>
                    <div class="mini-footer">
                        <ul>
                            <li>Legal</li>
                            <li>Safety & Privacy Center</li><br><br>
                            <li>Privacy Policy</li><br><br>
                            <li>Cookies</li>
                            <li>About ads</li><br><br>
                            <li>Accessibility</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="artists">
                <div class="artists-content">
                    <div class="title">
                        <h1>Popular Artists</h1>
                    </div>
                    <div class="artists-preview">
                        <div class="artist">
                            <div class="image-part">
                                <img src="../assets/travis scot.jpg" height='150' width='150'>
                            </div>
                            <p>Travis Scot</p>
                            <small>Artist</small>

                            <div class="button-play">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                            </div>
                        </div>
                        <div class="artist">
                            <div class="image-part">
                                <img src="../assets/noizt.jpg" height="150" width="150">

                            </div>
                            <p>Noizy</p>
                            <small>Artist</small>

                            <div class="button-play">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                            </div>
                        </div>
                        <div class="artist">
                            <div class="image-part">
                                <img src="../assets/liluzi.jpg" height="150" width="150">
                            </div>
                            <p>Lil Uzi</p>
                            <small>Artist</small>

                            <div class="button-play">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                            </div>
                        </div>
                        <div class="artist">
                            <div class="image-part">
                                <img src="../assets/drake.jpg" height="150" width="150">
                            </div>
                            <p>Drake</p>
                            <small>Artist</small>

                            <div class="button-play">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script src='./scripts/main.js?v=1.9'></script>
</html>