<?php

$opts = getopt('s::b::u::t::civ', array('url::', 'built', 'log::'));

    $browsers = array(
                 'Firefox',
                 'Safari',
                 'Chrome',
                 'IE8',
                 'IE9',
                );

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

    $logFilePath = '';
    if (array_key_exists('log', $opts) === TRUE) {
        $logFilePath = $opts['log'];
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
        } else if ($browser === 'Chrome') {
            $browser = 'Google Chrome';
        }

        echo "\n=== Running tests on: $browser ===\n";
        putenv('VIPER_TEST_BROWSER='.$browser);

        $phpunitCMD = '';

        // Setup logging if there is no filter.
        if ($test === NULL || empty($logFilePath) === FALSE) {
            $browserid      = getBrowserid($browser);
            $browserTmpPath = dirname(__FILE__).'/tmp/'.$browserid;
            if (file_exists($browserTmpPath) === FALSE) {
                mkdir($browserTmpPath, 0755, TRUE);
            }

            if (empty($logFilePath) === TRUE) {
                $logFilePath = $browserTmpPath.'/test.log';
            }

            $phpunitCMD .= '--log-junit '.$logFilePath;
        }

        if ($unitTests !== NULL) {
            $phpunitCMD .= $unitTests;
        }

        if ($test !== NULL) {
            $phpunitCMD .= ' --filter "'.$test.'"';
            putenv('VIPER_TEST_FILTER='.$test);
        }

        if (empty($unitTests) === TRUE) {
            $phpunitCMD .= ' .';
        }

        passthru('phpunit '.$phpunitCMD);
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
