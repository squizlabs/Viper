<?php
require_once 'PHPSikuli/PHPSikuliBrowser.php';

/**
 * An abstract class that all Viper unit tests must extend.
 */
abstract class AbstractViperUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Do not backup static attributes.
     *
     * @var boolean
     */
    protected $backupStaticAttributes = false;

    /**
     * The sikuli object.
     *
     * @var object
     */
    private static $_sikuli = null;

    /**
     * The sikuli object.
     *
     * @var object
     */
    protected $sikuli = null;

    /**
     * The test.html file content.
     *
     * @var string
     */
    private static $_testContent = null;

    /**
     * Set to TRUE then the first test has run.
     *
     * @var boolean
     */
    private static $_testRun = false;

    /**
     * Name of the browser that the tests are running on.
     *
     * @var string
     */
    private static $_browser = null;

    /**
     * Region object of the Viper Top toolbar.
     *
     * @var string
     */
    private static $_topToolbar = null;

    /**
     * The default similarity setting.
     *
     * @var float
     */
    private static $_similarity = 0.85;

    /**
     * Keeps cache of JS that is executed.
     *
     * @var array
     */
    private static $_data = null;

    /**
     * Number of tests run.
     *
     * @var integer
     */
    private static $_testCount = 0;

    /**
     * Maximum number of consecutive errors before Sikuli connection is reset and browser is restarted.
     *
     * @var integer
     */
    private static $_maxErrorStreak = 3;

    /**
     * List of applications and if they are available in the current system.
     *
     * @var array
     */
    private static $_apps = array();

    /**
     * The current version of Viper.
     *
     * @var string
     */
    private static $_viperVersion = '';

    /**
     * Name of string that holds alternatives for different OS.
     *
     * @var string
     */
    private static $_Command = null;

    /**
     * Name of string that directs $Command.
     *
     * @var string
     */
    private static $_CommandDirection = null;

    /**
     * Returns the path of a test file.
     *
     * @param string $type The type of the file, js or html.
     *
     * @return string
     */
    private function _getTestFile($type)
    {
        $baseDir   = dirname(__FILE__);
        $className = get_class($this);
        $paths     = explode('_', $className);
        array_shift($paths);
        array_shift($paths);
        $paths[] = $this->getName();

        // Find the HTML file for this test.
        $testFileContent = '';
        $jsPath          = null;
        $count           = count($paths);
        while ($count > 0) {
            $last     = array_pop($paths);
            $filePath = $baseDir.'/'.implode('/', $paths).'/'.$last.'.'.$type;
            if (file_exists($filePath) === true) {
                return $filePath;
            } else if (count($paths) > 0) {
                // Check for HTML file that has the same name as the directory.
                $filePath = $baseDir.'/'.implode('/', $paths).'/'.$paths[(count($paths) - 1)].'.'.$type;
                if (file_exists($filePath) === true) {
                    return $filePath;
                }
            }

            $count = count($paths);
        }

        return null;

    }//end _getTestFile()


    /**
     * Setup test.
     *
     * @return void
     * @throws Exception If browser is invalud.
     */
    protected function setUp()
    {
        self::$_testCount++;

        $baseDir = dirname(__FILE__);

        // Get the test HTML file.
        $htmlFilePath    = $this->_getTestFile('html');
        $testFileContent = '';
        if ($htmlFilePath !== null) {
            $testFileContent = trim(file_get_contents($htmlFilePath));
            $testFileContent = $this->replaceKeywords($testFileContent);
        }

        // Get the test JS file.
        $jsFilePath = $this->_getTestFile('js');
        $jsInclude  = '';
        if ($jsFilePath !== null) {
            $jsFilePath = str_replace($baseDir, '../', $jsFilePath);
            $jsInclude  = '<script type="text/javascript" src="'.$jsFilePath.'"></script>';
        }

        parent::setUp();

        if (self::$_sikuli === null) {
            $browser       = getenv('VIPER_TEST_BROWSER');
            $options       = array(
                              'size'           => array(
                                                   'width'  => 1270,
                                                   'height' => 850,
                                                  ),
                              'fileGroupOwner' => '_www',
                             );
            self::$_sikuli = new PHPSikuliBrowser($browser, $options);
        }

        $this->sikuli = self::$_sikuli;

        if (self::$_testRun !== true) {
            try {
                // Press ESC incase there is an active screensaver.
                $this->sikuli->keyDown('Key.ESC');
                sleep(2);
            } catch (Exception $e) {
                // Ignore the error.
            }

            self::$_viperVersion = $this->_getGitCommitid();
        }

        // Get the contents of the test file template.
        if (self::$_testContent === null) {
            self::$_testContent = file_get_contents($baseDir.'/Web/test-template.html');
        }

        $viperInclude = '';
        if (getenv('VIPER_TEST_USE_BUILT_VIPER') === 'TRUE') {
            $path = dirname(dirname(__FILE__)).'/build/viper.js';
            if (file_exists($path) === false) {
                throw new Exception('Could not find: '.$path);
            }

            $viperInclude = '<script type="text/javascript" src="../../build/viper.js?v='.self::$_viperVersion.'"></script>
                             <link rel="stylesheet" media="screen" href="../../build/viper.css?v='.self::$_viperVersion.'" />';
        } else {
            $viperInclude = '<script type="text/javascript" src="../../Viper-all.js?v='.self::$_viperVersion.'"></script>';
        }

        // Get stats.
        $testTitle  = $this->getName();
        $numFails   = ViperTestListener::getFailures();
        $numErrors  = ViperTestListener::getErrors();
        $totalTests = ViperTestListener::getNumberOfTests();
        $testsRun   = ViperTestListener::getTestsRun();

        // Reset the Sikuli connection and restart the browser if the number of consecutive errors reach the limit or
        // every 100 tests.
        if (ViperTestListener::getErrorStreak() >= self::$_maxErrorStreak || ($testsRun % 100) === 0) {
            $this->resetConnection();
            ViperTestListener::resetErrorStreak();
        }

        ViperTestListener::setSikuli($this->sikuli);
        ViperTestListener::setFilter(getenv('VIPER_TEST_FILTER'));
        ViperTestListener::setLogPath(getenv('VIPER_TEST_LOG_PATH'));

        $testTitle .= '['.$testsRun.'/'.$totalTests.']';

        if ($numFails !== 0 || $numErrors !== 0) {
            $testTitle .= '(F:'.ViperTestListener::getFailures().', ';
            $testTitle .= 'E:'.ViperTestListener::getErrors().')';
        }

        // Put the current test file contents to the main test file.
        $contents = str_replace('__TEST_CONTENT__', $testFileContent, self::$_testContent);
        $contents = str_replace('__TEST_BROWSER__', $this->sikuli->getBrowserid(), $contents);
        $contents = str_replace('__TEST_VIPER_INCLUDE__', $viperInclude, $contents);
        $contents = str_replace('__TEST_TITLE__', $testTitle, $contents);
        $contents = str_replace('__TEST_JS_INCLUDE__', $jsInclude, $contents);
        $contents = str_replace('__TEST_VIPER_VERSION__', self::$_viperVersion, $contents);
        $contents = str_replace('__TEST_URL__', $this->_getBaseUrl(), $contents);

        $dest = $baseDir.'/tmp/test_tmp.html';
        file_put_contents($dest, $contents);

        $this->sikuli->resize();

        if (strpos($this->sikuli->getBrowserid(), 'ie') === 0) {
            // Set click delay.
            $this->sikuli->setClickDelay(250);
        }

        // Change browser and then change the URL.
        if (self::$_testRun === true) {
            // URL is already changed to the test runner, so just reload.
            $this->sikuli->setSetting('MinSimilarity', self::$_similarity);
            $this->reloadPage();

            // Reset zoom.
            $this->sikuli->keyDown('Key.CMD + 0');

            $this->sikuli->setAutoWaitTimeout(1);
            $this->_waitForViper();
        } else {
            $this->sikuli->setSetting('MinSimilarity', self::$_similarity);
            $calibrate = getenv('VIPER_TEST_CALIBRATE');

            // Turn off calibration incase of reconnection to Sikuli server.
            putenv('VIPER_TEST_CALIBRATE=FALSE');

            if ($calibrate === 'TRUE' || file_exists($this->getBrowserImagePath()) === false) {
                try {
                    $this->_calibrate();
                } catch (Exception $e) {
                    echo $e;
                    exit;
                }
            }

            $this->sikuli->goToURL($this->_getBaseUrl().'/tmp/test_tmp.html?_t='.time());

            // Reset zoom.
            $this->sikuli->keyDown('Key.CMD + 0');

            $this->sikuli->setAutoWaitTimeout(1);
            $this->_waitForViper();

            self::$_testRun = true;
        }//end if

    }//end setUp()


    /**
     * Returns the commit id.
     *
     * @return string
     */
    private function _getGitCommitid()
    {
        $commitid = exec('git rev-parse --short HEAD');
        return $commitid;

    }//end _getGitCommitid()


    /**
     * Resets the Sikuli connection.
     *
     * @return void
     */
    protected function resetConnection()
    {
        $this->sikuli->execJS('clean()', TRUE);

        self::$_topToolbar = null;
        self::$_testRun    = false;

        $this->sikuli->resetConnection();
        $this->sikuli->resize();

    }//end resetConnection()


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
     * Reload the test page.
     *
     * @return void
     */
    protected function reloadPage()
    {
        $this->sikuli->execJS('clean()', TRUE);
        $this->sikuli->reloadPage();

    }//end reloadPage()


    /**
     * Returns the path of a specific browser image directory.
     *
     * @param string $browserid ID of the browser, e.g. googlechrome.
     *
     * @return string
     */
    protected function getBrowserImagePath($browserid=null)
    {
        if ($browserid === null) {
            $browserid = $this->sikuli->getBrowserid();
        }

        $path = dirname(__FILE__).'/tmp/'.$browserid.'/images';

        return $path;

    }//end getBrowserImagePath()


    /**
     * Returns the path to the button image created in calibration process.
     *
     * @param string $buttonName The name of the button.
     * @param string $state      The name of the button state (active, selected).
     *
     * @return string
     * @throws Exception If the button icon does not exist.
     */
    protected function getButtonIconPath($buttonName, $state=null)
    {
        // Calibrate image recognition.
        $imgPath  = $this->getBrowserImagePath();
        $imgPath .= '/'.$buttonName;

        if ($state !== null) {
            $imgPath .= '_'.$state;
        }

        $imgPath .= '.png';

        if (file_exists($imgPath) === false) {
            throw new Exception('Button icon not found: '.$imgPath);
        }

        return $imgPath;

    }//end getButtonIconPath()


    /**
     * Clean up.
     *
     * Does not call parent method so that the Sikuli connection is not closed after
     * each test.
     *
     * @return void
     */
    protected function tearDown()
    {
        // Clear the toptoolbar location cache here so that if there is another test then the waitForViper method will
        // work after the test page is reloaded.
        self::$_topToolbar = null;

        if ($this->sikuli !== null) {
            // Check if there were any JS errors.
            $jsErrors = $this->sikuli->getJSErrors();
            if (empty($jsErrors) === false) {
                $msgs = array();
                foreach ($jsErrors as $error) {
                    $msg  = 'JavaScript error detected: '.$error['errorMsg'].' in '.$error['url'];
                    $msg .= ' on line '.$error['lineNumber'];

                    if (empty($error['stackTrace']) === false) {
                        $msg .= "\n\nStack:\n".$error['stackTrace'];
                    }

                    $msgs[] = $msg;
                }

                $this->fail(implode("\n", $msgs));
            }

            $this->sikuli->clearVars();
        }//end if

    }//end tearDown()


    /**
     * Cleans up after all tests are completed.
     *
     * @return void
     */
    public static function tearDownAfterClass()
    {
        $path = dirname(__FILE__).'/test_tmp.html';
        if (file_exists($path) === true) {
            // Remove the tmp file.
            unlink($path);
        }

    }//end tearDownAfterClass()


    /**
     * Waits till the Viper elements are loaded.
     *
     * @return void
     * @throws Exception If Viper fails to load on the page.
     */
    private function _waitForViper($retries=2)
    {
        if ($retries === 0) {
            $this->resetConnection();
            throw new Exception('Failed to load Viper test page.');
        }

        try {
            // This will make sure that the browser has loaded the Viper page.
            $this->getTopToolbar();
        } catch (Exception $e) {
            $this->resetConnection();
            $this->fail('Browser is not functioning properly');
            return FALSE;
            // Its not working.. Try to start browser again.
            $this->sikuli->restartBrowser();
            $this->sikuli->resize();
            $this->sikuli->goToURL($this->_getBaseUrl().'/tmp/test_tmp.html?_t='.time());
            sleep(2);
            $this->getTopToolbar();
        }

        $this->sikuli->setAutoWaitTimeout(4, $this->getTopToolbar());

        // Make sure page is loaded.
        if ($this->topToolbarButtonExists('bold', 'disabled') === false) {
            // Try to go to the test URL again. Do not refresh incase browser has navigated to another URL.
            $this->sikuli->goToURL($this->_getBaseUrl().'/tmp/test_tmp.html?_t='.time());
            $this->_waitForViper($retries - 1);
            return;
        }

        $this->sikuli->setAutoWaitTimeout(0.5, $this->getTopToolbar());
        $this->sikuli->setAutoWaitTimeout(1);

        if ($this->sikuli->getBrowserid() === 'ie8') {
            // Give some time for IE to catch up....
            sleep(2);
        }

    }//end _waitForViper()


    /**
     * Calibrates the testing to work with the current browser.
     *
     * This method will create images of each button image and place it in a temp
     * directory.
     *
     * @return void
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrate()
    {
        // Clean up old files.
        $imgPath = $this->getBrowserImagePath();
        $images  = glob($imgPath.'/*.png');
        foreach ($images as $image) {
            if (is_file($image) === true) {
                unlink($image);
            }
        }

        $url = $this->_getBaseUrl().'/Web/calibrate.html';
        $this->sikuli->goToURL($url);
        sleep(3);

        $this->_calibrateKeywords();
        $this->_calibrateIcons();

    }//end _calibrate()


    /**
     * Creates screenshot for the keywords.
     *
     * @return void
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrateKeywords()
    {
        $this->sikuli->setAutoWaitTimeout(0.5);

        // Calibrate image recognition.
        $imgPath = $this->getBrowserImagePath();

        if (file_exists($imgPath) === false) {
            mkdir($imgPath, 0755, true);
        }

        $this->sikuli->execJS('calibrate("keywords")');

        $texts = $this->sikuli->execJS('getKeywordCoords('.json_encode(self::_getKeywordsList()).')');
        $count = count($texts);

        $i      = 1;
        $coords = array();
        foreach ($texts as $id => $textRect) {
            $region     = $this->sikuli->getRegionOnPage($textRect);
            $coordsText = $this->sikuli->getX($region).'-'.$this->sikuli->getY($region);

            if (isset($coords[$coordsText]) === true) {
                throw new Exception('Text match conflict between '.$coords[$coordsText].' and '.$id);
            }

            $coords[$coordsText] = $id;

            $textImage = $this->sikuli->capture($region);
            copy($textImage, $this->_getKeywordImage($i));
            $i++;
        }

        $tests          = 5;
        $pass           = false;
        $textSimilarity = 0.98;

        do {
            try {
                for ($j = 1; $j <= $tests; $j++) {
                    // Change the contents of the test page.
                    $this->sikuli->execJS('changeContent('.$j.', '.$textSimilarity.')');

                    // Test that captured images can be found on the page.
                    for ($i = 1; $i <= $count; $i++) {
                        $this->sikuli->find($this->_getKeywordImage($i), null, $textSimilarity);
                    }
                }

                $pass = true;
            } catch (Exception $e) {
                if ($textSimilarity < 0.85) {
                    throw new Exception('Text similarity test dropped below minimum threshold (85%)');
                }

                $textSimilarity -= 0.01;
            }
        } while ($pass !== true);

        $this->addData('textSimmilarity', $textSimilarity);

    }//end _calibrateKeywords()


    /**
     * Creates button images that are used in Viper for the current browser.
     *
     * @return void
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrateIcons()
    {
        $this->sikuli->setAutoWaitTimeout(0.5);

        // Calibrate image recognition.
        $baseDir = dirname(__FILE__);
        $imgPath = $this->getBrowserImagePath();

        if (file_exists($imgPath) === false) {
            mkdir($imgPath, 0755, true);
        }

        $cssContents = file_get_contents($baseDir.'/../Css/viper_tools.css');

        $matches = array();
        preg_match_all('#.Viper-buttonIcon.Viper-([\w-_]+)#', $cssContents, $matches);

        $buttonHTML   = '';
        $browserClass = '';
        $buttonNames  = array_values(array_unique($matches[1]));
        $statuses     = array(
                         ''             => ' Viper-dummyClass',
                         '_selected'    => ' Viper-selected',
                         '_active'      => ' Viper-active',
                         '_disabled'    => ' Viper-disabled',
                         '_active-selected' => 'Viper-selected Viper-active',
                        );

        if ($this->sikuli->getBrowserid() === 'ie8') {
            $browserClass = 'Viper-browser-msie Viper-browserVer-msie8';
        }

        $buttonCount = count($buttonNames);
        for ($i = 0; $i < $buttonCount; $i++) {
            if (($i % 20) === 0) {
                if ($buttonHTML !== '') {
                    $buttonHTML .= '</div></div>';
                }

                $buttonHTML .= '<div class="ViperTP-bar Viper-themeDark '.$browserClass.'" style="position:relative"><div class="Viper-buttonGroup">';
            }

            $buttonHTML .= '<div id="'.$buttonNames[$i].'" class="Viper-button Viper-'.$buttonNames[$i].'">';
            $buttonHTML .= '<span class="Viper-buttonIcon Viper-'.$buttonNames[$i].'"></span>&nbsp;</div>';
        }

        $buttonHTML .= '</div></div>';

        $this->sikuli->execJS('calibrate("icons", '.json_encode($buttonHTML).')');

        // Create image for the inline toolbar pattern (the arrow on top).
        sleep(2);
        $this->selectKeyword(1);
        sleep(1);

        $vitp      = $this->sikuli->execJS('getVITP()');
        $vitp['x'] = $this->sikuli->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->sikuli->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->sikuli->createRegion(($vitp['x'] - 12), ($vitp['y'] - 10), 27, 14);
        $vitpImage = $this->sikuli->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrow.png');

        // Left arrow.
        $vitp = $this->sikuli->execJS('getVITP("left")');
        sleep(1);
        $vitp['x'] = $this->sikuli->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->sikuli->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->sikuli->createRegion(($vitp['x'] - 2), ($vitp['y'] - 10), 30, 14);
        $vitpImage = $this->sikuli->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrowLeft.png');

        // Right arrow.
        $vitp = $this->sikuli->execJS('getVITP("right")');
        sleep(1);
        $vitp['x'] = $this->sikuli->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->sikuli->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->sikuli->createRegion(($vitp['x'] + $vitp['width'] - 24), ($vitp['y'] - 10), 30, 14);
        $vitpImage = $this->sikuli->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrowRight.png');

        // Remove all Viper elements.
        $this->sikuli->execJS('viper.destroy()', TRUE);

        // Create image for the text field actions.
        $textFieldActionRevertRegion = $this->sikuli->getRegionOnPage($this->sikuli->execJS('ViperUtil.getBoundingRectangle(ViperUtil.getid("textboxActionRevert"))'));
        $textFieldActionRevertImage  = $this->sikuli->capture($textFieldActionRevertRegion);
        copy($textFieldActionRevertImage, $imgPath.'/textField_action_revert.png');

        $textFieldActionClearRegion = $this->sikuli->getRegionOnPage($this->sikuli->execJS('ViperUtil.getBoundingRectangle(ViperUtil.getid("textboxActionClear"))'));
        $textFieldActionClearImage  = $this->sikuli->capture($textFieldActionClearRegion);
        copy($textFieldActionClearImage, $imgPath.'/textField_action_clear.png');

        foreach ($statuses as $status => $className) {
            $btnRects = $this->sikuli->execJS('getCoords("'.$status.'", "'.$className.'")');
            sleep(1);
            foreach ($btnRects as $buttonName => $rect) {
                $this->_createButtonImageFromRectangle($buttonName, $rect);
            }
        }

        $this->sikuli->execJS('showAllBtns()');

        // Remove dupe icons.
        $dupeIcons = array(
                      'tableSettings',
                      'sourceNewWindow',
                     );
        foreach ($dupeIcons as $dupeIcon) {
            $btnIndex = array_search($dupeIcon, $buttonNames);
            if ($btnIndex !== false) {
                unset($buttonNames[$btnIndex]);
            }
        }

        unset($statuses['_active-selected']);

        for ($similarity = 0.92; $similarity < 0.97; $similarity += 0.01) {
            // Find each of the icons, if any fails it will throw an exception.
            $regions = array();
            foreach ($statuses as $status => $className) {
                foreach ($buttonNames as $buttonName) {
                    if ($status !== '') {
                        $buttonName .= $status;
                    }

                    $testImage = $imgPath.'/'.$buttonName.'.png';
                    try {
                        $region = $this->sikuli->find($testImage, null, $similarity);
                        $loc    = $this->sikuli->getX($region).'-'.$this->sikuli->getY($region);

                        if (isset($regions[$loc]) === true) {
                            throw new Exception('Image match conflict between '.$regions[$loc].' and '.$buttonName);
                        }

                        $regions[$loc] = $buttonName;

                        // Prevent screensaver turning on.
                        $this->sikuli->keyDown('Key.ESC');
                    } catch (Exception $e) {
                        continue(3);
                    }
                }
            }//end foreach

            break;
        }//end for

        $this->addData('buttonSimmilarity', number_format($similarity, 2, '.', ''));

    }//end _calibrateIcons()


    /**
     * Stores the specified data so that it can be accessed by unit test.
     *
     * Stored data is cached and placed in tmp/<browserId>/data.inc file.
     *
     * @param string $varName The name of the variable.
     * @param mixed  $value   The value.
     *
     * @return void
     */
    protected function addData($varName, $value)
    {
        $path = dirname(__FILE__).'/tmp/'.$this->sikuli->getBrowserid();
        if (file_exists($path) === false) {
            mkdir($path, 0755, true);
        }

        $path .= '/data.inc';

        $data = self::$_data;

        if ($data === null) {
            if (file_exists($path) === true) {
                include $path;
            }
        }

        $data[$varName] = $value;

        self::$_data = $data;
        file_put_contents($path, '<?php $data = '.var_export($data, true).'; ?>');

    }//end addData()


    /**
     * Returns the value of a stored variable.
     *
     * @param string $varName Name of the variable.
     *
     * @return mixed
     */
    protected function getData($varName)
    {
        $data = array();
        if (self::$_data === null) {
            $path = dirname(__FILE__).'/tmp/'.$this->sikuli->getBrowserid().'/data.inc';
            if (file_exists($path) === true) {
                include $path;
                self::$_data = $data;
            }
        }

        if (isset(self::$_data[$varName]) === true) {
            return self::$_data[$varName];
        }

        return null;

    }//end getData()


    /**
     * Returns list of available keywords that can be used in tests.
     *
     * @return array
     */
    private static function _getKeywordsList()
    {
        $keywords = array(
                     'XAX',
                     'XBX',
                     'XCX',
                     'XDX',
                     'XTX',
                     'XFX',
                     'XGX',
                     'XHX',
                     'XIX',
                     'XJX',
                     'XKX',
                     'XLX',
                     'XMX',
                    );
        return $keywords;

    }//end _getKeywordsList()


    /**
     * Returns the keyword string for the specifed keyword index.
     *
     * @param integer $index The index of the keyword.
     *
     * @return string
     */
    protected function getKeyword($index)
    {
        $keyword = $this->_getKeyword($index - 1);
        return $keyword;

    }//end getKeyword()


    /**
     * Returns the keyword string for the specifed keyword index.
     *
     * @param integer $index The index of the keyword.
     *
     * @return string
     */
    private function _getKeyword($index)
    {
        $keywords = self::_getKeywordsList();
        $keyword  = $keywords[$index];

        return $keyword;

    }//end _getKeyword()


    /**
     * Returns the image path of the specified keyword.
     *
     * @param integer $index The index of the keyword.
     *
     * @return string
     */
    private function _getKeywordImage($index)
    {
        $imgPath  = $this->getBrowserImagePath();
        $imgPath .= '/text-'.$index.'.png';

        return $imgPath;

    }//end _getKeywordImage()


    /**
     * Replaces the keywords in given content.
     *
     * @param string $content The content to search.
     *
     * @return string
     */
    protected function replaceKeywords($content)
    {
        return self::_replaceKeywords($content);

    }//end replaceKeywords()


    /**
     * Replaces the keywords in given content.
     *
     * @param string $content The content to search.
     *
     * @return string
     */
    private static function _replaceKeywords($content)
    {
        $keywords = self::_getKeywordsList();
        foreach ($keywords as $index => $keyword) {
            $content = str_replace('%'.($index + 1).'%', $keyword, $content);
        }

        // Replace URL keyword.
        $url = getenv('VIPER_TEST_URL');
        if (empty($url) === true) {
            $url = dirname(__FILE__);
        }

        $content = str_replace('%url%', $url, $content);

        return $content;

    }//end _replaceKeywords()


    /**
     * Returns the base URL.
     *
     * @return string
     */
    private function _getBaseUrl()
    {
        $url = getenv('VIPER_TEST_URL');
        if (empty($url) === true) {
            $url = dirname(__FILE__);
        }

        return $url;

    }//end _getBaseUrl()


    /**
     * Returns the URL for the test page.
     *
     * @param string $path The additional path.
     *
     * @return string
     */
    protected function getTestURL($path='')
    {
        return $this->_getBaseUrl().$path.'?v='.self::$_viperVersion;

    }//end getTestURL()


    /**
     * Sets the content of the test page to the specified test case.
     *
     * @param string  $id           The ID of the test case.
     * @param integer $clickKeyword Keyword to click after the content is set. Set to null for no click.
     *
     * @return void
     */
    protected function useTest($id, $clickKeyword=1)
    {
        $this->sikuli->execJS('useTest("test-'.$id.'")', FALSE);
        sleep(1);

        if ($clickKeyword !== null) {
            $this->clickKeyword($clickKeyword);
        }

    }//end useTest()


    /**
     * Assert that given HTML string matches the test page's HTML.
     *
     * @param string  $html               The HTML string to compare.
     * @param string  $msg                The error message to print.
     * @param boolean $removeTableHeaders If TRUE then table headers will be removed
     *                                    before matching HTML.
     *
     * @return void
     */
    protected function assertHTMLMatch($html, $msg=null, $removeTableHeaders=false)
    {
        $html     = $this->_normaliseHTML($this->replaceKeywords($html));
        $pageHtml = $this->_normaliseHTML($this->getHtml(null, 0, $removeTableHeaders, true));

        $this->assertEquals($html, $pageHtml, $msg);

    }//end assertHTMLMatch()


    /**
     * Assert that given HTML string matches the tests page's HTML.
     *
     * @param string $html The HTML string to compare.
     * @param string $msg  The error message to print.
     *
     */
    protected function assertRawHTMLMatch($html, $msg=null)
    {
        $html     = $this->_normaliseHTML($this->replaceKeywords($html));
        $pageHTML = $this->_normaliseHTML($this->getRawHtml());

        $this->assertEquals($html, $pageHTML, $msg);

    }//end assertRawHTMLMatch()


    private function _normaliseHTML($html)
    {
        $html = preg_replace("/<([a-z0-9]+)\n([a-z0-9]*)/i", '<$1$2', $html);
        $html = str_replace("<\n", '<', $html);
        $html = str_replace("\n", ' ', $html);
        $html = str_replace('\n', ' ', $html);

        // Chrome requires &nbsp; inside block elements unlike Firefox, remove all
        // single &nbsp; from tags and just before a start tag.
        $html     = str_replace('>&nbsp;<', '><', $html);
        $html     = str_replace('&nbsp;<', '<', $html);
        $html     = str_replace('&nbsp;<', '<', $html);
        $html     = str_replace('>&nbsp;', '> ', $html);
        $html     = str_replace('> <', '><', $html);
        $html     = str_replace(' <', '<', $html);

        // Remove the Viper version from the end of URLs.
        $html = preg_replace('#\?v=[\d\w]+"#', '"', $html);

        $html = $this->_orderTagAttributes($html);

        return $html;

    }//end _normaliseHTML()


    /**
     * Checks that the expected html matches the actual html after removing the header tags from the tables.
     *
     * @param string $html The expected HTML.
     * @param string $msg  The error message to print.
     *
     * @return void
     */
    protected function assertHTMLMatchNoHeaders($html, $msg=null)
    {
        $this->assertHTMLMatch($html, $msg, true);

    }//end assertHTMLMatchNoHeaders()


    /**
     * Asserts that expected value is equal to the actual value.
     *
     * @param mixed   $expected     Expected value.
     * @param mixed   $actual       Actual value.
     * @param string  $message      Error Message.
     * @param float   $delta        Delta.
     * @param integer $maxDepth     Max array depth.
     * @param boolean $canonicalize Canonicalize.
     * @param boolean $ignoreCase   Ignore case.
     *
     * @return mixed
     */
    public static function assertEquals($expected, $actual, $message='', $delta=0, $maxDepth=10, $canonicalize=false, $ignoreCase=false)
    {
        $expected = self::_replaceKeywords($expected);

        return parent::assertEquals($expected, $actual, $message, $delta, $maxDepth, $canonicalize, $ignoreCase);

    }//end assertEquals()


    /**
     * Assert that given HTML string matches the test page's HTML.
     *
     * @param string  $html             The HTML string to compare.
     * @param integer $pos              If specified then, the specified HTML must
     *                                  start from that pos.
     * @param string  $msg              The message for the assertion.
     * @param boolean $ignoreExtraSpace If TRUE then extra spaces will be removed
     *                                  from the content.
     *
     * @return void
     */
    protected function assertHasHTML($html, $pos=null, $msg=null, $ignoreExtraSpace=false)
    {
        $pageHtml = str_replace('\n', '', $this->getHtml());
        $html     = str_replace("\n", '', $html);

        if ($ignoreExtraSpace === true) {
            $pageHtml = preg_replace('/\s\s+/', ' ', $pageHtml);
        }

        if ($msg === null) {
            $msg = 'Specified HTML not found in page content';
        }

        if ($pos === null) {
            if (strpos($pageHtml, $html) === false) {
                $this->fail($msg);
            }
        } else if (strpos($pageHtml, $html) !== $pos) {
            $this->fail($msg);
        }

    }//end assertHasHTML()


    /**
     * Asserts that given list and the list on test page have the same structure.
     *
     * @param array   $expected   The expected array structure.
     * @param boolean $incContent If TRUE then each list item content is also compared.
     *
     * @return void
     */
    protected function assertListEqual(array $expected, $incContent=false)
    {
        $actual = $this->sikuli->execJS('gListS(null, '.((int) $incContent).')');
        $this->assertEquals($expected, $actual);

    }//end assertListEqual()


    /**
     * Rebuilds a HTML string with tag attributes in alphabetical order.
     *
     * @param string $html The HTML string to rebuild.
     *
     * @return string
     */
    private function _orderTagAttributes($html)
    {
        $attrRegex = '(?:(?:\s+[\w-]+(?:\s*=\s*(?:"(?:[^"]+)?"))?)+)?(?:(?:\s+[\w-]+(?:\s*=\s*(?:"(?:[^"]+)?"))?)+)?\s*\/?';
        $matches   = preg_split(
            '/(<\w+'.$attrRegex.'>)/i',
            $html,
            -1,
            (PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)
        );

        $newHtml = '';
        foreach ($matches as $match) {
            if ($match[0] === '<' && $match[1] !== '/') {
                // This is an open tag.
                $tagMatches = array();
                $tagRegex   = '/(<\w+)'.$attrRegex.'>/i';
                preg_match($tagRegex, $match, $tagMatches);
                if ($tagMatches[1].'>' !== $match) {
                    // This tag has attributes, which need to be ordered
                    // alphabetically as the browser changes the order sometimes.
                    $attrs = array();
                    preg_match_all('/\s+([\w-]+)\s*=\s*(?:"([^"]+)?")/i', $match, $attrs);
                    asort($attrs[1]);
                    $match = $tagMatches[1];
                    foreach ($attrs[1] as $attrIndex => $attrName) {
                        if ($attrName === 'style') {
                            $attrVal = $attrs[2][$attrIndex];
                            // Values in a style attribute need to be ordered
                            // alphabetically as the browser changes the order sometimes.
                            $vals = array();
                            preg_match_all('/([\w-]+)\s*:\s*[^:;]+;?/i', $attrVal, $vals);
                            asort($vals[1]);
                            $match .= ' '.$attrs[1][$attrIndex].'="';
                            foreach ($vals[1] as $valIndex => $value) {
                                if (strpos($vals[0][$valIndex], ';') === false) {
                                    $vals[0][$valIndex] .= ';';
                                }

                                // Remove the space between colon and style value.
                                $vals[0][$valIndex] = str_replace(': ', ':', $vals[0][$valIndex]);
                                $match .= $vals[0][$valIndex].' ';
                            }

                            $match  = rtrim($match);
                            $match .= '"';
                        } else if ($attrName === 'href') {
                            // Remove trailing slash at the end of URLs.
                            $match .= ' '.$attrs[1][$attrIndex].'="'.rtrim($attrs[2][$attrIndex], '/').'"';
                        } else {
                            $match .= $attrs[0][$attrIndex];
                        }//end if
                    }//end foreach

                    if (substr($tagMatches[0], -2) === '/>') {
                        $match .= ' />';
                    } else {
                        $match .= '>';
                    }
                }//end if
            }//end if

            $newHtml .= $match;
        }//end foreach

        return $newHtml;

    }//end _orderTagAttributes()


    /**
     * Returns the match object variable of the inline toolbar.
     *
     * @return string
     * @throws Exception If the toolbar cannot be found.
     */
    protected function getInlineToolbar()
    {
        $match = null;
        try {
            $match = $this->sikuli->find($this->getBrowserImagePath().'/vitp_arrow.png', null, 0.85);
            if ($this->sikuli->getX($match) === 0) {
                $match = null;
            }
        } catch (Exception $e) {
            $match = null;
        }

        if ($match === null) {
            // Get it using JS.
            $elemRect = $this->sikuli->execJS('gVITPArrow()');
            if ($elemRect === null) {
                $this->fail('Inline Toolbar is not visible');
            }

            $match = $this->sikuli->getRegionOnPage($elemRect);
            if ($match === null) {
                $this->fail('Inline Toolbar is not visible');
            }
        }

        $x = ($this->sikuli->getX($match) - 200);
        if ($x < 0) {
            $x = 10;
        }

        $this->sikuli->setX($match, $x);
        $this->sikuli->setW($match, ($this->sikuli->getW($match) + 400));
        $this->sikuli->setH($match, ($this->sikuli->getH($match) + 200));
        $this->sikuli->setAutoWaitTimeout(0.3, $match);

        return $match;

    }//end getInlineToolbar()


    /**
     * Returns the match object variable of the inline toolbar.
     *
     * @return string
     */
    protected function getTopToolbar()
    {
        if (self::$_topToolbar !== null) {
            return self::$_topToolbar;
        }

        $region = $this->sikuli->createRegion(
            $this->sikuli->getPageXRelativeToScreen(0),
            $this->sikuli->getPageYRelativeToScreen(0),
            $this->sikuli->getW($this->sikuli->getBrowserWindow()),
            150
        );

        self::$_topToolbar = $region;
        $this->sikuli->addCacheVar($region);

        $this->sikuli->setAutoWaitTimeout(0.5, $region);

        return $region;

    }//end getTopToolbar()


    /**
     * Returns the region of the active bubble.
     *
     * @return string
     * @throws Exception If there are no active bubbles.
     */
    protected function getActiveBubble()
    {
        $rect = $this->sikuli->execJS('gActBubble()');

        if (is_array($rect) === true) {
            $region = $this->sikuli->getRegionOnPage($rect);
            return $region;
        }

        throw new Exception('There is no active bubble');

    }//end getActiveBubble()


    /**
     * Returns TRUE if the specified button icon exists in the Inline Toolbar.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     *
     * @return boolean
     */
    protected function inlineToolbarButtonExists($buttonIcon, $state=null, $isText=false)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);

        if ($isText === true) {
            // Its harder for Sikuli to match a text button so use lower similarity.
            try {
                $this->sikuli->find($button, $this->getInlineToolbar(), 0.7);
            } catch (Exception $e) {
                // Try to find it again without the image.
                try {
                    $rect = $this->_getTextButtonRectangle($buttonIcon, $state, 'inlineToolbar');
                    $this->sikuli->getRegionOnPage($rect);
                } catch (Exception $e) {
                    return false;
                }
            }
        } else {
            $toolbar = $this->getInlineToolbar();
            try {
                $this->sikuli->find($button, $toolbar, $this->getData('buttonSimmilarity'));
            } catch (Exception $e) {
                return false;
            }
        }//end if

        return true;

    }//end inlineToolbarButtonExists()


    /**
     * Returns TRUE if the specified button icon exists in the Toolbar.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     *
     * @return boolean
     */
    protected function topToolbarButtonExists($buttonIcon, $state=null, $isText=false)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);

        if ($isText === true) {
            // Its harder for Sikuli to match a text button so use lower similarity.
            try {
                $this->sikuli->find($button, $this->getTopToolbar(), 0.7);
            } catch (Exception $e) {
                // Try to find it again without the image.
                try {
                    $rect = $this->_getTextButtonRectangle($buttonIcon, $state, 'topToolbar');
                    $this->sikuli->getRegionOnPage($rect);
                } catch (Exception $e) {
                    return false;
                }
            }
        } else {
            $toolbar = $this->getTopToolbar();
            try {
                $this->sikuli->find($button, $toolbar, $this->getData('buttonSimmilarity'));
            } catch (Exception $e) {
                try {
                    $this->sikuli->find($button, $toolbar, 0.92);
                } catch (Exception $e) {
                    return false;
                }
            }
        }//end if

        return true;

    }//end topToolbarButtonExists()


    /**
     * Clicks the specified button icon in the Inline Toolbar.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param boolean $forceJSPos If isText option is set to TRUE and this is set to TRUE then
     *                            image will not be used.
     *
     * @return void
     * @throws Exception If the specified icon file not found.
     */
    protected function clickTopToolbarButton($buttonIcon, $state=null, $isText=false, $forceJSPos=false)
    {
        $this->_clickButton($buttonIcon, $state, $isText, 'topToolbar', $forceJSPos);

    }//end clickTopToolbarButton()


    /**
     * Clicks the specified button icon in the Inline Toolbar.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param boolean $forceJSPos If isText option is set to TRUE and this is set to TRUE then
     *                            image will not be used.
     *
     * @return void
     * @throws Exception If the specified icon file not found.
     */
    protected function clickInlineToolbarButton($buttonIcon, $state=null, $isText=false, $forceJSPos=false)
    {
        $this->_clickButton($buttonIcon, $state, $isText, 'inlineToolbar', $forceJSPos);

    }//end clickInlineToolbarButton()


    /**
     * Returns TRUE if the specified button exists on the page.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $region     The region to look in to.
     *
     * @return boolean
     */
    protected function buttonExists($buttonIcon, $state=null, $isText=false, $region=null)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);
        return $this->sikuli->exists($button, $region);

    }//end buttonExists()


    /**
     * Clicks the specified button on the page.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $location   The location of the button (topToolbar, inlineToolbar, or a region).
     * @param boolean $forceJSPos If isText option is set to TRUE and this is set to TRUE then
     *                            image will not be used.
     *
     * @return void
     */
    private function _clickButton(
        $buttonIcon,
        $state=null,
        $isText=false,
        $location=null,
        $forceJSPos=false
    ) {
        $buttonObj = $this->_getButton($buttonIcon, $state, $isText, $location);

        $region = null;
        if ($location === 'topToolbar') {
            $region = $this->getTopToolbar();
        } else if ($location === 'inlineToolbar') {
            $region = $this->getInlineToolbar();
        } else {
            $region = $location;
        }

        try {
            $match = null;
            if ($isText === true) {
                if ($forceJSPos === true) {
                    $rect  = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                    $match = $this->sikuli->getRegionOnPage($rect);
                } else {
                    // Its harder for Sikuli to match a text button so use lower similarity.
                    try {
                        $match = $this->sikuli->find($buttonObj, $region, 0.7);
                    } catch (Exception $e) {
                        // Try to find it again without the image.
                        $rect  = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                        $match = $this->sikuli->getRegionOnPage($rect);
                    }
                }
            } else {
                $match = $this->sikuli->find($buttonObj, $region, $this->getData('buttonSimmilarity'));
            }
        } catch (FindFailedException $e) {
            $this->fail($e->getMessage());
        }//end try

        $this->sikuli->click($match);

        // Move the mouse pointer away from the button so that its tooltip does not
        // cause issues.
        $this->sikuli->mouseMove($this->sikuli->createLocation(($this->sikuli->getX($match) - 5), ($this->sikuli->getY($match) - 5)));

    }//end _clickButton()


    /**
     * Clicks the specified button on the page.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $region     The region to look in to.
     *
     * @return string
     */
    protected function clickButton($buttonIcon, $state=null, $isText=false, $region=null)
    {
        return $this->_clickButton($buttonIcon, $state, $isText, $region);

    }//end clickButton()


    /**
     * Returns the found button object.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $location   The location of the button (topToolbar, inlineToolbar, etc.).
     *
     * @return object
     */
    protected function findButton($buttonIcon, $state=null, $isText=false, $location=null)
    {
        return $this->sikuli->find($this->_getButton($buttonIcon, $state, $isText, $location), null, $this->getData('buttonSimmilarity'));

    }//end findButton()


    /**
     * Returns the button object.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $location   The location of the button (topToolbar, inlineToolbar, etc.).
     *
     * @return string
     * @throws Exception If the button image cannot be found.
     */
    private function _getButton($buttonIcon, $state=null, $isText=false, $location=null)
    {
        if ($isText === true) {
            $buttonIconId = preg_replace('#\W#', '_', $buttonIcon);
            try {
                $buttonIcon = $this->getButtonIconPath($buttonIconId, $state);
            } catch (Exception $e) {
                $rect       = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                $buttonIcon = $this->_createButtonImageFromRectangle($buttonIcon, $rect, $state);
            }//end try
        } else if (is_file($buttonIcon) === false) {
            $buttonIcon = $this->getButtonIconPath($buttonIcon, $state);
        }//end if

        if (file_exists($buttonIcon) === false) {
            throw new Exception('File not found: '.$buttonIcon);
        }

        return $buttonIcon;

    }//end _getButton()


    /**
     * Returns the ractangle for the specified text button.
     *
     * @param string $button   The name of the button.
     * @param string $state    The name of the button state (active, selected).
     * @param string $location The location of the button (topToolbar, inlineToolbar, etc.).
     *
     * @return string
     * @throws Exception If the button image cannot be found.
     */
    private function _getTextButtonRectangle($button, $state=null, $location=null)
    {
        $jsFn = 'gBtn';

        if ($location === 'topToolbar') {
            $jsFn = 'gTPBtn';
        } else if ($location === 'inlineToolbar') {
            $jsFn = 'gITPBtn';
        }

        $rect = null;
        if ($state !== null) {
            $rect = $this->sikuli->execJS($jsFn.'("'.$button.'", "'.$state.'")');
        } else {
            $rect = $this->sikuli->execJS($jsFn.'("'.$button.'")');
        }

        if (is_array($rect) === false) {
            throw new Exception('Could not find button with text: '.$button);
        }

        return $rect;

    }//end _getTextButtonRectangle()


    /**
     * Creates the Viper button image for testing using a given page location.
     *
     * @param string $button The name of the button.
     * @param array  $rect   The x1, x2, y1, y2 points of the button on the page.
     * @param string $state  The state of the button.
     *
     * @return string
     */
    private function _createButtonImageFromRectangle($button, array $rect, $state=null)
    {
        return $this->createImageFromRectangle($button, $rect, $state);

    }//end _createButtonImageFromRectangle()


    /**
     * Creats image for the current browser for the given region on the page.
     *
     * This new image can then be used in find operations.
     *
     * @param string $imageName The name of the image.
     * @param array  $rect      The x1, x2, y1, y2 points of the button on the page.
     * @param string $postFix   The string to append to the end of the file name.
     *
     * @return string
     */
    protected function createImageFromRectangle($imageName, array $rect, $postFix=null)
    {
        $imageName = preg_replace('#[^a-zA-Z0-9_-]#', '_', $imageName);
        $image     = $this->sikuli->capture($this->sikuli->getRegionOnPage($rect));
        $filePath  = $this->getBrowserImagePath().'/'.$imageName;

        if ($postFix !== null) {
            $filePath .= '_'.$postFix;
        }

        $filePath .= '.png';
        copy($image, $filePath);

        return $filePath;

    }//end createImageFromRectangle()


    /**
     * Finds the specified image on the screen.
     *
     * Selector must be given so that the first time the image is found using the
     * selector and the next time using the Sikuli image matching.
     *
     * @param string  $imageName   Name of the image.
     * @param string  $selector    The jQuery selector to use for finding the element.
     * @param integer $index       The element index of the resulting array.
     * @param boolean $forceUpdate Ignores the cached image.
     *
     * @return string
     */
    protected function findImage($imageName, $selector, $index=0, $forceUpdate=false)
    {
        $filePath = $this->getBrowserImagePath().'/'.$imageName.'.png';

        if ($forceUpdate !== true && file_exists($filePath) === true) {
            return $this->sikuli->find($filePath);
        } else {
            $elemRect = $this->getBoundingRectangle($selector, $index);
            $this->createImageFromRectangle($imageName, $elemRect);
            return $this->findImage($imageName, $selector, $index);
        }

    }//end findImage()


    /**
     * Clicks the lineage item in the Inline Toolbar.
     *
     * @param integer $index The index of the lineage item.
     *
     * @return void
     */
    protected function selectInlineToolbarLineageItem($index)
    {
        $rect = $this->getBoundingRectangle('.ViperITP-lineageItem', $index);
        if (is_array($rect) === false) {
            $this->fail('Inline Toolbar lineage item ('.$index.') not found!');
        }

        $region = $this->sikuli->getRegionOnPage($rect);
        $this->sikuli->click($region);
        usleep(80000);

    }//end selectInlineToolbarLineageItem()


    /**
     * Selects the specified word.
     *
     * If the $endWord is also specified then everything in between $startWord and
     * $endWord will be selected.
     *
     * @param string $startWord The word to select.
     * @param string $endWord   The word where the selection will end.
     *
     * @return void
     */
    protected function selectText($startWord, $endWord=null)
    {
        if (empty($endWord) === true) {
            $ipsum = $this->sikuli->find($startWord, $this->getBrowserWindow());
            $this->sikuli->doubleClick($ipsum);
            return;
        }

        $start = $this->sikuli->find($startWord, $this->getBrowserWindow());
        $end   = $this->sikuli->find($endWord, $this->getBrowserWindow());

        $this->sikuli->click($start);

        $startLeft = $this->sikuli->getTopLeft($start);
        $endRight  = $this->sikuli->getBottomRight($end);

        $this->sikuli->setLocation(
            $startLeft,
            ($this->sikuli->getX($startLeft) + 2),
            $this->sikuli->getY($startLeft)
        );

        $this->sikuli->setLocation(
            $endRight,
            ($this->sikuli->getX($endRight) + 2),
            $this->sikuli->getY($endRight)
        );

        $this->sikuli->dragDrop($startLeft, $endRight);

    }//end selectText()


    /**
     * Clicks the specified keyword.
     *
     * @param integer $keyword The keyword to select.
     *
     * @return void
     */
    protected function clickKeyword($keyword)
    {
        $this->sikuli->click($this->findKeyword($keyword));

    }//end clickKeyword()


    /**
     * Selects the specified keyword.
     *
     * If the $endKeyword is also specified then everything in between $startKeyword
     *  and $endKeyword will be selected.
     *
     * @param integer $startKeyword The keyword to select.
     * @param integer $endKeyword   The keyword where the selection will end.
     *
     * @return void
     * @throws Exception If the keyword is not found.
     */
    protected function selectKeyword($startKeyword, $endKeyword=null)
    {
        $startKeywordImage = $this->_getKeywordImage($startKeyword);

        if ($endKeyword === null) {
            $endKeyword = $startKeyword;
        }

        $start = $this->findKeyword($startKeyword);
        $end   = $start;
        if ($startKeyword !== $endKeyword) {
            $end = $this->findKeyword($endKeyword);
        }

        $this->sikuli->click($start);

        if ($this->sikuli->getBrowserid() === 'safari') {
            sleep(1);
        }

        $startLeft = $this->sikuli->getTopLeft($start);
        $endRight  = $this->sikuli->getTopRight($end);

        $this->sikuli->setLocation(
            $startLeft,
            ($this->sikuli->getX($startLeft) + 2),
            ($this->sikuli->getY($startLeft) + 2)
        );

        $this->sikuli->setLocation(
            $endRight,
            ($this->sikuli->getX($endRight) + 1),
            ($this->sikuli->getY($endRight) + 2)
        );

        if (strpos($this->sikuli->getBrowserid(), 'ie') === 0 || $this->sikuli->getBrowserid() === 'edge') {
            $this->sikuli->dragDrop($endRight, $startLeft);
            usleep(200000);
        } else {
            $this->sikuli->dragDrop($startLeft, $endRight);
            usleep(50000);
        }//end if

    }//end selectKeyword()


    /**
     * Moves the caret to the right or left of the specified keyword.
     *
     * @param integer $keyword  The keyword to move to.
     * @param string  $position To the right or left.
     *
     * @return void
     */
    protected function moveToKeyword($keyword, $position='right')
    {
        $this->selectKeyword($keyword);

        if ($position === 'right' && ($this->sikuli->getBrowserid() === 'ie8' || $this->sikuli->getBrowserid() === 'ie9')) {
            $this->sikuli->keyDown('Key.LEFT');
            $this->sikuli->keyDown('Key.RIGHT');
            $this->sikuli->keyDown('Key.RIGHT');
            $this->sikuli->keyDown('Key.RIGHT');
        } else if ($position === 'right') {
            $this->sikuli->keyDown('Key.RIGHT');
        } else if ($position === 'left') {
            $this->sikuli->keyDown('Key.LEFT');
        } else if ($position === 'middle') {
            $this->sikuli->keyDown('Key.LEFT');
            $this->sikuli->keyDown('Key.RIGHT');
        }

    }//end moveToKeyword()


    /**
     * Returns the region for the specified keyword.
     *
     * @param integer $keyword The keyword to find.
     *
     * @return object
     */
    protected function findKeyword($keyword)
    {
        $loc = null;
        try {
            $loc = $this->sikuli->find($this->_getKeywordImage($keyword), null, $this->getData('textSimmilarity'));
        } catch (FindFailedException $e) {
            // Try searching for it using JS.
            $loc = $this->getStringLocation($this->getKeyword($keyword));
            if (is_array($loc) === false) {
                throw new FindFailedException('Failed to find keyword: '.$this->getKeyword($keyword));
            }

            // Need to hide toolbars incase the keyword is under the toolbar.
            $this->sikuli->execJS('hideToolbarsAtLocation('.json_encode($loc).')');
            $loc = $this->sikuli->getRegionOnPage($loc);
        }

        return $loc;

    }//end findKeyword()


    /**
     * Returns the location of the given string.
     *
     * @param string $string String to search for.
     *
     * @return mixed
     */
    protected function getStringLocation($string)
    {
        $loc = $this->sikuli->execJS('gStringLoc("'.$string.'")');
        return $loc;

    }//end getStringLocation()


    /**
     * Returns TRUE of the specified field exists.
     *
     * @param string $label The label of the field.
     *
     * @return boolean
     */
    protected function fieldExists($label)
    {
        try {
            $this->sikuli->find($this->_getLabel($label), null, 0.7);
        } catch (FindFailedException $e) {
            return false;
        }

        return true;

    }//end fieldExists()


    /**
     * Clicks the field with specified label.
     *
     * @param string $label The label of the field.
     *
     * @return void
     */
    protected function clickField($label, $required=FALSE)
    {
        $this->sikuli->click($this->sikuli->find($this->_getLabel($label, false, $required), null, 0.7));

    }//end clickField()


    /**
     * Clicks the clear field value action for specified field.
     *
     * @param string $label The label of the field.
     *
     * @return void
     */
    protected function clearFieldValue($label)
    {
        try {
            $fieldLabel = $this->sikuli->find($this->_getLabel($label), null, 0.7);
        } catch (FindFailedException $e) {
            $fieldLabel = $this->sikuli->find($this->_getLabel($label, true), null, 0.7);
        }

        $fieldRegion  = $this->sikuli->extendRight($fieldLabel, 400);
        $actionImage  = $this->getBrowserImagePath().'/textField_action_clear.png';
        $actionButton = $this->sikuli->find($actionImage, $fieldRegion, 0.6);

        $this->sikuli->click($actionButton);

    }//end clearFieldValue()


    /**
     * Clicks the revert field value action for specified field.
     *
     * @param string $label The label of the field.
     *
     * @return void
     */
    protected function revertFieldValue($label)
    {
        try {
            $fieldLabel = $this->sikuli->find($this->_getLabel($label), null, 0.7);
        } catch (FindFailedException $e) {
            $fieldLabel = $this->sikuli->find($this->_getLabel($label, true), null, 0.7);
        }

        $topLeft     = $this->sikuli->getTopLeft($fieldLabel);
        $fieldRegion = $this->sikuli->createRegion(
            $this->sikuli->getX($topLeft),
            ($this->sikuli->getY($topLeft) - 5),
            400,
            30
        );

        $actionImage  = $this->getBrowserImagePath().'/textField_action_revert.png';
        $actionButton = $this->sikuli->find($actionImage, $fieldRegion, 0.4);

        $this->sikuli->click($actionButton);

    }//end revertFieldValue()


    /**
     * Returns the value of the specified field.
     *
     * If field not found it will return FALSE.
     *
     * @param string $label The label of the field.
     *
     * @return mixed
     */
    protected function getFieldValue($label)
    {
        $value = $this->sikuli->execJS('gFieldValue("'.$label.'")');
        return $value;

    }//end getFieldValue()


    /**
     * Returns the label image for the specified label element.
     *
     * @param string  $label    The label of a field.
     * @param boolean $force    Force update the label screenshot.
     * @param boolean $required If true then required label image is used.
     *
     * @return string
     */
    private function _getLabel($label, $force=false, $required=false)
    {
        $labelImg  = preg_replace('#\W#', '_', $label);

        if ($required === true) {
            $labelImg .= '_required';
        }

        $imagePath = $this->getBrowserImagePath().'/label_'.$labelImg.'.png';

        if (file_exists($imagePath) === false || $force === true) {
            $rect    = $this->sikuli->execJS('gField("'.$label.'")');
            $region  = $this->sikuli->getRegionOnPage($rect);
            $tmpPath = $this->sikuli->capture($region);
            copy($tmpPath, $imagePath);
        }

        return $imagePath;

    }//end _getLabel()


    /**
     * Type the text at the current focused input field or at a click point specified by PSMRL.
     *
     * @param string $text      The text to type.
     * @param string $modifiers Key modifiers.
     * @param string $psmrl     PSMRL variable.
     *
     * @return integer
     */
    protected function type($text, $modifiers=null, $psmrl=null)
    {
        $text   = $this->replaceKeywords($text);
        $result = $this->sikuli->type($text, $modifiers, $psmrl);

        return $result;

    }//end type()


    /**
     * Returns the raw HTML of the test page.
     *
     * @param string  $selector The jQuery selector to use for finding the element.
     * @param integer $index    The element index of the resulting array.
     *
     * @return string
     */
    protected function getRawHtml($selector=null, $index=0)
    {
        if ($selector === null) {
            $text = $this->sikuli->execJS('getRawHTML()');
        } else {
            $text = $this->sikuli->execJS('getRawHTML("'.$selector.'", '.$index.')');
        }

        $text = str_replace("\n", '', $text);
        $text = str_replace('\n', '', $text);
        
        // IE never has the px for width/height...
        $text = preg_replace('#="(\d+)"#', '="$1px"', $text);

        // Google Chrome always adds an extra space at the end of a style attribute
        // remove it here...
        $text = preg_replace('#style="(.+)\s"#', 'style="$1"', $text);

        return $text;

    }//end getRawHtml()


    /**
     * Returns the HTML of the test page.
     *
     * @param string  $selector           The jQuery selector to use for finding the element.
     * @param integer $index              The element index of the resulting array.
     * @param boolean $removeTableHeaders If TRUE then table headers will be removed.
     * @param boolean $noModify           If TRUE the HTML will not be modified.
     *
     * @return string
     */
    protected function getHtml($selector=null, $index=0, $removeTableHeaders=false, $noModify=false)
    {
        $removeTableHeaders = (int) $removeTableHeaders;

        if ($selector === null) {
            $text = $this->sikuli->execJS('gHtml(null, null, '.$removeTableHeaders.')');
        } else {
            $text = $this->sikuli->execJS('gHtml("'.$selector.'", '.$index.', '.$removeTableHeaders.')');
        }

        if ($noModify !== true) {
            $text = str_replace("\n", '', $text);
            $text = str_replace('\n', '', $text);
        }

        // Google Chrome always adds an extra space at the end of a style attribute
        // remove it here...
        $text = preg_replace('#style="(.+)\s"#', 'style="$1"', $text);

        return $text;

    }//end getHtml()


    /**
     * Returns the text that is selected.
     *
     * @param boolean $clean If TRUE then the content is cleaned up, e.g. new lines and extra spaces removed.
     *
     * @return string
     */
    protected function getSelectedText($clean=true)
    {
        $text = $this->sikuli->execJS('gText()');

        if ($clean !== true) {
            return $text;
        }

        $text = preg_replace('/\s*\\\n\s+/', '', $text);
        return $text;

    }//end getSelectedText()


    /**
     * Returns the rectangle for a DOM element found using the specified selector.
     *
     * @param string  $selector The jQuery selector to use for finding the element.
     * @param integer $index    The element index of the resulting array.
     *
     * @return array
     */
    protected function getBoundingRectangle($selector, $index=0)
    {
        return $this->sikuli->getBoundingRectangle($selector, $index);

    }//end getBoundingRectangle()


    /**
     * Clicks an element in the content.
     *
     * @param string  $selector   The jQuery selector to use for finding the element.
     * @param integer $index      The element index of the resulting array.
     * @param boolean $rightClick If TRUE then right mouse button is used.
     *
     * @return void
     */
    protected function clickElement($selector, $index=0, $rightClick=false)
    {
        return $this->sikuli->clickElement($selector, $index, $rightClick);

    }//end clickElement()


    /**
     * Sets the settings for specified plugin.
     *
     * @param string $pluginName The name of the plugin.
     * @param array  $settings   List of settings for the plugin.
     *
     * @return void
     */
    protected function setPluginSettings($pluginName, array $settings)
    {
        $settings = json_encode($settings);
        $this->sikuli->execJS('viper.getPluginManager().setPluginSettings(\''.$pluginName.'\', '.$settings.')', TRUE);

    }//end setPluginSettings()


    /**
     * Open file using specified application.
     *
     * If the application is not available then this method will return FALSE.
     * If the application that is being opened is the current browser then a new tab
     * will be opened instead.
     *
     * @param string $filePath The file to open.
     * @param string $appName  The name of the application to use to open the file.
     *
     * @return boolean
     */
    protected function openFile($filePath, $appName)
    {
        if ($appName === $this->sikuli->getBrowserName()) {
            // Open a new tab in this browser. Popup blocker must be disabled.
            $this->sikuli->execJS('window.open("'.$filePath.'", "_blank")', TRUE);
            return true;
        }

        if (array_key_exists($appName, self::$_apps) === true) {
            if (self::$_apps[$appName] === true) {
                system('open '.escapeshellarg($filePath));
                return true;
            } else {
                return false;
            }
        } else {
            $retval = null;
            if ($this->sikuli->getOS() === 'windows') {
                system('open '.escapeshellarg($filePath), $retval);
            } else {
                system('open -a'.escapeshellarg($appName).' '.escapeshellarg($filePath), $retval);
            }

            if ($retval === 1) {
                self::$_apps[$appName] = false;
                return false;
            } else {
                self::$_apps[$appName] = true;
                return true;
            }
        }//end if

    }//end openFile()


    /**
     * Close the specified app.
     *
     * Note if the current browser is being closed then it will close its tab instead
     * of the whole application.
     *
     * @param string $appName The name of the application to close.
     *
     * @return void
     */
    protected function closeApp($appName)
    {
        $this->sikuli->switchApp($appName);
        if ($this->sikuli->getOS() === 'windows') {
            $this->sikuli->keyDown('Key.ALT + F4');
        } else {
            if ($appName === $this->sikuli->getBrowserName()) {
                sleep(5);
                $this->sikuli->keyDown('Key.CMD + w');
            } else {
                $this->sikuli->keyDown('Key.CMD + q');
            }
        }

    }//end closeApp()


    /**
     * Removes the specified table's headers and ids.
     *
     * @param integer $tableIndex The table selector index.
     * @param boolean $removeid   If TRUE then the table and cell ids will be removed.
     *
     * @return void
     */
    protected function removeTableHeaders($tableIndex=null, $removeid=true)
    {
        if ($tableIndex === null) {
            $tableIndex = 'null';
        }

        $js = 'rmTableHeaders('.$tableIndex.',';

        if ($removeid === true) {
            $js .= ' true)';
        } else {
            $js .= ' false)';
        }

        $this->sikuli->execJS($js);

    }//end removeTableHeaders()


    /**
     * Paste clipboard content.
     *
     * Note that if right click is being used then make sure to move the mouse to the
     * target location before calling this method.
     *
     * @param boolean $rightClick If TRUE then contents will be pasted using the
     *                            browser's right click menu.
     *
     * @return void
     * @throws Exception If the browser is not supported.
     */
    protected function paste($rightClick=false)
    {
        if ($rightClick !== true) {
            $this->sikuli->keyDown('Key.CMD + v');
        } else {
            $this->sikuli->rightClick($this->sikuli->getMouseLocation());

            if ($this->sikuli->getBrowserid() === 'safari') {
                $this->sikuli->keyDown('Key.DOWN');
                $this->sikuli->keyDown('Key.ENTER');
            } else {
                $this->sikuli->keyDown('p');
                $this->sikuli->keyDown('Key.ENTER');
            }//end if

            sleep(1);

        }//end if

    }//end paste()


    /**
     * Pastes content from specified URL in to Viper.
     *
     * @param string $url The URL to get the content from.
     *
     * @return void
     */
    protected function pasteFromURL($url)
    {
        $this->sikuli->execJS('pasteFromURL("'.$url.'")', false, true);

    }//end pasteFromURL()


    /**
     * Cut content.
     *
     * Note that if right click is being used then make sure to move the mouse to the
     * target location before calling this method.
     *
     * @param boolean $rightClick If TRUE then contents will be cut using the
     *                            browser's right click menu.
     *
     * @return void
     * @throws Exception If the browser is not supported.
     */
    protected function cut($rightClick=false)
    {
        if ($rightClick !== true) {
            $this->sikuli->keyDown('Key.CMD + x');
        } else {
            $this->sikuli->rightClick($this->sikuli->getMouseLocation());

            switch ($this->sikuli->getBrowserid()) {
                case 'firefox':
                case 'ie11':
                case 'ie10':
                case 'ie9':
                case 'ie8':
                    // Use the shortcut to select the cut menu option.
                    $this->sikuli->keyDown('t');
                break;

                case 'chrome':
                case 'safari':
                    // Use the shortcut menu to select the menu option and then move the mouse up to cut.
                    $this->sikuli->keyDown('c');
                    sleep(2);
                    $this->sikuli->keyDown('Key.UP');
                    sleep(2);
                    $this->sikuli->keyDown('Key.ENTER');
                break;

                default:
                throw new Exception('Right click testing for this browser has not been implemented');
            }//end switch
        }//end if

    }//end cut()


    /**
     * Copy content.
     *
     * Note that if right click is being used then make sure to move the mouse to the
     * target location before calling this method.
     *
     * @param boolean $rightClick If TRUE then contents will be copied using the
     *                            browser's right click menu.
     *
     * @return void
     * @throws Exception If the browser is not supported.
     */
    protected function copy($rightClick=false)
    {
        if ($rightClick !== true) {
            $this->sikuli->keyDown('Key.CMD + c');
        } else {
            $this->sikuli->rightClick($this->sikuli->getMouseLocation());

            switch ($this->sikuli->getBrowserid()) {
                case 'firefox':
                case 'ie11':
                case 'ie10':
                case 'ie9':
                case 'ie8':
                    // Use the shortcut to select the copy menu option.
                    $this->sikuli->keyDown('c');
                break;

                case 'chrome':
                case 'safari':
                    // Use the shortcut menu to select the menu option and then move the mouse up to copy.
                    $this->sikuli->keyDown('c');
                    sleep(2);
                    $this->sikuli->keyDown('Key.ENTER');
                break;

                default:
                throw new Exception('Right click testing for this browser has not been implemented');
            }//end switch
        }//end if

    }//end copy()


    /**
     * Runs the test only if the specified OS or the browser is being used.
     *
     * @param string $os      The OS the test runs for, if NULL it will run for all OS types.
     * @param string $browser The browser the test runs for, if NULL it will run for all browsers.
     *
     * @return void
     */
    protected function runTestFor($os=null, $browser=null)
    {
        if ($os !== null && $os !== $this->sikuli->getOS()) {
            $this->markTestSkipped('This test does not run for this OS');
        } else if ($browser !== null && $browser !== $this->sikuli->getBrowserid()) {
            $this->markTestSkipped('This test does not run for this browser');
        }

    }//end runTestFor()


    /**
     * Returns TRUE if the current browser/os matches the specified parameters.
     *
     * @param string $os      The OS the test runs for, NULL for any.
     * @param string $browser The browser the test runs for, NULL for any.
     *
     * @return void
     */
    protected function isOSAndBrowser($os=null, $browser=null)
    {
        if ($os !== null && $os !== $this->sikuli->getOS()) {
            return false;
        } else if ($browser !== null && $browser !== $this->sikuli->getBrowserid()) {
            return false;
        }

        return true;

    }//end isOSAndBrowser()


    /**
     * Skip the test for the specified OS and/or browsers.
     *
     * @param string $os       The OS id.
     * @param array  $browsers List of browsers.
     *
     * @return void
     */
    protected function skipTestFor($os=null, array $browsers=null)
    {
        $skip = false;
        if ($os !== null) {
            if ($os === $this->sikuli->getOS()) {
                // OS matches but if browsers also specified then do not skip here.
                if (empty($browsers) === true) {
                    // No browsers, skip test.
                    $this->markTestSkipped('This test does not run for this OS');
                }
            } else {
                // OS does not match, dont skip test.
                return;
            }
        }

        if (empty($browsers) === false) {
            if (in_array($this->sikuli->getBrowserid(), $browsers) === true) {
                $this->markTestSkipped('This test does not run for this browser');
            }
        }


    }//end skiptestFor()


    /**
     * Moves the mouse to the next line from its current position and clicks it.
     *
     * Note that the mouse must already be pointing to a line.
     *
     * @return void
     */
    protected function clickNextLine()
    {
        $this->sikuli->click($this->sikuli->mouseMoveOffset(0, 50));

    }//end clickNextLine()


    /**
     * Moves the mouse pointer to the specified location for the given element.
     *
     * @return void
     */
    protected function moveMouseToElement($selector, $position='bottom', $index=0, $yOffset=0)
    {
        $elemRect = $this->getBoundingRectangle($selector, $index);
        $x        = ($elemRect['x1'] + ($elemRect['x2'] - $elemRect['x1']) / 2);

        switch ($position) {
            case 'bottom':
                $y = ($elemRect['y2'] + $yOffset);
            break;

            case 'top':
                $y = ($elemRect['y1'] + $yOffset);
            break;
        }

        $loc = $this->sikuli->createLocation(
            $this->sikuli->getPageXRelativeToScreen($x),
            $this->sikuli->getPageYRelativeToScreen($y)
        );
        $this->sikuli->mouseMove($loc);

    }//end moveMouseToElement()


    /**
     * Returns TRUE if the Cursor Assist plugin's line is visible.
     *
     * @param string  $relativeElement The selector for the relative element.
     * @param string  $position        The position of the line relative to the element.
     * @param integer $index           The element index of the resulting array.
     *
     * @return boolean
     */
    protected function isCursorAssistLineVisible($relativeElement=null, $position='bottom', $index=0)
    {
        $rect = $this->getBoundingRectangle('.ViperCursorAssistPlugin');
        if (empty($rect) === false) {
            if ($relativeElement !== null) {
                // Get the position  of the element.
                $elemPos = $this->getBoundingRectangle($relativeElement, $index);

                switch ($position) {
                    case 'bottom':
                        if ($rect['y2'] <= $elemPos['y2']) {
                            return false;
                        }
                    break;

                    case 'top':
                        if ($rect['y1'] >= $elemPos['y1']) {
                            return false;
                        }
                    break;

                    default:
                    throw new Exception('Position "'.$position.'" not supported.');
                    break;
                }//end switch
            }//end if

            return true;
        }//end if

        return false;

    }//end isCursorAssistLineVisible()


    /**
     * Clicks the visible cursor assist line.
     *
     * @return void
     */
    protected function clickCursorAssistLine()
    {
        $this->clickElement('.ViperCursorAssistPlugin');

    }//end clickCursorAssistLine()


    /**
     * Clicks outside of Viper.
     *
     * @return void
     */
    protected function clickOutside()
    {
        $this->clickElement('#testTitle');

    }//end clickOutside()


    /**
     * Returns the browser window's scroll coordinates.
     *
     * @return void
     */
    protected function getScrollCoords()
    {
        $coordY = $this->sikuli->execJS('document.getElementById("content").scrollTop');
        $coordX = $this->sikuli->execJS('document.getElementById("content").scrollLeft');

        $coords = array(
                   'x' => $coordX,
                   'y' => $coordY,
                  );

        return $coords;

    }//end getScrollCoords()


    /**
     * Automatically provides OS alternative shortcuts
     *
     * @param string   $_Command             The selector for the command to execute
     * @param string   $_CommandDirection    The selector for commands that require direction
     *
     * @return void
     */
    public function getOSAltShortcut($_Command=NULL, $_CommandDirection=NULL)
    {
        if ($_Command !== NULL) {
            if ($this->sikuli->getOS() === 'windows') {
                switch ($_Command) {
                    case 'WholeWordSelect':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.UP');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.DOWN');
                            break;
                        } // End WholeWordSelect
                        break;
                    case 'Copy':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
                                $this->sikuli->keyDown('Key.CTRL + c');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
                                $this->sikuli->keyDown('Key.CTRL + c');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.UP');
                                $this->sikuli->keyDown('Key.CTRL + c');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.DOWN');
                                $this->sikuli->keyDown('Key.CTRL + c');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CTRL + c');
                            break;
                        } // End Copy
                        break;
                    case 'Cut':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
                                $this->sikuli->keyDown('Key.CTRL + x');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
                                $this->sikuli->keyDown('Key.CTRL + x');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.UP');
                                $this->sikuli->keyDown('Key.CTRL + x');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.DOWN');
                                $this->sikuli->keyDown('Key.CTRL + x');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CTRL + x');
                            break;
                        } // End Cut
                        break;
                    case 'Paste':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.RIGHT');
                                $this->sikuli->keyDown('Key.CTRL + v');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.LEFT');
                                $this->sikuli->keyDown('Key.CTRL + v');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.UP');
                                $this->sikuli->keyDown('Key.CTRL + v');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.DOWN');
                                $this->sikuli->keyDown('Key.CTRL + v');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CTRL + v');
                            break;
                        } // End Paste
                        break;
                    case 'Undo':
                        $this->sikuli->keyDown('Key.CTRL + z');
                    break;
                    case 'Redo':
                        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + z');
                    break;
                    case 'Bold':
                        $this->sikuli->keyDown('Key.CTRL + b');
                    break;
                    case 'Italic':
                        $this->sikuli->keyDown('Key.CTRL + i');
                    break;
                    case 'Underline':
                        $this->sikuli->keyDown('Key.CTRL + u');
                    break;
                    case 'SelectAll':
                        $this->sikuli->keyDown('Key.CTRL + a');
                    break;
                    case 'DeselectAll':
                        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + a');
                    break;
                } // End $_Command for windows
            } else {
                switch ($_Command) {
                    case 'WholeWordSelect':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.UP');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.DOWN');
                            break;
                        } // End WholeWordSelect
                        break;
                    case 'ToEndOfLineSelect':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.CMD + Key.SHIFT + Key.RIGHT');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.CMD + Key.SHIFT + Key.LEFT');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.CMD + Key.SHIFT + Key.UP');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.CMD + Key.SHIFT + Key.DOWN');
                            break;
                        } // End ToEndOfLineSelect
                        break;
                    case 'Copy':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.UP');
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.DOWN');
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                            case '':
                                $this->sikuli->keyDown('Key.CMD + c');
                            break;
                        } // End Copy
                        break;
                    case 'Cut':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
                                $this->sikuli->keyDown('Key.CMD + x');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
                                $this->sikuli->keyDown('Key.CMD + x');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.UP');
                                $this->sikuli->keyDown('Key.CMD + x');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.DOWN');
                                $this->sikuli->keyDown('Key.CMD + x');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CMD + x');
                            break;
                        } // End Cut
                        break;
                    case 'Paste':
                        switch ($_CommandDirection) {
                            case 'right':
                                $this->sikuli->keyDown('Key.RIGHT');
                                $this->sikuli->keyDown('Key.CMD + v');
                            break;
                            case 'left':
                                $this->sikuli->keyDown('Key.LEFT');
                                $this->sikuli->keyDown('Key.CMD + v');
                            break;
                            case 'up':
                                $this->sikuli->keyDown('Key.UP');
                                $this->sikuli->keyDown('Key.CMD + v');
                            break;
                            case 'down':
                                $this->sikuli->keyDown('Key.DOWN');
                                $this->sikuli->keyDown('Key.CMD + v');
                            break;
                            case NULL:
                                $this->sikuli->keyDown('Key.CMD + v');
                            break;
                        } // End Paste
                        break;
                    case 'Undo':
                        $this->sikuli->keyDown('Key.CMD + z');
                    break;
                    case 'Redo':
                        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
                    break;
                    case 'Bold':
                        $this->sikuli->keyDown('Key.CMD + b');
                    break;
                    case 'Italic':
                        $this->sikuli->keyDown('Key.CMD + i');
                    break;
                    case 'Underline':
                        $this->sikuli->keyDown('Key.CMD + u');
                    break;
                    case 'SelectAll':
                        $this->sikuli->keyDown('Key.CMD + a');
                    break;
                    case 'DeselectAll':
                        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + a');
                    break;
                } // End $_Command for osx
            } // End GetOS()
        } // End $_Command switch
    }//end getOSAltShortcut()


}//end class
