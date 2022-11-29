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
            header('Location: ./result.php');
        }else{
            $error = true;
        }
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
    <div class="my-container">
        <div class="box">
            <h1 class="text-center text-blue">Stron Password Generator</h1>
            <h2 class="text-center text-light-blue">Genera una password sicura</h2>
            <form action="index.php" method="post" class="form">
                <div class="col-5"><label for="">Numero di caratteri della password</label></div>
                <div class="col-3"><input required type="number" name="length" value="<?php isset($_POST['length']) ? $_POST['length'] : '' ?>"></div>
                <div class="col-5 my-2"><label for="">Consenti ripetizioni dei caratteri</label></div>
                <div class="col-3 my-2">
                    <input type="radio" name="repeat" value="repeat" checked="checked">
                    <label for="">Si</label>
                    <input type="radio" name="repeat" value="no-repeat">
                    <label for="">No</label>
                </div>
                <div class="col-5 d-flex align-items-end ">
                    <button type="submit" class="btn btn-primary me-2">Invia</button>
                    <button type="reset" class="btn btn-secondary">Anulla</button>
                </div>
                <div class="col-3 d-flex flex-column align-self-end">
                    <div>
                        <input type="checkbox" name="elements[]" value="alphabet" class="p-2" checked="checked">
                        <label for="alphabet">Lettere minuscole</label>
                    </div>
                    <div>
                        <input type="checkbox" name="elements[]" value="alphabetMaius" checked="checked">
                        <label for="alphabetMaius">Letttere maiuscole</label>
                    </div>
                    <div>
                        <input type="checkbox" name="elements[]" value="numbers" checked="checked">
                        <label for="numbers">Numeri</label>
                    </div>
                    <div>
                        <input type="checkbox" name="elements[]" value="symbols" checked="checked">
                        <label for="symbols">Simboli</label>
                    </div>
                </div>
            </form>
            <?php if(isset($error)){  ?>
            <div class="alert alert-danger w-75 m-auto" role="alert">
                I dati inseriti non sono corretti assicurati che la password non sia troppo corta o eccessivamente lunga <br>
                Ti consigliamo di scegliere 15 caratteri con lettere minuscole, numeri e simboli.
            </div>
            <?php } ?>
        </div>
    </div>
</body>

