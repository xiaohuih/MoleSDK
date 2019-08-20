<?php

namespace App\Utils;

/**
 * Provides crypt utilities.
 */
class OpenSSL
{
    /**
     * Generate key pairs.
     *
     * @return string
     */
    public static function newKey()
    {
        $config = array(
            "digest_alg" => "sha1",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        return openssl_pkey_new($config);
    }
    
    /**
     * @param string $pem
     *
     * @return resource
     */
    public static function getPrivateKey($pem)
    {
        openssl_pkey_export($pem, $privateKey);
        return $privateKey;
    }

    /**
     * @param string $pem
     *
     * @return resource
     */
    public static function getPublicKey($pem)
    {
        $publicKey = openssl_pkey_get_details($pem);
        return $publicKey["key"];
    }

    /**
     * @param string $content
     * @param string $publicKey
     *
     * @return string
     */
    public static function encrypt($content, $publicKey)
    {
        openssl_public_encrypt($content, $encrypted, $publicKey);
        return $encrypted;
    }

    /**
     * @param string $content
     * @param string $privateKey
     *
     * @return string
     */
    public static function decrypt($content, $privateKey)
    {
        openssl_private_decrypt($content, $decrypted, $privateKey);
        return $decrypted;
    }
}
