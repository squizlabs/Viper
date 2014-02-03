<?php
class ViperTestListener implements PHPUnit_Framework_TestListener
{
    private $_test                = NULL;
    private static $_failures     = 0;
    private static $_errors       = 0;
    private static $_numTests     = 0;
    private static $_testsRun     = 0;
    public static $browserid      = NULL;
    private static $_startTime    = NULL;
    public static $viperTestObj   = NULL;
    private static $_minTestCount = 10;

    private static function _getExportPath()
    {
        $exportPath  = dirname(__FILE__).'/tmp/'.self::$browserid.'/results/';
        $exportPath .= date('d_M_y_H-i', self::$_startTime);

        return $exportPath;

    }

    private function _exportFail($type, $test, $e)
    {
        $exportPath = self::_getExportPath();

        $exportPath .= '/'.get_class($test);
        if (file_exists($exportPath) === FALSE) {
            mkdir($exportPath, 0755, TRUE);
        }

        $exportPath .= '/'.$type.'-'.$test->getName().'.txt';

        $msg  = PHPUnit_Framework_TestFailure::exceptionToString($e)."\n";
        $msg .= PHPUnit_Util_Filter::getFilteredStacktrace($e);

        file_put_contents($exportPath, $msg);

    }

    private function _screenshot($test, $e, $type='error')
    {
        $exportPath = self::_getExportPath();

        $exportPath .= '/'.get_class($test);
        if (file_exists($exportPath) === FALSE) {
            mkdir($exportPath, 0755, TRUE);
        }

        $exportPath .= '/'.$type.'-'.$test->getName().'.png';

        $sikuli = self::$viperTestObj->getSikuli();
        if (empty($sikuli) === FALSE) {
            $imagePath = $sikuli->capture();
            $imagePath = str_replace('u\'', '', $imagePath);
            $imagePath = trim($imagePath, '\'');
            rename($imagePath, $exportPath);
        }

    }

    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->_test = $test;
        self::$_testsRun++;

    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$viperTestObj !== NULL
            && $suite->getName() === '.'
            && $this->_test !== NULL
        ) {
            $sikuli = self::$viperTestObj->getSikuli();
            if (empty($sikuli) === FALSE) {
                $sikuli->stopJSPolling();
            }
        }

    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errors++;

        if (self::$_numTests > self::$_minTestCount) {
            $this->_exportFail('error', $test, $e);
            $this->_screenshot($test, $e, 'error');
        }

    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        self::$_failures++;

        if (self::$_numTests > self::$_minTestCount) {
            $this->_exportFail('failure', $test, $e);
        }

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
        if (self::$_numTests > self::$_minTestCount && ((self::$_testsRun >= self::$_numTests) || ((self::$_testsRun - 1) % 10) === 0)) {
            $startTime   = date('d M y, H:i', self::$_startTime);
            $currentTime = date('d M y, H:i', time());

            $datetime1 = new DateTime($startTime);
            $datetime2 = new DateTime($currentTime);
            $interval = $datetime1->diff($datetime2);

            $progress  = 'Tests: '.self::$_numTests."\n";
            $progress .= 'Completed: '.self::$_testsRun.' ('.((int) ((self::$_testsRun / self::$_numTests) * 100))."%)\n";
            $progress .= 'Errors: '.self::$_errors."\n";
            $progress .= 'Failures: '.self::$_failures."\n";
            $progress .= 'Start Time: '.$startTime."\n";
            $progress .= 'Last Updated: '.$currentTime."\n";
            $progress .= 'Run Time: '.$interval->format('%hh %im')."\n";

            // Init export dir.
            $path = self::_getExportPath();
            if (file_exists($path) === FALSE) {
                mkdir($path, 0755, TRUE);
            }

            $path = self::_getExportPath().'/progress.txt';
            file_put_contents($path, $progress);
        }

    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_numTests === 0) {
            self::$_startTime = time();

            $filter = getenv('VIPER_TEST_FILTER');

            if ($filter) {
                if (strpos($filter, '::') !== FALSE) {
                    $testName  = '';
                    $className = '';
                    list($className, $testName) = explode('::', $filter);

                    if ($className !== $suite->getName()) {
                        return;
                    }

                    $tests = $suite->tests();
                    foreach ($tests as $test) {
                        if ($testName === $test->getName()) {
                            self::$_numTests++;
                            return;
                        }
                    }
                } else if (method_exists($suite, 'tests') === TRUE) {
                    $tests = $suite->tests();
                    foreach ($tests as $test) {
                        if (preg_match('#'.$filter.'#', $test->getName()) > 0) {
                            self::$_numTests += $test->count();
                        } else {
                            foreach ($test->tests() as $testCase) {
                                if (preg_match('#'.$filter.'#', $testCase->getName()) > 0) {
                                    self::$_numTests++;
                                }
                            }
                        }
                    }
                }
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
