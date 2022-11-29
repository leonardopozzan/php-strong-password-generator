<?php 
    session_start();
    include __DIR__ . '/functions/functions.php';
    $characters = [
        'alphabet' => 'qwertyuiopasdfghjklzxcvbnm',
        'alphabetMaius' => 'QWERTYUIOPASDFGHJKLZXCVBNM',
        'numbers' => '1234567890',
        'symbols' => '\|!"$%&/()=?^*.;,-_#@][><'
    ];
    //controllo che siano settati i parametri necessari
    if(isset($_POST['length']) && !empty($_POST['length']) && isset($_POST['elements']) && isset($_POST['repeat'])){
        //assegno i dati alle variabili e inizializzo una password temporanea che verrà assegnata solo se si rispetteranno altre condizioni
        $length = $_POST['length'];
        $repeat = $_POST['repeat'];
        $elements = $_POST['elements'];
        $sum = '';
        $passwordTemp = '';
        //ciclo l'array delle checbox che corrispondono alle chiavi del mio array characters
        //e per ogni chiave scelta costruisco una stringa con la somma dei caratteri
        foreach($elements as $element){
            //metto già un carattere per ogni tipo richiesto nella password per esser sicuro che sia presente
            $passwordTemp .= getCharacter($characters[$element]);
            $sum .= $characters[$element];
        };
        //faccio un shuffle giusto per non avere una stringa con i caratteri in sequenza
        $sum = str_shuffle($sum);
        //controllo che la lunghezza della password richiesta non sia inferiore al numero di tipi di caratteri richiesti
        //es. non puoi chiedere una password di 3 caratteri selezionando tutte le checkbox
        //allo stesso tempo controllo che se chiede che non vengano ripetuti caratteri ci siano abbastanza caratteri tra cui scegliere per generare la password
        //senza quindi finire in loop
        if($length >= strlen($passwordTemp)  && ($repeat == 'repeat' || $repeat == 'no-repeat' && strlen($sum) > $length)){
            $password = $passwordTemp;
            //ciclo while che popola la stringa password
            while(strlen($password) < $length){
                //faccio il controllo sul repeat
                if($repeat == 'no-repeat'){
                    //se non voglio ripetizioni controllo se il carattere random è presente o no
                    $randomCharacter = getCharacter($sum);
                    if(!str_contains($password,$randomCharacter)){
                        $password .= $randomCharacter;
                    }
                }else{
                    $password .= getCharacter($sum);
                }
            }
            //faccio un ulteriore shuffle per mischiare il risultato
            $password = str_shuffle($password);
            $_SESSION['password'] = $password;
            // header('Location: ./result.php');
        }else{
            $error = true;
        }
    }else{
        $error = true;
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
                <input type="radio" name="repeat" value="repeat" checked="checked"> si
                <input type="radio" name="repeat" value="no-repeat"> no
            </div>
            <div>
                <input type="checkbox" name="elements[]" value="alphabet"> Lettere minuscole
                <input type="checkbox" name="elements[]" value="alphabetMaius"> Letttere maiuscole
                <input type="checkbox" name="elements[]" value="numbers"> Numeri
                <input type="checkbox" name="elements[]" value="symbols"> Simboli
            </div>
            <button type="submit" class="btn btn-dark">Invia</button>
        </form>
        
    </div>
</body>

