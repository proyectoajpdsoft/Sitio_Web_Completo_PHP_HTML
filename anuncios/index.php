<?

/////////////////////////////
#############################
#       phProfession        #
# The Resume Posting Script #
# Source by Mykel Nahorniak #
#############################
/////////////////////////////

/*
You are free to edit this source as much as
you want and claim it as your own. Just remember
the original source is posted on SourceForge.net,
so if any of your cool friends find out it isn't
yours, you'd better have a big bat ready :)
*/

#########################
# Including CONFIG file #
#########################

include("config.php"); 

    ### If no $cmd, just list jobs ###

        if ((!isset($cmd)) || ($cmd == "")){
            $cmd = "List";
        }

?>

<!--
    Header section
-->

<html>
    <head>
        <basefont face="Verdana" size="2">
    </head>

    <body bgcolor=white>

        <? $image="$cmd.jpg"; ?>

        <table 
            bgcolor="6583C3" 
            width="100%" 
            cellspacing="0" 
            cellpadding="0">
            <tr>
                <td 
                    height=50 
                    align=right>&nbsp;<img src="images/Header.gif"  alt="" border="0">
                </td>
            </tr>
        </table>

        <p>
            <img src="images/<? echo $image; ?>" alt="" border="0">
        <p>
<?

#####################
# Listing open jobs #
#####################

if ($cmd =="List"){

    ### Get List of Open Jobs ###
        $query = "SELECT DISTINCT id, department 
                    from department, listing 
                    WHERE department.id = listing.fk_department";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

    ### Check each department ###
        while(list($id, $department) = mysql_fetch_row($result))
        {
        ### Printing department ###
            echo "<b>Department:</b> $department";

        ### Look for jobs in each department and print as list ###
            $query2 = "SELECT jcode, designation 
                        from listing 
                        WHERE listing.fk_department = '$id'";
            $result2 = mysql_db_query($database, $query2, $connection) or die ("Error in query: $query2. " . mysql_error());

            echo "<ul>";
            while(list($jcode, $dsg) = mysql_fetch_row($result2))
            {
            echo "<li><a href=?cmd=Details&jcode=$jcode>$dsg ($jcode)</a>";
            }
            echo "</ul>";
            echo "<p>";
            }
}

#######################
# Echoing job details #
#######################

if($cmd == "Details"){
    if (!$jcode || $jcode == "")
    {
        header("Location:?cmd=Error");
        exit;
    }
    ### Get job details ###
        $query = "SELECT listing.designation,
                            listing.jcode,
                            department.department,
                            location.location,
                            salary.salary,
                            listing.responsibilities,
                            listing.qualifications,
                            listing.cname,
                            listing.cmail,
                            listing.posted 
                                from department, 
                                        listing, 
                                        location, 
                                        salary 
                                WHERE department.id = listing.fk_department 
                                AND location.id = listing.fk_location 
                                AND salary.id = listing.fk_salary 
                                AND listing.jcode = '$jcode'";

        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

    ### Checking for errors ###
        if (mysql_num_rows($result) <= 0)
        {
        header("Location:?cmd=Error");
        exit;
        }
        else
        {
    ### Obtain data from query ###
        list($designation, $jcode, $department, $location, $salary, $description, $qualification, $cname, $cmail, $posted) = mysql_fetch_row($result);


    echo"

        <!--
            Printing job details
        -->

        <b>Designation:</b>$designation
        <p>
        <b>Department:</b>$department
        <p>
        <b>Location:</b>$location
        <p>
        <b>Salary:</b>$salary
        <p>
        <b>Responsibilities:</b>$description
        <p>
        <b>Qualifications:</b>$qualification
        <p>
        <b>Contact:</b> <a href=mailto:$cmail>$cname</a>
        <p>
        <b>Job code:</b>$jcode
        <p>
        <b>Posted on:</b>fixDate($posted);
        <p>

        <!-- 
            Link to application form 
        -->

        <a href=?cmd=Apply&jcode=$jcode>Apply online</a> for this job, or <a href=?cmd=List>return to job listings</a>";
    }
}

######################
# Applying for a job #
######################

