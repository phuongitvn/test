<?php
function encrypt_decrypt($action, $string, $appId="") {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'crmplus_phuongnv_key'.$appId;
    $secret_iv = 'crmplus_phuongnv_iv'.$appId;

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
$code=$codeDecrypt="";
$name=$code2="";
if(isset($_GET['name']) && $_GET['name']!=''){
	$salt = $_GET['salt'];
	$code = encrypt_decrypt('encrypt', $_GET['name'], $salt);
	$name=$_GET['name'];
}
if(isset($_GET['code']) && $_GET['code']!=''){
	$salt2 = $_GET['salt2'];
	$codeDecrypt = encrypt_decrypt('decrypt', $_GET['code'],$salt2);
	$code2=$_GET['code'];
}
?>
<form action="" method="get">
<span>Put Name to Encrypt</span>
<input type="text" name="name" value="<?php echo $name;?>" />
Salt:
<input type="text" name="salt" value="<?php echo $salt;?>" />
<button type="submit" name="encrypt">Encrypt</button><span><?php echo $code;?></span>
<br />
<span>Put Code to Decrypt</span>
<input type="text" name="code" value="<?php echo $code2;?>" />
Salt:
<input type="text" name="salt2" value="<?php echo $salt2;?>" />
<button type="submit" name="decrypt">Decrypt</button><span><?php echo $codeDecrypt;?></span>
</form>
