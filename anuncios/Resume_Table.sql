###########################
# MySQL Table Parser File #
###########################

### This file is intended to be parsed with MySQL by typing
### mysql -u <user> -p <password> <database> < Resume_Tables.sql

#################
# Country Table #
#################

    CREATE TABLE country (
    id tinyint(4) unsigned NOT NULL auto_increment,
    country varchar(255) NOT NULL,
    PRIMARY KEY (id)
    );

    ####################
    # Inserting Values #
    ####################

        INSERT INTO country (id, country) VALUES ( '', 'Afghanistan');
        INSERT INTO country (id, country) VALUES ( '', 'Albania');
        INSERT INTO country (id, country) VALUES ( '', 'Algeria');
        INSERT INTO country (id, country) VALUES ( '', 'American Samoa');
        INSERT INTO country (id, country) VALUES ( '', 'Andorra');
        INSERT INTO country (id, country) VALUES ( '', 'Angola');
        INSERT INTO country (id, country) VALUES ( '', 'Anguilla');
        INSERT INTO country (id, country) VALUES ( '', 'Antarctica');
        INSERT INTO country (id, country) VALUES ( '', 'Antigua And Barbuda');
        INSERT INTO country (id, country) VALUES ( '', 'Argentina');
        INSERT INTO country (id, country) VALUES ( '', 'Armenia');
        INSERT INTO country (id, country) VALUES ( '', 'Aruba');
        INSERT INTO country (id, country) VALUES ( '', 'Australia');
        INSERT INTO country (id, country) VALUES ( '', 'Austria');
        INSERT INTO country (id, country) VALUES ( '', 'Azerbaijan');
        INSERT INTO country (id, country) VALUES ( '', 'Bahamas, The');
        INSERT INTO country (id, country) VALUES ( '', 'Bahrain');
        INSERT INTO country (id, country) VALUES ( '', 'Bangladesh');
        INSERT INTO country (id, country) VALUES ( '', 'Barbados');
        INSERT INTO country (id, country) VALUES ( '', 'Belarus');
        INSERT INTO country (id, country) VALUES ( '', 'Belgium');
        INSERT INTO country (id, country) VALUES ( '', 'Belize');
        INSERT INTO country (id, country) VALUES ( '', 'Benin');
        INSERT INTO country (id, country) VALUES ( '', 'Bermuda');
        INSERT INTO country (id, country) VALUES ( '', 'Bhutan');
        INSERT INTO country (id, country) VALUES ( '', 'Bolivia');
        INSERT INTO country (id, country) VALUES ( '', 'Botswana');
        INSERT INTO country (id, country) VALUES ( '', 'Bouvet Island');
        INSERT INTO country (id, country) VALUES ( '', 'Brazil');
        INSERT INTO country (id, country) VALUES ( '', 'Brunei');
        INSERT INTO country (id, country) VALUES ( '', 'Bulgaria');
        INSERT INTO country (id, country) VALUES ( '', 'Burkina Faso');
        INSERT INTO country (id, country) VALUES ( '', 'Burundi');
        INSERT INTO country (id, country) VALUES ( '', 'Cambodia');
        INSERT INTO country (id, country) VALUES ( '', 'Cameroon');
        INSERT INTO country (id, country) VALUES ( '', 'Canada');
        INSERT INTO country (id, country) VALUES ( '', 'Cape Verde');
        INSERT INTO country (id, country) VALUES ( '', 'Cayman Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Central African Republic');
        INSERT INTO country (id, country) VALUES ( '', 'Chad');
        INSERT INTO country (id, country) VALUES ( '', 'Chile');
        INSERT INTO country (id, country) VALUES ( '', 'China');
        INSERT INTO country (id, country) VALUES ( '', 'Christmas Island');
        INSERT INTO country (id, country) VALUES ( '', 'Cocos (Keeling) Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Colombia');
        INSERT INTO country (id, country) VALUES ( '', 'Comoros');
        INSERT INTO country (id, country) VALUES ( '', 'Congo');
        INSERT INTO country (id, country) VALUES ( '', 'Congo');
        INSERT INTO country (id, country) VALUES ( '', 'Cook Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Costa Rica');
        INSERT INTO country (id, country) VALUES ( '', 'Croatia');
        INSERT INTO country (id, country) VALUES ( '', 'Cuba');
        INSERT INTO country (id, country) VALUES ( '', 'Cyprus');
        INSERT INTO country (id, country) VALUES ( '', 'Czech Republic');
        INSERT INTO country (id, country) VALUES ( '', 'Denmark');
        INSERT INTO country (id, country) VALUES ( '', 'Djibouti');
        INSERT INTO country (id, country) VALUES ( '', 'Dominica');
        INSERT INTO country (id, country) VALUES ( '', 'Dominican Republic');
        INSERT INTO country (id, country) VALUES ( '', 'East Timor');
        INSERT INTO country (id, country) VALUES ( '', 'Ecuador');
        INSERT INTO country (id, country) VALUES ( '', 'Egypt');
        INSERT INTO country (id, country) VALUES ( '', 'El Salvador');
        INSERT INTO country (id, country) VALUES ( '', 'Equatorial Guinea');
        INSERT INTO country (id, country) VALUES ( '', 'Eritrea');
        INSERT INTO country (id, country) VALUES ( '', 'Estonia');
        INSERT INTO country (id, country) VALUES ( '', 'Ethiopia');
        INSERT INTO country (id, country) VALUES ( '', 'Falkland Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Faroe Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Fiji Islands');
        INSERT INTO country (id, country) VALUES ( '', 'Finland');
        INSERT INTO country (id, country) VALUES ( '', 'France');
        INSERT INTO country (id, country) VALUES ( '', 'French Guiana');
        INSERT INTO country (id, country) VALUES ( '', 'French Polynesia');
        INSERT INTO country (id, country) VALUES ( '', 'French Southern Territories');
        INSERT INTO country (id, country) VALUES ( '', 'Gabon');
        INSERT INTO country (id, country) VALUES ( '', 'Gambia, The');
        INSERT INTO country (id, country) VALUES ( '', 'Georgia');
        INSERT INTO country (id, country) VALUES ( '', 'Germany');
        INSERT INTO country (id, country) VALUES ( '', 'Ghana');
        INSERT INTO country (id, country) VALUES ( '', 'Gibraltar');
        INSERT INTO country (id, country) VALUES ( '', 'Greece');
        INSERT INTO country (id, country) VALUES ( '', 'Greenland');
        INSERT INTO country (id, country) VALUES ( '', 'Grenada');
        INSERT INTO country (id, country) VALUES ( '', 'Guadeloupe');
        INSERT INTO country (id, country) VALUES ( '', 'Guam');
        INSERT INTO country (id, country) VALUES ( '', 'Guatemala');
        INSERT INTO country (id, country) VALUES ( '', 'Guinea');
        INSERT INTO country (id, country) VALUES ( '', 'Guinea-Bissau');
        INSERT INTO country (id, country) VALUES ( '', 'Guyana');
        INSERT INTO country (id, country) VALUES ( '', 'Haiti');
        INSERT INTO country (id, country) VALUES ( '', 'Honduras');
        INSERT INTO country (id, country) VALUES ( '', 'Hong Kong S.A.R.');
        INSERT INTO country (id, country) VALUES ( '', 'Hungary');
        INSERT INTO country (id, country) VALUES ( '', 'Iceland');
        INSERT INTO country (id, country) VALUES ( '', 'India');
        INSERT INTO country (id, country) VALUES ( '', 'Indonesia');

