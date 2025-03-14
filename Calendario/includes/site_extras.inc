<?php
// site_extras.inc
//
// This file can be used to define extra information associated with a
// calender entry.
//
// You may define extra fields of the following types:
//   EXTRA_TEXT - will allow user to enter a line of text
//   EXTRA_MULTILINETEXT - will allow user to enter multiple lines of text
//   EXTRA_URL - will be displayed as a link
//   EXTRA_DATE - will be presented with date pulldown menus when entering
//   EXTRA_EMAIL - will be presented as a mailto URL
//   EXTRA_USER - most be a calendar user name; will be presented
//                with a pulldown
//   EXTRA_REMINDER - will allow reminder email messages to be sent
//     out to all event participants
//   EXTRA_REMINDER_DATE - will allow reminder email messages to be sent
//     out to all event participants on the specified date.  Can use
//     extra options to send it out before this date also.
//
// NOTE: If you want to fully support using languages other than what
// you define below, you will need to add the 2nd field of the arrays
// below to the translation files.
//
// WARNING: If you want to use reminders, you will need to do some
// extra steps in setting up WebCalendar.  There is no built-in support
// for executing time-based jobs within PHP, so you need to setup something
// to execute the send_reminders.php script.
// On UNIX/Linux, this will be cron.
// On Windows, you'll need to find a cron-like way to do this.
// See the README for more info.
//

// define types
$EXTRA_TEXT = 1;
$EXTRA_MULTILINETEXT = 2;
$EXTRA_URL = 3;
$EXTRA_DATE = 4;
$EXTRA_EMAIL = 5;
$EXTRA_USER = 6;
$EXTRA_REMINDER = 7;

// Options for reminders - these should be or-ed together when
// it makes sense.  (Right now the only two available options wouldn't
// make sense to or together.)
// By default, options = 0.

// Owner specifies what date to send.  This will present a date selection
// area on the edit page (just like a EXTRA_DATE will).
$EXTRA_REMINDER_WITH_DATE =	0x0001;

// Owner chooses how many days/hours/minutes before event date that
// the reminder should be sent.  Will see:  __ Days __ Hrs __ Mins on
// event edit page.
$EXTRA_REMINDER_WITH_OFFSET =	0x0002;

// Format of an entry is an array with the following elements:
// name: unique name of this extra field (used in db)
// description: how this field will be described to users
// type: $EXTRA_URL, $EXTRA_TEXT, etc...
// arg1: for reminders how many minutes before event should reminder
//       for multi-line text, how many columns to display in the form
//         as in <TEXTAREA ROWS="XX" COLS="XX"
//       for text (single line), how many columns to display
//         as in <INPUT SIZE="XX"
// arg2: for reminders, this specifies options such as
//         $EXTRA_REMINDER_WITH_DATE or $EXTRA_REMINDER_WITH_OFFSET.
//       for multi-line text, how many rows to display in the form
//         as in <TEXTAREA ROWS="XX" COLS="XX"

// Example 1:
// You want to just add an optional URL to all event entries and a simple
// reminder.
// $site_extra = array (
//   array (
//     "URL",        // unique name of this extra field (used in db)
//     "Event URL",  // how this field will be described to users
//     $EXTRA_URL,   // type of field
//     0,            // arg 1
//     0             // arg 2
//   ),
//   array (
//     "Email",         // unique name of this extra field (used in db)
//     "Event Email",   // how this field will be described to users
//     $EXTRA_EMAIL,    // type of field
//     0,               // arg 1 (unused)
//     0                // arg 2 (unused)
//   ),
//   array (
//     "Contact",       // unique name of this extra field (used in db)
//     "Event Contact", // how this field will be described to users
//     $EXTRA_USER,     // type of field
//     0,               // arg 1 (unused)
//     0                // arg 2 (unused)
//   ),
//   array (
//     "Directions",         // unique name of this extra field (used in db)
//     "Driving Directions", // how this field will be described to users
//     $EXTRA_MULTILINETEXT, // type of field
//     50,                   // width of text entry
//     8                     // height of text entry
//   ),
//   array (
//     "Reminder",          // unique name of this extra field (used in db)
//     "Send Reminder",     // how this field will be described to users
//     $EXTRA_REMINDER,     // type of field
//     21 * (24 * 60),      // how many minutes before event should reminder
//                          // be sent (21 days in this case)
//     $EXTRA_REMINDER_WITH_OFFSET
//                          // specifies reminder options bit-or
//   )
// );

// END EXAMPLES


// Define your stuff here...
$site_extras = array (
  array (
    "Reminder",          // unique name of this extra field (used in db)
    "Send Reminder",     // how this field will be described to users
    $EXTRA_REMINDER,     // type of field
    240,                 // arg 1: how many minutes before event should
                         // reminder be sent (however, this option is just
                         // the default when used with the
                         // EXTRA_REMINDER_WITH_OFFSET option) since the user
                         // can override this.
    $EXTRA_REMINDER_WITH_OFFSET
                         // arg 2: specifies reminder options bit-or
  )
);

?>
