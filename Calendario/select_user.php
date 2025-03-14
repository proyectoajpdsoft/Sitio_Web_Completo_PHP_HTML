<?php

include "./includes/config.inc";
include "./includes/php-dbi.inc";
include "./includes/functions.inc";
include "./includes/$user_inc";
include "./includes/validate.inc";
include "./includes/connect.inc";

load_user_preferences ();
load_user_layers ();

include "./includes/translate.inc";

?>
<HTML>
<HEAD>
<TITLE><?php etranslate("Title")?></TITLE>
<?php include "./includes/styles.inc"; ?>
</HEAD>
<BODY BGCOLOR="<?php echo $BGCOLOR;?>">


<H2><FONT COLOR="<?php echo $H2COLOR; ?>"><?php etranslate("View Another User's Calendar"); ?></H2></FONT>

<?php
if ( ! $allow_view_other && ! $is_admin ) {
  $error = translate ( "You are not authorized" );
}

if ( ! empty ( $error ) ) {
  echo "<BLOCKQUOTE>$error</BLOCKQUOTE>\n";
} else {
  $userlist = user_get_users ();
  if ( count ( $userlist ) > 20 ) {
    echo "<table WIDTH=\"95%\" BORDER=0>\n";
    $table_width = 4; $tw = " WIDTH=\"25%\"";
    $nu = count ( $userlist );
    $nr = floor ( ($nu + $table_width - 1) / $table_width );
    for ( $r = 0; $r < $nr; $r++ ) {
      echo "<tr>\n";
      for ( $col = 0; $col < $table_width; $col++ ) {
        //$i = $r * $table_width + $col;    // order by rows
        $i = $col * $nr + $r;   // order by columns
        echo "<td $tw>";
        if ( trim ( $userlist[$i]['cal_login'] ) != "" )
          echo "<UL><LI><A HREF=\"$STARTVIEW.php?user=" . $userlist[$i]['cal_login'] .
            "\">" . $userlist[$i]['cal_fullname'] . "</A></UL>";
        else
          echo "&nbsp;";
        echo "</td>\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  } else {
    echo "<UL>\n";
    for ( $i = 0; $i < count ( $userlist ); $i++ ) {
      echo "<LI><A HREF=\"$STARTVIEW.php?user=" . $userlist[$i]['cal_login'] .
        "\">" . $userlist[$i]['cal_fullname'] . "</A>";
    }
    echo "</UL>\n";
  }
}

?>
<P>

<?php include "./includes/trailer.inc"; ?>
</BODY>
</HTML>
