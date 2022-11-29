<?php 
    session_start();
    include __DIR__ . '/functions/functions.php';
    $characters = [
        'alphabet' => 'qwertyuiopasdfghjklzxcvbnm',
        'alphabetMaius' => 'QWERTYUIOPASDFGHJKLZXCVBNM',
        'numbers' => '1234567890',
        'symbols' => '\|!"$%&/()=?^*.;,-_#@][><'
    ];
    
    $password = '';
    if(isset($_POST['length']) && !empty($_POST['length'])){
        $length = $_POST['length'];
        $sum = $characters['alphabet'] .$characters['numbers'] . $characters['symbols'] . $characters['alphabetMaius'];
        $sum = str_shuffle($sum);
        while(strlen($password) < $length){
            $password .= getCharacter($sum);
        };
        $password = str_shuffle($password);
        $_SESSION['password'] = $password;
        header('Location: ./result.php');
    };

    if(isset($_POST['element'])){
        var_dump($_POST['element']);
    }
    
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
            <div>
                <label for="">Numero di caratteri della password</label>
                <input type="number" name="length" value="<?php isset($_POST['length']) ? $_POST['length'] : '' ?>">
            </div>
            <div>
                <label for="">Ripetizioni</label>
                <input type="radio" name="repet" value="repet" selected> si
                <input type="radio" name="repet" value="no-repet"> no
            </div>
            <div>
                <input type="checkbox" name="element[]" value="alphabet"> Lettere minuscole
                <input type="checkbox" name="element[]" value="alphabetMaius"> Letttere maiuscole
                <input type="checkbox" name="element[]" value="numbers"> Numeri
                <input type="checkbox" name="element[]" value="symbols"> Simboli
            </div>
            <button type="submit" class="btn btn-dark">Invia</button>
        </form>
        <div>La tua password è <?php echo $password  ?></div>
        <div>Lunghezza <?php echo strlen($password)  ?> </div>
    </div>
</body>

