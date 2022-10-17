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

  public function e($string="", $replace=false)
  {
    return htmlspecialchars(addslashes(trim($string, $replace)));
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

  public function invalid($status=false, $code=403, $msg="access denied", $data=[])
  {
    $response = [
      'status'  => $status,
      'code'    => $code,
      'msg'     => $msg,
      'result'  => $data,
    ];

    return $response;
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

  public function saveVisitor()
  {
    $query = [
      "ip_address" => $this->myIP(),
      "device" => $this->userAgent(),
      "created" => time(),
    ];
    return $query;
  }

  public function saveHistory($code=200, $msg = "OK")
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $params = http_build_query($_POST);
    } else {
      $params = http_build_query($_GET);
    }

    $query = [
      "email" => (isset($_SESSION['email']))? htmlspecialchars($_SESSION['email']):"",
      "ip_address" => $this->myIP(),
      "method" => $_SERVER['REQUEST_METHOD'],
      "query" => $_SERVER['REQUEST_URI'],
      "params" => $params,
      "code" => $code,
      "msg" => $msg,
      "device" => $this->userAgent(),
      "created" => time(),
    ];
    return $query;
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

  public function CryAttr() 
  {
    return array(
      'a' => "*&^D1",
      'b' => "VFM*(",
      'c' => "X@$&s",
      'd' => ")(XZC",
      'e' => ":$(*)",
      'f' => "(NB*+",
      'g' => "|:E@$",
      'h' => "MX*(@",
      'i' => "@D%#@",
      'j' => "(*NM)",
      'k' => "@()D4",
      'l' => "@#_$@",
      'm' => "++(#!",
      'n' => "_)(D@",
      'o' => ")M&J^",
      'p' => "@_&*!",
      'q' => ")(^&!",
      'r' => "+*@5&",
      's' => ")Y^)(",
      't' => "_@@#$",
      'u' => "+!%Q@",
      'v' => "_@#A&",
      'w' => "{)(&@",
      'x' => "NX)(@",
      'y' => "=)(&$",
      'z' => ")_(&D",
      'A' => "+)*&#",
      'B' => "@$@!@",
      'C' => "=1$@(",
      'D' => "_@$^&",
      'E' => "X!@)*",
      'F' => "@)*(S",
      'G' => "NX@_#",
      'H' => "^#D@f",
      'I' => "2()@*",
      'J' => "@a#_)",
      'K' => "@*A%#",
      'L' => "@C$!V",
      'M' => "V%#S#",
      'N' => "#V@B#",
      'O' => "$%@CQ",
      'P' => "%C#!G",
      'Q' => ")_Y*(",
      'R' => "N@&)A",
      'S' => "@M)*S",
      'T' => "MNC@_",
      'U' => "@#%Cw",
      'V' => "_3*&$",
      'W' => "@NX@&",
      'X' => "@(*%!",
      'Y' => "N&@T(",
      'Z' => "@#)(*",
      '1' => "*&%@@",
      '2' => "!()&N",
      '3' => "@#)^!",
      '4' => "+)#!S",
      '5' => "(*^NB",
      '6' => "@+_!*",
      '7' => "+_)#!",
      '8' => "=)@%_",
      '9' => "_)(@S",
      '0' => "+_@*@",
      '-' => "!_~$@",
      '=' => "+*(#&",
      '`' => "+&@#^",
      '~' => "+_!&+",
      '!' => "~_^@*",
      '@' => "*^*)(",
      '#' => "@#_^&",
      '$' => "@$!~$",
      '%' => ")^~$+",
      '^' => "~&*(_",
      '&' => "()@$&",
      '*' => ")N^#@",
      '(' => "@#_)&",
      ')' => "+_*(#",
      '_' => "@_^&3",
      '[' => "@&+*&",
      ']' => "()#@~",
      '{' => "_^*(@",
      '}' => "_)&@#",
      "\/" => "+&(+O",
      '|' => "}*#+_",
      ';' => "+_~$&",
      ':' => "_)^&#",
      '"' => "_^&_@",
      "'" => ")(&#@",
      ',' => ")&#@~",
      '.' => ")&#)@",
      '<' => "@@%1$",
      '>' => "~#@$@",
      '?' => "{_)+@",
      '/' => "+_@2#",
      ' ' => ")@_+@",
    );
  }

  public function CryEnc($txt='')
  {
    $enc = "";
    $lenght = strlen($txt);
    for ($i=0; $i < $lenght; $i++) { 
      if (isset($this->CryAttr()[substr($txt, $i,1)])) {
        $enc .= $this->CryAttr()[substr($txt, $i,1)].",";
      }
    }
    $enc = rtrim($enc,",");
    $enc = base64_encode($enc);

    $arr = array('a','i','u','e','o','A','I','U','E','O','=');
    $_arr = array('�a','�i','�u','�e','�o','�A','�I','�U','�E','�O','�');

    $enc = gzencode($enc);
    $enc = strrev($enc); // DI BALIKKAN
    $enc = gzcompress($enc);
    $enc = base64_encode($enc);
    $enc = strrev($enc); // DI BALIKKAN
    $enc = str_replace($arr, $_arr, $enc);

    return $enc;
  }

  public function CryDec($txt='')
  {
    // error_reporting(0);
    $arr = array('a','i','u','e','o','A','I','U','E','O','=');
    $_arr = array('�a','�i','�u','�e','�o','�A','�I','�U','�E','�O','�');
    $dec = str_replace($_arr, $arr, $txt);
    $dec = strrev($dec);
    $dec = base64_decode($dec);
    $dec = gzuncompress($dec);
    $dec = strrev($dec);
    $dec = gzdecode($dec);
    $dec = base64_decode($dec);

    $exp = explode(",", $dec);
    $result = '';
    for ($i=0; $i < count($exp); $i++) { 
      foreach ($this->CryAttr() as $key => $value) {
        if ($exp[$i] == $value) {
          $result .= $key;
        }
      }
    }

    return $result;

  }

  public function w3llEncode($str=false)
  {
    $first = '$'.dechex(strlen($str)*strlen($str)+$this->randNumb(2));
    $second = "";
    for ($i=0; $i < strlen($str); $i++) { 
      $second .= dechex(decoct(ord(substr($str, $i, 1))));
    }
    $second = $first ."$". $second;
    $tree = ""; 
    for ($x=0; $x < strlen($second); $x++) { 
      $tree .= dechex(decoct(ord(substr($second, $x, 1))));
    }
    $result = $second ."/". $tree;
    return trim($result);
  }

  public function w3llDecode($str=false)
  {
    $splitFirst = explode("/", $str);
    $splitSecond = explode("$", $str);
    $result = false;
    if (count($splitFirst) == 2 && count($splitSecond) == 3) {
      $first = $splitFirst[0];
      $second = $splitFirst[1];
      $confirmFirst = "";
      for ($i=0; $i < strlen($second)/2; $i++) { 
        $confirmFirst .= chr(octdec(hexdec(substr($second, $i*2, 2))));
      }
      if ($first == $confirmFirst) {
        $finish = explode("$", $confirmFirst);
        if (count($finish) == count($splitSecond)) {
          $result = "";
          for ($i=0; $i < strlen($second)/2; $i++) { 
            $result .= chr(octdec(hexdec(substr($finish[2], $i*2, 2))));
          }
        }
      }
    }
    return trim($result);
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

  public function chars()
  {
    $data = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', '1', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', ' '];
    return $data;
  }

  public function numbs()
  {
    $data = ['1' => 'a', '2' => 'b', '3' => 'c', '4' => 'd', '5' => 'e', '7' => 'f', '8' => 'g', '9' => 'h', '0' => 'i'];
    return $data;
  }

  public function symbols()
  {
    $data = ['`', '~', '!', '@', '#', '$', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', ',', '<', '.', '>', '/', '?', ';', ':', '"', "'", '[', '{', ']', '}', "\/", '|'];
    return $data;
  }

  public function mailler($params=[])
  {

    if (!isset($params['to'])) {
      return false;
    }

    if (!isset($params['subject'])) {
      $params['subject'] = '';
    }

    if (!isset($params['msg'])) {
      $params['msg'] = '';
    }

    if (!isset($params['from_name'])) {
      $params['from_name'] = 'W3LL Team';
    }

    if (!isset($params['from_mail'])) {
      $params['from_mail'] = 'team@w3llsquad.or.id';
    }

    // Digunakan untuk promosi
    if (isset($params['reply'])) {
      // balas ke
      $headers[] = 'Reply-To: '.$params['reply']; // $params['reply'] = 'cs@w3llsquad.or.id';
    }

    // dikirim dari
    $headers[] = 'From: '. $params['from_name'] .' <'. $params['from_mail'] .'>';
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $sendMail = mail($params['to'], $params['subject'], $params['msg'], implode("\r\n", $headers));

    if ($sendMail == false) {
      $this->mailler($params);
    }

    return $sendMail;

  }

  public function RSAPublicKey()
  {
    $public = '-----BEGIN PUBLIC KEY-----MIICITANBgkqhkiG9w0BAQEFAAOCAg4AMIICCQKCAgBVF6uQzQVvodjUrm6wrJf+1NRy6jQZwznyFif3/LDbtTQhnol/VAoTlMLYkyEXK9slWFEF6hJAtK7vrycEksIN8sczCyZ2Fhwnf6K9BNjpZhjudbmjmjGB/RN9WjOqb3aaXKjsM81ZCftfMyBqoOdWKV1+rhvuMC1WpFjvSkKLh0k3+dtIXW75AkkXrtJywn8h2eQ02TmSayG7sO+Q1/7drBON91Gxaj6LYkMW7MC9MymdYy3QVQz38ROk3pbfUA0M4tfpTVtjrBd8Hwk5U+96xL41GHK3bpVyNQt3ws0vJufTxJ1e4i593ubhvypw7kMALLt6b4fvhEmAi8PAxBo98dvHpBsZOOzW1clnqWsqx8vZEsk0W4QnN6yATgMnzJW1hAQqJxO15REZijCR+7T40buWKtQTCTAelk0OxVoeyWmLV8rpt+rZNXtY0c8yZsLGngrFDqr7bJQOoN24C3/p5Fn9UIoMZc1N/Zi2d/unzHSlKSHBQv4siu1zX5RrB6XXSpG9ACUfjFzuomWiVtWtyzNqsQodRHaRQGNCkDoCuJTBBQ8RpbBUDLNQfA1By6Wvbm00sFkI5IBmpK77rm/hbZsJpNf9WPS6yjuY1NGsMRKP5AI+XD3DZjFR6vUveRdkaql0eB2N5K3JJkbVJ9ciAmN/T1Jg3S6u8ffVKt36LQIDAQAB-----END PUBLIC KEY-----';
    return $public;
  }

  public function RSAPrivateKey()
  {
    $private = "-----BEGIN RSA PRIVATE KEY-----\n";
    $private .= "MIIJKAIBAAKCAgBVF6uQzQVvodjUrm6wrJf+1NRy6jQZwznyFif3/LDbtTQhnol/\n";
    $private .= "VAoTlMLYkyEXK9slWFEF6hJAtK7vrycEksIN8sczCyZ2Fhwnf6K9BNjpZhjudbmj\n";
    $private .= "mjGB/RN9WjOqb3aaXKjsM81ZCftfMyBqoOdWKV1+rhvuMC1WpFjvSkKLh0k3+dtI\n";
    $private .= "XW75AkkXrtJywn8h2eQ02TmSayG7sO+Q1/7drBON91Gxaj6LYkMW7MC9MymdYy3Q\n";
    $private .= "VQz38ROk3pbfUA0M4tfpTVtjrBd8Hwk5U+96xL41GHK3bpVyNQt3ws0vJufTxJ1e\n";
    $private .= "4i593ubhvypw7kMALLt6b4fvhEmAi8PAxBo98dvHpBsZOOzW1clnqWsqx8vZEsk0\n";
    $private .= "W4QnN6yATgMnzJW1hAQqJxO15REZijCR+7T40buWKtQTCTAelk0OxVoeyWmLV8rp\n";
    $private .= "t+rZNXtY0c8yZsLGngrFDqr7bJQOoN24C3/p5Fn9UIoMZc1N/Zi2d/unzHSlKSHB\n";
    $private .= "Qv4siu1zX5RrB6XXSpG9ACUfjFzuomWiVtWtyzNqsQodRHaRQGNCkDoCuJTBBQ8R\n";
    $private .= "pbBUDLNQfA1By6Wvbm00sFkI5IBmpK77rm/hbZsJpNf9WPS6yjuY1NGsMRKP5AI+\n";
    $private .= "XD3DZjFR6vUveRdkaql0eB2N5K3JJkbVJ9ciAmN/T1Jg3S6u8ffVKt36LQIDAQAB\n";
    $private .= "AoICACtKyqf2F0DvaAD06i4K8Z3eLGR20aEV2WJYcWdS8awmaep83VmhqSrDMcq8\n";
    $private .= "OEawsmMypq5Ko5S2GJarVz+VZxNvpHdMwfmsUBCseGCQmcdNgXu4+4TIC04mMwdA\n";
    $private .= "oC6jXQU2BV9/D4ewc2rA+UomqOwGSaIM9PrfGgINxY2hC3AvmUnYXf9YQgCAcC2T\n";
    $private .= "bVCjscjIMbnNluPui5AReiEIM4wWYzCEVtTbyAxkJtwAAiOAZzjC3+kxjFKNHcBw\n";
    $private .= "2vOsp6cZtl3lVIzGXoBwzeGT2bBtbpRW5u56XaBoang47OmDcskkLCi9DIhPosnR\n";
    $private .= "18bzAbWSDKRDIDb05+x1r1dgrjSkrCdedew6yC7vsJ/rOcUk/06oWf0py62/xq1N\n";
    $private .= "BV69KHVTW2N6/uLPjvHnB/5l3FAxdkcZiRqpD+l07a6Voxt7y/QIbc8Q1l9ylq7t\n";
    $private .= "n2mL1hhfW5+CgjpwjJBkGeKJFe4R9osHpGwTYeTuLoJ7Bgf5yHp+cPdqIFv5kdc1\n";
    $private .= "VVn3kWB3uJFJyAlNaY0CvsPF8PN2EgsEPcm6d4BZ4mUw2BblWyKXw/dopM6koLWL\n";
    $private .= "L9NRdy7PENqlADbRj1s9yXHdwFaJZwaAFuVkLNuHuMZpGvBznO1EvPaz7ZPD6sKa\n";
    $private .= "LNZE7vduJUXaKq7B75GyNYDuFPwHVblFIlEVhydhxxRkG7UlAoIBAQClp+Qw+JQ5\n";
    $private .= "QSwHNMwddCUmazaFzzD4CxRwM+UKUsUHRvp62TThfqMBxfHuMk+h3Oq5sgkaBzxp\n";
    $private .= "lZ6Z6CGdTCYGVodF4TpwnAEa9RxjmuJHoIHgB2Bg23p4IOcbCiAkO0bpWk17QpJQ\n";
    $private .= "ytx59nI8i/vy4s1xM8fRepoM82zfzu6Gvfa9t5sUApNefhFpS2+83og0lJRJ5Omg\n";
    $private .= "eicbFxc5stWSOVO/GJ17TLApanvmfdrtkVgZ0iH6rhzPHaiehzWNmcDGKNz/GlE+\n";
    $private .= "bww+vRz7BQ9vbWnBhKP4kU44IpC4OT3rWfDjsNsHDK1w7jWQF1ozwiAqZ4aAgiu2\n";
    $private .= "AfDN/dVaAXkfAoIBAQCDf+Pzpp41BS896V2UoLqJLmzLJXFET2D9OkUjMQdc33nY\n";
    $private .= "YqtU9zxQT+lR23+ky+5ypZMOQ9G/LYSEW97P2sxmi8vXu1xiZE0k1aidmrPUuUAW\n";
    $private .= "BgsKOOWcuTrZrGLCENNppWlhZSVd9NAef7QrhiD30wZamFR2c9b2iNN0uARojpGr\n";
    $private .= "ApYtM5tgstQxFK5Yqwa7MYk7Psy126uaekgLGXSOsK5lnSb56vN45/88LDVzfC5Q\n";
    $private .= "XM7+J5R1dspccsH7E1kQjt3zCaXYfc6CvTPXhCsTN/LrO18Ih1aKs4f0BMtnknAG\n";
    $private .= "emhS1ZzUSUHV3v49Ju8XlMcqGu8IeiqFQBqOXQczAoIBAQCSOmjxXYyiGch+t/ly\n";
    $private .= "CoN8rWlcpu+IFWe+P+Dvwu6PpPUYmkHWx42m1A/ifuDSdgtxThpAsqB+Z4ewPjvl\n";
    $private .= "+UEbmSgh5FZM7zj+jd24gxE5vxLGKlzGQxeRkSHQOZjzwquu83qv0q0Lynbi5kwi\n";
    $private .= "7ELEPbayNc4uOPZhdkPmMGlX4bo78CZhfICQCeLeuqtw4lMDbyCTNhGRCiMZA8IJ\n";
    $private .= "ubZTNG2bo2PoYmKivI+QgApQaVuGt3otKaLepUSiY6I/U7jac1nZimarISWDADbj\n";
    $private .= "0qy0ZLXVEHwZwFJ2tPRg2o6xARzmMMi3KVa0+GGpxyNlyvfP1sDhEYb6TC4/99Bs\n";
    $private .= "eh5rAoIBAHtQJeJpf/i2aOvE+HWVF/fmqi0CaqolSg2NZCIxKvdjta4+MO7Xfh7O\n";
    $private .= "IT0a+iL+/hdSv4lj/cAqnhdE07fVNVKAi+I9F9BIwLLnDVzmIvc71SYR+q5WVrPW\n";
    $private .= "W6KebmoQP0DV1fF4WUc3eSbwmHMsL6RWpqG0MZh23sGH48uTeMbX0zArl8rBl1Zh\n";
    $private .= "vGxeOXR6xTArrsX5CR0M52pQe1i1QUFB2/j8Gv3H3xOlcwrpZiJq9D92GMHrOePB\n";
    $private .= "RtjU4KVjKmVFpErx5C0VJOAjLwdOMNqv38PJhD/KMlSVMMua52ezwgvBJC1xlcTZ\n";
    $private .= "AbzehUmxRgq2AOKyKS+o6FDWoVCZWlMCggEBAJDV12KPjghoi0dMpjabr2aDXVap\n";
    $private .= "onK8i6KiJUK2QsbW3VxY4VbuVxkY4kHyVHMLfOUzE39ujD5h0kVhnPGHUuSNZbeC\n";
    $private .= "tmLSAvn0+hLvFixpRdvU0Wu7yBS1sKSUWT1pzc2898VIjb9Qy8kXK6NhmtCUAmg9\n";
    $private .= "eXnooH3jpIq8cN/PHITKWHAVXqMW1I/mV24Qh/dyrIc5T3uGvQM7zpOwvcBu+tCY\n";
    $private .= "bN+eOtoeCZ9YOttiCqNIz5UaX4AzKoU765yxwg7mJLG701DaMZ6OZh+FoEY4tw4+\n";
    $private .= "aB7YtXDoZx+JdP2mC4ktqprm6RbrBF+tz32YEgWaIYKg5k0GLwgDBiAq67c=\n";
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