#!/usr/local/bin/perl
#
# This tool helps with the translation into other languages by verifying that
# all text specified in translate() and etranslate() within the application
# has a corresponding entry in the translation data file.  In short, this
# makes sure all text has a correspoding translation.
#
# Usage:
#	check_translation.pl languagefile
#	  ... or to check the most recently modified translation file
#	check_translation.pl
# Example:
#	check_translation.pl ../translations/English-US.txt
#
# Note: this utility should be run from this directory (tools).
#
###########################################################################


$infile = $ARGV[0];

if ( $infile eq "" ) {
  opendir ( DIR, "../translations" ) || die "se ha producido un error mientras se habr�a el fichero de traducci�n ../translations";
  @files = grep ( /\.txt$/, readdir ( DIR ) );
  closedir ( DIR );
  $last_mtime = 0;
  foreach $f ( @files ) {
    ( $mtime ) = ( stat ( "../translations/$f" ) )[9];
    if ( $mtime > $last_mtime ) {
      $last_mtime = $mtime;
      $infile = "../translations/$f";
    }
  }
}


# First get the list of .php and .inc files.
opendir ( DIR, ".." ) || die "Error opening ..";
@files = grep ( /\.php$/, readdir ( DIR ) );
closedir ( DIR );

opendir ( DIR, "../includes" ) || die "Error abriendo ../includes";
@incfiles = grep ( /\.inc$/, readdir ( DIR ) );
closedir ( DIR );
foreach $f ( @incfiles ) {
  push ( @files, "includes/$f" );
}
push ( @files, "tools/send_reminders.php" );


foreach $f ( @files ) {
  $file = "../$f";
  open ( F, $file ) || die "Error leyendo $file";
  #print "Checking $f for text.\n";
  while ( <F> ) {
    $data = $_;
    while ( $data =~ /translate\s*\(\s*"/ ) {
      $data = $';
      if ( $data =~ /"\s*\)/ ) {
        $text = $`;
        $text{$text} = 1;
        $data = $';
      }
    }
  }
  close ( F );
}

#print "Found the following entries:\n";
#foreach $text ( sort { uc($a) cmp uc($b) } keys ( %text ) ) {
#  print "$text\n";
#}

# Now load the translation file
if ( ! -f $infile ) {
  die "Usage: $0 translation-file\n";
}
open ( F, $infile ) || die "Error abriendo $infile";
while ( <F> ) {
  chop;
  next if ( /^#/ );
  if ( /\s*:/ ) {
    $abbrev = $`;
    $trans{$abbrev} = $';
  }
}

$notfound = 0;
foreach $text ( sort { uc($a) cmp uc($b) } keys ( %text ) ) {
  if ( ! defined ( $trans{$text} ) ) {
    if ( ! $notfound ) {
      print "El texto siguiente no tiene una traducci�n en $infile:\n\n";
    }
    print "$text\n";
    $notfound++;
  }
}

# Check for translations that are not used...
$extra = 0;
foreach $text ( sort { uc($a) cmp uc($b) } keys ( %trans ) ) {
  if ( ! defined ( $text{$text} ) ) {
    if ( ! $extra ) {
      print "\nEl texto de traducci�n siguiente no se necesita en $infile:\n\n";
    }
    print "$text\n";
    $extra++;
  }
}

if ( ! $notfound ) {
  print "All text was found in $infile.  Good job :-)\n";
} else {
  print "\n$notfound traducci�n desconocida.\n";
}

exit 0;