if($cmd == "Apply"){
    if (!$jcode || $jcode == ""){

        header("Location:?cmd=Error");
        exit;
    }

    ### Get job details ###
        $query = "SELECT designation, 
                    jcode, 
                    department 
                        from listing, 
                            department 
                                WHERE jcode = '$jcode' 
                                AND department.id = listing.fk_department";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

    ### Checking for errors ###
        if (mysql_num_rows($result) <= 0){

            header("Location:?cmd=Error");
            exit;
        } else {

    ### Obtain data from query ###
        list($designation, $jcode, $department) = mysql_fetch_row($result);

    ### Clean up ###
        mysql_free_result($result);

    ?>

    <style type="text/css">
        TD {font-family: Verdana; font-size: smaller;}
    </style>

    Please fill up this form to apply for the post of <b><? echo "$designation, $department ($jcode)"; ?></b>

    <table 
        border="0" 
        cellspacing="5" 
        cellpadding="2">
        <form action="?cmd=Apply_Result" method="post">
        <input type="hidden" name="jcode" value="<? echo $jcode; ?>">

        <!-- 
            Personal Information
        -->

        <tr>
            <td colspan=4><img src="images/Personal.gif"></td>
        </tr>

        <tr>
            <td colspan=2>First name<font color="red">*</font></td>
            <td colspan=2>Last name<font color="red">*</font></td>
        </tr>

        <tr>
            <td colspan=2><input type="text" name="fname" size="20" maxlength="255"></td>
            <td colspan=2><input type="text" name="lname" size="20" maxlength="255"></td>
        </tr>

        <tr>
            <td colspan=4>Address line 1<font color="red">*</font></td>
        </tr>

        <tr>
            <td colspan=4><input type="text" name="addr1" size="40" maxlength="255"></td>
        </tr>

        <tr>
            <td colspan=4>Address line 2</td>
        </tr>

        <tr>
            <td colspan=4><input type="text" name="addr2" size="40" maxlength="255"></td>
        </tr>

        <tr>
            <td>City<font color="red">*</font></td>
            <td>State<font color="red">*</font></td>
            <td colspan=2>Zip<font color="red">*</font></td>
        </tr>

        <tr>
            <td><input type="text" name="city" size="15" maxlength="255"></td>
            <td><input type="text" name="state" size="15" maxlength="255"></td>
            <td colspan=2><input type="text" name="zip" size="8" maxlength="10"></td>
        </tr>

        <tr>
            <td colspan=4>Country<font color="red">*</font></td>
        </tr>

        <tr>
            <td colspan=4>
                <select name="country">

        <?

            ### Get country list ###
                $query = "SELECT id, country from country";
                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                while (list($id, $country) = mysql_fetch_row($result)){

                    echo "<option value=$id>$country</option>";	
                    }
                mysql_free_result($result);

        ?>

                </select>
            </td>
        </tr>

        <tr>
            <td colspan=4>Phone<font color="red">*</font><br><font size="-2">(example: 703-555-5555)</font></td>
        </tr>

        <tr>
            <td colspan=4><input type="text" name="phone" size="30" maxlength="25"></td>
        </tr>

        <tr>
            <td colspan=2>E-mail address<font color="red">*</font><br><font size="-2">(example: mykel@domain.com)</font></td>
            <td colspan=2>Web site URL<br><font size="-2">(example: http://www.somedomain.com)</font></td>
        </tr>

        <tr>
            <td colspan=2><input type="text" name="email" size="30" maxlength="255"></td>
            <td colspan=2><input type="text" name="url" size="30" maxlength="255"></td>
        </tr>

        <tr>
            <td colspan=4>Date of birth<font color="red">*</font><br><font size="-2">(in dd-mm-yyyy format)</font></td>
        </tr>

        <tr>
            <td colspan=4>
                <select name="dd">
                    <? 
                        for ($x=1; $x<=31; $x++){ 
                            echo "<option value=\"" . sprintf("%02d", $x) . "\">" . sprintf("%02d", $x) . "</option>";
                        }
                    ?>
                </select> - 
                <select name="mm">
                    <? 
                        for ($x=1; $x<=12; $x++){
                            echo "<option value=\"" . sprintf("%02d", $x) . "\">" . sprintf("%02d", $x) . "</option>";
                        }
                    ?>
                </select> - 
                <select name="yyyy">
                    <?
                        for ($x=1940; $x<=(date("Y", mktime())-10); $x++){
                            echo "<option value=$x>$x</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>

        <!--
            Education Section
        -->

        <tr>
            <td colspan=4><img src="images/Education.gif"></td>
        </tr>

        <tr>
            <td colspan=4><i>You may fill all or none of the rows below; ensure that no fields are left empty per filled-in row</i></td>
        </tr>

        <tr>
            <td>Institute/University<br><font size=-2>(example: XYZ University)</td>
            <td>Degree<br><font size=-2>(example: Master's degree)</td>
            <td>Primary subject<br><font size=-2>(example: Accounting)</td>
            <td>Year<br><font size=-2>(example: 1992)</td>
        </tr>

        <? 
            ### Get degree list ###
                $query = "SELECT id, degree from degree";
                $degree_result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            ### Get subject list ###
                $query = "SELECT id, subject from subject";
                $subject_result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

                for ($x=0; $x<5; $x++) 
                { 
        ?>

        <tr>
            <td>
                <input type="text" name="institute[]" size="20" maxlength="255">
            </td>
            <td>
                <select name="degree[]">

        <?
                while (list($id, $degree) = mysql_fetch_row($degree_result)){
                    echo "<option value=$id>$degree</option>";
                }
            ### Same data, not required to re-query ###
                mysql_data_seek($degree_result, 0);
        ?>

                </select>
            </td>
            <td>
                <select name="subject[]">

        <?
            while (list($id, $subject) = mysql_fetch_row($subject_result))
                {
                echo "<option value=$id>$subject</option>";	
                }
            ### Same data, not required to re-query
                mysql_data_seek($subject_result, 0);
        ?>

                </select>
            </td>
            <td>
                <input type="text" name="degree_year[]" size="4" maxlength="4"></td>
        </tr>

        <?
                }
                mysql_free_result($degree_result);
                mysql_free_result($subject_result);
        ?>

        <!--
            Employment History
        -->

        <tr>
            <td colspan=4><img src="images/Employment.gif"></td>
        </tr>

        <tr>
            <td colspan=4><i>You may fill all or none of the sections below; ensure that no fields are left empty per filled-in section</i></td>
        </tr>

        <?
            ### Get industry list ###
                $query = "SELECT id, industry from industry";
                $ind_result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

                for ($x=0; $x<3; $x++)
                {

        ?>

        <tr>
            <td>Employer [<? echo ($x+1); ?>]
                <? 
                    if ($x == 0){
                        echo "<br><font size=-2>(example: ABC, Inc.)</font>";
                    }
                ?>
            </td>
            <td>Industry
                <? 
                    if ($x == 0){
                        echo "<br><font size=-2>(example: Advertising)</font>";
                    }
                ?>
            </td>
            <td>Start year
                <? 
                    if ($x == 0){
                        echo "<br><font size=-2>(example: 1996)</font>";
                    }
                ?>
            </td>
            <td>End year
                <? 
                    if ($x == 0)
                    {
                        echo "<br><font size=-2>(example: 1998)</font>";
                    }
                ?>
            </td>
        </tr>

        <tr>
            <td>
                <input type="text" name="employer[]" size="15" maxlength="255">
            </td>
            <td>
                <select name="industry[]">
        <?
        ### Print industry list ###
            while (list($id, $industry) = mysql_fetch_row($ind_result)){
                echo "<option value=$id>$industry</option>";	
            }
            mysql_data_seek($ind_result, 0);
        ?>

                </select>
            </td>
            <td>
                <input type="text" name="start_year[]" size="4" maxlength="4">
            </td>
            <td>
                <input type="text" name="end_year[]" size="4" maxlength="4">
            </td>
        </tr>

        <tr>
            <td colspan=4>Responsibilities
                <?
                    if ($x == 0){
                        echo "<br><font size=-2>(example: Managing projects and...)";
                    }
                ?>
            </td>
        </tr>

        <tr>
            <td colspan=4><textarea name="rsp[]" cols="40" rows="8"></textarea></td>
        </tr>

        <?
            }
            mysql_free_result($ind_result);
            mysql_close($connection);
        ?>


        <!-- 
            Skills Section 
        -->

        <tr>
            <td colspan=4><img src="images/Skills.gif"></td>
        </tr>

        <tr>
            <td colspan=4><i>You may fill all or none of the rows below; ensure that no fields are left empty per filled-in row</i></td>
        </tr>

        <tr>
            <td colspan=2>Skill<br><font size="-2">(example: PHP)</font></td>
            <td colspan=2>Experience<br><font size="-2">(example: 2 years)</font></td>
        </tr>

        <?
            for ($x=0; $x<5; $x++) 
            { 
        ?>
                <tr>
                    <td colspan=2><input type="text" name="skill[]" size="35" maxlength="255"></td>
                    <td colspan=2><input type="text" name="experience[]" size="2" maxlength="2"> year(s)</td>
                </tr>
        <?
            }
        ?>

        <!-- 
            References
        -->

        <tr>
            <td colspan=4><img src="images/References.gif"></td>
        </tr>

        <tr>
            <td colspan=4><i>You may fill all or none of the rows below; ensure that no fields are left empty per filled-in row</i></td>
        </tr>

        <tr>
            <td colspan=2>Name<br><font size="-2">(example: Mykel Nahorniak)</font></td>
            <td>Phone<br><font size="-2">(example: 703-555-5555)</font></td>
            <td>Email address<br><font size="-2">(example: mykel@domain.com)</font></td>
        </tr>

        <?
            for ($x=0; $x<5; $x++) 
            { 
        ?>
                <tr>
                <td colspan=2><input type="text" name="ref_name[]" size="35" maxlength="255"></td>
                <td><input type="text" name="ref_phone[]" size="20" maxlength="25"></td>
                <td><input type="text" name="ref_email[]" size="20" maxlength="255"></td>
                </tr>
        <?
            }
        ?>

        <tr>
            <td colspan=4><img src="images/Miscellaneous.gif"></td>
        </tr>

        <tr>
            <td colspan=4><input type="Checkbox" name="relo" value="1">I am willing to relocate if necessary</td>
        </tr>

        <tr>
            <td align=center colspan=4><input type=submit name=submit value="Submit"></td>
        </tr>

    </table>
    </form>
    <?
    }
}

##############################
# Viewing Application Result #
##############################

if($cmd == "Apply_Result"){
    if (!$jcode || $jcode == "")
    {
        header("Location:?cmd=Error");
        exit;
    }

    ### Get job details ###
        $query = "SELECT designation, 
                        jcode, 
                        department 
                            from listing, 
                                department 
                                    WHERE jcode = '$jcode' 
                                    AND department.id = listing.fk_department";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

    ### Checking for errors ###
        if (mysql_num_rows($result) <= 0)
        {
        header("Location:?cmd=Error");
        exit;
        }
        else
        {
    ### Obtain data from query ###
        list($designation, $jcode, $department) = mysql_fetch_row($result);
        mysql_free_result($result);

    ?>

    <style type="text/css">
    TD {font-family: Verdana; font-size: smaller;}
    </style>

    <?

    ### Create error list array ###
        $errorList = array();
        $count = 0;

            ### Validate text input fields ###
                if (empty($fname)){
                    $errorList[$count] = "Invalid entry: First name"; $count++;
                }
                
                if (empty($lname))
                    {$errorList[$count] = "Invalid entry: Last name"; $count++; 
                }
                
                if (empty($addr1)){
                    $errorList[$count] = "Invalid entry: Address line 1"; $count++;
                }
                
                if (empty($city))
                    {$errorList[$count] = "Invalid entry: City"; $count++; 
                }
                
                if (empty($state))
                    {$errorList[$count] = "Invalid entry: State"; $count++; 
                }
                
                if (empty($zip))
                    {$errorList[$count] = "Invalid entry: Zip"; $count++; 
                }
                
                if (empty($phone))
                    {$errorList[$count] = "Invalid entry: Phone"; $count++; 
                }
                
                if (empty($email) || isEmailInvalid($email)) { $errorList[$count] = "Invalid entry: Email address"; $count++; 
                }

            ### See if the user has already applied for the same job ###
                if (!empty($email)){
                    $query = "SELECT email from r_user WHERE email = '$email' AND jcode = '$jcode'";
                    $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                        if (mysql_num_rows($result) > 0){
                        $errorList[$count] = "Duplicate entry: An application for this job already exists with the same email address"; 
                        $count++; 
                        }
                }

            ### Validate multiple-record items ###

                ### 1. get number of entries possible (rows) ###
                ### 2. check to see if any text field in that row is filled up ###
                ### 3. if yes, ensure that all other fields in that row are also filled ###
                ### 4. if no, go to next row and repeat ###

            ### Check education rows ###
                for ($x=0; $x<sizeof($institute); $x++){
                    if(!empty($institute[$x]) || !empty($degree_year[$x])){
                        if(empty($degree[$x]) || empty($degree_year[$x]) || !is_numeric($degree_year[$x])){ 
                            $errorList[$count] = "Invalid entry: Educational qualifications, item " . ($x+1);
                            $count++;
                        }
                    }
                }

            ### Check employment rows ###
                for ($x=0; $x<sizeof($employer); $x++){
                    if(!empty($employer[$x]) || !empty($start_year[$x]) || !empty($end_year[$x]) || !empty($rsp[$x])){
                        if(empty($start_year[$x]) || empty($end_year[$x]) || empty($rsp[$x]) || !is_numeric($start_year[$x]) || !is_numeric($end_year[$x])){
                            $errorList[$count] = "Invalid entry: Employment history, item " . ($x+1);
                            $count++;
                        }
                    }
                }

            ### Check skill rows ###
                for ($x=0; $x<sizeof($skill); $x++){
                    if(!empty($skill[$x]) || !empty($experience[$x])){
                        if(empty($experience[$x]) || empty($skill[$x]) || !is_numeric($experience[$x])){
                            $errorList[$count] = "Invalid entry: Skills, item " . ($x+1);
                            $count++;
                        }
                    }
                }

            ### Check reference rows ###
                for ($x=0; $x<sizeof($ref_name); $x++){
                    if(!empty($ref_name[$x]) || !empty($ref_phone[$x]) || !empty($ref_email[$x])){
                        if( empty($ref_name[$x]) || empty($ref_phone[$x]) || ( !empty($ref_email[$x]) && isEmailInvalid($ref_email[$x]) ) ){
                            $errorList[$count] = "Invalid entry: References, item " . ($x+1);
                            $count++;
                        }
                    }
                }

            
            ### Format date of birth as DATE value ###
                $dob = sprintf ("%04d-%02d-%02d", $yyyy, $mm, $dd);
            
            ### No errors ###
                if (sizeof($errorList) == 0)
                {
            ### Insert personal information ###
                $query = "INSERT INTO r_user (
                                        jcode,
                                        fname,
                                        lname,
                                        dob, addr1,
                                        addr2, 
                                        city, 
                                        state, 
                                        zip, 
                                        fk_country, 
                                        phone, 
                                        email, 
                                        url, 
                                        relo, 
                                        posted)
                                            VALUES (
                                                '$jcode', 
                                                '$fname', 
                                                '$lname', 
                                                '$dob', 
                                                '$addr1', 
                                                '$addr2', 
                                                '$city', 
                                                '$state', 
                                                '$zip', 
                                                '$country', 
                                                '$phone', 
                                                '$email', 
                                                '$url', 
                                                '$relo', 
                                                NOW(''))";
                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            ### Get resume id, for use in subsequest operations ###
                $rid = mysql_insert_id($connection);

                    ### Insert educational qualifications ###
                        for($x=0; $x<sizeof($institute); $x++)
                        {
                            if (!empty($institute[$x]) && !empty($degree_year[$x]))
                            {
                                $query = "INSERT INTO r_education (
                                                        rid, 
                                                        institute, 
                                                        fk_degree, 
                                                        fk_subject, 
                                                        year) 
                                                            VALUES (
                                                                '$rid', 
                                                                '$institute[$x]', 
                                                                '$degree[$x]', 
                                                                '$subject[$x]', 
                                                                '$degree_year[$x]')";
                                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                            }
                        }

                    ### Insert employment history ###
                        for($x=0; $x<sizeof($employer); $x++){
                            if (!empty($employer[$x]) && !empty($start_year[$x]) && !empty($end_year[$x]) && !empty($rsp[$x])){
                                $query = "INSERT INTO r_employment (
                                                        rid, 
                                                        employer, 
                                                        fk_industry, 
                                                        start_year, 
                                                        end_year, 
                                                        responsibilities) 
                                                            VALUES ('$rid', 
                                                                    '$employer[$x]', 
                                                                    '$industry[$x]', 
                                                                    '$start_year[$x]', 
                                                                    '$end_year[$x]', 
                                                                    '$rsp[$x]')";
                                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                            }
                        }

                    ### Insert skill profile ###
                        for($x=0; $x<sizeof($skill); $x++){
                            if (!empty($skill[$x]) && !empty($experience[$x])){
                                $query = "INSERT INTO r_skill (
                                                        rid, 
                                                        skill, 
                                                        experience) 
                                                            VALUES ('$rid', 
                                                                    '$skill[$x]', 
                                                                    '$experience[$x]')";
                                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                            }
                        }

                    ### Insert references ###
                        for($x=0; $x<sizeof($employer); $x++){
                            if (!empty($ref_name[$x]) && !empty($ref_phone[$x])){
                                $query = "INSERT INTO r_reference (
                                                        rid, 
                                                        name, 
                                                        phone, 
                                                        email) 
                                                            VALUES ('$rid', 
                                                                    '$ref_name[$x]', 
                                                                    '$ref_phone[$x]', 
                                                                    '$ref_email[$x]')";
                                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
                            }
                        }

            ### Print success code ###
                echo "Your application has been accepted.<p><a href=?cmd=List>Return to job listings</a>";
                }
                else
                {
            ### Or list errors ###
                listErrors();
                }
        }
}

