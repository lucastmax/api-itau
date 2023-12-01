<?php
namespace Itau\API;

use Exception;
use Itau\API\Exception\ItauException;

/**
 * Class Request
 *
 * @package Itau\API
 */
class Request
{

    public const CURL_TYPE_POST = "POST";
    public const CURL_TYPE_PUT = "PUT";
    public const CURL_TYPE_GET = "GET";
    public const CURL_TYPE_DELETE = "DELETE";
    private $baseUrl = '';
    private $authUrl = '';

    /**
     * Request constructor.
     *
     * @param Itau $credentials
     * TODO create local variable to $credentials
     */
    public function __construct(Itau $credentials)
    {
        $this->baseUrl = $credentials->getEnvironment()->getApiUrl();

        if (! $credentials->getAuthorizationToken()) {
            $this->auth($credentials);
        }
    }

    /**
     *
     * @param Itau $credentials
     * @return Itau
     * @throws Exception
     */
    public function auth(Itau $credentials)
    {
        if ($this->verifyAuthSession($credentials)) {
            return $credentials;
        }
            
        $endpoint = $credentials->getEnvironment()->getApiUrlAuth();
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'x-itau-correlationID: 2',
            'x-itau-flowID: 1'
        ];

        $request = [
            'grant_type' => 'client_credentials',
            'client_id' => $credentials->getClientId(),
            'client_secret' => $credentials->getClientSecret()
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_PORT => 443,
            CURLOPT_VERBOSE => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($request),
            CURLOPT_SSLCERT => $credentials->getCertificate(),
            CURLOPT_SSLKEY => $credentials->getCertificateKey(),
            CURLOPT_CAINFO => $credentials->getCertificate(),
            CURLOPT_SSL_VERIFYPEER => 0
        ]);

        try {
            $response = curl_exec($curl);
        } catch (Exception $e) {
            throw new ItauException($e->getMessage(), 100);
        }
        // Verify error
        if ($response === false) {
            $errorMessage = curl_error($curl);
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode >= 400) {
            // TODO see what it means code 100
            throw new ItauException($response, 100);
        }

        // Status code 204 don't have content. That means $response will be always false
        // Provides a custom content for $response to avoid error in the next if logic
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        if (! $response) {
            throw new ItauException("Empty response, curl_error: $errorMessage", $statusCode);
        }

        $responseDecode = json_decode($response, true);

        if (is_array($responseDecode) && isset($responseDecode['error'])) {
            throw new ItauException($responseDecode['error_description'], 100);
        }

        $credentials->setAuthorizationToken($responseDecode["access_token"]);

        // Save auth session
        if ($credentials->getKeySession()) {
            $responseDecode['generated'] = microtime(true);
            $_SESSION[$credentials->getKeySession()] = $responseDecode;
        }

        return $credentials;
    }

    private function verifyAuthSession(Itau $credentials)
    {
        if ($credentials->getKeySession() && isset($_SESSION[$credentials->getKeySession()]) && $_SESSION[$credentials->getKeySession()]["access_token"]) {

            $auth = $_SESSION[$credentials->getKeySession()];
            $now = microtime(true);
            $init = $auth["generated"];

            if (($now - $init) < $auth["expires_in"]) {
                $credentials->setAuthorizationToken($auth["access_token"]);

                return true;
            }
        }

        return false;
    }

    public function post(Itau $credentials, $url_path, $params)
    {
        return $this->send($credentials, $url_path, self::CURL_TYPE_POST, $params);
    }

    private function send(Itau $credentials, $url_path, $method, $jsonBody = null)
    {
        var_dump($this->getFullUrl($url_path));
        $curl = curl_init($this->getFullUrl($url_path));

        $defaultCurlOptions = array(
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json; charset=utf-8'
            ),
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => 0
        );

        $defaultCurlOptions[CURLOPT_HTTPHEADER][] = 'x-itau-correlationID: 2';
        $defaultCurlOptions[CURLOPT_HTTPHEADER][] = 'Authorization: Bearer ' . $credentials->getAuthorizationToken();

        // Add custom method
        if (in_array($method, [
            self::CURL_TYPE_DELETE,
            self::CURL_TYPE_PUT
        ])) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        // Add body params
        if (! empty($jsonBody)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, is_string($jsonBody) ? $jsonBody : json_encode($jsonBody));
        }

        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt_array($curl, $defaultCurlOptions);

        $response = null;
        $errorMessage = '';

        try {
            $response = curl_exec($curl);
        } catch (Exception $e) {
            throw new ItauException("Request Exception, error: {$e->getMessage()}", 100);
        }

        // Verify error
        if ($response === false) {
            $errorMessage = curl_error($curl);
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode >= 400) {
            // TODO see what it means code 100
            throw new ItauException($response, 100);
        }

        // Status code 204 don't have content. That means $response will be always false
        // Provides a custom content for $response to avoid error in the next if logic
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        if (! $response) {
            throw new ItauException("Empty response, curl_error: $errorMessage", $statusCode);
        }

        $responseDecode = json_decode($response, true);
var_dump($responseDecode);
        if (is_array($responseDecode) && isset($responseDecode['error'])) {
            throw new ItauException($responseDecode['error_description'], 100);
        }

        return $responseDecode;
    }

    private function getFullUrl($url_path)
    {
        if (stripos($url_path, $this->baseUrl, 0) === 0) {
            return $url_path;
        }

        return $this->baseUrl . $url_path;
    }
}
