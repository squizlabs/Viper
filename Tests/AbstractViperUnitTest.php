<?php
require_once 'AbstractSikuliUnitTest.php';

/**
 * An abstract class that all Viper unit tests must extend.
 */
abstract class AbstractViperUnitTest extends AbstractSikuliUnitTest
{

    /**
     * Do not backup static attributes.
     *
     * @var boolean
     */
    protected $backupStaticAttributes = FALSE;

    /**
     * The test.html file content.
     *
     * @var string
     */
    private static $_testContent = NULL;

    /**
     * Set to TRUE then the first test has run.
     *
     * @var boolean
     */
    private static $_testRun = FALSE;

    /**
     * Name of the browser that the tests are running on.
     *
     * @var string
     */
    private static $_browser = NULL;

    /**
     * The browser's window object.
     *
     * @var string
     */
    private static $_window = NULL;

    /**
     * Size of the browser window.
     *
     * @var array
     */
    private static $_windowSize = NULL;

    /**
     * Default size of the browser window.
     *
     * @var array
     */
    private $_defaultWindowSize = array(
                                   'w' => 1270,
                                   'h' => 900,
                                  );

    /**
     * Region object of the Viper Top toolbar.
     *
     * @var string
     */
    private static $_topToolbar = NULL;

    /**
     * The default similarity setting.
     *
     * @var float
     */
    private static $_similarity = 0.85;

    /**
     * The top left position of the browser page relative to the screen 0,0.
     *
     * @var array
     */
    private static $_pageTopLeft = NULL;

    /**
     * Set to TRUE when the browser is selected and focused.
     *
     * @var boolean
     */
    private static $_browserSelected = FALSE;

    /**
     * If TRUE then AJAX polling is used to execute JS.
     *
     * @var boolean
     */
    private static $_pollFilePath = NULL;

    /**
     * Keeps cache of JS that is executed.
     *
     * @var array
     */
    private static $_data = NULL;

    /**
     * Number of tests run.
     *
     * @var integer
     */
    private static $_testCount = 0;

    /**
     * List of applications and if they are available in the current system.
     *
     * @var array
     */
    private static $_apps = array();


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
        $jsPath          = NULL;
        $count = count($paths);
        while ($count > 0) {
            $last     = array_pop($paths);
            $filePath = $baseDir.'/'.implode('/', $paths).'/'.$last.'.'.$type;
            if (file_exists($filePath) === TRUE) {
                return $filePath;
            } else if (count($paths) > 0) {
                // Check for HTML file that has the same name as the directory.
                $filePath = $baseDir.'/'.implode('/', $paths).'/'.$paths[(count($paths) - 1)].'.'.$type;
                if (file_exists($filePath) === TRUE) {
                    return $filePath;
                }
            }

            $count = count($paths);
        }

        return NULL;

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

        // Determine browser and OS.
        if (self::$_browser === NULL) {
            $browser = getenv('VIPER_TEST_BROWSER');
            if ($browser === FALSE) {
                throw new Exception('Invalid browser');
            }

            self::$_browser      = $browser;
            self::$_pollFilePath = dirname(__FILE__).'/tmp/poll';

            if (file_exists(self::$_pollFilePath) === FALSE) {
                mkdir(self::$_pollFilePath, 0777, TRUE);
                chmod(self::$_pollFilePath, 0777);
            } else {
                if (file_exists(self::$_pollFilePath.'/_jsres.tmp') === TRUE) {
                    unlink(self::$_pollFilePath.'/_jsres.tmp');
                }

                if (file_exists(self::$_pollFilePath.'/_jsexec.tmp') === TRUE) {
                    unlink(self::$_pollFilePath.'/_jsexec.tmp');
                }
            }
        }//end if

        $baseDir = dirname(__FILE__);

        // Get the test HTML file.
        $htmlFilePath    = $this->_getTestFile('html');
        $testFileContent = '';
        if ($htmlFilePath !== NULL) {
            $testFileContent = trim(file_get_contents($htmlFilePath));
            $testFileContent = $this->replaceKeywords($testFileContent);
        }

        // Get the test JS file.
        $jsFilePath = $this->_getTestFile('js');
        $jsInclude  = '';
        if ($jsFilePath !== NULL) {
            $jsFilePath = str_replace($baseDir, '.', $jsFilePath);
            $jsInclude  = '<script type="text/javascript" src="'.$jsFilePath.'"></script>';
        }

        // Reset the Sikuli connection after 15 tests.
        if ((self::$_testCount % 15) === 0) {
            $this->resetConnection();
        }

        parent::setUp();

        // Get the contents of the test file template.
        if (self::$_testContent === NULL) {
            self::$_testContent = file_get_contents($baseDir.'/test.html');
        }

        $viperInclude = '';
        if (getenv('VIPER_TEST_USE_BUILT_VIPER') === 'TRUE') {
            $path = dirname(dirname(__FILE__)).'/build/viper.js';
            if (file_exists($path) === FALSE) {
                throw new Exception('Could not find: '.$path);
            }

            $viperInclude = '<script type="text/javascript" src="../build/viper.js"></script>
                             <link rel="stylesheet" media="screen" href="../build/viper.css" />';
        } else {
            $viperInclude = '<script type="text/javascript" src="../DfxJSLib/dfx.js"></script>
                             <script type="text/javascript" src="../Viper-all.js"></script>';
        }

        // Get stats.
        $testTitle  = $this->getName();
        $numFails   = ViperTestListener::getFailures();
        $numErrors  = ViperTestListener::getErrors();
        $totalTests = ViperTestListener::getNumberOfTests();
        $testsRun   = ViperTestListener::getTestsRun();

        $testTitle .= '['.$testsRun.'/'.$totalTests.']';

        if ($numFails !== 0 || $numErrors !== 0) {
            $testTitle .= '(F:'.ViperTestListener::getFailures().', ';
            $testTitle .= 'E:'.ViperTestListener::getErrors().')';
        }

        // Put the current test file contents to the main test file.
        $contents = str_replace('__TEST_CONTENT__', $testFileContent, self::$_testContent);
        $contents = str_replace('__TEST_BROWSER__', $this->getBrowserid(), $contents);
        $contents = str_replace('__TEST_VIPER_INCLUDE__', $viperInclude, $contents);
        $contents = str_replace('__TEST_TITLE__', $testTitle, $contents);
        $contents = str_replace('__TEST_JS_INCLUDE__', $jsInclude, $contents);
        $dest     = $baseDir.'/test_tmp.html';
        file_put_contents($dest, $contents);

