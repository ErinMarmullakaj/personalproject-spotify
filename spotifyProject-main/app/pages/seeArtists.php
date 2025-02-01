<?php   
    function all_artists(){
        try{
            require '../config/db.inc.php';
            require '../config/sessions.inc.php';

            $user_id = $_SESSION['userId'];

            $the_query = 'SELECT * FROM artists_added INNER JOIN artists ON artists_added.artist_added = artists.artist_id WHERE user_added = :user_id;';
            $the_prep = $pdo->prepare($the_query);

            $the_prep->bindParam(':user_id',$user_id);

            $the_prep->execute();

            $the_fetched = $the_prep->fetchAll(PDO::FETCH_ASSOC);

            return $the_fetched;
        } catch(PDOException $e){
            echo 'Failed ' . $e->getMessage();
        }
    }

    $the_artists = all_artists();

    if(!$the_artists){
        header('Location:index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Quicksand|Anaheim|Roboto Slab">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body{
            background-color:#181818;
            overflow:hidden;
            margin:0;
            padding:0;
        }
        .container{
            height:100vh;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;

        }
        .container-artists{
            display:flex;
            flex-direction:column;
        }
        .artist{
            margin:5px 0;
            background-color:#232323;
            height:80px;
            width:500px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .artist > div:nth-child(1){
            padding-left:10px;
        }

        .artist > div:nth-child(2){
            margin-right:10px;
            padding:8px 20px;
            background-color:#1DB954;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3), 0 1px 3px rgba(0, 0, 0, 0.18);

        }

        .artist > div:nth-child(2) a{
            text-decoration:none;
            color:white;
            font-family:'Quicksand';
            border-radius:4px;

        }

        .artist .text p{
            color:white;
            font-family:'Quicksand';
            font-weight:1000;
        }

        

    </style>
</head>
<body>
    <div class="container">
        <div class="container-artists">
            <?php foreach($the_artists as $artist): ?>
                <div class="artist">
                    <div class="text">
                        <p><?php echo $artist['artist_name'] ?></p>
                    </div>
                    <div class="delete">
                        <a href="delete.php?artist_id=<?php echo $artist['artist_id'] ?>">Delete</a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>