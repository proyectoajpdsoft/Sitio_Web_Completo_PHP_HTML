<?php

include "includes/config.inc";
include "includes/php-dbi.inc";
include "includes/functions.inc";
include "includes/$user_inc";
include "includes/validate.inc";
include "includes/connect.inc";

load_user_preferences ();
load_user_layers ();

include "includes/translate.inc";

?>
<HTML>
<HEAD>
<TITLE><?php etranslate("Title")?></TITLE>
<SCRIPT LANGUAGE="JavaScript">
function selectDate ( day, month, year ) {
  // get currently selected month/year
  monthobj = eval ( 'document.exportform.' + month );
  curmonth = monthobj.options[monthobj.selectedIndex].value;
  yearobj = eval ( 'document.exportform.' + year );
  curyear = yearobj.options[yearobj.selectedIndex].value;
  date = curyear;
  if ( curmonth < 10 )
    date += "0";
  date += curmonth;
  date += "01";
  url = "datesel.php?form=exportform&day=" + day +
    "&month=" + month + "&year=" + year + "&date=" + date;
  var colorWindow = window.open(url,"DateSelection","width=200,height=160,resizable=yes,scrollbars=yes");
}
</SCRIPT>

<?php include "includes/styles.inc"; ?>
</HEAD>
<BODY BGCOLOR="<?php echo $BGCOLOR;?>">

<H2><FONT COLOR="<?php echo $H2COLOR;?>"><?php etranslate("Export")?></FONT></H2>

<FORM ACTION="export_handler.php/webcalendar-export.txt" METHOD="POST" NAME="exportform">

<TABLE BORDER=0>
<TR><TD><B><?php etranslate("Export format")?>:</B></TD><TD><SELECT NAME="format">
  <OPTION VALUE="pilot-text">install-datebook (<?php etranslate("Palm Pilot")?>)
  <OPTION VALUE="ical">iCal
</SELECT></TD></TR>
<TR><TD></TD><TD><INPUT TYPE="checkbox" NAME="use_all_dates" VALUE="y"></INPUT>
  <B><?php etranslate("Export all dates")?></B></TD></TR>
<TR><TD><B><?php etranslate("Start date")?>:</B></TD>
  <TD><SELECT NAME="fromday">
<?php
  $day = date ( "d" );
  for ( $i = 1; $i <= 31; $i++ ) echo "<OPTION " . ( $i == $day ? " SELECTED" : "" ) . ">$i";
?>
  </SELECT>
  <SELECT NAME="frommonth">
<?php
  $month = date ( "m" );
  $year = date ( "Y" );
  for ( $i = 1; $i <= 12; $i++ ) {
    $m = month_short_name ( $i - 1 );
    print "<OPTION VALUE=\"$i\"" . ( $i == $month ? " SELECTED" : "" ) . ">$m";
  }
?>
  </SELECT>
  <SELECT NAME="fromyear">
<?php
  $year = date ( "Y" ) - 1;
  for ( $i = -1; $i < 5; $i++ ) {
    $y = date ( "Y" ) + $i;
    print "<OPTION VALUE=\"$y\"" . ( $y == $year ? " SELECTED" : "" ) . ">$y";
  }
?>
  </SELECT>
  <INPUT TYPE="button" ONCLICK="selectDate('fromday','frommonth','fromyear')" VALUE="<?php etranslate("Select")?>...">
</TD></TR>

<TR><TD><B><?php etranslate("End date")?>:</B></TD>
  <TD><SELECT NAME="endday">
<?php
  $day = date ( "d" );
  for ( $i = 1; $i <= 31; $i++ ) echo "<OPTION " . ( $i == $day ? " SELECTED" : "" ) . ">$i";
?>
  </SELECT>
  <SELECT NAME="endmonth">
<?php
  $month = date ( "m" );
  $year = date ( "Y" );
  for ( $i = 1; $i <= 12; $i++ ) {
    $m = month_short_name ( $i - 1 );
    print "<OPTION VALUE=\"$i\"" . ( $i == $month ? " SELECTED" : "" ) . ">$m";
  }
?>
  </SELECT>
  <SELECT NAME="endyear">
<?php
  $year = date ( "Y" ) + 1;
  for ( $i = -1; $i < 5; $i++ ) {
    $y = date ( "Y" ) + $i;
    print "<OPTION VALUE=\"$y\"" . ( $y == $year ? " SELECTED" : "" ) . ">$y";
  }
?>
  </SELECT>
  <INPUT TYPE="button" ONCLICK="selectDate('endday','endmonth','endyear')" VALUE="<?php etranslate("Select")?>...">
</TD></TR>

<TR><TD><B><?php etranslate("Modified since")?>:</B></TD>
  <TD><SELECT NAME="modday">
<?php
  $week_ago = mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - 7, date ( "Y" ) );
  $day = date ( "d", $week_ago );
  for ( $i = 1; $i <= 31; $i++ ) echo "<OPTION " . ( $i == $day ? " SELECTED" : "" ) . ">$i";
?>
  </SELECT>
  <SELECT NAME="modmonth">
<?php
  $month = date ( "m", $week_ago );
  $year = date ( "Y", $week_ago );
  for ( $i = 1; $i <= 12; $i++ ) {
    $m = month_short_name ( $i - 1 );
    print "<OPTION VALUE=\"$i\"" . ( $i == $month ? " SELECTED" : "" ) . ">$m";
  }
?>
  </SELECT>
  <SELECT NAME="modyear">
<?php
  $year = date ( "Y", $week_ago );
  for ( $i = -1; $i < 5; $i++ ) {
    $y = date ( "Y" ) + $i;
    print "<OPTION VALUE=\"$y\"" . ( $y == $year ? " SELECTED" : "" ) . ">$y";
  }
?>
  </SELECT>
  <INPUT TYPE="button" ONCLICK="selectDate('modday','modmonth','modyear')" VALUE="<?php etranslate("Select")?>...">
</TD></TR>

<TR><TD COLSPAN="2"><INPUT TYPE="submit" VALUE="<?php etranslate("Export")?>"></TD></TR>

</TABLE>
</FORM>

<?php include "includes/trailer.inc"; ?>
</BODY>
</HTML>
