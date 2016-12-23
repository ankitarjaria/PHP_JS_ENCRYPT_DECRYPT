<?php error_reporting(E_ALL);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CryptoJS AES and PHP</title>
    <script type="text/javascript" src="aes.js"></script>
    <script type="text/javascript" src="aes-json-format.js"></script>

</head>
<body>
    <h1>PHP ENCRYPT JS DECRYPT</h1>

    <h2>Pass parameter by GET request (eg. => index.php?q=Hello My Name Is Ankit)</h2>
   <?php
            function cryptoJsAesEncrypt($passphrase, $value){
                $salt = openssl_random_pseudo_bytes(8);
                $salted = '';
                $dx = '';
                while (strlen($salted) < 48) {
                    $dx = md5($dx.$passphrase.$salt, true);
                    $salted .= $dx;
                }
                $key = substr($salted, 0, 32);
                $iv  = substr($salted, 32,16);
                $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
                return json_encode(array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt)));
            }

            $publicKey = 'Ankit_arjaria_8800589538';
            $data = $_GET['q'];
            echo $phpEncryptData =  cryptoJsAesEncrypt($publicKey,$data);
            ?>
    </form>
    <br/>Decrypt Message:- 
    <div id="result">asad</div>
    <script>
    var data = '<?php echo $phpEncryptData; ?>';
    var key = "<?php echo $publicKey; ?>";

    var dt = CryptoJS.AES.decrypt(data,key, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8);
    document.getElementById("result").innerHTML = dt;
    console.log(dt);
    </script>
</body>
</html>