///////////////////////
#######################
# Administration Code #
#######################
///////////////////////

/*
Do not alter the following code unless
you are a proficient PHP coder. Altering
the code incorrectly may result in 
corrupting the entire script.
*/

#####################
# Job Listing Admin #
#####################

if($cmd == "Admin"){

    ### Get list of departments with open jobs ###
        $query = "SELECT DISTINCT id, 
                                    department 
                                        from department, 
                                                listing 
                                                    WHERE department.id = listing.fk_department";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

    ### Generate a table ###
        echo "<table border=0 cellspacing=5 cellpadding=5>";

    ### Echoing from query ###
        while(list($id, $department) = mysql_fetch_row($result))
        {

            ### Print department name ###
                echo "<tr><td colspan=4><font size=-1><b>Department:</b> $department</td></tr>";

            ### Look for jobs within the department and print as list, add edit and delete links ###
                $query2 = "SELECT jcode, designation from listing WHERE listing.fk_department = '$id'";
                $result2 = mysql_db_query($database, $query2, $connection) or die ("Error in query: $query2. " . mysql_error());

                while(list($jcode, $dsg) = mysql_fetch_row($result2)){
                    echo "
                        <tr>
                            <td width=10>&nbsp;</td>
                            <td><font size=-1>$dsg ($jcode)</td>
                            <td>
                                <a href=?cmd=Edit&jcode=$jcode><font size=-1>edit</font></a>
                            </td> 
                            <td>
                                <a href=?cmd=Delete&jcode=$jcode><font size=-1>delete</font></a>
                            </td>
                        </tr>";
                }
        }
        echo "</table>
        <p>
        <a href=\"?cmd=Add\">Add a new listing</a> or <a href=\"?cmd=Search\">search the database</a>";
}

