# encrypt-decrypt

This is a example how you can encrypt a html form data and decrypt with php to have some kind of data security. 

**Generate RSA keys with phpGenerateKeys.php**

The phpGenerateKeys.php is a example how the RSA public and private keys can be generated with a passphrase.

The public, private keys and passphrase can be saved for later use.



> phpGenerateKeys.php

    require_once('class/Encrypt.php');
    
    define('RSA_PASSPHRASE_KEY', 'password');
    
    $encrypt = new Encrypt();
    $keys = $encrypt->generateKeys(RSA_PASSPHRASE_KEY);
    
    echo "== public key and private key width pass: '".RSA_PASSPHRASE_KEY."' ==";
    var_dump($keys);

**Encrypt form inputs with jsEncryptString.html and decrypt with phpDecryptString.php**

The jsEncryptString.html is a example how you can encrypt with javascript and decrypt with php, when you submit the form to phpDecryptString.php.

> phpDecryptString.php

    require_once("class/Encrypt.php");
    
    define("RSA_PUBLIC_KEY", "-----BEGIN PUBLIC KEY-----
    MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBALphmWV0fY4KNQLNqNLVxImey3b11PNz
    r4x+EhsNSfDNVxBxfQ1EF3X6Q+Eki8zEEdL6noukArV7gVW2sncv5UUCAwEAAQ==
    -----END PUBLIC KEY-----");
    
    define("RSA_PRIVATE_KEY", "-----BEGIN RSA PRIVATE KEY-----
    Proc-Type: 4,ENCRYPTED
    DEK-Info: DES-EDE3-CBC,52F2C9C29F23A60D
    
    OuKKp9rksZLXHOnSO21t12lpUtn++K/eqqhGh0kZIV5OhpbeapP84n+SFw/+LS4J
    NNi3DlJZTDgZiKhmAbhWfPXbS1T8IX/HS+3X/FbULYcJyiaRkEQiDe+L00mO3Qid
    /CMOmF79xFHmSAKv1uhLG+f8QnfFTACIyvwOJIEQuPrtn7Uqgo3NtZdYTVKh6awN
    Tj/GNes6sHgM4/gB7NrGau3+xOWlntCS/bRO1oKqkwG9Hd13MCFQhcImqBQKm8I5
    aPHXBU79xkXOTOpwTXAnMDh39bAdksz6+Ue0KaftfeTR/64IQhZ/kzc9yOqKokX1
    fJ265fdEBPr+i20lu3tpTr1O98/WzTjYdu7cE+hSz+k9cJJbfEdfsjLoVg1qfK4Z
    zydwNC0w0S0TpZEftEdKgJApZ3gfV5Lzza+F6gIuG2w=
    -----END RSA PRIVATE KEY-----");
    
    define("RSA_PASSPHRASE_KEY", "password");
    
    $encrypt = new Encrypt(array("type" => "rsa"));
    
    $firstNameDecrypt = $encrypt->transformString($_REQUEST["first_name_encrypt"]);
    $lastNameDecrypt = $encrypt->transformString($_REQUEST["last_name_encrypt"]);
    
    echo "== first name and last name crypted ==";
    var_dump($_REQUEST["first_name_encrypt"], $_REQUEST["last_name_encrypt"]);
    
    echo "== first name and last name decrypted ==";
    var_dump($firstNameDecrypt, $lastNameDecrypt);



