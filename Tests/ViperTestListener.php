<?php
/**
 * Class ViperTestListener for PHPUnit.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file license.txt. If not, see
 * <http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt>
 *
 * @package    Viper
 * @subpackage Testing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */

/**
 * ViperTestListener Class.
 */
class ViperTestListener implements PHPUnit_Framework_TestListener
{

    /**
     * Current test object.
     *
     * @var object
     */
    private $_test = NULL;

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
     * Number of consecutive errors.
     *
     * @var integer
     */
    private static $_errorStreak = 0;


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
        $errMsg  = PHPUnit_Framework_TestFailure::exceptionToString($e)."\n";
        $errMsg .= PHPUnit_Util_Filter::getFilteredStacktrace($e);

        $this->_addResult($test, $type, $errMsg);
        $this->_screenshot($type, $test, $e);

    }//end _addLog()


    /**
     * Add a result to the results log file.
     *
     * @param PHPUnit_Framework_Test $test   The PHPUnit test object.
     * @param string                 $status The status of the test.
     * @param string                 $msg    The error/failure message.
     *
     * @return void
     */
    private function _addResult(PHPUnit_Framework_Test $test, $status, $msg='')
    {
        $path = $this->getLogPath();
        if (empty($path) === TRUE) {
            return;
        }

        $path .= '/results.inc';

        $result = array(
                   'testClass' => get_class($test),
                   'testName'  => $test->getName(),
                   'status'    => $status,
                   'message'   => $msg,
                   'time'      => 0,
                  );

        $resultCont  = '<'.'?php $results[] = ';
        $resultCont .= var_export($result, TRUE);
        $resultCont .= "; ?>\n";

        file_put_contents($path, $resultCont, FILE_APPEND);

    }//end _addResult()


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
        // TODO: Disable screenshots for now.
        return;

        $path = $this->getLogPath();
        if (empty($path) === TRUE) {
            return;
        }

        $path .= '/'.get_class($test).'-'.$test->getName().'.jpg';

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


    /**
     * A test started.
     *
     * @param PHPUnit_Framework_Test $test The test that started.
     *
     * @return void
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->_test = $test;
        self::$_testsRun++;

    }//end startTest()


    /**
     * A test suite ended.
     *
     * @param PHPUnit_Framework_TestSuite $suite The test suite.
     *
     * @return void
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_sikuli !== NULL
            && $suite->getName() === '.'
            && $this->_test !== NULL
        ) {
            self::$_sikuli->stopJSPolling();

            if (self::$_sikuli->getOS() === 'windows') {
                // Close the browser window.
                self::$_sikuli->keyDown('Key.CTRL + w');
            }
        }

    }//end endTestSuite()


    /**
     * An error occurred.
     *
     * @param PHPUnit_Framework_Test $test Current test.
     * @param Exception              $e    The exception object.
     * @param float                  $time Time taken.
     *
     * @return void
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errorStreak++;
        self::$_errors++;
        $this->_addLog('error', $test, $e);

    }//end addError()


    /**
     * A failure occurred.
     *
     * @param PHPUnit_Framework_Test                 $test Current test.
     * @param PHPUnit_Framework_AssertionFailedError $e    The exception object.
     * @param float                                  $time Time taken.
     *
     * @return void
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        self::$_errorStreak = 0;
        self::$_failures++;
        $this->_addLog('failure', $test, $e);

    }//end addFailure()


    /**
     * A test ended.
     *
     * @param PHPUnit_Framework_Test $test The test that ended.
     * @param float                  $time Time taken for the test.
     *
     * @return void
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        if ($test->getStatus() === 0) {
            // Pass..
            self::$_errorStreak = 0;
        }

        // Report progress.
        $path = $this->getLogPath();
        if (empty($path) === FALSE) {
            $progress = array(
                         'tests'       => self::$_numTests,
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

            if ($test->getStatus() === 0) {
                $this->_addResult($test, 'pass');
            }
        }//end if

    }//end endTest()


    /**
     * A test suite started.
     *
     * @param PHPUnit_Framework_TestSuite $suite The suite object.
     *
     * @return void
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if (self::$_numTests !== 0) {
            return;
        }

        self::$_startTime = time();
        $filters          = getenv('VIPER_TEST_FILTER');

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
                }//end if
            }//end foreach
        } else {
            self::$_numTests = $suite->count();
        }//end if

    }//end startTestSuite()


    /**
     * Returns the number of failures.
     *
     * @return integer
     */
    public static function getFailures()
    {
        return self::$_failures;

    }//end getFailures()


    /**
     * Returns the number of errors.
     *
     * @return integer
     */
    public static function getErrors()
    {
        return self::$_errors;

    }//end getErrors()


    /**
     * Returns the total number of tests.
     *
     * @return integer
     */
    public static function getNumberOfTests()
    {
        return self::$_numTests;

    }//end getNumberOfTests()


    /**
     * Returns the number of tests run.
     *
     * @return integer
     */
    public static function getTestsRun()
    {
        return self::$_testsRun;

    }//end getTestsRun()


    /**
     * Returns the number of consecutive errors.
     *
     * @return integer
     */
    public static function getErrorStreak()
    {
        return self::$_errorStreak;

    }//end getErrorStreak()


    /**
     * Incomplete test.
     *
     * @param PHPUnit_Framework_Test $test The test object.
     * @param Exception              $e    The exception.
     * @param float                  $time Time of the error.
     *
     * @return void
     */
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errorStreak = 0;

    }//end addIncompleteTest()


    /**
     * Skipped test.
     *
     * @param PHPUnit_Framework_Test $test The test object.
     * @param Exception              $e    The exception.
     * @param float                  $time Time of the error.
     *
     * @return void
     */
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errorStreak = 0;

    }//end addSkippedTest()


    /**
     * Risky test.
     *
     * @param PHPUnit_Framework_Test $test The test object.
     * @param Exception              $e    The exception.
     * @param float                  $time Time of the error.
     *
     * @return void
     */
    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        self::$_errorStreak = 0;

    }//end addRiskyTest()


}//end class