####################
# Adding a listing #
####################

if($cmd == "Add"){
    ### If form has not been submitted ###
        if (!$submit)
        {
?>

<table 
    border="0" 
    cellspacing="5" 
    cellpadding="2">
    <form action="?cmd=Add" method="POST">

        <!--
            Input job details
        -->

            <tr>
                <td><font size=-1>Job code<font color="red">*</font></td>
            </tr>
            <tr>
                <td><input type="text" name="jcode" size="10" maxlength="10"></td>
            </tr>

            <tr>
                <td><font size=-1>Designation<font color="red">*</font></td>
                <td width=30>&nbsp;</td>
                <td><font size=-1>Department<font color="red">*</font></td>
            </tr>
            <tr>
                <td><input type="text" name="dsg" size="25"></td>
                <td width=30>&nbsp;</td>
                <td>
                    <select name="dpt">

<?

### Get department list ###
    $query = "SELECT id, department from department";
    $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
        while (list($id, $department) = mysql_fetch_row($result)){
            echo "<option value=$id>$department</option>";
        }
        mysql_free_result($result);

?>

                    </select>
                </td>
            </tr>

            <tr>
                <td><font size=-1>Location<font color="red">*</font></td>
                <td width=30>&nbsp;</td>
                <td><font size=-1>Salary<font color="red">*</font></td>
            </tr>

            <tr>
                <td>
                    <select name="loc">

<?

### Get location list ###
    $query = "SELECT id, location from location";
    $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
        while (list($id, $location) = mysql_fetch_row($result)){
            echo "<option value=$id>$location</option>";    
        }
        mysql_free_result($result);
?>

                    </select>
                </td>
                <td width=30>&nbsp;</td>
                <td>
                    <select name="sal">

<?

### Get salary list ###
    $query = "SELECT id, salary from salary";
    $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
    while (list($id, $salary) = mysql_fetch_row($result)){
        echo "<option value=$id>$salary</option>";  
    }
    mysql_free_result($result);

?>

                    </select>
                </td>
            </tr>

            <tr>
                <td><font size=-1>Responsibilities<font color="red">*</font></td>
                <td width=30>&nbsp;</td>
                <td><font size=-1>Qualifications<font color="red">*</font></td>
            </tr>

            <tr>
                <td><textarea name="rsp" cols="40" rows="8"></textarea></td>
                <td width=30>&nbsp;</td>
                <td><textarea name="qlf" cols="40" rows="8"></textarea></td>
            </tr>

            <tr>
                <td><font size=-1>Contact person<font color="red">*</font></td>
                <td width=30>&nbsp;</td>
                <td><font size=-1>Email address<font color="red">*</font></td>
            </tr>

            <tr>
                <td><input type="text" name="cname" size="25"></td>
                <td width=30>&nbsp;</td>
                <td><input type="text" name="cmail" size="25"></td>
            </tr>

            <tr>
                <td align=center colspan=3>
                    <input type=submit name=submit value="Add Listing">
                </td>
            </tr>

        </table>
    </form>

<?

}else{

### Set up error list array ###
    $errorList = array();
    $count = 0;

### Validate text fields ###
    if (empty($jcode)){ 
        $errorList[$count] = "Invalid entry: Job code"; $count++;
    }

    if (empty($dsg)) {
        $errorList[$count] = "Invalid entry: Designation"; $count++; 
    }

    if (empty($rsp)) {
        $errorList[$count] = "Invalid entry: Responsibilities"; $count++; 
    }

    if (empty($qlf)) {
        $errorList[$count] = "Invalid entry: Qualifications"; $count++; 
    }

    if (empty($cname)) { 
        $errorList[$count] = "Invalid entry: Contact name"; $count++; 
    }

    if (empty($cmail) || isEmailInvalid($cmail)) { 
        $errorList[$count] = "Invalid entry: Email address"; $count++; 
    }

        if (sizeof($errorList) == 0){
            ### Insert data ###
                $query = "INSERT INTO listing (
                                        jcode, 
                                        designation, 
                                        responsibilities, 
                                        qualifications, 
                                        cname, cmail, 
                                        posted, 
                                        fk_department, 
                                        fk_location, 
                                        fk_salary) 
                                            VALUES (
                                                '$jcode', 
                                                '$dsg', 
                                                '$rsp', 
                                                '$qlf', 
                                                '$cname', 
                                                '$cmail', 
                                                NOW(), 
                                                '$dpt', 
                                                '$loc', 
                                                '$sal')";
                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            ### Clean up ###
                echo "Entry successfully added.<p><a href=?cmd=Add>Add another entry</a>, or <a href=?cmd=List>return to job listings</a>";
                }
                else
                {
                listErrors();
                }
    }

}