        // Change browser and then change the URL.
        if (self::$_testRun === TRUE) {
            $this->resizeWindow();
            $this->setDefaultRegion(self::$_window);

            // URL is already changed to the test runner, so just reload.
            $this->setSetting('MinSimilarity', self::$_similarity);

            $this->reloadPage();
            $this->setAutoWaitTimeout(1);
            $this->_waitForViper();
        } else {
            $this->selectBrowser(self::$_browser);

            $this->resizeWindow();

            $this->setSetting('MinSimilarity', self::$_similarity);
            $calibrate = getenv('VIPER_TEST_CALIBRATE');
            if ($calibrate === 'TRUE' || file_exists($this->getBrowserImagePath()) === FALSE) {
                try {
                    $this->_calibrate();
                } catch (Exception $e) {
                    echo $e;
                    exit;
                }
            }

            $this->goToURL($this->_getBaseUrl().'/test_tmp.html');
            $this->setAutoWaitTimeout(1);
            $this->_waitForViper();

            self::$_testRun = TRUE;

            $pageLoc = $this->getPageTopLeft();
            $this->setH(self::$_window, ($this->getH(self::$_window) - ($pageLoc['y'] - $this->getY(self::$_window))));
            $this->setX(self::$_window, $pageLoc['x']);
            $this->setY(self::$_window, $pageLoc['y']);
        }//end if

    }//end setUp()


    /**
     * Resets the Sikuli connection.
     *
     * @return void
     */
    protected function resetConnection()
    {
        self::$_browserSelected = FALSE;
        self::$_window          = NULL;
        self::$_windowSize      = NULL;
        self::$_testRun         = FALSE;
        self::$_topToolbar      = NULL;
        self::$_pageTopLeft     = NULL;

        parent::resetConnection();

    }//end resetConnection()


    /**
     * Returns the path of a specific browser image directory.
     *
     * @param string $browserid ID of the browser, e.g. googlechrome.
     *
     * @return string
     */
    protected function getBrowserImagePath($browserid=NULL)
    {
        if ($browserid === NULL) {
            $browserid = $this->getBrowserid();
        }

        $path = dirname(__FILE__).'/tmp/Images/'.$browserid;

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
    protected function getButtonIconPath($buttonName, $state=NULL)
    {
        // Calibrate image recognition.
        $imgPath  = dirname(__FILE__).'/tmp/Images/'.$this->getBrowserid();
        $imgPath .= '/'.$buttonName;

        if ($state !== NULL) {
            $imgPath .= '_'.$state;
        }

        $imgPath .= '.png';

        if (file_exists($imgPath) === FALSE) {
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

    }//end tearDown()


    /**
     * Cleans up after all tests are completed.
     *
     * @return void
     */
    public static function tearDownAfterClass()
    {
        $path = dirname(__FILE__).'/test_tmp.html';
        if (file_exists($path) === TRUE) {
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
    private function _waitForViper()
    {
        $this->setAutoWaitTimeout(5, $this->getTopToolbar());

        // Make sure page is loaded.
        $maxRetries = 3;
        while ($this->topToolbarButtonExists('bold', 'disabled') === FALSE) {
            if ($maxRetries === 0) {
                throw new Exception('Failed to load Viper test page.');
            }

            $maxRetries--;
            $this->reloadPage();
        }

        $this->setAutoWaitTimeout(1, $this->getTopToolbar());

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
        $this->setAutoWaitTimeout(0.5);
        $baseDir = dirname(__FILE__);

        // Calibrate image recognition.
        $baseDir = dirname(__FILE__);
        $imgPath = $baseDir.'/tmp/Images/'.$this->getBrowserid();

        if (file_exists($imgPath) === FALSE) {
            mkdir($imgPath, 0755, TRUE);
        }

        $dest = $baseDir.'/calibrate-text.html';

        $url = $this->_getBaseUrl().'/calibrate-text.html';

        $this->goToURL($url);
        sleep(3);

        $texts = $this->execJS('getCoords('.json_encode(self::_getKeywordsList()).')', TRUE);
        $count = count($texts);

        $i      = 1;
        $coords = array();
        foreach ($texts as $id => $textRect) {
            $region = $this->getRegionOnPage($textRect);

            $coordsText = $this->getX($region).'-'.$this->getY($region);

            if (isset($coords[$coordsText]) === TRUE) {
                throw new Exception('Text match conflict between '.$coords[$coordsText].' and '.$id);
            }

            $coords[$coordsText] = $id;

            $textImage = $this->capture($region);
            copy($textImage, $this->_getKeywordImage($i));
            $i++;
        }

        $tests          = 5;
        $pass           = FALSE;
        $textSimilarity = 0.98;

        do {
            try {
                for ($j = 1; $j <= $tests; $j++) {
                    // Change the contents of the test page.
                    $this->execJS('changeContent('.$j.', '.$textSimilarity.')', TRUE);

                    // Test that captured images can be found on the page.
                    for ($i = 1; $i <= $count; $i++) {
                        $this->find($this->_getKeywordImage($i), NULL, $textSimilarity);
                    }
                }

                $pass = TRUE;
            } catch (Exception $e) {
                if ($textSimilarity < 0.85) {
                    throw new Exception('Text similarity test dropped below minimum threshold (85%)');
                }

                $textSimilarity -= 0.01;
            }
        } while ($pass !== TRUE);

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
        $this->setAutoWaitTimeout(0.5);

        // Calibrate image recognition.
        $baseDir = dirname(__FILE__);
        $imgPath = $baseDir.'/tmp/Images/'.$this->getBrowserid();

        if (file_exists($imgPath) === FALSE) {
            mkdir($imgPath, 0755, TRUE);
        }

        $cssContents = file_get_contents($baseDir.'/../Css/viper_tools.css');

        $matches = array();
        preg_match_all('#.Viper-buttonIcon.Viper-([\w-_]+)#', $cssContents, $matches);

        $buttonNames = array_values(array_unique($matches[1]));

        // Create the temp calibration file.
        $tmpFile = $baseDir.'/tmp-calibrate.html';

        $statuses = array(
                     ''          => ' Viper-dummyClass',
                     '_selected' => ' Viper-selected',
                     '_active'   => ' Viper-active',
                     '_disabled' => ' Viper-disabled',
                    );

        $buttonHTML = '';

        $browserClass = '';

        if ($this->getBrowserid() === 'ie8') {
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

        $calibrateHtml = file_get_contents($baseDir.'/calibrate.html');
        $calibrateHtml = str_replace('__TEST_CONTENT__', $buttonHTML, $calibrateHtml);

        file_put_contents($tmpFile, $calibrateHtml);

        $dest = $baseDir.'/tmp-calibrate.html';

        $url = $this->_getBaseUrl().'/tmp-calibrate.html';

        $this->goToURL($url);
        sleep(3);

        if ($this->execJS('testJSExec()', TRUE) !== 'Pass') {
            throw new Exception('JavaScript execution test failed!!');
        }

        // Create image for the inline toolbar pattern (the arrow on top).
        sleep(2);
        $this->selectText('PyP');
        sleep(1);

        $vitp      = $this->execJS('getVITP()', TRUE);
        $vitp['x'] = $this->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->createRegion(($vitp['x'] - 12), ($vitp['y'] - 10), 27, 14);
        $vitpImage = $this->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrow.png');

        sleep(2);

        // Left arrow.
        $vitp      = $this->execJS('getVITP("left")', TRUE);
        $vitp['x'] = $this->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->createRegion(($vitp['x'] - 2), ($vitp['y'] - 10), 30, 14);
        $vitpImage = $this->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrowLeft.png');

        sleep(2);

        // Right arrow.
        $vitp      = $this->execJS('getVITP("right")', TRUE);
        $vitp['x'] = $this->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->createRegion(($vitp['x'] + $vitp['width'] - 24), ($vitp['y'] - 10), 30, 14);
        $vitpImage = $this->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrowRight.png');

        // Create image for the text field actions.
        $textFieldActionRevertRegion = $this->getRegionOnPage($this->execJS('dfx.getBoundingRectangle(dfx.getId("textboxActionRevert"))', TRUE));
        $textFieldActionRevertImage  = $this->capture($textFieldActionRevertRegion);
        copy($textFieldActionRevertImage, $imgPath.'/textField_action_revert.png');

        $textFieldActionClearRegion = $this->getRegionOnPage($this->execJS('dfx.getBoundingRectangle(dfx.getId("textboxActionClear"))', TRUE));
        $textFieldActionClearImage  = $this->capture($textFieldActionClearRegion);
        copy($textFieldActionClearImage, $imgPath.'/textField_action_clear.png');

        // Remove all Viper elements.
        $this->execJS('viper.destroy()', TRUE);

        foreach ($statuses as $status => $className) {
            $btnRects = $this->execJS('getCoords("'.$status.'", "'.$className.'")', TRUE);
            sleep(1);
            foreach ($btnRects as $buttonName => $rect) {
                $this->_createButtonImageFromRectangle($buttonName, $rect);
            }
        }

        $this->execJS('showAllBtns()', TRUE);

        // Remove dupe icons.
        $dupeIcons = array(
                      'tableSettings',
                      'sourceNewWindow',
                     );
        foreach ($dupeIcons as $dupeIcon) {
            $btnIndex = array_search($dupeIcon, $buttonNames);
            if ($btnIndex !== FALSE) {
                unset($buttonNames[$btnIndex]);
            }
        }

        for ($similarity = 0.98; $similarity > 0.90; $similarity -= 0.01) {
            // Find each of the icons, if any fails it will throw an exception.
            $regions = array();
            foreach ($statuses as $status => $className) {
                foreach ($buttonNames as $buttonName) {
                    if ($status !== '') {
                        $buttonName .= $status;
                    }

                    $testImage = $imgPath.'/'.$buttonName.'.png';
                    try {
                        $region = $this->find($testImage, NULL, $similarity);
                        $loc    = $this->getX($region).'-'.$this->getY($region);

                        if (isset($regions[$loc]) === TRUE) {
                            throw new Exception('Image match conflict between '.$regions[$loc].' and '.$buttonName);
                        }

                        $regions[$loc] = $buttonName;
                    } catch (Exception $e) {
                        continue(3);
                    }
                }
            }//end foreach

            break;
        }//end for

        // Remove the temp calibrate file.
        unlink($tmpFile);

        $this->addData('buttonSimmilarity', $similarity);

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
        $path = dirname(__FILE__).'/tmp/'.$this->getBrowserid();
        if (file_exists($path) === FALSE) {
            mkdir($path, 0755, TRUE);
        }

        $path .= '/data.inc';

        $data = self::$_data;

        if ($data === NULL) {
            if (file_exists($path) === TRUE) {
                include $path;
            }
        }

        $data[$varName] = $value;

        self::$_data = $data;
        file_put_contents($path, '<?php $data = '.var_export($data, TRUE).'; ?>');

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
        if (self::$_data === NULL) {
            $path = dirname(__FILE__).'/tmp/'.$this->getBrowserid().'/data.inc';
            if (file_exists($path) === TRUE) {
                include $path;
                self::$_data = $data;
            }
        }

        if (isset(self::$_data[$varName]) === TRUE) {
            return self::$_data[$varName];
        }

        return NULL;

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
        $baseDir  = dirname(__FILE__);
        $imgPath  = $baseDir.'/tmp/Images/'.$this->getBrowserid();
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
        $keywords = self::_getKeywordsList();
        foreach ($keywords as $index => $keyword) {
            $content = str_replace('%'.($index + 1).'%', $keyword, $content);
        }

        // Replace URL keyword.
        $url = getenv('VIPER_TEST_URL');
        if (empty($url) === TRUE) {
            $url = dirname(__FILE__);
        }

        $content = str_replace('%url%', $url, $content);

        return $content;

    }//end replaceKeywords()


    /**
     * Returns the base URL.
     *
     * @return string
     */
    private function _getBaseUrl()
    {
        $url = getenv('VIPER_TEST_URL');
        if (empty($url) === TRUE) {
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
        return $this->_getBaseUrl().$path;

    }//end getTestURL()


    /**
     * Reloads the page.
     *
     * @return void
     */
    protected function reloadPage()
    {
        $topLeft = array(
                    'x1' => 0,
                    'y1' => 0,
                    'x2' => 14,
                    'y2' => 14,
                   );
        $region  = $this->getRegionOnPage($topLeft);
        $this->click($region);
        sleep(1);

    }//end reloadPage()


    /**
     * Sets the browser URL to the specified URL.
     *
     * @param string $url The new URL.
     *
     * @return void
     */
    protected function goToURL($url)
    {
        $this->keyDown('Key.CMD+l');
        $this->type($url);
        $this->keyDown('Key.ENTER');
        sleep(1);

    }//end goToURL()


    /**
     * Changes the active application to the specified browser.
     *
     * @param string $browser The name of the browser.
     *
     * @return void
     */
    protected function selectBrowser($browser)
    {
        if ($this->getOS() === 'windows') {
            if ($browser === 'Google Chrome') {
                $browser = '- Google Chrome';
            } else if ($browser === 'Firefox') {
                $browser = 'Mozilla Firefox';
            } else if ($browser === 'IE8' || $browser === 'IE9') {
                $browser = 'Windows Internet Explorer';
            }
        } else if ($browser === 'Firefox') {
            $browser = '/Applications/Firefox.app';
        }

        if (self::$_browserSelected === FALSE) {
            $app = $this->switchApp($browser);
            if ($this->getOS() !== 'windows') {
                $windowNum = 0;
                switch ($browser) {
                    case 'Google Chrome':
                        $windowNum = 1;
                    break;

                    default:
                        $windowNum = 0;
                    break;
                }

                self::$_window = $this->callFunc('window', array($windowNum), $app, TRUE);
            } else {
                self::$_window = $app;
            }//end if
        } else {
            if ($this->getOS() !== 'windows') {
                self::$_window = $this->callFunc('App.focusedWindow', array(), NULL, TRUE);
            } else {
                self::$_window = $this->switchApp($browser);
            }
        }//end if

        if (self::$_testRun === TRUE) {
            // Adjust the brwoser window region so that its only the area of the actual page.
            $pageLoc = $this->getPageTopLeft();
            $this->setH(self::$_window, ($this->getH(self::$_window) - ($pageLoc['y'] - $this->getY(self::$_window))));
            $this->setX(self::$_window, $pageLoc['x']);
            $this->setY(self::$_window, $pageLoc['y']);
        }

        $this->setDefaultRegion(self::$_window);

        self::$_browserSelected = TRUE;

    }//end selectBrowser()


    /**
     * Returns the name of the current browser.
     *
     * @return string
     */
    protected function getBrowserName()
    {
        return self::$_browser;

    }//end getBrowserName()


    /**
     * Returns the ID of the current browser.
     *
     * @return string
     */
    protected function getBrowserid()
    {
        $id = self::$_browser;
        if ($this->getOS() === 'windows'
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


    /**
     * Returns the region of the browser window.
     *
     * @return string
     */
    protected function getBrowserWindow()
    {
        return self::$_window;

    }//end getBrowserWindow()


    /**
     * Returns the size of the browser window.
     *
     * @return array
     */
    protected function getBrowserWindowSize()
    {
        $w = $this->getW($this->getBrowserWindow());
        $h = $this->getH($this->getBrowserWindow());

        $size = array(
                 'w' => $w,
                 'h' => $h,
                );

        return $size;

    }//end getBrowserWindowSize()


    /**
     * Returns the default browser window size.
     *
     * @return array
     */
    protected function getDefaultWindowSize()
    {
        return $this->_defaultWindowSize;

    }//end getDefaultWindowSize()


    /**
     * Set the default browser window size.
     *
     * @param integer $w The width of the window.
     * @param integer $h The height of the window.
     *
     * @return void
     */
    protected function setDefaultWindowSize($w, $h)
    {
        $this->_defaultWindowSize = array(
                                     'w' => $w,
                                     'h' => $h,
                                    );

    }//end setDefaultWindowSize()


    /**
     * Resizes the browser window.
     *
     * @param integer $w The width of the window.
     * @param integer $h The height of the window.
     *
     * @return void
     */
    protected function resizeWindow($w=NULL, $h=NULL)
    {
        if ($w === NULL || $h === NULL) {
            $size = $this->getDefaultWindowSize();

            if ($w === NULL) {
                $w = $size['w'];
            }

            if ($h === NULL) {
                $h = $size['h'];
            }
        }

        if (is_array(self::$_windowSize) === TRUE) {
            if (self::$_windowSize['w'] === $w && self::$_windowSize['h'] === $h) {
                return;
            }
        }

        // Update the self::$_window object.
        $this->selectBrowser($this->getBrowserName());

        $window = $this->getBrowserWindow();

        $bottomRight = $this->getBottomRight($window);

        if ($this->getOS() === 'windows') {
            $bottomRight = $this->createLocation(
                ($this->getX($bottomRight) - 5),
                ($this->getY($bottomRight) - 5)
            );
        }

        $newLocation = $this->createLocation(
            ($this->getX($window) + $w),
            ($this->getY($window) + $h)
        );

        $this->dragDrop($bottomRight, $newLocation);

        // Update the self::$_window object.
        $this->selectBrowser($this->getBrowserName());

        self::$_windowSize = array(
                              'w' => $w,
                              'h' => $h,
                             );

    }//end resizeWindow()


    /**
     * Closes the JS exec window.
     *
     * @return void
     */
    public function closeJSWindow()
    {
        $this->execJS('cw();', TRUE, TRUE);

    }//end closeJSWindow()


    /**
     * Sets the content of the test page to the specified test case.
     *
     * @param string $id The ID of the test case.
     *
     * @return void
     */
    protected function useTest($id)
    {
        $this->execJS('useTest("test-'.$id.'")');

    }//end useTest()


    /**
     * Returns the location of the page relative to the screen.
     *
     * @return array
     */
    protected function getPageTopLeft()
    {
        if (self::$_pageTopLeft !== NULL) {
            return self::$_pageTopLeft;
        }

        $targetIcon = $this->find(dirname(__FILE__).'/Core/Images/window-target.png');
        $topLeft    = $this->getTopLeft($targetIcon);
        $loc        = array(
                       'x' => $this->getX($topLeft),
                       'y' => $this->getY($topLeft),
                      );

        self::$_pageTopLeft = $loc;

        return $loc;

    }//end getPageTopLeft()


    /**
     * Returns a new Region object relative to the top left of the test page.
     *
     * @param array $rect The rectangle (x1, y1, x2, y2).
     *
     * @return string
     */
    protected function getRegionOnPage(array $rect)
    {
        $pageLoc = $this->getPageTopLeft();

        $x = ($pageLoc['x'] + $rect['x1']);
        $y = ($pageLoc['y'] + $rect['y1']);
        $w = ($rect['x2'] - $rect['x1']);
        $h = ($rect['y2'] - $rect['y1']);

        $region = $this->createRegion($x, $y, $w, $h);
        return $region;

    }//end getRegionOnPage()


    /**
     * Returns the given page X location relative to the screen.
     *
     * @param integer $x The x location relative to the page.
     *
     * @return integer
     */
    protected function getPageXRelativeToScreen($x)
    {
        $pageLoc = $this->getPageTopLeft();

        $x = ($pageLoc['x'] + $x);
        return $x;

    }//end getPageXRelativeToScreen()


    /**
     * Returns the given page X location relative to the screen.
     *
     * @param integer $y The x location relative to the page.
     *
     * @return integer
     */
    protected function getPageYRelativeToScreen($y)
    {
        $pageLoc = $this->getPageTopLeft();

        $y = ($pageLoc['y'] + $y);
        return $y;

    }//end getPageYRelativeToScreen()


    /**
     * Returns the X position of given location relative to the page.
     *
     * @param string $loc The location variable.
     *
     * @return integer
     */
    protected function getPageX($loc)
    {
        $pageLoc = $this->getPageTopLeft();
        $x       = ($this->getX($loc) - $pageLoc['x']);

        return $x;

    }//end getPageX()


    /**
     * Returns the Y position of given location relative to the page.
     *
     * @param string $loc The location variable.
     *
     * @return integer
     */
    protected function getPageY($loc)
    {
        $pageLoc = $this->getPageTopLeft();
        $y       = ($this->getY($loc) - $pageLoc['y']);

        return $y;

    }//end getPageY()


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
    protected function assertHTMLMatch($html, $msg=NULL, $removeTableHeaders=FALSE)
    {
        $html = $this->replaceKeywords($html);

        $pageHtml = $this->getHtml(NULL, 0, $removeTableHeaders);

        $pageHtml = preg_replace("/<([a-z0-9]+)\n([a-z0-9]*)/i", '<$1$2', $pageHtml);
        $pageHtml = str_replace("<\n", '<', $pageHtml);
        $pageHtml = str_replace("\n", ' ', $pageHtml);
        $pageHtml = str_replace('\n', ' ', $pageHtml);
        $html     = str_replace("\n", ' ', $html);

        // Chrome requires &nbsp; inside block elements unlike Firefox, remove all
        // single &nbsp; from tags and just before a start tag.
        $pageHtml = str_replace('>&nbsp;<', '><', $pageHtml);
        $pageHtml = str_replace('&nbsp;<', '<', $pageHtml);
        $pageHtml = str_replace('&nbsp;<', '<', $pageHtml);
        $pageHtml = str_replace('>&nbsp;', '> ', $pageHtml);
        $html     = str_replace('>&nbsp;<', '><', $html);
        $html     = str_replace('&nbsp;<', '<', $html);
        $html     = str_replace('&nbsp;<', '<', $html);
        $html     = str_replace('>&nbsp;', '> ', $html);
        $pageHtml = str_replace('> <', '><', $pageHtml);
        $pageHtml = str_replace(' <', '<', $pageHtml);
        $html     = str_replace('> <', '><', $html);
        $html     = str_replace(' <', '<', $html);

        if ($html !== $pageHtml) {
            $pageHtml = $this->_orderTagAttributes($pageHtml);
            $html     = $this->_orderTagAttributes($html);
        }

        $this->assertEquals($html, $pageHtml, $msg);

    }//end assertHTMLMatch()


    /**
     * Checks that the expected html matches the actual html after removing the header tags from the tables.
     *
     * @param string $html The expected HTML.
     * @param string $msg  The error message to print.
     *
     * @return void
     */
    protected function assertHTMLMatchNoHeaders($html, $msg=NULL)
    {
        $this->assertHTMLMatch($html, $msg, TRUE);

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
    public static function assertEquals($expected, $actual, $message='', $delta=0, $maxDepth=10, $canonicalize=FALSE, $ignoreCase=FALSE)
    {
        $expected = self::replaceKeywords($expected);

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
    protected function assertHasHTML($html, $pos=NULL, $msg=NULL, $ignoreExtraSpace=FALSE)
    {
        $pageHtml = str_replace('\n', '', $this->getHtml());
        $html     = str_replace("\n", '', $html);

        if ($ignoreExtraSpace === TRUE) {
            $pageHtml = preg_replace('/\s\s+/', ' ', $pageHtml);
        }

        if ($msg === NULL) {
            $msg = 'Specified HTML not found in page content';
        }

        if ($pos === NULL) {
            if (strpos($pageHtml, $html) === FALSE) {
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
    protected function assertListEqual(array $expected, $incContent=FALSE)
    {
        $actual = $this->execJS('gListS(null, '.((int) $incContent).')');
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
        $attrRegex = '(?:(?:\s+\w+(?:\s*=\s*(?:"(?:[^"]+)?"))?)+)?(?:(?:\s+\w+(?:\s*=\s*(?:"(?:[^"]+)?"))?)+)?\s*\/?';
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
                    preg_match_all('/\s+(\w+)\s*=\s*(?:"([^"]+)?")/i', $match, $attrs);
                    asort($attrs[1]);
                    $match = $tagMatches[1];
                    foreach ($attrs[1] as $attrIndex => $attrName) {
                        if ($attrName === 'style') {
                            $attrVal = $attrs[2][$attrIndex];
                            // Values in a style attribute need to be ordered
                            // alphabetically as the browser changes the order sometimes.
                            $vals = array();
                            preg_match_all('/(\w+)\s*:\s*[^:]+;?/i', $attrVal, $vals);
                            asort($vals[1]);
                            $match .= ' '.$attrs[1][$attrIndex].'="';
                            foreach ($vals[1] as $valIndex => $value) {
                                if (strpos($vals[0][$valIndex], ';') === FALSE) {
                                    $vals[0][$valIndex] .= ';';
                                }

                                $match .= $vals[0][$valIndex].' ';
                            }

                            $match  = rtrim($match);
                            $match .= '"';
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
        $match = NULL;
        try {
            $match = $this->find($this->getBrowserImagePath().'/vitp_arrow.png', self::$_window, 0.85);
        } catch (Exception $e) {
            // Get it using JS.
            $elemRect = $this->execJS('gVITPArrow()');
            $match    = $this->getRegionOnPage($elemRect);
            if ($match === NULL) {
                throw new Exception('Could not find Inline Toolbar');
            }
        }

        $this->setX($match, ($this->getX($match) - 200));
        $this->setW($match, ($this->getW($match) + 400));
        $this->setH($match, ($this->getH($match) + 200));

        $this->setAutoWaitTimeout(0.5, $match);

        return $match;

    }//end getInlineToolbar()


    /**
     * Returns the match object variable of the inline toolbar.
     *
     * @return string
     */
    protected function getTopToolbar()
    {
        if (self::$_topToolbar !== NULL) {
            return self::$_topToolbar;
        }

        $region = $this->createRegion(
            $this->getPageXRelativeToScreen(0),
            $this->getPageYRelativeToScreen(0),
            $this->getW(self::$_window),
            150
        );

        self::$_topToolbar = $region;

        $this->setAutoWaitTimeout(0.5, $region);

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
        $rect = $this->execJS('gActBubble()');

        if (is_array($rect) === TRUE) {
            $region = $this->getRegionOnPage($rect);
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
    protected function inlineToolbarButtonExists($buttonIcon, $state=NULL, $isText=FALSE)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);

        if ($isText === TRUE) {
            // Its harder for Sikuli to match a text button so use lower similarity.
            try {
                $this->find($button, $this->getInlineToolbar(), 0.7);
            } catch (Exception $e) {
                // Try to find it again without the image.
                try {
                    $rect = $this->_getTextButtonRectangle($buttonIcon, $state, 'inlineToolbar');
                    $this->getRegionOnPage($rect);
                } catch (Exception $e) {
                    return FALSE;
                }
            }
        } else {
            $toolbar = $this->getInlineToolbar();
            try {
                $this->find($button, $toolbar, $this->getData('buttonSimmilarity'));
            } catch (Exception $e) {
                try {
                    $this->find($button, $toolbar, 0.92);
                } catch (Exception $e) {
                    return FALSE;
                }
            }
        }//end if

        return TRUE;

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
    protected function topToolbarButtonExists($buttonIcon, $state=NULL, $isText=FALSE)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);

        if ($isText === TRUE) {
            // Its harder for Sikuli to match a text button so use lower similarity.
            try {
                $this->find($button, $this->getTopToolbar(), 0.7);
            } catch (Exception $e) {
                // Try to find it again without the image.
                try {
                    $rect = $this->_getTextButtonRectangle($buttonIcon, $state, 'topToolbar');
                    $this->getRegionOnPage($rect);
                } catch (Exception $e) {
                    return FALSE;
                }
            }
        } else {
            $toolbar = $this->getTopToolbar();
            try {
                $this->find($button, $toolbar, $this->getData('buttonSimmilarity'));
            } catch (Exception $e) {
                try {
                    $this->find($button, $toolbar, 0.92);
                } catch (Exception $e) {
                    return FALSE;
                }
            }
        }//end if

        return TRUE;

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
    protected function clickTopToolbarButton($buttonIcon, $state=NULL, $isText=FALSE, $forceJSPos=FALSE)
    {
        $this->_clickButton($buttonIcon, $state, $isText, 'topToolbar', $forceJSPos);

    }//end clickTopToolbarButton()


    /**
     * Clicks the specified button icon in the Inline Toolbar.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     *
     * @return void
     * @throws Exception If the specified icon file not found.
     */
    protected function clickInlineToolbarButton($buttonIcon, $state=NULL, $isText=FALSE)
    {
        $this->_clickButton($buttonIcon, $state, $isText, 'inlineToolbar');

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
    protected function buttonExists($buttonIcon, $state=NULL, $isText=FALSE, $region=NULL)
    {
        $button = $this->_getButton($buttonIcon, $state, $isText);
        return $this->exists($button, $region);

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
        $state=NULL,
        $isText=FALSE,
        $location=NULL,
        $forceJSPos=FALSE
    ) {
        $buttonObj = $this->_getButton($buttonIcon, $state, $isText, $location);

        $region = NULL;
        if ($location === 'topToolbar') {
            $region = $this->getTopToolbar();
        } else if ($location === 'inlineToolbar') {
            $region = $this->getInlineToolbar();
        } else {
            $region = $location;
        }

        $match = NULL;
        if ($isText === TRUE) {
            if ($forceJSPos === TRUE) {
                $rect  = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                $match = $this->getRegionOnPage($rect);
            } else {
                // Its harder for Sikuli to match a text button so use lower similarity.
                try {
                    $match = $this->find($buttonObj, $region, 0.7);
                } catch (Exception $e) {
                    // Try to find it again without the image.
                    $rect  = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                    $match = $this->getRegionOnPage($rect);
                }
            }
        } else {
            $match = $this->find($buttonObj, $region, $this->getData('buttonSimmilarity'));
        }

        $this->click($match);

        // Move the mouse pointer away from the button so that its tooltip does not
        // cause issues.
        $this->mouseMove($this->createLocation(($this->getX($match) - 5), ($this->getY($match) - 5)));

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
    protected function clickButton($buttonIcon, $state=NULL, $isText=FALSE, $region=NULL)
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
    protected function findButton($buttonIcon, $state=NULL, $isText=FALSE, $location=NULL)
    {
        return $this->find($this->_getButton($buttonIcon, $state, $isText, $location), NULL, $this->getData('buttonSimmilarity'));

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
    private function _getButton($buttonIcon, $state=NULL, $isText=FALSE, $location=NULL)
    {
        if ($isText === TRUE) {
            $buttonIconId = preg_replace('#\W#', '_', $buttonIcon);
            try {
                $buttonIcon = $this->getButtonIconPath($buttonIconId, $state);
            } catch (Exception $e) {
                $rect       = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                $buttonIcon = $this->_createButtonImageFromRectangle($buttonIcon, $rect, $state);
            }//end try
        } else if (is_file($buttonIcon) === FALSE) {
            $buttonIcon = $this->getButtonIconPath($buttonIcon, $state);
        }//end if

        if (file_exists($buttonIcon) === FALSE) {
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
    private function _getTextButtonRectangle($button, $state=NULL, $location=NULL)
    {
        $jsFn = 'gBtn';

        if ($location === 'topToolbar') {
            $jsFn = 'gTPBtn';
        } else if ($location === 'inlineToolbar') {
            $jsFn = 'gITPBtn';
        }

        $rect = NULL;
        if ($state !== NULL) {
            $rect = $this->execJS($jsFn.'("'.$button.'", "'.$state.'")');
        } else {
            $rect = $this->execJS($jsFn.'("'.$button.'")');
        }

        if (is_array($rect) === FALSE) {
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
    private function _createButtonImageFromRectangle($button, array $rect, $state=NULL)
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
    protected function createImageFromRectangle($imageName, array $rect, $postFix=NULL)
    {
        $imageName = preg_replace('#[^a-zA-Z0-9_-]#', '_', $imageName);
        $image     = $this->capture($this->getRegionOnPage($rect));
        $filePath  = $this->getBrowserImagePath().'/'.$imageName;

        if ($postFix !== NULL) {
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
     * @param string  $imageName Name of the image.
     * @param string  $selector  The jQuery selector to use for finding the element.
     * @param integer $index     The element index of the resulting array.
     *
     * @return string
     */
    protected function findImage($imageName, $selector, $index=0)
    {
        $filePath = $this->getBrowserImagePath().'/'.$imageName.'.png';

        if (file_exists($filePath) === TRUE) {
            return $this->find($filePath);
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
        $rect   = $this->getBoundingRectangle('.ViperITP-lineageItem', $index);
        $region = $this->getRegionOnPage($rect);
        $this->click($region);

    }//end selectInlineToolbarLineageItem()


    /**
     * Executes the specified JavaScript and returns its result.
     *
     * @param string  $js            The JavaScript to execute.
     * @param boolean $noCache       If TRUE the executed JS will not be cached.
     * @param boolean $noReturnValue If TRUE then JS has no return value and NULL
     *                               will be returned to speed up execution.
     *
     * @return string
     * @throws Exception If there is a Selenium error.
     */
    protected function execJS($js, $noCache=FALSE, $noReturnValue=FALSE)
    {
        $this->debug('ExecJS: '.$js);

        file_put_contents(self::$_pollFilePath.'/_jsexec.tmp', $js);
        chmod(self::$_pollFilePath.'/_jsexec.tmp', 0777);

        if ($js === 'cw();' || $noReturnValue === TRUE) {
            return NULL;
        }

        $startTime = microtime(TRUE);
        $timeout   = 3;
        while (file_exists(self::$_pollFilePath.'/_jsres.tmp') === FALSE) {
            if ((microtime(TRUE) - $startTime) > $timeout) {
                break;
            }

            usleep(50000);
        }

        $result = NULL;
        if (file_exists(self::$_pollFilePath.'/_jsres.tmp') === TRUE) {
            $result = file_get_contents(self::$_pollFilePath.'/_jsres.tmp');

            unlink(self::$_pollFilePath.'/_jsres.tmp');

            if ($result === 'undefined' || trim($result) === '') {
                return NULL;
            }

            $result = json_decode($result, TRUE);

            if (is_string($result) === TRUE) {
                $result = str_replace("\r\n", '\n', $result);
                $result = str_replace("\n", '\n', $result);
            }
        }

        return $result;

    }//end execJS()


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
    protected function selectText($startWord, $endWord=NULL)
    {
        if (empty($endWord) === TRUE) {
            $ipsum = $this->find($startWord, $this->getBrowserWindow());
            $this->doubleClick($ipsum);
            return;
        }

        $start = $this->find($startWord, $this->getBrowserWindow());
        $end   = $this->find($endWord, $this->getBrowserWindow());

        $this->click($start);

        $startLeft = $this->getTopLeft($start);
        $endRight  = $this->getBottomRight($end);

        $this->setLocation(
            $startLeft,
            ($this->getX($startLeft) + 2),
            $this->getY($startLeft)
        );

        $this->setLocation(
            $endRight,
            ($this->getX($endRight) + 2),
            $this->getY($endRight)
        );

        $this->dragDrop($startLeft, $endRight);

    }//end selectText()


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
    protected function selectKeyword($startKeyword, $endKeyword=NULL)
    {
        $startKeywordImage = $this->_getKeywordImage($startKeyword);

        if ($endKeyword === NULL) {
            $endKeyword = $startKeyword;
        }

        try {
            $start = $this->find($startKeywordImage, NULL, $this->getData('textSimmilarity'));
        } catch (Exception $e) {
            // Sometimes the caret is causing Sikuli not to find the keyword, Click on another keyword
            // and then try to find this keyword again.
            try {
                if ($startKeyword === 1) {
                    $this->click($this->findKeyword($startKeyword + 1));
                } else {
                    $this->click($this->findKeyword(1));
                }

                $start = $this->find($startKeywordImage, NULL, $this->getData('textSimmilarity'));
            } catch (Exception $e) {
                throw new Exception('Failed to find keyword: '.$this->getKeyword($startKeyword));
            }
        }

        $end = $start;
        if ($startKeyword !== $endKeyword) {
            $end = $this->find($this->_getKeywordImage($endKeyword), NULL, $this->getData('textSimmilarity'));
        }

        $this->click($start);

        if ($this->getBrowserid() === 'safari') {
            sleep(1);
        }

        $startLeft = $this->getTopLeft($start);
        $endRight  = $this->getTopRight($end);

        $this->setLocation(
            $startLeft,
            ($this->getX($startLeft) + 2),
            ($this->getY($startLeft) + 2)
        );

        $this->setLocation(
            $endRight,
            ($this->getX($endRight) + 2),
            ($this->getY($endRight) + 2)
        );

        if ($endKeyword !== $startKeyword && ($this->getBrowserid() === 'ie8' || $this->getBrowserid() === 'ie9')) {
            // Of course, even a simple thing like selecting words is a problem in
            // IE. When you select words it also selects the space after it, causing
            // tests to fail where style is applied to the selection or modification
            // are made to the selection. To prevent this we need to select the words
            // and then move the mouse back a few pixels while holding down left
            // button and then drop it at the end of the last word.
            $this->drag($startLeft);
            $this->mouseMove($endRight);
            $this->mouseMoveOffset(-10, 0);
            $this->dropAt($endRight);
            sleep(1);
        } else {
            $this->dragDrop($startLeft, $endRight);
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

        if ($position === 'right' && ($this->getBrowserid() === 'ie8' || $this->getBrowserid() === 'ie9')) {
            $this->keyDown('Key.LEFT');
            $this->keyDown('Key.RIGHT');
            $this->keyDown('Key.RIGHT');
            $this->keyDown('Key.RIGHT');
        } else if ($position === 'right') {
            $this->keyDown('Key.RIGHT');
        } else if ($position === 'left') {
            $this->keyDown('Key.LEFT');
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
        return $this->find($this->_getKeywordImage($keyword), NULL, $this->getData('textSimmilarity'));

    }//end findKeyword()


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
            $this->find($this->_getLabel($label), NULL, 0.7);
        } catch (Exception $e) {
            return FALSE;
        }

        return TRUE;

    }//end fieldExists()


    /**
     * Clicks the field with specified label.
     *
     * @param string $label The label of the field.
     *
     * @return void
     */
    protected function clickField($label)
    {
        $this->click($this->find($this->_getLabel($label), NULL, 0.7));

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
            $fieldLabel = $this->find($this->_getLabel($label), NULL, 0.7);
        } catch (Exception $e) {
            $fieldLabel = $this->find($this->_getLabel($label, TRUE), NULL, 0.7);
        }

        $fieldRegion  = $this->extendRight($fieldLabel, 400);
        $actionImage  = $this->getBrowserImagePath().'/textField_action_clear.png';
        $actionButton = $this->find($actionImage, $fieldRegion);

        $this->click($actionButton);

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
            $fieldLabel = $this->find($this->_getLabel($label), NULL, 0.7);
        } catch (Exception $e) {
            $fieldLabel = $this->find($this->_getLabel($label, TRUE), NULL, 0.7);
        }

        $fieldRegion  = $this->extendRight($fieldLabel, 400);
        $actionImage  = $this->getBrowserImagePath().'/textField_action_revert.png';
        $actionButton = $this->find($actionImage, $fieldRegion);

    }//end revertFieldValue()


    /**
     * Returns the label image for the specified label element.
     *
     * @param string  $label The label of a field.
     * @param boolean $force Force update the label screenshot.
     *
     * @return string
     */
    private function _getLabel($label, $force=FALSE)
    {
        $labelImg  = preg_replace('#\W#', '_', $label);
        $imagePath = $this->getBrowserImagePath().'/label_'.$labelImg.'.png';

        if (file_exists($imagePath) === FALSE || $force === TRUE) {
            $rect    = $this->execJS('gField("'.$label.'")');
            $region  = $this->getRegionOnPage($rect);
            $tmpPath = $this->capture($region);
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
    protected function type($text, $modifiers=NULL, $psmrl=NULL)
    {
        $text = $this->replaceKeywords($text);
        return parent::type($text, $modifiers, $psmrl);

    }//end type()


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
    protected function getHtml($selector=NULL, $index=0, $removeTableHeaders=FALSE, $noModify=FALSE)
    {
        $removeTableHeaders = (int) $removeTableHeaders;

        if ($selector === NULL) {
            $text = $this->execJS('gHtml(null, null, '.$removeTableHeaders.')');
        } else {
            $text = $this->execJS('gHtml("'.$selector.'", '.$index.', '.$removeTableHeaders.')');
        }

        if ($noModify !== TRUE) {
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
     * @return string
     */
    protected function getSelectedText()
    {
        return $this->execJS('gText()');

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
        $rect = $this->execJS('gBRec("'.$selector.'", '.$index.')');
        return $rect;

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
    protected function clickElement($selector, $index=0, $rightClick=FALSE)
    {
        $elemRect = $this->getBoundingRectangle($selector, $index);
        $region   = $this->getRegionOnPage($elemRect);

        // Click the element.
        if ($rightClick !== TRUE) {
            $this->click($region);
        } else {
            $this->rightClick($region);
        }

    }//end clickElement()


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
        if ($appName === $this->getBrowserName()) {
            // Open a new tab in this browser.
            $this->keyDown('Key.CMD + t');
            sleep(1);
            $this->goToURL($filePath);
            return TRUE;
        }

        if (array_key_exists($appName, self::$_apps) === TRUE) {
            if (self::$_apps[$appName] === TRUE) {
                system('open '.escapeshellarg($filePath));
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $retval = NULL;
            if ($this->getOS() === 'windows') {
                system('open '.escapeshellarg($filePath), $retval);
            } else {
                system('open -a'.escapeshellarg($appName).' '.escapeshellarg($filePath), $retval);
            }

            if ($retval === 1) {
                self::$_apps[$appName] = FALSE;
                return FALSE;
            } else {
                self::$_apps[$appName] = TRUE;
                return TRUE;
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
        $this->switchApp($appName);
        if ($this->getOS() === 'windows') {
            $this->keyDown('Key.ALT + F4');
        } else {
            if ($appName === $this->getBrowserName()) {
                sleep(5);
                $this->keyDown('Key.CMD + w');
            } else {
                $this->keyDown('Key.CMD + q');
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
    protected function removeTableHeaders($tableIndex=NULL, $removeid=TRUE)
    {
        if ($tableIndex === NULL) {
            $tableIndex = 'null';
        }

        $js = 'rmTableHeaders('.$tableIndex.',';

        if ($removeid === TRUE) {
            $js .= ' true)';
        } else {
            $js .= ' false)';
        }

        $this->execJS($js, NULL, TRUE);

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
    protected function paste($rightClick=FALSE)
    {
        if ($rightClick !== TRUE) {
            $this->keyDown('Key.CMD + v');
        } else {
            sleep(1);
            $this->rightClick($this->getMouseLocation());

            switch ($this->getBrowserid()) {
                case 'firefox':
                    // Click the paste item in the right click menu.
                    $this->click($this->mouseMoveOffset(30, 80));

                    $this->_rightClickPasteDiv();

                    // Click the paste item in the right click menu.
                    $this->click($this->mouseMoveOffset(30, 80));
                break;

                case 'safari':
                    // Click the paste item in the right click menu.
                    $this->click($this->mouseMoveOffset(30, 100));

                    $this->_rightClickPasteDiv();

                    // Click the paste item in the right click menu.
                    $this->click($this->mouseMoveOffset(30, 40));
                break;

                case 'googlechrome':
                    // Google does not need the right click pop for pasting, just
                    // click the paste from the right click menu.
                    $this->click($this->mouseMoveOffset(30, 95));
                break;

                default:
                    throw new Exception('Right click testing for this browser has not been implemented');
                break;
            }//end switch
        }//end if

    }//end paste()


    /**
     * Finds the location of right click paste div and right clicks the paste frame.
     *
     * @return void
     */
    private function _rightClickPasteDiv()
    {
        $targetIcon = $this->find(dirname(__FILE__).'/Core/Images/window-target2.png');
        $topLeft    = $this->getTopLeft($targetIcon);
        $loc        = array(
                       'x' => ($this->getX($topLeft) + 50),
                       'y' => ($this->getY($topLeft) + 100),
                      );
        $this->rightClick($this->createLocation($loc['x'], $loc['y']));

    }//end _rightClickPasteDiv()


}//end class

?>
