<?php
class ViperTestListener implements PHPUnit_Framework_TestListener
{
    private $_test            = NULL;
    private static $_failures = 0;
    private static $_errors   = 0;
    private static $_numTests = 0;
    private static $_testsRun = 0;
    public static $browserid  = NULL;

    private function _exportFail($type, $test, $msg)
    {
        $exportPath = dirname(__FILE__).'/tmp/'.self::$browserid.'/run/'.get_class($test);
        if (file_exists($exportPath) === FALSE) {
            mkdir($exportPath, 0755, TRUE);
        }

        $exportPath .= '/'.$type.'-'.$test->getName().'.txt';

        file_put_contents($exportPath, $msg);

    }

    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->_test = $test;
        self::$_testsRun++;

    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if ($suite->getName() === '.' && $this->_test !== NULL) {
            $this->_test->closeJSWindow();
        }

    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errors++;
        $this->_exportFail('error', $test, $e);

    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        self::$_failures++;
        $this->_exportFail('failure', $test, $e->getMessage());

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
        if ((self::$_testsRun >= self::$_numTests) || ((self::$_testsRun - 1) % 10) === 0) {
            $progress  = 'Tests: '.self::$_numTests."\n";
            $progress .= 'Completed: '.self::$_testsRun.' ('.((int) ((self::$_testsRun / self::$_numTests) * 100))."%)\n";
            $progress .= 'Errors: '.self::$_errors."\n";
            $progress .= 'Failures: '.self::$_failures."\n";

            $path = dirname(__FILE__).'/tmp/'.self::$browserid.'/run/progress.txt';
            file_put_contents($path, $progress);
        }

    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_numTests === 0) {
            $filter = getenv('VIPER_TEST_FILTER');
            if ($filter) {
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
