<html>
<head>
<title>AjpdSoft - Calculadora</title>
</head>
<body>
<?php 
/****************************************
***************************************
*************************************
*****         Simple Calculator v1.0
*****
*****   by Surren a.k.a. Wargoat
*****   Wargoat@mailandnews.com
*****   Copyright (c) 2001. 
*****   All Rights Reserved
*****
*****   Feel Free to redistribute 
*****   and/or modify at will, please
*****   leave copyright and Credits.
*****   *Use at Own Risk* 
*****	there is no warranty, or by 
*****	using this I take no 
*****   responsibility for any
*****	damage (what's a calc gonna do?)
*****	done to your site or you.
*****
*****   http://wargoat.cjb.net
*****	http://wargoat.hobbiton.org
************************************
**************************************
****************************************/

//variables being posted
$t1 = $HTTP_POST_VARS['n1'];
$t2 = $HTTP_POST_VARS['n2'];
$t3 = $HTTP_POST_VARS['R1'];
$b1 = $HTTP_POST_VARS['D1'];
$b2 = $HTTP_POST_VARS['n3'];

//first commands
if($t3 == a)
	$ta = $t1 + $t2;

if($t3 == s)
	$ta = $t1 - $t2;

if($t3 == m)
	$ta = $t1 * $t2;

if($t3 == d)
	$ta = $t1 / $t2;

if($t3 == pow)
	$ta = pow($t1, $t2);

//2nd commands
if($b1 == abs)
	$ta = abs($b2);

if($b1 == sin)
	$ta = sin($b2);

if($b1 == cos)
	$ta = cos($b2);

if($b1 == tan)
	$ta = tan($b2);

if($b1 == asin)
	$ta = asin($b2);

if($b1 == acos)
	$ta = acos($b2);

if($b1 == atan)
	$ta = atan($b2);

if($b1 == sqrt)
	$ta = sqrt($b2);

if($b1 == log)
	$ta = log($b2);

if($b1 == log10)
	$ta = log10($b2);

if($b1 == rad2deg)
	$ta = rad2deg($b2);

if($b1 == deg2rad)
	$ta = deg2rad($b2);

if($b1 == dec2bin)
	$ta = decbin($b2);

if($b1 == bin2dec)
	$ta = bindec($b2);

if($b1 == dec2hex)
	$ta = dechex($b2);

if($b1 == hex2dec)
	$ta = hexdec($b2);

if($b1 == dec2oct)
	$ta = decoct($b2);

if($b1 == oct2dec)
	$ta = octdec($b2);

?> 
<table width="250" border="1" cellspacing="0" cellpadding="0" bgcolor="#0066FF">
  <tr bgcolor="#003399" valign="top" align="center"> 
    <td><font color="#CCCCCC" face="Verdana, Arial, Helvetica, sans-serif" size="2">Wargoat's 
      Calculator Script</font></td>
  </tr>
  <tr align="center" valign="top"> 
    <td> 
      <form action="simpcalc.php" method="post">
        <font color="#CCCCCC" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        N1: 
        <input type="text" name="n1" size="8">
        N2: 
        <input type="text" name="n2" size="8">
        <br>
        +
	<input type="radio" name="R1" value="a">
        - 
        <input type="radio" name="R1" value="s">
        * 
        <input type="radio" name="R1" value="m">
        / 
        <input type="radio" name="R1" value="d">
        pow 
        <input type="radio" name="R1" value="pow">
        <br>
        <input type="submit" value="Solve" name="submit">
        </font>
</form>
    </td>
  </tr>
  <tr align="center" valign="top"> 
    <td> 
      <form action="simpcalc.php" method="post">
        <font color="#CCCCCC" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        N1: 
        <input type="text" name="n3" size="8">
        <select name="D1" size="1">
          <option value="abs">Absolute Value</option>
          <option value="sin">Sin</option>
          <option value="cos">Cosine</option>
          <option value="tan">Tangent</option>
          <option value="asin">Arc Sin</option>
          <option value="acos">Arc Cosine</option>
          <option value="atan">Arc Tangent</option>
          <option value="sqrt">Square Root</option>
          <option value="log">log</option>
          <option value="log10">Base10 Log</option>
          <option value="rad2deg">Radian to Degrees</option>
          <option value="deg2rad">Degrees to Radians</option>
          <option value="dec2bin">Decimal To Binary</option>
          <option value="bin2dec">Binary to Decimal</option>
          <option value="dec2hex">Decimal to Hex</option>
          <option value="hex2dec">Hex to Decimal</option>
          <option value="dec2oct">Decimal to Octal</option>
          <option value="oct2dec">Octal to Decimal</option>
        </select>
        <br>
        <input type="submit" value="Solve" name="submit">
        </font> 
      </form>
    </td>
  </tr>
  <tr> 
    <td>
      <font color="#CCCCCC" face="Verdana, Arial, Helvetica, sans-serif" size="2">Result[ 
<?php
//answer
echo $ta;
?> ] - <a href="help.php" target="_blank">Help</a></font>
    </td>
  </tr>
</table>
<hr>
The Answer to the problem is
<b>
<?php
echo $ta;
?>
</b>
<noscript><noscript><!--
