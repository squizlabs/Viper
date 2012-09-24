<?php
class ViperTestListener implements PHPUnit_Framework_TestListener
{
    private $_test = NULL;

    private static $_failures = 0;
    private static $_errors = 0;

    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->_test = $test;

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
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        self::$_failures++;
    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function getFailures()
    {
        return self::$_failures;

    }

    public function getErrors()
    {
        return self::$_errors;

    }

}
?>
