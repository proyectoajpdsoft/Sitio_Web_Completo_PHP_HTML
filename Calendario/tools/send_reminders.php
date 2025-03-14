#!/usr/local/bin/php -q
<?php
// This script should be setup to run periodically on your system.
// You could run it once every minute, but every 5-15 minutes should be
// sufficient.
//
// To set this up in cron, add a line like the following in your crontab
// to run it every 10 minutes:
//   1,11,21,31,41,51 * * * * /some/patch/here/send_reminders.ph
// (of course change the path to where this script lives!)
// On Linux, just type crontab -e to edit your crontab.
//
// If you're a Windows user, you'll either need to find a cron clone
// for Windows (they're out there) or come up with another creative
// solution.
// 
// You will need PHP build as a CGI (rather than an Apache module) for
// this script to work.  I install PHP as an Apache module and then
// build the CGI version later (without Apache).  The module version
// of PHP is preferred for use in a web server.

// How many days in advance can a reminder be sent (max)
// this will affect performance, but keep in mind that someone may enter
// a reminder to be sent 60 days in advance or they may enter a specific
// date for a reminder to be sent that is more than 30 days before the
// event's date.  If you're only running this once an hour or less often,
// then you could certainly change this to look a whole 365 days ahead.
$DAYS_IN_ADVANCE = 30;
//$DAYS_IN_ADVANCE = 365;


// Load include files.
// If you have moved this script out of the WebCalendar directory,
// which you probably should do since it would be better for security
// reasons, you would need to change $includedir to point to the
// webcalendar include directory.
$basedir = ".."; // points to the base WebCalendar directory relative to
                 // current working directory
$includedir = "../includes";

include "$includedir/config.inc";
include "$includedir/php-dbi.inc";
include "$includedir/functions.inc";
include "$includedir/site_extras.inc";

$debug = false; // set to true to print debug info...

// Establish a database connection.
$c = dbi_connect ( $db_host, $db_login, $db_password, $db_database );
if ( ! $c ) {
  echo "Error connecting to database: " . dbi_error ();
  exit;
}

include "$includedir/translate.inc";


// Get a list of the email users in the system.
// They must also have an email address.  Otherwise, we can't
// send them mail, so what's the point?
$sql = "SELECT cal_login, cal_email, cal_lastname, cal_firstname " .
  "FROM webcal_user";
$res = dbi_query ( $sql );
$i = 0;
if ( $res ) {
  while ( $row = dbi_fetch_row ( $res ) ) {
    $cal_login = $row[0];
    $cal_email = $row[1];
    $cal_lastname = $row[2];
    $cal_firstname = $row[3];
    $users[$i++] = $cal_login;
    $emails[$cal_login] = $cal_email;
    if ( strlen ( $cal_lastname ) ) {
      if ( strlen ( $cal_firstname ) )
        $names[$cal_login] = "$cal_lastname, $cal_firstname";
      else
        $names[$cal_login] = $cal_lastname;
    } else if ( strlen ( $cal_firstname ) ) {
      $names[$cal_login] = $cal_firstname;
    } else {
      $names[$cal_login] = $cal_login;
    }
    //echo "Processing $cal_login ($names[$cal_login])\n";
  }
  dbi_free_result ( $res );
}

// Now read events all the repeating events (for all users)
$repeated_events = read_repeated_events ( "" );

// Read non-repeating events (for all users)
$startdate = date ( "Ymd" );
$enddate = date ( "Ymd", time() + ( $DAYS_IN_ADVANCE * 24 * 3600 ) );
if ( $debug )
  echo "Checking for events from date $startdate to date $enddate\n";
$events = read_events ( "", $startdate, $enddate );
if ( $debug )
  echo "Found " . count ( $events ) . " events in time range.\n";


function indent ( $str ) {
  return "  " . str_replace ( "\n", "\n  ", $str );
}


