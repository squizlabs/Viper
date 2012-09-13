<?php

$opts = getopt('s::b::u::t::civ', array('selenium', 'popup', 'url::', 'built'));

    $browsers = array(
                 'Firefox',
                 'Safari',
                 'Google Chrome',
                 'IE8',
                 'IE9',
                );

    /*if (isset($opts['s']) === TRUE) {
        putenv('SIKULI_HOME='.$opts['s']);
    } else {
        $sikuliHome = getenv('SIKULI_HOME');
        if ($sikuliHome === FALSE) {
            throw new Exception('SIKULI_HOME is not set');
        }
    }*/

    // Browsers.
    if (isset($opts['b']) === TRUE) {
        $browsers = explode(',', $opts['b']);
    }

    $unitTests = NULL;
    if (isset($opts['u']) === TRUE) {
        $unitTests = $opts['u'];
    }

    $test = NULL;
    if (isset($opts['t']) === TRUE) {
        $test = $opts['t'];
    }

    if (isset($opts['v']) === TRUE) {
        // Turn on verbose mode.
        putenv('VIPER_TEST_VERBOSE=TRUE');
    }

    if (isset($opts['c']) === TRUE) {
        putenv('VIPER_TEST_CALIBRATE=TRUE');
    }

    if (array_key_exists('built', $opts) === TRUE) {
        putenv('VIPER_TEST_USE_BUILT_VIPER=TRUE');
    }

    if (array_key_exists('selenium', $opts) === TRUE) {
        putenv('VIPER_TEST_USE_SELENIUM=TRUE');
    } else if (array_key_exists('popup', $opts) === FALSE) {
        putenv('VIPER_TEST_USE_POLLING=TRUE');
    }

    $urlFile = dirname(__FILE__).'/tmp/url.inc';
    if (array_key_exists('url', $opts) === TRUE) {
        putenv('VIPER_TEST_URL='.$opts['url']);

        if (file_exists(dirname($urlFile)) === FALSE) {
            mkdir(dirname($urlFile), 0755, TRUE);
        }

        file_put_contents($urlFile, $opts['url']);
    } else if (file_exists($urlFile) === TRUE) {
        $url = trim(file_get_contents($urlFile));
        if (empty($url) === TRUE) {
            echo "Error: Please provide the URL for the test system using --url.\n";
            exit;
        } else {
            putenv('VIPER_TEST_URL='.$url);
        }
    } else {
        echo "Error: Please provide the URL for the test system using --url.\n";
        exit;
    }

    foreach ($browsers as $browser) {
        $browser = trim($browser);
        if (empty($browser) === TRUE) {
            continue;
        }

        echo "\n=== Running tests on: $browser ===\n";
        putenv('VIPER_TEST_BROWSER='.$browser);

        $phpunitCMD = '';

        // Setup logging if there is no filter.
        if ($test === NULL) {
            $browserid      = getBrowserid($browser);
            $browserTmpPath = dirname(__FILE__).'/tmp/'.$browserid;
            if (file_exists($browserTmpPath) === FALSE) {
                mkdir($browserTmpPath, 0755, TRUE);
            }

            $logPath     = $browserTmpPath.'/test.log';
            $phpunitCMD .= '--log-junit '.$logPath;
        }

        if ($unitTests !== NULL) {
            $phpunitCMD .= $unitTests;
        }

        if ($test !== NULL) {
            $phpunitCMD .= ' --filter "'.$test.'"';
        }

        if (empty($unitTests) === TRUE) {
            $phpunitCMD .= ' .';
        }

        passthru('phpunit --configuration phpunit.xml '.$phpunitCMD);
    }

    function getBrowserid($browser)
    {
        $id = $browser;
        if (getOS() === 'windows'
            && strpos($id, '.exe') !== FALSE
        ) {
            $id = explode('\\', $id);
            $id = array_pop($id);
            $id = str_replace('.exe', '', $id);
        }

        $id = strtolower($id);
        $id = str_replace(' ', '', $id);
        return $id;

    }//end getBrowserid()

    function getOS()
    {
        $os = strtolower(php_uname('s'));
        switch ($os) {
            case 'darwin':
                $os = 'osx';
            break;

            case 'linux':
                $os = 'linux';
            break;

            case 'windows nt':
                $os = 'windows';
            break;

            default:
                $os = $os;
            break;
        }//end switch

        return $os;

    }//end getOS()

?>
