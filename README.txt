Here are the steps to upload the database into PostgreSQL:


1. Open DarkNUS_table.sql. Copy and paste into your terminal.
2. Open DarkNUS_triggers.sql. Copy and paste into your terminal.
3. Open DarkNUS_dummy_data.sql. Copy and paste into your terminal.
4. The login credentials (user ID and password) can be found in login_credentials.xlsx.


Setup to run DarkNUS PHP files:
1. Download and Install NetBeans IDE using the following URL:
https://www-us.apache.org/dist/netbeans/netbeans/11.2/Apache-NetBeans-11.2-bin-windows-x64.exe


2. Download and Install XAMPP from the following URL:
https://www.apachefriends.org/index.html
Click XAMPP for Windows under Download


3. After installing XAMPP, navigate to XAMPP/php/php.ini
Include 
"extension=php_pdo_pgsql.dll"
"extension=php_pgsql.dll"
after line 962 in the php.ini file


4. Export the folder "DarkNUS" to xampp/htdocs/ folder


5. Open NetBeans
Go to Files -> New Project
Categories: PHP
Projects: PHP Application with Existing Source
Choose DarkNUS folder in XAMPP/htdocs as Sources Folder
Click Finish


6. To connect to the database
Open dbFunction.php and edit the following:
$link = pg_connect("host=localhost dbname=postgres user=postgres password=password");

host=localhost 
dbname=your postgres database name 
user=your postgres userID
password=your postgres password


7. Open xampp-control.exe
Start Apache


8. Right Click index.php
Click Run

9. Launch Google Chrome and go to localhost/darknus