// Send a reminder for a single event for a single day to all
// participants in the event.
// Send to participants who have accepted and who have not yet
// approved.
// TODO: Consider sending out a message to each person that selected
// a specific language preference.  For now, all recipients get the
// message in the default language preference set in config.inc.
function send_reminder ( $id, $event_date ) {
  global $names, $emails, $site_extras, $debug;
  global $EXTRA_TEXT, $EXTRA_MULTILINETEXT, $EXTRA_URL, $EXTRA_DATE,
    $EXTRA_EMAIL, $EXTRA_USER, $EXTRA_REMINDER;

  $pri[1] = translate("Low");
  $pri[2] = translate("Medium");
  $pri[3] = translate("High");

  // get participants first...
 
  $sql = "SELECT cal_login FROM webcal_entry_user " .
    "WHERE cal_id = $id " .
    "ORDER BY cal_login";
  $res = dbi_query ( $sql );
  $participants = array ();
  $num_participants = 0;
  if ( $res ) {
    while ( $row = dbi_fetch_row ( $res ) ) {
      $participants[$num_participants++] = $row[0];
    }
  }
  if ( ! $num_participants ) {
    echo "Error: no participants found for event id: $id\n";
    return;
  }


  // get event details
  $res = dbi_query (
    "SELECT cal_create_by, cal_date, cal_time, cal_mod_date, " .
    "cal_mod_time, cal_duration, cal_priority, cal_type, cal_access, " .
    "cal_name, cal_description FROM webcal_entry WHERE cal_id = $id" );
  if ( ! $res ) {
    echo "Db error: could not find event id $id.\n";
    return;
  }

  $body = translate("This is a reminder for the event detailed below.") .
    "\n\n";
  if ( ! ( $row = dbi_fetch_row ( $res ) ) ) {
    echo "Error: could not find event id $id in database.\n";
    return;
  }
  $create_by = $row[0];
  $name = $row[9];
  $description = $row[10];

  $body .= strtoupper ( $name ) . "\n\n";
  $body .= translate("Description") . ":\n";
  $body .= indent ( $description ) . "\n";
  $body .= translate("Date") . ": " . date_to_str ( $row[1] ) . "\n";
  if ( $row[2] >= 0 )
    $body .= translate ("Time") . ": " . display_time ( $row[2] ) . "\n";
  if ( $row[5] > 0 )
    $body .= translate ("Duration") . ": " . $row[5] .
      " " . translate("minutes") . "\n";
  if ( ! $disable_priority_field )
    $body .= translate("Priority") . ": " . $pri[$row[6]] . "\n";
  if ( ! $disable_access_field )
    $body .= translate("Access") . ": " .
      ( $row[8] == "P" ? translate("Public") : translate("Confidential") ) .
      "\n";
  if ( ! strlen ( $single_user_login ) )
    $body .= translate("Created by") . ": " . $row[0] . "\n";
  $body .= translate("Updated") . ": " . date_to_str ( $row[3] ) . " " .
    display_time ( $row[4] ) . "\n";

  // site extra fields
  $extras = get_site_extra_fields ( $id );
  for ( $i = 0; $i < count ( $site_extras ); $i++ ) {
    $extra_name = $site_extras[$i][0];
    $extra_descr = $site_extras[$i][1];
    $extra_type = $site_extras[$i][2];
    if ( $extras[$extra_name]['cal_name'] != "" ) {
      $body .= translate ( $extra_descr ) . ": ";
      if ( $extra_type == $EXTRA_DATE ) {
        $body .= date_to_str ( $extras[$extra_name]['cal_date'] ) . "\n";
      } else if ( $extra_type == $EXTRA_MULTILINETEXT ) {
        $body .= "\n" . indent ( $extras[$extra_name]['cal_data'] ) . "\n";
      } else if ( $extra_type == $EXTRA_REMINDER ) {
        $body .= ( $extras[$extra_name]['cal_remind'] > 0 ?
          translate("Yes") : translate("No") ) . "\n";
      } else {
        // default method for $EXTRA_URL, $EXTRA_TEXT, etc...
        $body .= $extras[$extra_name]['cal_data'] . "\n";
      }
    }
  }
  if ( ! $single_user && ! $disable_participants_field ) {
    $body .= translate("Participants") . ":\n";
    for ( $i = 0; $i < count ( $participants ); $i++ ) {
      $body .= "  " . $participants[$i] .
        " (" . $names[$participants[$i]] . ")\n";
    }
  }
  
  $subject = translate("Reminder") . ": " . $name;

  $recip = "";
  if ( $single_user ) {
    $recip = $emails[$single_user_login];
  } else {
    for ( $i = 0; $i < count ( $participants ); $i++ ) {
      if ( strlen ( $emails[$participants[$i]] ) ) {
        if ( strlen ( $recip ) )
          $recip .= ", ";
        $recip .= $emails[$participants[$i]];
      }
    }
  }

  if ( strlen ( $GLOBALS["email_fallback_from"] ) )
    $extra_hdrs = "From: " . $GLOBALS["email_fallback_from"] . "\n" .
      "X-Mailer: " . translate("Title");
  else
    $extra_hdrs = "X-Mailer: " . translate("Title");

  // send mail
  if ( strlen ( $recip ) ) {
    if ( $debug )
      echo "Sending mail...\n";
    mail ( $recip, $subject, $body, $extra_hdrs );
  } else {
    if ( $debug )
      echo "Not sending mail... no email addresses available.\n";
  }
}


// keep track of the fact that we send the reminder, so we don't
// do it again.
function log_reminder ( $id, $name, $event_date ) {
  dbi_query ( "DELETE FROM webcal_reminder_log " .
    "WHERE cal_id = $id AND cal_name = '$name' " .
    "AND cal_event_date = $event_date" );
  dbi_query ( "INSERT INTO webcal_reminder_log " .
    "( cal_id, cal_name, cal_event_date, cal_last_sent ) VALUES ( " .
    "$id, '" . $name . "', $event_date, " . time() . ")" );
}


