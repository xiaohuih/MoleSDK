<?php

namespace App\Utils;

/**
 * Provides crypt utilities.
 */
class OpenSSL
{
    private static $kPubKeySearch = [
        "-----BEGIN PUBLIC KEY-----",
        "-----END PUBLIC KEY-----",
        "\n",
        "\r",
        "\r\n"
    ];
    
    private static $kPriKeySearch = [
        "-----BEGIN PRIVATE KEY-----",
        "-----END PRIVATE KEY-----",
        "\n",
        "\r",
        "\r\n"
    ];

    private static $keyGenConfig = [
        "digest_alg" => "sha1",
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];

    /**
     * Generate key pairs.
     *
     * @return string
     */
    public static function newKey()
    {
        return openssl_pkey_new(self::$keyGenConfig);
    }
    
    /**
     * @param string $pem
     *
     * @return resource
     */
    public static function getPrivateKey($pem)
    {
        openssl_pkey_export($pem, $privateKey);

        return str_replace(self::$kPriKeySearch, "", $privateKey);
    }

    /**
     * @param string $pem
     *
     * @return resource
     */
    public static function getPublicKey($pem)
    {
        $publicKey = openssl_pkey_get_details($pem);
        $publicKey = $publicKey["key"];

        return str_replace(self::$kPubKeySearch, "", $publicKey);
    }

    /**
     * @param string $privateKey
     *
     * @return string
     */
    public static function pkcs8PrivateKey($privateKey)
    {
        return self::$kPriKeySearch[0] . PHP_EOL . wordwrap($privateKey, 64, "\n", true) . PHP_EOL . self::$kPriKeySearch[1];
    }

    /**
     * @param string $publicKey
     *
     * @return string
     */
    public static function pkcs8PublicKey($publicKey)
    {
        return self::$kPubKeySearch[0] . PHP_EOL . wordwrap($publicKey, 64, "\n", true) . PHP_EOL . self::$kPubKeySearch[1];
    }

    /**
     * @param string $data
     * @param string $publicKey
     *
     * @return string
     */
    public static function public_encrypt($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, self::pkcs8PublicKey($publicKey));
        return $encrypted;
    }

    /**
     * @param string $data
     * @param string $privateKey
     *
     * @return string
     */
    public static function private_decrypt($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, self::pkcs8PrivateKey($privateKey));
        return $decrypted;
    }

    /**
     * @param string $data
     * @param string $privateKey
     *
     * @return string
     */
    public static function private_encrypt($data, $privateKey)
    {
        openssl_private_encrypt($data, $encrypted, self::pkcs8PrivateKey($privateKey));
        return $encrypted;
    }

    /**
     * @param string $data
     * @param string $publicKey
     *
     * @return string
     */
    public static function public_decrypt($data, $publicKey)
    {
        openssl_public_decrypt($data, $decrypted, self::pkcs8PublicKey($publicKey));
        return $decrypted;
    }
}
