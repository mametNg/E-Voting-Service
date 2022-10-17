<?php

/**
* 
*/
use Controller\Controller;

class Cookies
{
	public $cookieMember = "_c";
	public $cookieUser = "ci";
	public $cookieTime = "tm";
	public $cookieDev = "dv";
	public $cookieIP = "cip";

	function __construct()
	{
		$this->Controller = new Controller();
	}

	public function start()
	{
		if (!$this->check()) $this->set();
	}

	public function check()
	{	
		if (
			!isset($_COOKIE[$this->cookieTime]) || 
			!isset($_COOKIE[$this->cookieDev]) || 
			!isset($_COOKIE[$this->cookieIP]) ||
			!isset($_SESSION[$this->cookieTime]) || 
			!isset($_SESSION[$this->cookieDev]) || 
			!isset($_SESSION[$this->cookieIP])
		) return false;

		$cookieTime = $this->decode($_COOKIE[$this->cookieTime]);
		$cookieDev = $this->decode($_COOKIE[$this->cookieDev]);
		$cookieIP = $this->decode($_COOKIE[$this->cookieIP]);

		$dataCookies = [$cookieTime, $cookieDev, $cookieIP];

		return ($this->expires($dataCookies) ? true:false);
	}

	public function set()
	{
		$this->clear();

		$path = $this->Controller->base_url("/");
		foreach ($this->Controller->get_url() as $key => $value) {
			$path .= $value."/";
		}

		$this->setCookieTime();
		$this->setCookieDevice();
		$this->setCookieIP();

		header("location: ". rtrim($path, "/"));
		exit();
	}

	public function options($time=false)
	{
		return [
			'expires' => $time,
			'path' => '/',
			// 'domain' => $this->Controller->base_host(),
			// 'secure' => true,
			// 'httponly' => true,
			// 'samesite' => 'None'
		];
	}

	public function setCookieLogin($value='')
	{
		$time = time() + (86400);
		$arr_cookie_options = static::options($time);

		setcookie($this->cookieUser, $value, $arr_cookie_options);
	}

	public function setCookieMemberLogin($value='')
	{
		$time = time() + (86400);
		$arr_cookie_options = static::options($time);

		setcookie($this->cookieMember, $value, $arr_cookie_options);
	}

	public function setCookieTime()
	{
		$time = time() + (86400);
		$cookieValue = hash("crc32", $time);
		$cookieValue = $this->encode($cookieValue);

		$arr_cookie_options = static::options($time);

		setcookie($this->cookieTime, $cookieValue, $arr_cookie_options);
		$_SESSION[$this->cookieTime] = $time;
	}

	public function setCookieDevice()
	{
		$time = time() + (86400);
		$cookieValue = hash("fnv1a64", $this->Controller->ua);
		$cookieValue = $this->encode($cookieValue);

		$arr_cookie_options = static::options($time);

		setcookie($this->cookieDev, $cookieValue, $arr_cookie_options);
		$_SESSION[$this->cookieDev] = $time;
	}

	public function setCookieIP()
	{
		$time = time() + (86400);
		$cookieValue = hash("adler32", $this->Controller->ip);
		$cookieValue = $this->encode($cookieValue);

		$arr_cookie_options = static::options($time);
		
		setcookie($this->cookieIP, $cookieValue, $arr_cookie_options);
		$_SESSION[$this->cookieIP] = $time;
	}

	public function clear()
	{
		$arr_cookie_options = static::options(time());

		if (isset($_COOKIE[$this->cookieUser])) {
			setcookie($this->cookieUser, '', $arr_cookie_options);
		}
		if (isset($_COOKIE[$this->cookieTime])) {
			setcookie($this->cookieTime, '', $arr_cookie_options);
		}
		if (isset($_COOKIE[$this->cookieDev])) {
			setcookie($this->cookieDev, '', $arr_cookie_options);
		}
		if (isset($_COOKIE[$this->cookieIP])) {
			setcookie($this->cookieIP, '', $arr_cookie_options);
		}
	}

	public function expires($data=[])
	{
		if ($data[0] !== hash("crc32", $_SESSION[$this->cookieTime])) return false;

		if ($data[1] !== hash("fnv1a64", $this->Controller->ua)) return false;

		if ($data[2] !== hash("adler32", $this->Controller->ip)) return false;

		return ($_SESSION[$this->cookieTime] >= time() ? true:false);
	}

	public function encode($data=false)
	{
		$data = base64_encode($data);
		$data = $this->Controller->balitbangEncode($data);
		$data = strrev($data);
		return $data;
	}

	public function decode($data=false)
	{
		$data = strrev($data);
		$data = $this->Controller->balitbangDecode($data);
		$data = base64_decode($data);
		return $data;
	}

}