<?php

    chdir(dirname(__FILE__));

    $opts = getopt('b::u::t::cv', array('url::', 'built', 'log::', 'help'));

    if (isset($opts['help']) === TRUE) {
        printHelp();
        exit;
    }

    $browsers = array(
                 'firefox',
                 'safari',
                 'chrome',
                 'ie8',
                 'ie9',
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
    if (isset($opts['t']) === TRUE && empty($opts['t']) === FALSE) {
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
        putenv('VIPER_TEST_LOG_PATH='.$opts['log']);
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
        }

        echo "\n=== Running tests on: ".ucfirst($browser)." ===\n";
        putenv('VIPER_TEST_BROWSER='.$browser);

        $phpunitCMD = '';

        $browserid      = getBrowserid($browser);
        $browserTmpPath = dirname(__FILE__).'/tmp/'.$browserid;
        if (file_exists($browserTmpPath) === FALSE) {
            mkdir($browserTmpPath, 0755, TRUE);
        }

        // Setup logging if there is no filter.
        if (empty($logFilePath) === FALSE) {
            if (file_exists($logFilePath) === FALSE) {
                mkdir($logFilePath, 0755, TRUE);
            }

            $logFilePath .= '/phpunit.xml';
            $phpunitCMD  .= '--log-junit '.$logFilePath;
        }

        if ($unitTests !== NULL) {
            $phpunitCMD .= $unitTests;
        }

        if ($test !== NULL) {
            $phpunitCMD .= ' --filter \''.$test.'\'';
            putenv('VIPER_TEST_FILTER='.$test);
        }

        if (empty($unitTests) === TRUE) {
            $phpunitCMD .= ' .';
        }

        passthru('php phpunit.phar '.$phpunitCMD);
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

    function printHelp()
    {
        echo "Usage: php runTests.php <switches>\n\n";
        echo "  -b            Comma separated browsers to test. I.e: firefox, chrome, safari, ie8, ie9.\n";
        echo "  -t            Name of the test to run.\n";
        echo "  -c            Run the test calibration.\n";
        echo "  -v            Output more verbose information.\n";
        echo "  --url <url>   Sets the URL for Viper testing. Must point to Viper's Test directory.\n";
        echo "  --built       Run tests on Viper build.\n";
        echo "  --log <file>  Logs test execution.\n";
        echo "  --help        Prints this help message.\n";
        echo "\nExamples:\n";
        echo "  # Run calibration on Firefox and run the test named testStartOfParaBold.\n";
        echo "  php runTests.php -bfirefox -c -ttestStartOfParaBold\n\n";
        echo "  # Run all tests that contain the ParaBold in their name on Firefox and Chrome.\n";
        echo "  php runTests.php -bfirefox,chrome -tParaBold";
        echo "\n\n";

    }//end printHelp()

?>
