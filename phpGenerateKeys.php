<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('class/Encrypt.php');

define('RSA_PASSPHRASE_KEY', 'password');

$encrypt = new Encrypt();
$keys = $encrypt->generateKeys(RSA_PASSPHRASE_KEY);

echo "== public key and private key width pass: '".RSA_PASSPHRASE_KEY."' ==";
var_dump($keys);

?>