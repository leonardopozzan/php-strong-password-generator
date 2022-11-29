<?php 
    $characters = [
        'alphabet' => 'qwertyuiopasdfghjklzxcvbnm',
        'numbers' => '1234567890',
        'symbols' => '\|!"£$%&/()=?^*.;,-_#@][><'
    ];
    function getCharacter($string): string{
        $length= strlen($string) - 1;
        $randomNumber = rand(0,$length);
        return $string[$randomNumber];
    };
    $password = '';
    if(isset($_POST['length']) && !empty($_POST['length'])){
        $length = $_POST['length'];
        while(strlen($password) < $length){
            $password .= getCharacter($characters['alphabet']);
        }
    };
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    <link rel='stylesheet' href='./css/style.css'>
    <script src='https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js'></script>
    <script src='https://unpkg.com/vue@3/dist/vue.global.js'></script>
    <title>Document</title>
</head>

<body>
    <div class="container pt-5">
        <form action="index.php" method="post">
            <label for="">Numero di caratteri della password</label>
            <input type="number" name="length">
            <button type="submit" class="btn btn-dark">Invia</button>
        </form>
        <div> <?php echo $password . strlen($password) ?> </div>
    </div>
</body>

