<?php

    $opts = getopt('s::b::u::t::c::');

    $browsers = array(
                 'Firefox',
                 'Safari',
                 'Google Chrome',
                 'Internet Explorer',
                );

    if (isset($opts['s']) === TRUE) {
        putenv('SIKULI_HOME='.$opts['s']);
    } else {
        $sikuliHome = getenv('SIKULI_HOME');
        if ($sikuliHome === FALSE) {
            throw new Exception('SIKULI_HOME is not set');
        }
    }

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

    if (isset($opts['c']) === TRUE) {
         putenv('VIPER_TEST_SIMILARITY='.$opts['c']);
    }

    foreach ($browsers as $browser) {
        if (empty($browser) === TRUE) {
            continue;
        }

        echo "\n=== Running tests on: $browser ===\n";
        putenv('VIPER_TEST_BROWSER='.$browser);

        $phpunitCMD = '';

        if ($unitTests !== NULL) {
            $phpunitCMD .= $unitTests;
        }

        if ($test !== NULL) {
            $phpunitCMD .= '--filter "'.$test.'"';
        }

        if (empty($unitTests) === TRUE) {
            $phpunitCMD .= ' .';
        }

        passthru('phpunit '.$phpunitCMD);
    }

?>
