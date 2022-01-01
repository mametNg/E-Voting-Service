<?php

namespace Controller;

class Controller {

  public $ua = false;
  public $ip = false;
  public $allowFile = true;

  public function view($view, $data = [])
  {
    $open = 'app/views/'.$view.'.php';
    if (!file_exists($open)) $open = 'app/views/error/404.php';
    include $open;
  }

  public function model($model)
  {
    include 'app/models/'.$model.'.php';
    return new $model;
  }

  public function helper($helper)
  {
    include 'app/helpers/'.$helper.'.php';
    return new $helper;
  }

  public function authApi($authApi)
  {
    include 'app/api/'.$authApi.'.php';
    return new $authApi;
  }

  public function base_url($path='')
  {
    return $this->e(BASE_URL.$path);
  }

  public function base_host()
  {
    return BASE_HOST;
  }

  public function config()
  {
    $this->ua = (!isset($_SERVER['HTTP_USER_AGENT']) ? $this->ua : $this->e($_SERVER['HTTP_USER_AGENT']));
    $this->ip = (!isset($_SERVER['REMOTE_ADDR']) ? $this->ip : $this->e($_SERVER['REMOTE_ADDR']));
    return $this;
  }

  public function e($string="")
  {
    return htmlspecialchars(addslashes(trim($string)));
  }

  public function printJson($arr=array())
  {
    header('Content-Type: application/json');
    print json_encode($arr, JSON_PRETTY_PRINT);
    exit();
  }

  public function array_group($array, $key) {
    $return = array();
    foreach($array as $val) {
      $return[$val[$key]][] = $val;

    }
    return $return;
  }

  public function printImg($path=false)
  {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    header('Content-Type: image/'.$type);
    print $data;
    // print $this->imgToBase64($path);
  }

  public function imgToBase64($path=false)
  {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $img = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $img;
  }

  public function filterString($value='') {
    $result = false;
    for ($i=0; $i < strlen($value); $i++) { 
      if (substr($value, $i,1) == " " || substr($value, $i,1) >= "a" && substr($value, $i,1) <= "z" || substr($value, $i,1) >= "A" && substr($value, $i,1) <= "Z") {
        $result = true;
      } else {
        $result = false;
        break;
      }
    }

    return $result;
  }

  public function filterNumb($value='') {
    $result = false;
    for ($i=0; $i < strlen($value); $i++) { 
      if (substr($value, $i,1) >= "0" && substr($value, $i,1) <= "9") {
        $result = true;
      } else {
        $result = false;
        break;
      }
    }

    return $result;
  }
  
  public function filterMail($email=false)
  {
    return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false ;
  }

  public function randNumb($length)
  {
    $txt = "1234567890";
    $string = "";
    for ($i=0; $i < $length; $i++) { 
      $acak = rand(0, strlen($txt)-1);
      $string .= $txt[$acak];
    }
    return $string;
  }

  public function randString($length)
  {
    $chars = "abcdefghijklmnopqrstuvwxyz";
    $txt = "1234567890".strtolower($chars).strtoupper($chars);
    $string = "";
    for ($i=0; $i < $length; $i++) { 
      $acak = rand(0, strlen($txt)-1);
      $string .= $txt[$acak];
    }
    return $string;
  }

  public function filterImg($myFile=[])
  {
    $img = [
      'name'            => trim($myFile['name']),
      'size'            => trim($myFile['size']),
      'type'            => trim($myFile['type']),
      'tmp'             => trim($myFile['tmp_name']),
      'pixel'           => @getimagesize($myFile['tmp_name']),
      'error'           => trim($myFile['error']),
      'extension'       => explode(".", trim($myFile['name'])),
      'allowExtension'  => ['png', 'jpg', 'jpeg', 'svg'],
    ];

    if (!in_array(end($img['extension']), $img['allowExtension'])) {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    if ($img['type'] !== "image/jpeg" && $img['type'] !== "image/png" && $img['type'] !== "image/svg+xml") {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    if ($img['pixel'] == false && end($img['extension']) !== 'svg') {
      return [
        'status'  => false,
        'msg'     => "Malicious files detected!",
      ];
    }

    if (!in_array(end($img['extension']), $img['allowExtension'])) {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    return [
      'status'  => true,
      'msg'     => "",
    ];
  }

  public function balitbangEncode($str='',$code=82)
  {
    $t='';
    if(($code>=0)and($code<100)) {
      $t .=dechex(strlen($str)+$code)."g";
      $str=strrev($str);
      for($i=0;$i<=strlen($str)-1;$i++) {
        $t .=dechex(ord(substr($str,$i,1))+$code);
      }
    }
    return $t;
  }

  public function balitbangDecode($str='',$code=82)
  {
    $all = explode("g",$str);
    $dec = $str;
    if (isset($all[1])) {
      $head = hexdec($all[0])-$code;
      $content = $all[1];
      $dec = '';
      if($head==(strlen($content)/2)) {
        for($i = 0; $i <= $head-1; $i++) {
          $dec .= chr(hexdec(substr($content,$i*2,2))-$code);
        }
        $dec = strrev($dec);
      }
    }
    return $dec;
  }

  public function RSAPublicKey()
  {
    $public = '-----BEGIN PUBLIC KEY----- YOUR KEY -----END PUBLIC KEY-----';
    return $public;
  }

  public function RSAPrivateKey()
  {
    $private = "-----BEGIN RSA PRIVATE KEY-----\n";
    $private .= "YOUR KEY\n";
    $private .= "-----END RSA PRIVATE KEY-----";
    return $private;
  }

  public function RSAdecrypt($field){

    if (!$privateKey = openssl_pkey_get_private($this->RSAPrivateKey()))
      return false;

    $decrypted_text = "";
    if (!openssl_private_decrypt(base64_decode($field), $decrypted_text, $privateKey))
      return false;

    $strTime = (int)substr($decrypted_text, strripos($decrypted_text, "+")+1);
    $decrypted_text = substr($decrypted_text, 0, strripos($decrypted_text, "+"));

    $time = time();

    openssl_free_key($privateKey);

    if(($time - $strTime) < 30){
      return $decrypted_text;
    } else {
      return false;
    }

  }

  public function get_url()
  { 
    $url[] = "";
    if (isset($_GET['url'])) {
      $url = htmlspecialchars(addslashes(trim(trim($_GET['url'], "/"))));
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode("/", $url);
    } 
    return $url;
  }
}