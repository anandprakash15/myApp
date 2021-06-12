<?php
namespace common\components;
use yii;
 
class CustomUrlRule extends yii\web\UrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager, $route, $params)
    {

        $args='?';
        $idx = 0;
        
        foreach($params as $num=>$val){
            if($num == 'id')
            { 
                $val = $this->encryptor('encrypt',$val);
            }

            if(is_array($val)){
                $paramarray[$num] = $val;
                $idx++;
                $args .= http_build_query($paramarray);
                if($idx!=count($params)) $args .= '&';
                
            }else{
                $args .= $num . '=' . $val;
                $idx++;
                if($idx!=count($params)) $args .= '&';
            }
        }
        $suffix = Yii::$app->urlManager->suffix;

        if ($args=='?') $args = '';
        return $route .$suffix. $args;
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $url = $request->getUrl();
        $queryString = parse_url($url);
        if(isset($queryString['query'])){
            $queryString = $queryString['query'];
            $args = [];
            parse_str($queryString, $args);
            $params = [];
            foreach($args as $num=>$val){
                if($num=='id'){
                    $val = $this->encryptor('decrypt',$val);
                }
                $params[$num]=$val;
            }
            $suffix = Yii::$app->urlManager->suffix;
            $route = str_replace($suffix,'',$pathInfo);
            return [$route,$params];
        }
        return false;  // this rule does not apply
    }

   function encryptor($action, $string) {
        $output = false;
        $encrypt_method = "BF-CBC";
        $key = "!@%&*#YR*(gfhiu@#@@";
        //pls set your unique hashing key
        $secret_key = $key;
        $secret_iv = $key;
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 8);

        //do the encyption given text, string, number
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            //decrypt the given text, string, number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}