#####################
# Editing a listing #
#####################

if($cmd == "Edit"){
    ### Checking for errors ###
        if (!$jcode || $jcode == ""){
            header("Location:error.php");
            exit;
        }

    ### Form not yet submitted ###
        if (!$submit){

    ### Get job details ###
        $query = "SELECT designation, 
                        jcode, 
                        fk_department, 
                        fk_location, 
                        fk_salary, 
                        responsibilities, 
                        qualifications, 
                        cname, 
                        cmail 
                            from listing 
                            WHERE jcode = '$jcode'";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

        ### Checking for errors ###
            if (mysql_num_rows($result) <= 0){
                header("Location:error.php");
                exit;
            } else {
                ### Obtain data from query ###
                    list($designation, 
                        $jcode, 
                        $department, 
                        $location, 
                        $salary, 
                        $description, 
                        $qualification, 
                        $cname, 
                        $cmail, 
                        $posted) = mysql_fetch_row($result);

                ### Clean up ###
                    mysql_free_result($result);

        ### Display form with values pre-filled ###

    ?>

        <table 
            border="0" 
            cellspacing="5" 
            cellpadding="2">
                <form action="?cmd=Edit" method="POST">
                <input type=hidden name="jcode" value="<? echo $jcode; ?>">

                <!--
                    Job details
                -->

                    <tr>
                        <td><font size=-1>Designation<font color="red">*</font></td>
                        <td width=30>&nbsp;</td>
                        <td><font size=-1>Department<font color="red">*</font></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="dsg" size="25" value="<? echo $designation; ?>"></td>
                        <td width=30>&nbsp;</td>
                        <td>
                            <select name="dpt">

    <?

        ### Get department list ###
            $query = "SELECT id, department from department";
            $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
            while (list($id, $dpt) = mysql_fetch_row($result)){
                echo "<option value=$id";
                    if ($id == $department){
                        echo " selected";
                    }
                    echo ">$dpt</option>";  
            }
            mysql_free_result($result);

    ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><font size=-1>Location<font color="red">*</font></td>
                        <td width=30>&nbsp;</td>
                        <td><font size=-1>Salary<font color="red">*</font></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="loc">

    <?
        ### Get location list ###
            $query = "SELECT id, location from location";
            $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
            while (list($id, $loc) = mysql_fetch_row($result)){
                echo "<option value=$id";
                    if ($id == $location){
                        echo " selected";
                    }
                    echo ">$loc</option>";  
            }
            mysql_free_result($result);

    ?>

                            <select>
                        </td>

                        <td width=30>&nbsp;</td>
                        <td>
                            <select name="sal">

    <?
        ### Get salary list ###
            $query = "SELECT id, salary from salary";
            $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
            while (list($id, $sal) = mysql_fetch_row($result)){
                echo "<option value=$id";
                    if ($id == $salary){
                        echo " selected";
                    }
                    echo ">$sal</option>";  
            }
            mysql_free_result($result);

    ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><font size=-1>Responsibilities<font color="red">*</font></td>
                        <td width=30>&nbsp;</td>
                        <td><font size=-1>Qualifications<font color="red">*</font></td>
                    </tr>
                    <tr>
                        <td><textarea name="rsp" cols="40" rows="8"><? echo $description; ?></textarea></td>
                        <td width=30>&nbsp;</td>
                        <td><textarea name="qlf" cols="40" rows="8"><? echo $qualification; ?></textarea></td>
                    </tr>

                    <tr>
                        <td><font size=-1>Contact person<font color="red">*</font></td>
                        <td width=30>&nbsp;</td>
                        <td><font size=-1>Email address<font color="red">*</font></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="cname" size="25" value="<? echo $cname; ?>"></td>
                        <td width=30>&nbsp;</td>
                        <td><input type="text" name="cmail" size="25" value="<? echo $cmail; ?>"></td>
                    </tr>

                    <tr>
                        <td align=center colspan=3><input type=submit name=submit value="Update Listing"></td>
                    </tr>
                </table>
            </form>

    <?
        }
    } else {
    ### Set up error list array ###
        $errorList = array();
        $count = 0;

    ### Validate text input fields ###
        if (empty($jcode)) {
            $errorList[$count] = "Invalid entry: Job code"; $count++; 
        }

        if (empty($dsg)) {
            $errorList[$count] = "Invalid entry: Designation"; $count++; 
        }

        if (empty($rsp)) { 
            $errorList[$count] = "Invalid entry: Responsibilities"; $count++; 
        }

        if (empty($qlf)) {
            $errorList[$count] = "Invalid entry: Qualifications"; $count++; 
        }

        if (empty($cname)) {
            $errorList[$count] = "Invalid entry: Contact name"; $count++; 
        }

        if (empty($cmail) || isEmailInvalid($cmail)) {
            $errorList[$count] = "Invalid entry: Email address"; $count++; 
        }

        if (sizeof($errorList) == 0){
            ### Update data ###
                $query = "UPDATE listing 
                            SET designation='$dsg', 
                                responsibilities='$rsp', 
                                qualifications='$qlf', 
                                cname='$cname', 
                                cmail='$cmail', 
                                fk_department='$dpt', 
                                fk_location='$loc', 
                                fk_salary='$sal' 
                                    WHERE jcode='$jcode'";
                $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());


        // redirect
        echo "Entry successfully edited.<p><a href=?cmd=Admin>Edit another entry</a>, or <a href=?cmd=List>return to job listings</a>";
        }
        else{
        listErrors();
        }
    }
}

