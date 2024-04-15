<?php

namespace App\Core;

use App\Supports\Log;
use Exception;
use stdClass;

/**
 *
 */
class Http
{
	/**
	 * @param $url
	 * @param array $data
	 * @param string|null $token
	 * @param string $type
	 * @return stdClass
	 */
	public function post($url, array $data, string $token = null, string $type = "application/json; charset=utf-8")
	{
		$curl = curl_init();

		$httpHeader = array();

		$httpHeader[] = 'Content-Type: ' . $type;

		if ($token) {
			$httpHeader[] = 'Authorization: Bearer ' . $token;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => $httpHeader,
		));
		
		if (CURL_LOG)
		{
			$fp = fopen(dirname(__DIR__, 2).'/logs/curl/post.txt', 'w');
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			curl_setopt($curl, CURLOPT_STDERR, $fp);
		}

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url;
			$logData->runtime = $runtime;
			$logData->data = json_encode($data);
			$logData->error = $error;

			(new Log("Http POST Request", $logData))->saveLog();
		}

		return $this->validateReturn($response, $responseCode);
	}

	/**
	 * @param $url
	 * @param array $data
	 * @param string|null $token
	 * @return mixed
	 */
	public function postFile($url, array $data, string $token = null)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $token
			),
		));

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url;
			$logData->runtime = $runtime;

			$log = (new Log("Http POST Request", $logData))->saveLog();
		}

		if (!empty($error)) {
			$return = new stdClass;
			$return->Error = true;
			$return->ErrorCode = $responseCode;
			$return->ErrorMessage = $error;

			return $return;
		}

		return $response;
	}

	/**
	 * @param $url
	 * @param string|null $token
	 * @param array|null $data
	 * @param string|null $contentType
	 * @return mixed
	 */
	public function get($url, string $token = null, array $data = null, string $contentType = null)
	{
		$curl = curl_init();

		$httpHeader = array();

		if ($token)
			$httpHeader[] = 'Authorization: Bearer ' . $token;

		if ($contentType)
			$httpHeader[] = 'Content-Type: ' . $contentType;

		if (!empty($data)) {
			$queryParams = http_build_query($data, '', '&');
			$queryParams = "?" . str_replace("_", ".", $queryParams);
		} else
			$queryParams = "";

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url . $queryParams,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => $httpHeader,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false
		));
		
		if (CURL_LOG)
		{
			$fp = fopen(dirname(__DIR__, 2).'/logs/curl/get.txt', 'w');
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			curl_setopt($curl, CURLOPT_STDERR, $fp);
		}

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url . $queryParams;
			$logData->runtime = $runtime;
			$logData->error = $error;

			(new Log("Http GET Request", $logData))->saveLog();
		}

		return $this->validateReturn($response, $responseCode);
	}

	/**
	 * @param $url
	 * @param $email
	 * @return stdClass
	 */
	public function getAccess($url, $email, $pass)
	{
		$curl = curl_init();

		$httpHeader = array();
		$httpHeader[] = 'Content-Type: application/x-www-form-urlencoded';

		$data = [
			"UserName" => $email,
			"Password" => $pass,
			"grant_type" => "password",
		];

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_HTTPHEADER => $httpHeader,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false
		));

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url;
			$logData->runtime = $runtime;

			$log = (new Log("Http GET Request", $logData))->saveLog();
		}

		if ($responseCode == 200) {
			return $response;
		} else {
			$return = new stdClass;
			$return->Error = true;
			$return->ErrorCode = $responseCode;
			$return->ErrorMessage = $response->error_description ?? "E-mail e/ou senha incorretos!";

			return $return;
		}
	}

	/**
	 * @param $url
	 * @param array $data
	 * @param string|null $token
	 * @param $type
	 * @return stdClass
	 */
	public function put($url, array $data, string $token = null, $type = "application/json; charset=utf-8")
	{
		$curl = curl_init();

		$httpHeader = array();

		$httpHeader[] = 'Content-Type: ' . $type;

		if ($token) {
			$httpHeader[] = 'Authorization: Bearer ' . $token;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => $httpHeader,
		));
		
		if (CURL_LOG)
		{
			$fp = fopen(dirname(__DIR__, 2).'/logs/curl/delete.txt', 'w');
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			curl_setopt($curl, CURLOPT_STDERR, $fp);
		}

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url;
			$logData->runtime = $runtime;
			$logData->data = json_encode($data);
			$logData->error = $error;

			(new Log("Http PUT Request", $logData))->saveLog();
		}

		return $this->validateReturn($response, $responseCode);
	}

	/**
	 * @param string $url
	 * @param string|null $token
	 * @return stdClass
	 */
	public function delete(string $url, string $token = null)
	{
		$curl = curl_init();

		$httpHeader = array();

		if ($token) {
			$httpHeader[] = 'Authorization: Bearer ' . $token;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST => 'DELETE',
			CURLOPT_HTTPHEADER => $httpHeader,
		));
		
		if (CURL_LOG)
		{
			$fp = fopen(dirname(__DIR__, 2).'/logs/curl/delete.txt', 'w');
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			curl_setopt($curl, CURLOPT_STDERR, $fp);
		}

		$response = curl_exec($curl);
		$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response);

		if (LOG_CURL) {
			$logData = new \stdClass();
			$logData->url = $url;
			$logData->runtime = $runtime;
			$logData->error = $error;

			(new Log("Http DELETE Request", $logData))->saveLog();
		}

		return $this->validateReturn($response, $responseCode);
	}

	/**
	 * @param $response
	 * @param $responseCode
	 * @return stdClass
	 */
	public function validateReturn($response, $responseCode)
	{
		if ($responseCode == 200) {
			return $response;
		} else {
			return $this->returnError($responseCode, !empty($response->ErrorMessage) ? $response->ErrorMessage : "");
		}
	}

	/**
	 * @param int $errorCode
	 * @param string $errorMessage
	 * @return stdClass
	 */
	public function returnError(int $errorCode = 409, string $errorMessage = "Ocorreu um erro. Tente novamente.")
	{
		$return = new stdClass;
		$return->Error = true;
		$return->ErrorCode = $errorCode;
		$return->ErrorMessage = $errorMessage;

		return $return;
	}
}
