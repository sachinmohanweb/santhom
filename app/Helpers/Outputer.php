<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use stdClass;

class Outputer 
{
	protected $data;
	protected $count;
	protected $metadata = [];
	protected $DailyDigest = [];
	protected $LoginUser = [];
	protected $code = 200;
	protected $success = true;
	protected $attribute = null;
	protected $extraInfo = null;

	public function success( $data)
	{
		$this->data = $data;
		return $this;
	}

	public function count( $count)
	{
		$this->count = $count;
		return $this;
	}

	public function metadata( $metadata)
	{
		$this->metadata = $metadata;
		return $this;
	}
	public function DailyDigest($DailyDigest)
	{
	    $this->DailyDigest = $DailyDigest;
	    return $this;
	}
	public function LoginUser($LoginUser)
	{
	    $this->LoginUser = $LoginUser;
	    return $this;
	}

	public function code( $code)
	{
		$this->code = $code;
		return $this;
	}

	public function attribute( $attribute)
	{
		$this->attribute = $attribute;
		return $this;
	}

	public function error( $data)
	{	
		$this->data = $data;
		$this->success = false;
		return $this;
	}

	public function extraInfo( $data)
	{	
		$this->extraInfo = $data;
		return $this;
	}

	function formatHttpHeader($code, $message = null)
	{	
		if(!is_null($message))
		{
	   		return 'HTTP/1.1' . ' ' . $code . ' ' . $message;
		}

		switch ($code) {
	       case 100: $text = 'Continue'; break;
	       case 101: $text = 'Switching Protocols'; break;
	       case 200: $text = 'OK'; break;
	       case 201: $text = 'Created'; break;
	       case 202: $text = 'Accepted'; break;
	       case 203: $text = 'Non-Authoritative Information'; break;
	       case 204: $text = 'No Content'; break;
	       case 205: $text = 'Reset Content'; break;
	       case 206: $text = 'Partial Content'; break;
	       case 300: $text = 'Multiple Choices'; break;
	       case 301: $text = 'Moved Permanently'; break;
	       case 302: $text = 'Moved Temporarily'; break;
	       case 303: $text = 'See Other'; break;
	       case 304: $text = 'Not Modified'; break;
	       case 305: $text = 'Use Proxy'; break;
	       case 400: $text = 'Bad Request'; break;
	       case 401: $text = 'Unauthorized'; break;
	       case 402: $text = 'Payment Required'; break;
	       case 403: $text = 'Forbidden'; break;
	       case 404: $text = 'Not Found'; break;
	       case 405: $text = 'Method Not Allowed'; break;
	       case 406: $text = 'Not Acceptable'; break;
	       case 407: $text = 'Proxy Authentication Required'; break;
	       case 408: $text = 'Request Time-out'; break;
	       case 409: $text = 'Conflict'; break;
	       case 410: $text = 'Gone'; break;
	       case 411: $text = 'Length Required'; break;
	       case 412: $text = 'Precondition Failed'; break;
	       case 413: $text = 'Request Entity Too Large'; break;
	       case 414: $text = 'Request-URI Too Large'; break;
	       case 415: $text = 'Unsupported Media Type'; break;
	       case 422: $text = 'Invalid Request'; break;
	       case 500: $text = 'Internal Server Error'; break;
	       case 501: $text = 'Not Implemented'; break;
	       case 502: $text = 'Bad Gateway'; break;
	       case 503: $text = 'Service Unavailable'; break;
	       case 504: $text = 'Gateway Time-out'; break;
	       case 505: $text = 'HTTP Version not supported'; break;
	       //--deafault
	       default: $text = 'Unknown Error';break;
   		}

	   return 'HTTP/1.1' . ' ' . $code . ' ' . $text;
	}

	public function json()
	{
		header('Content-Type: application/json');

		if( $this->success ){ 
			$res = new stdClass;
			$res->status = 'success';
			!is_null($this->count) ? $res->count = $this->count : '';
			$res->metadata = $this->metadata;
			$res->data = $this->data;
			if (!empty($this->DailyDigest)) {
					$res->DailyDigest = $this->DailyDigest;
			}
			if (!empty($this->LoginUser)) {
					$res->LoginUser = $this->LoginUser;
			}

			return new JsonResponse($res, $this->code);
		}

		$message = $this->data;
		$errorResponse = [ 'status'=>'error', 'message'=>$message, 'attribute' => $this->attribute, 'extraInfo' => $this->extraInfo ];
		return new JsonResponse($errorResponse, $this->code);	
	}

	public function fail($code=null)
	{
		header('Content-Type: application/json');
		$header = $this->formatHttpHeader($this->code);
	    header($header);	    
		if (!empty(config("errorcodes.$code"))) {
			$res = [ 'status'=>'error', 'code'=>$code, 'reason'=>config("errorcodes.$code")];					
		}else {
			$res = [ 'status'=>'error', 'code'=>$code];
		}
	    return new JsonResponse($res, $this->code);
	}
	
}