######################
# Deleting a listing #
######################

if($cmd == "Delete"){
    if (!$jcode || $jcode == ""){
        header("Location:?cmd=Error");
        exit;
    }

    ### Delete record ###
        $query = "DELETE FROM listing WHERE jcode = '$jcode'";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
        mysql_close($connection);

    ### Redirect ###
        echo "Entry successfully deleted.<p><a href=?cmd=Admin>Go back to Admin</a>, or <a href=?cmd=List>return to job listings</a>";
}

###########################
# Searching for a listing #
###########################

if($cmd == "Search"){

    if(!$submit)
    {
    ?>

        <form action=?cmd=Search method="post">
        Display all applications for the post 
        <select name="jcode">

    <?

    ### Get list of open jobs ###
        $query = "SELECT DISTINCT jcode, designation from listing";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            ### And print ###
                while(list($jcode, $designation) = mysql_fetch_row($result)){
                    echo "<option value=$jcode>$designation ($jcode)</option>";
                }
        mysql_free_result($result);

    ?>

        </select>
        <p>
            <ul>
            <li>with skills matching the keywords
            <input type=text name=skills size=35>
        <p>
            and experience 
            <select name=exp_modifier>
                <option value="">&lt;unspecified&gt;</option>
                <option value="=">equal to</option>
                <option value=">=">greater than or equal to</option>
                <option value="<=">less than or equal to</option>
            </select>
            <input type=text name=years size=2 maxlength=2>
            years
        <p>
            <li>with educational qualifications equivalent to
            <select name="degree">
                <option value="">&lt;unspecified&gt;</option>

    <?

    ### Get list of degrees ### 
        $query = "SELECT id, degree from degree";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
            while(list($id, $degree) = mysql_fetch_row($result)){
                echo "<option value=$id>$degree</option>";
            }
        mysql_free_result($result);

    ?>

            </select>
            in
            <select name=subject>
                <option value="">&lt;unspecified&gt;</option>

    <?

    ### Get list of subjects ###
        $query = "SELECT id, subject from subject";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
            while(list($id, $subject) = mysql_fetch_row($result)){
                echo "<option value=$id>$subject</option>";
            }
        mysql_free_result($result);

    ?>

            </select>
            </ul>
            <center>
                <input type="submit" name="submit" value="Search">
            </center>
        </form>

    <?

    } else {
    ### Form submitted, search entries ###

    ### Check for missing parameters ###
        if (!$jcode || $jcode == ""){
            header("Location:?cmd=Error");
            exit;
        }

        ### Set up basic query and joins ###
            $query = "SELECT DISTINCT 
                            r_user.rid, 
                            r_user.lname, 
                            r_user.fname, 
                            r_user.email 
                                from r_user, 
                                    r_skill, 
                                    r_education 
                                        WHERE r_user.jcode = '$jcode'";
            
                ### If skills criteria selected ###
                    if(!empty($skills) && !empty($exp_modifier) && !empty($years)){
                ### Modify query further ###
                    $query .= " AND r_user.rid = r_skill.rid  AND (";
                ### Turn keywords into tokens ###
                    $keywords = split(" ", $skills);
                    ### Iterate through list ###
                        for ($x=0; $x<sizeof($keywords); $x++){
                            trim($keywords[$x]);
                            ### This searches for skill1 and skill2. ###
                            ### Make this OR if you want an OR-type search ###
                                if($x != 0){
                                    $query .= " AND";
                                } 
                            $query .= " (r_skill.skill LIKE '%" . $keywords[$x] ."%' AND r_skill.experience " .  $exp_modifier . $years . " )";
                            }
                        $query .= ")";
                        }
        
            ### If education criteria selected ###
                if(!empty($degree) && !empty($subject)){
                ### Modify request further
                    $query .= " AND r_user.rid = r_education.rid AND r_education.fk_degree = '$degree' AND r_education.fk_subject = '$subject'";
                }

    ### Execute query ###
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());
    ### Number of records found ###
        $count = mysql_num_rows($result);

    ### Uncomment following for debugging
        #echo $query . "<p>";

    ?>

    Your search returned <? echo $count; ?> match(es)
    <p>
    <ul>

    <?

    ### List matches ###
        while (list($rid, $lname, $fname, $email) = mysql_fetch_row($result)){
            echo "<li><a href=resume_details.php?rid=$rid>$lname, $fname &lt;$email&gt;</a>";   
        }

    echo "<ul>";

    }
}

