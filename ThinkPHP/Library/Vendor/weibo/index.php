<?php

session_start();
//if( isset($_SESSION['last_key']) ) header("Location: weibolist.php");
include_once('config.php' );
include_once('weibooauth.php' );



$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();

$callback =  "http://www.gsteps.com/gsteps";


$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , $callback );

$_SESSION['keys'] = $keys;


?>
<a href="<?=$aurl?>">Use Oauth to login</a>