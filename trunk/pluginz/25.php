<?php

if (!defined('RAPIDLEECH'))
{
  require_once("404.php");
  exit;
  }
if ($_POST["step"]==1){
    
$LINK=$_POST["link"];
$cookie = $_POST['cookie'];
$FileName = $_POST['filename'];
$Url=parse_url($LINK);

//$page = geturl($Url["host"], $Url["port"] ? $Url["port"] : 80, $Url["path"].($Url["query"] ? "?".$Url["query"] : ""), 0, $cookie, 0, 0, $_GET["proxy"],$pauth);
//is_page($page);

//insert_timer("10");

insert_location("$PHP_SELF?filename=".urlencode($FileName)."&force_name=".urlencode($FileName)."&host=".$Url["host"]."&path=".urlencode($Url["path"].($Url["query"] ? "?".$Url["query"] : ""))."&referer=".urlencode($Referer)."&email=".($_GET["domail"] ? $_GET["email"] : "")."&partSize=".($_GET["split"] ? $_GET["partSize"] : "")."&method=".$_GET["method"]."&cookie=".urlencode($cookie)."&proxy=".($_GET["useproxy"] ? $_GET["proxy"] : "")."&saveto=".$_GET["path"]."&link=".urlencode($LINK).($_GET["add_comment"] == "on" ? "&comment=".urlencode($_GET["comment"]) : "")."&auth=".$auth.($pauth ? "&pauth=$pauth" : ""));
    
}else{			
$page = geturl($Url["host"], $Url["port"] ? $Url["port"] : 80, $Url["path"], $Referer, 0, 0, 0, $_GET["proxy"],$pauth);
is_page($page);
if (slice($page,"Location: ","\r")) html_error( "Probably the link is typed incorrect or old , verify it in your browser." , 0 );
is_present($page,"file does not exist", "The requsted file does not exist on this server.", 0);
$cookie=GetCookies($page);
$FileName=cut_str($page,"Name: </strong>","</font>");
$ss = <<<HTML
<html>
<head>
<title>FormLogin</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<form method="post" name="plink" action="$PHP_SELF">
<input id="link" name="link" type="hidden">
<input type="hidden" name="cookie" value="$cookie" >
<input type="hidden" name="step" value="1" > 
<input type="hidden" name="filename" value="$FileName">
</form>
HTML;

preg_match('/(var pong[\s\S]+?)<\/script>/i',$page,$scr)  ;
//$script1=slice($page,'var','function',3);
$script1=$scr[1];
$var=trim(slice($script1,'<a href="\' + ',' + \'"'));
$script=$ss.'<script language="Javascript">'.$script1.'document.getElementById("link").value='.$var.'; document.plink.submit();</script>' ;

echo ($script);
}

function slice($str, $left, $right,$cont=1)
	{
    for($iii=1;$iii<=$cont;$iii++){
	$str = substr ( stristr ( $str, $left ), strlen ( $left ) );
	}
    $leftLen = strlen ( stristr ( $str, $right ) );
    $leftLen = $leftLen ? - ($leftLen) : strlen ( $str );
    $str = substr ( $str, 0, $leftLen );
    return $str;
}

/*************************\
 WRITTEN BY KAOX 30-jan-10
\*************************/

?>