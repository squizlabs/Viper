<?php
class ViperTestListener implements PHPUnit_Framework_TestListener
{
    private $_test                = NULL;

    /**
     * Number of failures.
     *
     * @var integer
     */
    private static $_failures = 0;

    /**
     * Number of errors.
     *
     * @var integer
     */
    private static $_errors = 0;

    /**
     * Total number of tests.
     *
     * @var integer
     */
    private static $_numTests = 0;

    /**
     * Number of tests run.
     *
     * @var integer
     */
    private static $_testsRun = 0;

    /**
     * Start time of the tests.
     *
     * @var integer
     */
    private static $_startTime = NULL;

    /**
     * Path to the log directory.
     *
     * @var string
     */
    private static $_logPath = NULL;

    /**
     * Sikuli handler.
     *
     * @var PHPSikuliBrowser
     */
    private static $_sikuli = NULL;

    /**
     * The test filter.
     *
     * @var string
     */
    private static $_filter = NULL;


    /**
     * Set sikuli handler.
     *
     * @param object $sikuli The Sikuli handle.
     *
     * @return void
     */
    public static function setSikuli($sikuli)
    {
        self::$_sikuli = $sikuli;

    }//end setSikuli()


    /**
     * Returns the Sikuli object.
     *
     * @return object
     */
    public function getSikuli()
    {
        return self::$_sikuli;

    }//end getSikuli()


    /**
     * Set the test filter thats being used.
     *
     * @param string $filter The test filter thats in use.
     *
     * @return void
     */
    public static function setFilter($filter)
    {
        self::$_filter = $filter;

    }//end setFilter()


    /**
     * Returns the test filter.
     *
     * @return string
     */
    public function getFilter()
    {
        return self::$_filter;

    }//end getFilter()


    /**
     * Set the log path.
     *
     * @param string $path The log path.
     *
     * @return void
     */
    public static function setLogPath($path)
    {
        if (empty($path) === TRUE) {
            return;
        }

        self::$_logPath = $path;
        if (file_exists($path) === FALSE) {
            mkdir($path, 0755, TRUE);
        }

    }//end setLogPath()


    /**
     * Returns the log path.
     *
     * @return string
     */
    public static function getLogPath()
    {
        return self::$_logPath;

    }//end getLogPath()


    /**
     * Adds a log message.
     *
     * @param string                 $type The log type (e.g. error, failure).
     * @param PHPUnit_Framework_Test $test The PHPUnit test object.
     * @param Exception              $e    The exception object.
     *
     * @return void
     */
    private function _addLog($type, PHPUnit_Framework_Test $test, Exception $e)
    {
        $path = $this->getLogPath();
        if (empty($path) === TRUE) {
            return;
        }

        $path .= '/'.$type.'-'.get_class($test).'-'.$test->getName().'.log';

        $msg  = PHPUnit_Framework_TestFailure::exceptionToString($e)."\n";
        $msg .= PHPUnit_Util_Filter::getFilteredStacktrace($e);

        file_put_contents($path, $msg);

        $this->_screenshot($type, $test, $e);

    }//end _addLog()


    /**
     * Captures a screenshot of the entire screen.
     *
     * @param string                 $type The log type (e.g. error, failure).
     * @param PHPUnit_Framework_Test $test The PHPUnit test object.
     * @param Exception              $e    The exception object.
     *
     * @return void
     */
    private function _screenshot($type, PHPUnit_Framework_Test $test, Exception $e)
    {
        $path = $this->getLogPath();
        if (empty($path) === TRUE) {
            return;
        }

        $path .= '/'.$type.'-'.get_class($test).'-'.$test->getName().'.jpg';

        $sikuli = $this->getSikuli();
        if ($sikuli !== NULL) {
            // Capture screenshot of the entire screen.
            $imagePath = $sikuli->capture();
            $imagePath = str_replace('u\'', '', $imagePath);
            $imagePath = trim($imagePath, '\'');
            rename($imagePath, $path);

            // Resize image.
            exec('mogrify -resize 75% -quality 80 '.$path.' > /dev/null 2>&1');
        }

    }//end _screenshot()


    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->_test = $test;
        self::$_testsRun++;

    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_sikuli !== NULL
            && $suite->getName() === '.'
            && $this->_test !== NULL
        ) {
            self::$_sikuli->stopJSPolling();
        }

    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errors++;

        $this->_addLog('error', $test, $e);

    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        self::$_failures++;
        $this->_addLog('failure', $test, $e);

    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        // Report progress.
        // Report progress.
        $path = $this->getLogPath();
        if (empty($path) === FALSE) {
            if ((self::$_testsRun >= self::$_numTests) || ((self::$_testsRun - 1) % 10) === 0) {
                $progress = array(
                             'tests' => self::$_numTests,
                             'completed'   => self::$_testsRun,
                             'errors'      => self::$_errors,
                             'failure'     => self::$_failures,
                             'startTime'   => self::$_startTime,
                             'lastUpdated' => time(),
                            );

                // Init export dir.
                if (file_exists($path) === FALSE) {
                    mkdir($path, 0755, TRUE);
                }

                file_put_contents($path.'/progress.json', json_encode($progress));
            }
        }//end if

    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_numTests === 0) {
            self::$_startTime = time();

            $filters = getenv('VIPER_TEST_FILTER');
            if (empty($filters) === FALSE) {
                $filters = trim($filters, '/');
                $filters = explode('|', $filters);
                foreach ($filters as $filter) {
                    if (method_exists($suite, 'tests') === TRUE) {
                        $testName = $filter;
                        if (strpos($filter, '::') !== FALSE) {
                            list($className, $testName) = explode('::', $filter);
                        }

                        $tests = $suite->tests();
                        foreach ($tests as $test) {
                            if (preg_match('#'.$testName.'#', $test->getName()) > 0) {
                                self::$_numTests += $test->count();
                            } else if (method_exists($test, 'tests') === TRUE) {
                                foreach ($test->tests() as $testCase) {
                                    if (preg_match('#'.$testName.'#', $testCase->getName()) > 0) {
                                        self::$_numTests++;
                                    }
                                }
                            }
                        }
                    } else if (strpos($filter, '::') !== FALSE) {
                        $testName  = '';
                        $className = '';
                        list($className, $testName) = explode('::', $filter);
                        if ($className !== $suite->getName()) {
                            continue;
                        }

                        $tests = $suite->tests();
                        foreach ($tests as $test) {
                            if ($testName === $test->getName()) {
                                self::$_numTests++;
                                continue;
                            }
                        }
                    }
                }//end foreach
            } else {
                self::$_numTests = $suite->count();
            }//end if
        }

    }

    public function getFailures()
    {
        return self::$_failures;

    }

    public function getErrors()
    {
        return self::$_errors;

    }


    public function getNumberOfTests()
    {
        return self::$_numTests;

    }

    public function getTestsRun()
    {
        return self::$_testsRun;

    }

}
?>
