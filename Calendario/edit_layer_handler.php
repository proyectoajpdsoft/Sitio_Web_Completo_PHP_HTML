<?php

include "includes/config.inc";
include "includes/php-dbi.inc";
include "includes/functions.inc";
include "includes/$user_inc";
include "includes/validate.inc";
include "includes/connect.inc";

load_user_preferences ();
$save_status = $LAYERS_STATUS;
$LAYERS_STATUS = "Y";
load_user_layers ();
$LAYERS_STATUS = $save_status;

include "includes/translate.inc";

if ( empty ( $dups ) )
  $dups = 'N';

if ( ! empty ( $layeruser ) ) {
  // existing layer entry
  if ( ! empty ( $layers[$id]['cal_layeruser'] ) ) {
    // update existing layer entry for this user
    $layerid = $layers[$id]['cal_layerid'];

    dbi_query ( "UPDATE webcal_user_layers SET cal_layeruser = '$layeruser', cal_color = '$layercolor', cal_dups = '$dups' WHERE cal_layerid = '$layerid'");

  } else {
    // new layer entry
    $res = dbi_query ( "SELECT MAX(cal_layerid) FROM webcal_user_layers" );
    if ( $res ) {
      $row = dbi_fetch_row ( $res );
      $layerid = $row[0] + 1;
    } else {
      $layerid = 1;
    }

    dbi_query ( "INSERT INTO webcal_user_layers VALUES ('$layerid', '$login', '$layeruser', '$layercolor', '$dups')");
  }
}

do_redirect ( "layers.php" );

?>
