<?php
/**
 * Created by PhpStorm.
 * User: jderay
 * Date: 3/11/14
 * Time: 12:22 PM
 */

namespace League\OAuth2\Server\Util\KeyAlgorithm;


class DefaultAlgorithm implements KeyAlgorithmInterface
{
    /**
     * @param int $len
     * @return string
     * @throws \Exception
     */
    public function make($len = 40)
    {
        // We generate twice as many bytes here because we want to ensure we have
        // enough after we base64 encode it to get the length we need because we
        // take out the "/", "+", and "=" characters.
        $bytes = openssl_random_pseudo_bytes($len * 2, $strong);

        // We want to stop execution if the key fails because, well, that is bad.
        if ($bytes === false || $strong === false) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Error Generating Key');
            // @codeCoverageIgnoreEnd
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $len);
    }
}