################
# Degree Table #
################

    DROP TABLE IF EXISTS degree;
    CREATE TABLE degree (
       id tinyint(3) unsigned NOT NULL auto_increment,
       degree varchar(255) NOT NULL,
       PRIMARY KEY (id)
    );

    ####################
    # Inserting Values #
    ####################

        INSERT INTO degree (id, degree) VALUES ( '1', 'High School degree');
        INSERT INTO degree (id, degree) VALUES ( '2', 'Undergraduate degree');
        INSERT INTO degree (id, degree) VALUES ( '3', 'Bachelor\'s degree');
        INSERT INTO degree (id, degree) VALUES ( '4', 'Master\'s degree');
        INSERT INTO degree (id, degree) VALUES ( '5', 'Doctoral degree');
        INSERT INTO degree (id, degree) VALUES ( '6', 'Post-doctoral degree');
        INSERT INTO degree (id, degree) VALUES ( '7', 'Other');

####################
# Department Table #
####################

    DROP TABLE IF EXISTS department;
    CREATE TABLE department (
       id tinyint(3) unsigned NOT NULL auto_increment,
       department varchar(255) NOT NULL,
       PRIMARY KEY (id)
    );

    ####################
    # Inserting Values #
    ####################

        INSERT INTO department (id, department) VALUES ( '1', 'Human Resources');
        INSERT INTO department (id, department) VALUES ( '2', 'Accounting');
        INSERT INTO department (id, department) VALUES ( '3', 'Engineering');
        INSERT INTO department (id, department) VALUES ( '4', 'Design');
        INSERT INTO department (id, department) VALUES ( '5', 'Administration');

