<?php  declare(strict_types=1);namespace App\Validations;class CurlValidation extends Validation{const ROUTE_VALIDATION='/openwrt';const ROUTE_METHOD=CURLOPT_POST;const ROUTE_STATUS_CODE=202;public function cURLcheckBasicFunctions():bool{if(!function_exists('curl_init')&&!function_exists('curl_setopt')&&!function_exists('curl_exec')&&!function_exists('curl_close')){return false;}else{return true;}}public function isValidToken($host,$token):bool{if(!$this->cURLcheckBasicFunctions()){return false;}$host=str_ends_with($host,'/')?substr_replace($host,'',-1):$host;$endpoint=$host.self::ROUTE_VALIDATION;$status=0;$curlHandler=curl_init();if($curlHandler !==false){curl_setopt($curlHandler,CURLOPT_URL,$endpoint);curl_setopt($curlHandler,self::ROUTE_METHOD,1);curl_setopt($curlHandler,CURLOPT_RETURNTRANSFER,1);curl_setopt($curlHandler,CURLOPT_HTTPHEADER,["Authorization: Bearer $token"]);curl_exec($curlHandler);$status=curl_getinfo($curlHandler,CURLINFO_HTTP_CODE);curl_close($curlHandler);}return $status ==self::ROUTE_STATUS_CODE;}public function isValidatedRequest($request):bool{if(!$this->isCorrectRequest($request)){return false;}$host=$_ENV['CAPTIVEFIRE_ACCESS'];return $this->isValidToken($host,$this->getToken($request));}}