// Process an event for a single day.  Check to see if it has
// a reminder, when it needs to be sent and when the last time it
// was sent.
function process_event ( $id, $name, $event_date, $event_time ) {
  global $site_extras, $debug;
  global $EXTRA_REMINDER_WITH_OFFSET, $EXTRA_REMINDER_WITH_DATE;

  if ( $debug )
    printf ( "Event %d: \"%s\" at %s on %s\n",
      $id, $name, $event_time, $event_date );

  // Check to see if this event has any reminders
  $extras = get_site_extra_fields ( $id );
  for ( $j = 0; $j < count ( $site_extras ); $j++ ) {
    $extra_name = $site_extras[$j][0];
    $extra_type = $site_extras[$j][2];
    $extra_arg1 = $site_extras[$j][3];
    $extra_arg2 = $site_extras[$j][4];
    //if ( $debug )
    //  printf ( "  name: %s\n  type: %d\n  arg1: %s\n  arg2: %s\n",
    //  $extra_name, $extra_type, $extra_arg1, $extra_arg2 );
    if ( ! empty ( $extras[$extra_name]['cal_remind'] ) ) {
      if ( $debug )
        echo "  Reminder set for event.\n";
      // how many minutes before event should we send the reminder?
      $ev_h = (int) ( $event_time / 10000 );
      $ev_m = ( $event_time / 100 ) % 100;
      $ev_year = substr ( $event_date, 0, 4 );
      $ev_month = substr ( $event_date, 4, 2 );
      $ev_day = substr ( $event_date, 6, 2 );
      $event_time = mktime ( $ev_h, $ev_m, 0, $ev_month, $ev_day, $ev_year );
      if ( ( $extra_arg2 & $EXTRA_REMINDER_WITH_OFFSET ) > 0 ) {
        $minsbefore = $extras[$extra_name]['cal_data'];
        $remind_time = $event_time - ( $minsbefore * 60 );
      } else if ( ( $extra_arg2 & $EXTRA_REMINDER_WITH_DATE ) > 0 ) {
        $rd = $extras[$extra_name]['cal_date'];
        $r_year = substr ( $rd, 0, 4 );
        $r_month = substr ( $rd, 4, 2 );
        $r_day = substr ( $rd, 6, 2 );
        $remind_time = mktime ( 0, 0, 0, $r_month, $r_day, $r_year );
      } else {
        $minsbefore = $extra_arg1;
        $remind_time = $event_time - ( $minsbefore * 60 );
      }
      if ( $debug )
        echo "  Mins Before: $minsbefore\n";
      if ( $debug ) {
        echo "  Event time is: " . date ( "m/d/Y H:i", $event_time ) . "\n";
        echo "  Remind time is: " . date ( "m/d/Y H:i", $remind_time ) . "\n";
      }
      if ( time() > $remind_time ) {
        // It's later than the remind time.  See if one has already been sent
        $last_sent = 0;
        $res = dbi_query ( "SELECT MAX(cal_last_sent) FROM " .
          "webcal_reminder_log WHERE cal_id = " . $id .
          " AND cal_event_date = $event_date" .
          " AND cal_name = '" . $extra_name . "'" );
        if ( $res ) {
          if ( $row = dbi_fetch_row ( $res ) ) {
            $last_sent = $row[0];
          }
          dbi_free_result ( $res );
        }
        if ( $debug )
          echo "  Last sent on: " . date ( "m/d/Y H:i", $last_sent ) . "\n";
        if ( $last_sent < $remind_time ) {
          // Send a reminder
          if ( $debug )
            echo "  SENDING REMINDER!\n";
          send_reminder ( $id, $event_date );
          // now update the db...
          log_reminder ( $id, $extra_name, $event_date );
        }
      }
    }
  }
}


$startdate = time(); // today
for ( $d = 0; $d < $DAYS_IN_ADVANCE; $d++ ) {
  $date = date ( "Ymd", time() + ( $d * 24 * 3600 ) );
  //echo "Date: $date\n";
  // Get non-repeating events for this date.
  // An event will be included one time for each participant.
  $ev = get_entries ( "", $date );
  // Keep track of duplicates
  $completed_ids = array ( );
  for ( $i = 0; $i < count ( $ev ); $i++ ) {
    $id = $ev[$i]['cal_id'];
    if ( ! empty ( $completed_ids[$id] ) )
      continue;
    $completed_ids[$id] = 1;
    process_event ( $id, $ev[$i]['cal_name'], $date, $ev[$i]['cal_time'] );
  }
  $rep = get_repeating_entries ( "", $date );
  for ( $i = 0; $i < count ( $rep ); $i++ ) {
    $id = $rep[$i]['cal_id'];
    if ( ! empty ( $completed_ids[$id] ) )
      continue;
    $completed_ids[$id] = 1;
    process_event ( $id, $rep[$i]['cal_name'], $date, $rep[$i]['cal_time'] );
  }
}

if ( $debug )
  echo "Done.\n";

?>