#####################
# Building a resume #
#####################

if($cmd == "Resume_Details"){


    ### Check for missing parameters ###
        if (!$rid || $rid == ""){
            header("Location:error.php");
            exit;
        }

    ### Get personal information ###
        $query = "SELECT fname, 
                        lname, 
                        dob, 
                        addr1, 
                        addr2, 
                        city, 
                        state, 
                        zip, 
                        country, 
                        phone, 
                        email, 
                        url, 
                        relo, 
                        posted 
                        from 
                        r_user, 
                        country 
                            WHERE r_user.fk_country = country.id 
                            AND rid = '$rid'";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

        ### Checking for errors ###
            if (mysql_num_rows($result) <= 0){
                header("Location:error.php");
                exit;
            } else {
        ### Obtain data from query ###
            list(
                $fname, 
                $lname, 
                $dob, 
                $addr1, 
                $addr2, 
                $city, 
                $state, 
                $zip, 
                $country, 
                $phone, 
                $email, 
                $url, 
                $relo, 
                $posted) = mysql_fetch_row($result);

    ?>

    <img src="images/Personal.gif">
    <br>
    <b>Name:</b> 
        <? echo $fname . " " . $lname; ?>
    <p>
    <b>Date of birth:</b> 
        <? echo fixDate($dob); ?>
    <p>
    <b>Address:</b><br> 
        <? echo "$addr1<br>"; 
            if($addr2){ 
                echo "$addr2<br>";
            } 
           echo "$city $zip<br>$state, $country"; ?>
    <p>
    <b>Phone:</b> 
        <? echo $phone; ?>
    <p>
    <b>Email address: </b><a href="mailto:
        <? echo $email; ?>"><? echo $email; ?></a>
    <p>
    <b>Web site:</b> 
        <? if($url){
            echo "<a target=new href=$url>$url</a>"; 
           } else { 
            echo "None"; 
           } ?>
    <p>

    <?

    ### Get education history ###
        $query = "SELECT institute, 
                        degree, 
                        subject, 
                        year 
                            from r_education, 
                                    degree, 
                                    subject 
                                WHERE r_education.fk_degree = degree.id 
                                AND r_education.fk_subject = subject.id 
                                AND rid = '$rid' 
                                    ORDER BY year";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            if(mysql_num_rows($result) > 0){
                echo "<img src=images/Education.gif><br>";

                while (list($institute, $degree, $subject, $year ) = mysql_fetch_row($result)){
                    echo "<b>Institute:</b> $institute<br>";
                    echo "<b>Degree:</b> $degree ($subject, $year)<p>"; 
                }
            }

    ?>

    <?

    ### Get employment history ###
        $query = "SELECT employer, 
                        industry, 
                            start_year, 
                            end_year, 
                            responsibilities 
                                from r_employment, 
                                    industry 
                                    WHERE r_employment.fk_industry = industry.id 
                                    AND rid = '$rid' 
                                        ORDER BY end_year";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            if(mysql_num_rows($result) > 0){
                echo "<img src=images/em.gif><br>";
                while (list($employer, $industry, $start_year, $end_year, $responsibilities) = mysql_fetch_row($result)){
                    echo "<b>Employer</b>: $employer ($start_year-$end_year)<br>";  
                    echo "<b>Industry</b>: $industry<br>";  
                    echo "<b>Responsibilities</b>: <br>$responsibilities<p>";   
                }
            }
    ?>

    <?

    ### Get skills ###
        $query = "SELECT skill, experience from r_skill WHERE rid = '$rid' ORDER BY experience";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            if(mysql_num_rows($result) > 0){
                echo "<img src=images/Skills.gif><br>";
                while (list($skill, $experience) = mysql_fetch_row($result)){
                    echo "<b>$skill</b><br>";
                    echo "$experience years experience<p>"; 
                }
            }
    ?>

    <?

    ### Get references ###
        $query = "SELECT name, phone, email from r_reference WHERE rid = '$rid'";
        $result = mysql_db_query($database, $query, $connection) or die ("Error in query: $query. " . mysql_error());

            if(mysql_num_rows($result) > 0){
                echo "<img src=images/References.gif><br>";
                while (list($name, $phone, $ref_email) = mysql_fetch_row($result)){
                    echo "<b>Name:</b> $name<br>";
                    echo "<b>Phone:</b> $phone<br>";
                    if ($ref_email) {
                        echo "<b>Email address:</b> <a href=mailto:$ref_email>$ref_email</a><p>";
                    } else { 
                        echo "<p>";
                    }
                }
            }

    ?>

    <img src="images/Miscellaneous.gif">
    <br>
    <b>Willing to relocate:</b>
        <? 
            if($relo == 1) {
                echo "Yes";
            } else { 
                echo "No"; 
            } 
        ?>
    <p>
    Resume posted on <b><? echo fixDate($posted); ?></b>
    <p>
    <a href="javascript:history.back()">Go back to applicant list</a>, or <a href="?cmd=Search">search again</a>

    <?
    }
}

//////////////
##############
# Error Code #
##############
//////////////

/*
The following code is used for diagnosing
errors for users who post information
incorrectly in the script. Although not
recommended, feel free to edit the code
*/

#################
# Generic Error #
#################

if($cmd == "Error"){
    echo "There was an error accessing the page you requested. Please <a href=\"?cmd=List\">return to the main page</a> and try again.";
}

?>

        <p>
        <center>
            <font face="Verdana" size="-2">
                Powered by &copy; <a href="http://phprofession.sourceforge.net/">phProfession</a>.
            </font>
        </center>
    </body>
</html>