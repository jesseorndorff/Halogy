<?php
/**
 * Halogy Installer.
 *
 * @author  Halogy Dev Team
 * @package Halogy\Installer
 *
 */

/** keep installer clean */
error_reporting(E_NONE);

/** @var string Database.php config file path in CodeIgniter */
$db_config_path = '../halogy/config/database.php';

/** @var string Config.php config file path in CodeIgniter */
$configuration_path = "../halogy/config/config.php";

/** try to prepare permissions on all files and folders */
@chmod($db_config_path,0777);
@chmod($configuration_path,0777);
@chmod('../halogy/cache',0777);
@chmod('../halogy/logs',0777);
@chmod('../static/uploads',0777);


/** Execute the install on submit */
if ($_POST) {

    /** Load the required files */
    require_once('includes/core_class.php');
    require_once('includes/database_class.php');

    /** @var object core library */
    $core = new Core();

    /** @var object database library */
    $database = new Database();

    /** Validate the post data */
    if ($core->validate_post($_POST) == true) {

        /** Validate MySQL version before installation */
        if ($db = @mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password'])) {
            $mysql_server_version = @mysql_get_server_info($db);

            /** Close connection */
            @mysql_close($db);

            if ($mysql_server_version < 4)
                $message = $core->show_message('error', "MySQL must be at least version 4.");
        } else {
            $message = $core->show_message('error', "Cannot connect to the database.");
        }

        /** Determine if error message present */
        if (!isset($message)) {

            /** All is well. Create the database, tables, database files and config files */
            if ($database->create_database($_POST) == false) {
                $message = $core->show_message('error', "The database could not be created, please verify your settings.");
            } else if ($database->create_tables($_POST) == false) {
                $message = $core->show_message('error', "The database tables could not be created, please verify your settings.");
            } else if ($core->write_db_config($_POST) == false) {
                $message = $core->show_message('error', "The database configuration file could not be written, please chmod halogy/config/database.php file to 777");
            } else if ($core->write_config($_POST) == false) {
                $message = $core->show_message('error', "The configuration file could not be written, please chmod halogy/config/config.php file to 777");
            }

            /** Allow the database to process the import */
            sleep(1);
        }

        /** No errors, the proceed to the admin login to setup Halogy */
        if (!isset($message)) {
            $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $redir .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $redir = str_replace('install/', '', $redir);
            $redir = str_replace('index.php', '', $redir);
            header("Location: " . $redir . "admin");
            exit();
        }
    } else {
        $message = $core->show_message('error', '<strong>Warning:</strong> Not all fields have been filled in correctly. The host, username, password, and database name are required.');
    }
}

/** @var int PHP version init to OK  */
$php_version = 0;

/** @var int Mysql exists init to OK */
$mysql_exists = 0;

/** @var int GD exists init to OK */
$gd_exists = 0;

/** @var int /halogy/cache folder writable init to OK */
$cache_writable = 0;

/** @var int /halogy/log folder writable init to OK */
$logs_writable = 0;

/** @var int /static/uploads folder writable init to OK */
$uploads_writable = 0;

/** @var int /halogy/cache folder exists init to OK */
$cache_exists = 0;

/** @var int /halogy/logs folder exists init to OK */
$logs_exists = 0;

/** @var int /static/uploads folder exists init to OK */
$uploads_exists = 0;

/** @var int MOD REWRITE module exists init to OK */
$rewrite_exists = 0;

/** @var int /halogy/config/database.php file exists init to OK */
$dbfile_exists = 0;

/** @var int /halogy/config/config.php file exists init to OK */
$configfile_exists = 0;

/** @var int error flag init to OK */
$error = 0;

/** Check PHP version */
if (version_compare(PHP_VERSION, '5', '<')) {
    $php_version = 1;
    $error = 1;
}

/** Check if MySQL installed */
if (!function_exists('mysql_connect')) {
    $mysql_exists = 1;
    $error = 1;
}

/** Check if GD installed */
if (!function_exists('gd_info')) {
    $gd_exists = 1;
    $error = 1;
}

/** Check cache folder exists and is writable */
if (is_dir("../halogy/cache")) {
    if (!is_writable("../halogy/cache")) {
        $cache_writable = 1;
        $error = 1;
    }
} else {
    $cache_exists = 1;
    $error = 1;
}

/** Check logs folder exists and is writable */
if (is_dir("../halogy/logs")) {
    if (!is_writable("../halogy/logs")) {
        $logs_writable = 1;
        $error = 1;
    }
} else {
    $logs_exists = 1;
    $error = 1;
}

/** Check uploads folder exists and is writable */
if (is_dir("../static/uploads")) {
    if (!is_writable("../static/uploads")) {
        $uploads_writable = 1;
        $error = 1;
    }
} else {
    $uploads_exists = 1;
    $error = 1;
}

