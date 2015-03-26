<?php

/**
 * Class Authentication.
 * @package    Encrypt / Decrypt
 * @author     Francisco Caravana <fcaravana@gmail.com>
 * @copyright  Francisco Caravana
 * @license    http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link       http://www.franciscocaravana.com
 */
class Encrypt {

    public $type;

    /**
     * Class construct.
     *
     * @param array $params example array("type" => $type)
     * @param string $type 'text', 'base64' or 'rsa'
     */
    public function __construct($params = array("type" => "text")) {
        $type = null;

        extract($params, EXTR_OVERWRITE);

        $this->type = $type;
    }

    /**
     * Transform string.
     *
     * @param string $string 'text', 'base64' or 'rsa'
     * @return string string transformed
     */
    public function transformString($string) {
        switch ($this->type) {
            case "base64":
                $string = base64_decode($string);
                break;

            case "rsa":
                $string = $this->decryptString($string);
                break;
        }

        return $string;
    }

    /**
     * Encrypt string.
     *
     * @param string $string string in plain text to encrypt
     * @return string encrypted string
     */
    public function encryptString($string) {
        $result = false;

        if (openssl_public_encrypt($string, $string, RSA_PUBLIC_KEY)) {
            $result = base64_encode($string);
        }

        return $result;
    }

    /**
     * Decrypt string.
     *
     * @param string $string encrypted string
     * @return string plain text decrypted string
     */
    public function decryptString($string) {
        $result = false;

        $string = base64_decode($string);

        if (openssl_private_decrypt($string, $string, openssl_pkey_get_private(RSA_PRIVATE_KEY, RSA_PASSPHRASE_KEY))) {
            $result = $string;
        }

        return $result;
    }

    /**
     * Generate rsa private and public keys.
     *
     * @return array array with public and private key
     */
    public function generateKeys($passphrase) {
        $result = array(
            "PUBLIC_KEY" => null,
            "PRIVATE_KEY" => null,
        );

        $privateKey = null;

        $password = (empty($passphrase) ? RSA_PASSPHRASE_KEY : $passphrase);
        $config = array("private_key_bits" => 512);

        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privateKey, $password);

        $pubKey = openssl_pkey_get_details($res);
        $publicKey = $pubKey["key"];

        if ($publicKey && $privateKey) {
            $result = array(
                "PUBLIC_KEY" => $publicKey,
                "PRIVATE_KEY" => $privateKey,
            );
        }

        return $result;
    }

    /**
     * Class destruct.
     */
    public function __destruct() {
        $this->type = null;
        unset($this->type);
    }

}