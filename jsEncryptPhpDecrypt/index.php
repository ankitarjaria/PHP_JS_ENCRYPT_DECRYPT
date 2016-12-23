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
<?php $key="ankit_arjaria_8800589538"; ?>

<h2>Example to encrypt with CryptoJS on client side and decrypt on PHP side</h2>
<?php
if(isset($_POST["decrypt"])){
    function cryptoJsAesDecrypt($passphrase, $jsonString){
    $jsondata = json_decode($jsonString, true);
    try {
        $salt = hex2bin($jsondata["s"]);
        $iv  = hex2bin($jsondata["iv"]);
    } catch(Exception $e) { return null; }
    $ct = base64_decode($jsondata["ct"]);
    $concatedPassphrase = $passphrase.$salt;
    $md5 = array();
    $md5[0] = md5($concatedPassphrase, true);
    $result = $md5[0];
    for ($i = 1; $i < 3; $i++) {
        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
        $result .= $md5[$i];
    }
    $key = substr($result, 0, 32);
    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
    return json_decode($data, true);
    }
    ?>

    Decrypted value: <input type="text" value="<?php echo cryptoJsAesDecrypt($key, $_POST["jsEncryptValue"])?>" size="45" disabled="disabled"/><br/>
    
    <?php } ?>

<form name="d" method="post" action="">
    <input type="text" name="jsEncryptValue" id="data" value="" /><br/>
    <input type="submit" name="decrypt" value="Send to server and decrypt"/>
</form>

</body>
<script type="text/javascript">
document.getElementById("data").value = CryptoJS.AES.encrypt(JSON.stringify("Hi My Name is Ankit,"), "<?=$key;?>", {format: CryptoJSAesJson}).toString();
</script>
</html>