##################
# Industry Table #
##################

    DROP TABLE IF EXISTS industry;
    CREATE TABLE industry (
       id tinyint(4) unsigned NOT NULL auto_increment,
       industry varchar(255) NOT NULL,
       PRIMARY KEY (id)
    );

    ####################
    # Inserting Values #
    ####################

        INSERT INTO industry (id, industry) VALUES ( '1', 'Advertising');
        INSERT INTO industry (id, industry) VALUES ( '2', 'Agriculture and Forestry');
        INSERT INTO industry (id, industry) VALUES ( '3', 'Arts and Entertainment');
        INSERT INTO industry (id, industry) VALUES ( '4', 'Computers');
        INSERT INTO industry (id, industry) VALUES ( '5', 'Construction and Maintenance ');
        INSERT INTO industry (id, industry) VALUES ( '6', 'Defense');
        INSERT INTO industry (id, industry) VALUES ( '7', 'Design');
        INSERT INTO industry (id, industry) VALUES ( '8', 'Electronics');
        INSERT INTO industry (id, industry) VALUES ( '9', 'Energy');
        INSERT INTO industry (id, industry) VALUES ( '10', 'Engineering');
        INSERT INTO industry (id, industry) VALUES ( '11', 'Financial Services');
        INSERT INTO industry (id, industry) VALUES ( '12', 'Food and Related Products');
        INSERT INTO industry (id, industry) VALUES ( '13', 'Healthcare');
        INSERT INTO industry (id, industry) VALUES ( '14', 'Hospitality');
        INSERT INTO industry (id, industry) VALUES ( '15', 'Import and Export');
        INSERT INTO industry (id, industry) VALUES ( '16', 'Industrial Supply');
        INSERT INTO industry (id, industry) VALUES ( '17', 'Information Technology');
        INSERT INTO industry (id, industry) VALUES ( '18', 'Insurance');
        INSERT INTO industry (id, industry) VALUES ( '19', 'Internet');
        INSERT INTO industry (id, industry) VALUES ( '20', 'Manufacturing');
        INSERT INTO industry (id, industry) VALUES ( '21', 'Maritime');
        INSERT INTO industry (id, industry) VALUES ( '22', 'Marketing');
        INSERT INTO industry (id, industry) VALUES ( '23', 'Mining and Drilling');
        INSERT INTO industry (id, industry) VALUES ( '24', 'Printing');
        INSERT INTO industry (id, industry) VALUES ( '25', 'Publishing');
        INSERT INTO industry (id, industry) VALUES ( '26', 'Real Estate');
        INSERT INTO industry (id, industry) VALUES ( '27', 'Retail');
        INSERT INTO industry (id, industry) VALUES ( '28', 'Security');
        INSERT INTO industry (id, industry) VALUES ( '29', 'Telecommunications');
        INSERT INTO industry (id, industry) VALUES ( '30', 'Transportation');
        INSERT INTO industry (id, industry) VALUES ( '31', 'Waste Management');
        INSERT INTO industry (id, industry) VALUES ( '32', 'Wholesale');

#################
# Listing Table #
#################

