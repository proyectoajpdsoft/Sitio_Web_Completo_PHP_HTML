<?
/////////////////////////////
#############################
#       phProfession        #
# The Resume Posting Script #
# Source by Mykel Nahorniak #
#############################
/////////////////////////////

/*
This is the config file for phProfession.
Edit it to suit your computer's needs before
using the script for maximum performance.
*/

##############################
# MySQL Database Connections #
##############################

$database="anuncios";
$user = "administrador";
$pass = "aaaa";
$hostname = "localhost";

### Connect to Database ###
$connection = mysql_pconnect($hostname, $user, $pass) or die ("Unable to connect to MySQL!");

//////////////////////////////////////
######################################
# Functions included in phProfession #
######################################
//////////////////////////////////////

    ############################
    # Format MySQL Date Values #
    ############################

        function fixDate($val)
        {
        ### Split date up into components ###

            $arr = explode(" ", $val);
            $datearr = explode("-", $arr[0]);

        ### Creating timestamp ###

            return date("d M Y", mktime(0, 0, 0, $datearr[1], $datearr[2], $datearr[0]));
        }

    #########################
    # E-Mail Validity Check #
    #########################

        function isEmailInvalid($val)
        {
        ### Regex for e-mail validation ###

            $pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";

            ### Match? ###

                if(preg_match($pattern, $val))
                {
                return 0;
                }
                else
                {
                return 1;
                }
        }

    ############################################
    # List of errors after validating the form #
    ############################################

        function listErrors()
        {
        ### Read the errorList array ###

            global $errorList;

        ### Print as list ###

            echo "The following errors were encountered: <br>";
            echo "<ul>";
                for ($x=0; $x<sizeof($errorList); $x++)
                {
                echo "<li>$errorList[$x]";
                }
            echo "</ul>";

        ### Link to return to previous page ###

            echo "Click <a href=javascript:history.back();>here</a> to go back to the previous page and correct the errors";
        }

?>
