<?php
    function completePayment($name,$method,$card_number,$cvv){
        try{
            require '../config/sessions.inc.php';
            require '../config/db.inc.php';

            $user_id = $_SESSION['userId'];

            $query = 'INSERT INTO payments(user_id,method,name,card_number,cvv) VALUES (:user_id,:method,:name,:card_number,:cvv);';
            $the_prep = $pdo->prepare($query);

            $the_prep->bindParam(':user_id',$user_id);
            $the_prep->bindParam(':method',$method);

            $the_prep->bindParam(':name',$name);
            $the_prep->bindParam(':card_number',$card_number);
            $the_prep->bindParam(':cvv',$cvv);

            $the_prep->execute();

            if($the_prep->rowCount()){
                header('Location:index.php');
            }


        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $method = $_POST['method'];
        $card_number = $_POST['CardNumber'];
        $cvv = $_POST['Cvv'];

        if(!empty($name) && !empty($method) && !empty($card_number) && !empty($cvv)){
            completePayment($name,$method,$card_number,$cvv);
        }
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='variable' content="<?php $the_variable ? 'yes' : 'no' ?>">
    <title>Document</title>
    <link rel='stylesheet' href='./styles/signUp.css?v=1.5'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Quicksand|Anaheim|Roboto Slab">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   
</head>
<body>
<div class="container">
        <form class="form-wrapper" action='' method='post'>
            <div class="title-logo">
                <div class="logo">
                    <img src="../assets/spotify.png" alt="logo" height='60' width='60'>
                </div>
                <div class="title-page">
                    <h3>Payment Process</h3>
                    <p id='payment'>You Choosed: </p>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="choose">
                    <select name="method" id="select">
                        <option value="Reifeissen">Reifeissen</option>
                        <option value="Pro Credit">Pro Credit</option>
                        <option value="Teb">Teb</option>
                        <option value="Nlb">Nlb Bank</option>
                    </select>
                </div>
                <div class="username-input">
                    <input type="text" placeholder="Name" name='name' id='name'>
                </div>
                <div class="password-input">
                    <label for="" style='display:block; color:white; font-family:"Anaheim";'>Card Number</label>
                    <input type="text" placeholder="023-3445-90" name='CardNumber' id='card-number'>
                </div>
                <div class="password-input">
                    <label for="" style='display:block; color:white; font-family:"Anaheim";'>CVV</label>
                    <input type="number" placeholder="124" name='Cvv' id='cvv'>
                </div>
                <div class="signUp-button">
                    <button id='button'>Pay</button>
                </div>
            </div>
            
            
        </form>
    </div>    
</body>
<script>
    let the_payment_method = localStorage.getItem('option-choosed');
   

    document.getElementById('payment').innerHTML += the_payment_method.toUpperCase();

   

   
</script>
</html>