DROP TABLE IF EXISTS listing;
CREATE TABLE listing (
   jcode varchar(10) NOT NULL,
   designation varchar(255) NOT NULL,
   responsibilities text NOT NULL,
   qualifications text NOT NULL,
   cname varchar(255) NOT NULL,
   cmail varchar(255) NOT NULL,
   posted date DEFAULT '0000-00-00' NOT NULL,
   fk_department tinyint(3) unsigned DEFAULT '0' NOT NULL,
   fk_location tinyint(3) unsigned DEFAULT '0' NOT NULL,
   fk_salary tinyint(3) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (jcode),
   KEY jcode (jcode)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO listing (jcode, designation, responsibilities, qualifications, cname, cmail, posted, fk_department, fk_location, fk_salary) VALUES ( 'X5436', 'Senior Web Developer', 'Applicant will be responsible for developing Web applications and executing Web-related projects for corporate customers. ', 'Applicant should be familiar with scripting languages (PHP and Perl), databases (mySQL, PostgreSQL). Applicant should be comfortable with both Windows and *NIX operating system. Applicant will also be required to demonstrate a thorough knowledge of software design and engineering principles.', 'Roger Rabbit', 'roger@site.com', '2001-05-22', '3', '4', '1');
        INSERT INTO listing (jcode, designation, responsibilities, qualifications, cname, cmail, posted, fk_department, fk_location, fk_salary) VALUES ( 'KA6547', 'Project Manager', 'Applicant will be responsible for managing projects within the organization. Responsibilities include developing project plans and schedules, tracking project progress, communicating with the customer, and ensuring that deadlines and deliveries are met.', 'Applicant should be familiar with office applications like Word, Excel, Powerpoint and Project. Applicant should have prior experience with project management tasks, and must bring enthusiasm and professionalism to the post.', 'Bugs Bunny', 'a@a.com', '2001-04-05', '4', '5', '11');
        INSERT INTO listing (jcode, designation, responsibilities, qualifications, cname, cmail, posted, fk_department, fk_location, fk_salary) VALUES ( 'KA5463', 'Design Manager', 'Applicant will be responsible for overseeing design activities of the organization. This includes understanding customer needs, developing interface designs and prototypes, and spearheading new design initiatives within the organization.', 'Applicant should be familiar with image processing applications such as Adobe Photoshop, Adobe Pagemaker et al. Applicant must also demonstrate a sound understanding of the principles of visual interface design, and must have at least  five years prior experience in the field.', 'Bugs Bunny', 'bugs@site.com', '2001-05-18', '4', '5', '8');

##################
# Location Table #
##################

DROP TABLE IF EXISTS location;
CREATE TABLE location (
   id tinyint(3) unsigned NOT NULL auto_increment,
   location varchar(255) NOT NULL,
   PRIMARY KEY (id)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO location (id, location) VALUES ( '1', 'New York');
        INSERT INTO location (id, location) VALUES ( '2', 'London');
        INSERT INTO location (id, location) VALUES ( '3', 'Paris');
        INSERT INTO location (id, location) VALUES ( '4', 'Tokyo');
        INSERT INTO location (id, location) VALUES ( '5', 'Bombay');

#####################
# R_Education Table #
#####################

DROP TABLE IF EXISTS r_education;
CREATE TABLE r_education (
   rid tinyint(3) unsigned DEFAULT '0' NOT NULL,
   institute varchar(255) NOT NULL,
   fk_degree tinyint(3) unsigned DEFAULT '0' NOT NULL,
   fk_subject tinyint(3) unsigned DEFAULT '0' NOT NULL,
   year year(4) DEFAULT '0000' NOT NULL,
   KEY fk_degree (fk_degree),
   KEY fk_subject (fk_subject),
   KEY rid (rid)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO r_education (rid, institute, fk_degree, fk_subject, year) VALUES ( '1', 'University of Ennui', '6', '16', '1998');

######################
# R_Employment Table #
######################

DROP TABLE IF EXISTS r_employment;
CREATE TABLE r_employment (
   rid tinyint(3) unsigned DEFAULT '0' NOT NULL,
   employer varchar(255) NOT NULL,
   fk_industry tinyint(3) unsigned DEFAULT '0' NOT NULL,
   start_year year(4) DEFAULT '0000' NOT NULL,
   end_year year(4) DEFAULT '0000' NOT NULL,
   responsibilities text NOT NULL,
   KEY rid (rid)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO r_employment (rid, employer, fk_industry, start_year, end_year, responsibilities) VALUES ( '1', 'Trash Compactors, Inc.', '31', '1998', '2001', 'Oversaw an entire department of people engaged in the collection of trash. Woo hoo!');

#####################
# R_Reference Table #
#####################

DROP TABLE IF EXISTS r_reference;
CREATE TABLE r_reference (
   rid tinyint(3) unsigned DEFAULT '0' NOT NULL,
   name varchar(255) NOT NULL,
   phone varchar(25) NOT NULL,
   email varchar(255),
   KEY rid (rid)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO r_reference (rid, name, phone, email) VALUES ( '1', 'Mom', '+11 22 333 4567', 'bigmomma@myhome.com');
        INSERT INTO r_reference (rid, name, phone, email) VALUES ( '1', 'Dad', '+11 22 333 4567', '');

#################
# R_Skill Table #
#################

DROP TABLE IF EXISTS r_skill;
CREATE TABLE r_skill (
   rid tinyint(3) unsigned DEFAULT '0' NOT NULL,
   skill varchar(255) NOT NULL,
   experience tinyint(3) unsigned DEFAULT '0' NOT NULL,
   KEY skill (skill),
   KEY experience (experience),
   KEY rid (rid)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO r_skill (rid, skill, experience) VALUES ( '1', 'PHP', '3');
        INSERT INTO r_skill (rid, skill, experience) VALUES ( '1', 'Channel-surfing', '15');

################
# R-User Table #
################

DROP TABLE IF EXISTS r_user;
CREATE TABLE r_user (
   rid tinyint(3) unsigned NOT NULL auto_increment,
   jcode varchar(10) NOT NULL,
   fname varchar(255) NOT NULL,
   lname varchar(255) NOT NULL,
   dob date DEFAULT '0000-00-00' NOT NULL,
   addr1 varchar(255) NOT NULL,
   addr2 varchar(255),
   city varchar(255) NOT NULL,
   state varchar(255) NOT NULL,
   zip varchar(10) NOT NULL,
   fk_country tinyint(3) unsigned DEFAULT '0' NOT NULL,
   phone varchar(25) NOT NULL,
   email varchar(255) NOT NULL,
   url varchar(255),
   relo tinyint(4) DEFAULT '0' NOT NULL,
   posted date DEFAULT '0000-00-00' NOT NULL,
   PRIMARY KEY (rid),
   KEY jcode (jcode),
   KEY rid (rid)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO r_user (rid, jcode, fname, lname, dob, addr1, addr2, city, state, zip, fk_country, phone, email, url, relo, posted) VALUES ( '1', 'KA6547', 'Jack', 'Smith', '1980-04-01', '12, Dead Boring City', 'In The Middle Of Nowhere', 'Nowheresville', 'Of Boredom', '112233', '98', '+11 22 334 5677', 'jack@somewhere.com', '', '1', '2001-05-24');

################
# Salary Table #
################

DROP TABLE IF EXISTS salary;
CREATE TABLE salary (
   id tinyint(3) unsigned NOT NULL auto_increment,
   salary varchar(255) NOT NULL,
   PRIMARY KEY (id)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO salary (id, salary) VALUES ( '1', 'Not specified');
        INSERT INTO salary (id, salary) VALUES ( '2', '< USD 20,000');
        INSERT INTO salary (id, salary) VALUES ( '3', 'USD 20,000-29,900');
        INSERT INTO salary (id, salary) VALUES ( '4', 'USD 30,000-39,900');
        INSERT INTO salary (id, salary) VALUES ( '5', 'USD 40,000-49,900');
        INSERT INTO salary (id, salary) VALUES ( '6', 'USD 50,000-59,900');
        INSERT INTO salary (id, salary) VALUES ( '7', 'USD 60,000-69,900');
        INSERT INTO salary (id, salary) VALUES ( '8', 'USD 70,000-79,900');
        INSERT INTO salary (id, salary) VALUES ( '9', 'USD 80,000-89,900');
        INSERT INTO salary (id, salary) VALUES ( '10', 'USD 90,000-99,900');
        INSERT INTO salary (id, salary) VALUES ( '11', '> USD 100,000');

#################
# Subject Table #
#################

DROP TABLE IF EXISTS subject;
CREATE TABLE subject (
   id tinyint(3) unsigned NOT NULL auto_increment,
   subject varchar(255) NOT NULL,
   PRIMARY KEY (id)
);

    ####################
    # Inserting Values #
    ####################

        INSERT INTO subject (id, subject) VALUES ( '', 'Accounting');
        INSERT INTO subject (id, subject) VALUES ( '', 'Actuarial Science');
        INSERT INTO subject (id, subject) VALUES ( '', 'Adult Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Advertising and Public Relations');
        INSERT INTO subject (id, subject) VALUES ( '', 'African-American Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Agricultural Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Agricultural Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Agronomy and Soil Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Allopathic Medicine');
        INSERT INTO subject (id, subject) VALUES ( '', 'American Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Analytical Chemistry');
        INSERT INTO subject (id, subject) VALUES ( '', 'Anatomy');
        INSERT INTO subject (id, subject) VALUES ( '', 'Animal Behavior');
        INSERT INTO subject (id, subject) VALUES ( '', 'Animal Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Anthropology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Applied Arts and Design');
        INSERT INTO subject (id, subject) VALUES ( '', 'Applied Mathematics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Applied Physics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Applied Science and Technology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Aquaculture');
        INSERT INTO subject (id, subject) VALUES ( '', 'Archaeology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Architectural Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Architectural History');
        INSERT INTO subject (id, subject) VALUES ( '', 'Architecture');
        INSERT INTO subject (id, subject) VALUES ( '', 'Art/Fine Arts');
        INSERT INTO subject (id, subject) VALUES ( '', 'Art Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Art History');
        INSERT INTO subject (id, subject) VALUES ( '', 'Artificial Intelligence/Robotics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Arts Administration');
        INSERT INTO subject (id, subject) VALUES ( '', 'Art Therapy');
        INSERT INTO subject (id, subject) VALUES ( '', 'Asian Languages');
        INSERT INTO subject (id, subject) VALUES ( '', 'Asian Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Astronomy');
        INSERT INTO subject (id, subject) VALUES ( '', 'Astrophysics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Atmospheric Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Automotive Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Aviation');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biochemical Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biochemistry');
        INSERT INTO subject (id, subject) VALUES ( '', 'Bioengineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Bioethics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biomedical Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biometrics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biophysics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biopsychology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biostatistics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Biotechnology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Botany and Plant Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Business Administration');
        INSERT INTO subject (id, subject) VALUES ( '', 'Business Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Canadian Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Cardiovascular Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Cell Biology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Celtic Languages');
        INSERT INTO subject (id, subject) VALUES ( '', 'Chemical Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Chemistry');
        INSERT INTO subject (id, subject) VALUES ( '', 'Child and Family Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Chiropractic');
        INSERT INTO subject (id, subject) VALUES ( '', 'City and Regional Planning');
        INSERT INTO subject (id, subject) VALUES ( '', 'Civil Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Classics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Clinical Laboratory Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Clinical Psychology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Clothing and Textiles');
        INSERT INTO subject (id, subject) VALUES ( '', 'Cognitive Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Communication&');
        INSERT INTO subject (id, subject) VALUES ( '', 'Communication Disorders');
        INSERT INTO subject (id, subject) VALUES ( '', 'Community College Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Community Health');
        INSERT INTO subject (id, subject) VALUES ( '', 'Comparative Literature');
        INSERT INTO subject (id, subject) VALUES ( '', 'Computational Sciences');
        INSERT INTO subject (id, subject) VALUES ( '', 'Computer Art and Design');
        INSERT INTO subject (id, subject) VALUES ( '', 'Computer Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Computer Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Computer Science');
        INSERT INTO subject (id, subject) VALUES ( '', 'Conservation Biology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Construction Engineering');
        INSERT INTO subject (id, subject) VALUES ( '', 'Consumer Economics');
        INSERT INTO subject (id, subject) VALUES ( '', 'Corporate Communication');
        INSERT INTO subject (id, subject) VALUES ( '', 'Counseling Psychology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Counselor Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Criminal Justice and Criminology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Curriculum and Instruction');
        INSERT INTO subject (id, subject) VALUES ( '', 'Dance');
        INSERT INTO subject (id, subject) VALUES ( '', 'Decorative Arts');
        INSERT INTO subject (id, subject) VALUES ( '', 'Population Studies');
        INSERT INTO subject (id, subject) VALUES ( '', 'Dental Hygiene');
        INSERT INTO subject (id, subject) VALUES ( '', 'Dentistry');
        INSERT INTO subject (id, subject) VALUES ( '', 'Developmental Biology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Developmental Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Developmental Psychology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Early Childhood Education');
        INSERT INTO subject (id, subject) VALUES ( '', 'Ecology');
        INSERT INTO subject (id, subject) VALUES ( '', 'Economics');