/** Check MOD REWRITE is installed */
if (!in_array('mod_rewrite', apache_get_modules())) {
    $rewrite_exists = 1;
    $error = 1;
}

/** Check database.php exists and is writable */
if (!is_writable($db_config_path)) {
    $dbfile_exists = 1;
    $error = 1;
}

/** Check config.php exists and is writable */
if (!is_writable($configuration_path)) {
    $configfile_exists = 1;
    $error = 1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Install | Halogy</title>

        <style type="text/css">
            body {
                font-size: 75%;
                font-family: Helvetica,Arial,sans-serif;
                width: 600px;
                margin: 0 auto;
            }
            input, label {
                display: block;
                font-size: 18px;
                margin: 0;
                padding: 10px;
                border-radius:10px;
            }
            label {
                margin-top: 20px;
            }
            input.input_text {
                width: 270px;
            }
            input#submit {
                margin: 25px auto 0;
                font-size: 25px;
            }
            fieldset {
                padding: 15px;
                border-radius:10px;
            }
            legend {
                font-size: 18px;
                font-weight: bold;
            }
            .error {
                background: #ffd1d1;
                border: 1px solid #ff5858;
                padding: 6px;
                font-size:18px;
                color:#ff5858;
            }

            .error_window {
                font-size: 25px;
                line-height:35px;
            }

            .fail {
                display:inline-block;
                color:red;
                width:60px;
            }

            .success {
                display:inline-block;
                color:green;
                width:60px;
            }
        </style>
    </head>
    <body>

        <center>
            <img src="../static/images/halogy_logo.jpg" alt="Halogy">
                <h1>Install Halogy</h1>
                <p>Your site is ready. Add your database information below to complete the installation.</p>
        </center>
<?php if ($error == 0) { ?>

            <?php
            if (isset($message)) {
                echo '<p class="error">' . $message . '</p>';
            }
            ?>

            <center><form id="install_form" method="post" action="index.php">
                    <fieldset>
                        <legend>Database settings</legend>
                        <label for="hostname">Hostname (:port optional)</label><input type="text" id="hostname" value="localhost" class="input_text" name="hostname" />
                        <label for="username">Username</label><input type="text" id="username" class="input_text" name="username" />
                        <label for="password">Password</label><input type="password" id="password" class="input_text" name="password" />
                        <label for="database">Database Name</label><input type="text" id="database" class="input_text" name="database" />
                        <input type="submit" value="Install" id="submit" />
                    </fieldset>
                </form>

                <br />
                <h3>Security Note: Remove the '/install/*.*' folder and files after installing Halogy. Also change '/halogy/config/config.php' and '/halogy/config/database.php' files read-only.</h3>
            </center>

<?php } else { ?>

            <div class="error_window">

                <br />

    <?php
    // PHP VERSION
    if ($php_version == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " PHP Version greater than 5.0";
    ?>

                <br />

    <?php
    // MYSQL CHECK
    if ($mysql_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " MySQL installed";
    ?>

                <br />

    <?php
    // GD CHECK
    if ($gd_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " GD installed";
    ?>

                <br />

    <?php
    // CACHE FOLDER EXISTS
    if ($cache_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/cache/' folder exists";
    ?>

                <br />

    <?php
    // CACHE FOLDER CHECK
    if ($cache_writable == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/cache/' folder is writable";
    ?>

                <br />

    <?php
    // LOGS FOLDER EXISTS
    if ($logs_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/logs/' folder exists";
    ?>

                <br />

    <?php
    // LOGS FOLDER CHECK
    if ($logs_writable == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/logs/' folder is writable";
    ?>

                <br />

    <?php
    // UPLOADS FOLDER EXISTS
    if ($uploads_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/static/uploads/' folder exists";
    ?>

                <br />

    <?php
    // UPLOADS FOLDER CHECK
    if ($uploads_writable == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/static/uploads/' folder is writable";
    ?>

                <br />

    <?php
    // MOD REWRITE CHECK
    if ($rewrite_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " MOD REWRITE installed";
    ?>

                <br />

    <?php
    // DATABASE.PHP CHECK
    if ($dbfile_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/config/database.php' is writable";
    ?>

                <br />

    <?php
    // CONFIG.PHP CHECK
    if ($configfile_exists == 1)
        echo "<span class=\"fail\">FAIL</span> - ";
    else
        echo "<span class=\"success\">OK</span> - ";

    echo " '/halogy/config/config.php' is writable";
    ?>

                <br />


                <hr /><p>Fix all failed required items and <a href="index.php">retry</a>.</p>    
            </div>    
<?php } ?>

    </body>
</html>