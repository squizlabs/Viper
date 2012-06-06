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
                                   'w' => 1300,
                                   'h' => 800,
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
     * The selenium session object.
     *
     * @var object
     */
    private static $_selenium = NULL;

    /**
     * If TRUE then Selenium session is being used.
     *
     * @var boolean
     */
    private static $_useSelenium = FALSE;

    /**
     * The Selenium PID.
     *
     * This is used to kill the Selenium process at the end of testing.
     *
     * @var integer
     */
    private static $_seleniumpid = NULL;

    /**
     * The active browser window.
     *
     * @var string
     */
    private static $_currentWindow = 'js';

    /**
     * Keeps cache of JS that is executed.
     *
     * @var array
     */
    private static $_jsExecCache = array();


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
        // Determine browser and OS.
        if (self::$_browser === NULL) {
            $browser = getenv('VIPER_TEST_BROWSER');
            if ($browser === FALSE) {
                throw new Exception('Invalid browser');
            }

            self::$_browser = $browser;

            if (getenv('VIPER_TEST_USE_SELENIUM') === 'TRUE') {
                self::$_useSelenium = TRUE;
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

        // Create a new Sikuli connection if its not connected already.
        parent::setUp();

        // Create the test file.
        if (self::$_testContent === NULL) {
            self::$_testContent = file_get_contents($baseDir.'/test.html');
        }

        // Get the JS exec cache.
        if (empty(self::$_jsExecCache) === TRUE) {
            $jsExecCacheFile = dirname(__FILE__).'/tmp/js_cache.inc';
            if (file_exists($jsExecCacheFile) === TRUE) {
                self::$_jsExecCache = unserialize(file_get_contents($jsExecCacheFile));
            }
        }

        // Put the current test file contents to the main test file.
        $contents = str_replace('__TEST_CONTENT__', $testFileContent, self::$_testContent);
        $contents = str_replace('__TEST_TITLE__', $this->getName(), $contents);
        $contents = str_replace('__TEST_JS_INCLUDE__', $jsInclude, $contents);
        $contents = str_replace('__TEST_JS_EXEC_CACHE__', json_encode(array_flip(self::$_jsExecCache)), $contents);
        $dest     = $baseDir.'/test_tmp.html';
        file_put_contents($dest, $contents);

        // Change browser and then change the URL.
        if (self::$_testRun === TRUE) {
            $this->_switchWindow('main');

            $this->resizeWindow();
            $this->setDefaultRegion(self::$_window);

            // URL is already changed to the test runner, so just reload.
            $this->setSetting('MinSimilarity', self::$_similarity);

            $this->setAutoWaitTimeout(1);
            $this->reloadPage();

            // Make sure page is loaded.
            $maxRetries = 4;
            while ($this->topToolbarButtonExists('bold') === FALSE) {
                $this->reloadPage();
                if ($maxRetries === 0) {
                    throw new Exception('Failed to load Viper test page.');
                }

                sleep(2);

                $maxRetries--;
            }
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

            sleep(1);
            $this->_switchWindow('main');

            // Make sure page is loaded.
            $maxRetries = 4;
            while ($this->topToolbarButtonExists('bold') === FALSE) {
                $this->reloadPage();
                if ($maxRetries === 0) {
                    throw new Exception('Failed to load Viper test page.');
                }

                sleep(2);

                $maxRetries--;
            }

            self::$_testRun = TRUE;

            $pageLoc = $this->getPageTopLeft();
            $this->setH(self::$_window, ($this->getH(self::$_window) - ($pageLoc['y'] - $this->getY(self::$_window))));
            $this->setX(self::$_window, $pageLoc['x']);
            $this->setY(self::$_window, $pageLoc['y']);
        }//end if

    }//end setUp()


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
        $this->_calibrateText();
        $this->_calibrateImage();

    }//end _calibrate()


    /**
     * Creates special text used by Viper.
     *
     * Creates the screenshots of the text
     *
     * @return void
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrateText()
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
        $this->goToURL($this->_getBaseUrl().'/calibrate-text.html');

        $texts = $this->execJS('getCoords('.json_encode($this->_getKeywordsList()).')');
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

        $tests = 5;
        for ($j = 1; $j <= $tests; $j++) {
            // Change the contents of the test page.
            $this->execJS('changeContent('.$j.')');

            // Test that captured images can be found on the page.
            for ($i = 1; $i <= $count; $i++) {
                $this->find($this->_getKeywordImage($i));
            }
        }

    }//end _calibrateText()


    /**
     * Returns list of available keywords that can be used in tests.
     *
     * @return array
     */
    private function _getKeywordsList()
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
        $keywords = $this->_getKeywordsList();
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
        $keywords = $this->_getKeywordsList();
        foreach ($keywords as $index => $keyword) {
            $content = str_replace('%'.($index + 1).'%', $keyword, $content);
        }

        return $content;

    }//end replaceKeywords()


    /**
     * Creates button images that are used in Viper for the current browser.
     *
     * @return void
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrateImage()
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

        $buttonCount = count($buttonNames);
        for ($i = 0; $i < $buttonCount; $i++) {
            if (($i % 20) === 0) {
                if ($buttonHTML !== '') {
                    $buttonHTML .= '</div>';
                }

                $buttonHTML .= '<div class="ViperTP-bar Viper-themeDark" style="position:relative">';
            }

            $buttonHTML .= '<div id="'.$buttonNames[$i].'" class="Viper-button Viper-'.$buttonNames[$i].'">';
            $buttonHTML .= '<span class="Viper-buttonIcon Viper-'.$buttonNames[$i].'"></span>&nbsp;</div>';
        }

        $buttonHTML .= '</div>';

        $calibrateHtml = file_get_contents($baseDir.'/calibrate.html');
        $calibrateHtml = str_replace('__TEST_CONTENT__', $buttonHTML, $calibrateHtml);

        file_put_contents($tmpFile, $calibrateHtml);

        $dest = $baseDir.'/tmp-calibrate.html';
        $this->goToURL($this->_getBaseUrl().'/tmo-calibrate.html');

        // Create image for the inline toolbar pattern (the arrow on top).
        sleep(2);
        $this->selectText('PyP');

        sleep(1);
        $vitp      = $this->execJS('getVITP()');
        $vitp['x'] = $this->getPageXRelativeToScreen($vitp['x']);
        $vitp['y'] = $this->getPageYRelativeToScreen($vitp['y']);

        $region    = $this->createRegion(($vitp['x'] - 12), ($vitp['y'] - 10), 27, 14);
        $vitpImage = $this->capture($region);
        copy($vitpImage, $imgPath.'/vitp_arrow.png');

        // Remove all Viper elements.
        $this->execJS('viper.destroy()');

        // Create image for the text field actions.
        $textFieldActionRevertRegion = $this->getRegionOnPage($this->execJS('dfx.getBoundingRectangle(dfx.getId("textboxActionRevert"))'));
        $textFieldActionRevertImage  = $this->capture($textFieldActionRevertRegion);
        copy($textFieldActionRevertImage, $imgPath.'/textField_action_revert.png');

        $textFieldActionClearRegion = $this->getRegionOnPage($this->execJS('dfx.getBoundingRectangle(dfx.getId("textboxActionClear"))'));
        $textFieldActionClearImage  = $this->capture($textFieldActionClearRegion);
        copy($textFieldActionClearImage, $imgPath.'/textField_action_clear.png');

        foreach ($statuses as $status => $className) {
            $btnRects = $this->execJS('getCoords("'.$status.'", "'.$className.'")');
            foreach ($btnRects as $buttonName => $rect) {
                $this->_createButtonImageFromRectangle($buttonName, $rect);
            }
        }

        $this->execJS('showAllBtns()');

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

        // Find each of the icons, if any fails it will throw an exception.
        $regions = array();
        foreach ($statuses as $status => $className) {
            foreach ($buttonNames as $buttonName) {
                if ($status !== '') {
                    $buttonName .= $status;
                }

                $testImage = $imgPath.'/'.$buttonName.'.png';
                $region    = $this->find($testImage);
                $loc       = $this->getX($region).'-'.$this->getY($region);
                if (isset($regions[$loc]) === TRUE) {
                    throw new Exception('Image match conflict between '.$regions[$loc].' and '.$buttonName);
                }

                $regions[$loc] = $buttonName;
            }
        }

        // Remove the temp calibrate file.
        unlink($tmpFile);

    }//end _calibrateImage()


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

        if (self::$_selenium !== NULL) {
            if (self::$_seleniumpid !== NULL) {
                exec('kill -KILL '.self::$_seleniumpid);
                self::$_seleniumpid = NULL;
            }
        }

    }//end tearDownAfterClass()


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

        self::$_windowSize = array(
                              'w' => $w,
                              'h' => $h,
                             );

        return self::$_windowSize;

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

        $this->getBrowserWindowSize();

    }//end resizeWindow()


    /**
     * Toggles between main window and the JS execution window.
     *
     * @param string $type The window to switch to. If not specified then it will
     * toggle to inactive window.
     *
     * @return void
     */
    private function _switchWindow($type=NULL)
    {
        if ($type === self::$_currentWindow) {
            return;
        }

        if (self::$_currentWindow === 'js') {
            self::$_currentWindow = 'main';
        } else {
            self::$_currentWindow = 'js';
        }

        $this->keyDown('Key.CMD + `');
        sleep(1);

    }//end _switchWindow()


    /**
     * Closes the JS exec window.
     *
     * @return void
     */
    public function closeJSWindow()
    {
        $this->execJS('cw();');
        self::$_currentWindow = 'main';

    }//end closeJSWindow()


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
     * @param string $html The HTML string to compare.
     *
     * @return void
     */
    protected function assertHTMLMatch($html)
    {
        $html = $this->replaceKeywords($html);

        $pageHtml = str_replace('\n', '', $this->getHtml());
        $html     = str_replace("\n", '', $html);

        if ($html !== $pageHtml) {
            $pageHtml = $this->_orderTagAttributes($pageHtml);
            $html     = $this->_orderTagAttributes($html);
        }

        $this->assertEquals($html, $pageHtml);

    }//end assertHTMLMatch()


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
                            preg_match_all('/(\w+)\s*:\s*[^:]+;/i', $attrVal, $vals);
                            asort($vals[1]);
                            $match .= ' '.$attrs[1][$attrIndex].'="';
                            foreach ($vals[1] as $valIndex => $value) {
                                $match .= $vals[0][$valIndex].' ';
                            }

                            $match  = rtrim($match);
                            $match .= '"';
                        } else {
                            $match .= $attrs[0][$attrIndex];
                        }
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
     * Changes the active application to the specified browser.
     *
     * @param string $browser The name of the browser.
     *
     * @return void
     */
    protected function selectBrowser($browser)
    {
        if (self::$_useSelenium === TRUE) {
            if (self::$_selenium === NULL) {
                $seleniumPath = dirname(__FILE__).'/Selenium';

                include_once $seleniumPath.'/selenium_webdriver/__init__.php';

                $seleniumCmd = 'java -jar '.$seleniumPath.'/selenium-server-standalone-2.21.0.jar';

                $browser = strtolower($browser);
                if ($browser === 'google chrome') {
                    $browser      = 'chrome';
                    $seleniumCmd .= ' -Dwebdriver.chrome.driver='.$seleniumPath.'/chromedriver';
                }

                $seleniumCmd .= ' > /dev/null & echo $!';

                self::$_seleniumpid = shell_exec($seleniumCmd);
                sleep(10);

                $webDriver       = new WebDriver();
                $session         = $webDriver->session($browser);
                self::$_selenium = $session;
                sleep(2);

                if ($browser === 'chrome') {
                    // Focus Chrome window (TODO: Find another way).
                    $this->keyDown('Key.SHIFT + Key.CMD + Key.TAB');
                }

                self::$_browserSelected = TRUE;
                return;
            }//end if
        } else if (self::$_browserSelected === FALSE) {
            if ($browser === 'Firefox') {
                $browser = '/Applications/Firefox.app';
            }

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
        }//end if

        self::$_window = $this->callFunc('App.focusedWindow', array(), NULL, TRUE);

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
     * Returns the match object variable of the inline toolbar.
     *
     * @return string
     */
    protected function getInlineToolbar()
    {
        $match = $this->find($this->getBrowserImagePath().'/vitp_arrow.png', self::$_window, 0.85);
        $this->setX($match, ($this->getX($match) - 200));
        $this->setW($match, ($this->getW($match) + 400));
        $this->setH($match, ($this->getH($match) + 200));

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
            try {
                $this->find($button, $this->getInlineToolbar(), 0.9);
            } catch (Exception $e) {
                return FALSE;
            }
        }

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
            try {
                $this->find($button, $this->getTopToolbar(), 0.9);
            } catch (Exception $e) {
                return FALSE;
            }
        }

        return TRUE;

    }//end topToolbarButtonExists()


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
    protected function clickTopToolbarButton($buttonIcon, $state=NULL, $isText=FALSE)
    {
        $this->_clickButton($buttonIcon, $state, $isText, 'topToolbar');

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
     *
     * @return void
     */
    private function _clickButton($buttonIcon, $state=NULL, $isText=FALSE, $location=NULL)
    {
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
            // Its harder for Sikuli to match a text button so use lower similarity.
            try {
                $match = $this->find($buttonObj, $region, 0.7);
            } catch (Exception $e) {
                // Try to find it again without the image.
                $rect  = $this->_getTextButtonRectangle($buttonIcon, $state, $location);
                $match = $this->getRegionOnPage($rect);
            }
        } else {
            $match = $this->find($buttonObj, $region, 0.9);
        }

        $this->click($match);

        // Move the mouse pointer away from the button so that its tooltip does not
        // cause issues.
        $this->mouseMove($this->createLocation($this->getX($match), $this->getY($match)));

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
     * Returns the accesskey combination depending on OS and browser.
     *
     * @param string $key The key to include in the combination.
     *
     * @return string
     */
    private function _getAccessKeys($key)
    {
        $os   = $this->getOS();
        $keys = '';
        switch (self::$_browser) {
            case 'Safari':
            case 'Google Chrome':
                if ($os === 'osx') {
                    $keys = 'Key.CTRL + Key.ALT';
                } else {
                    $keys = 'Key.ALT';
                }
            break;

            default:
                if ($os === 'windows') {
                    $keys = 'Key.ALT';
                } else {
                    $keys = 'Key.CTRL';
                }
            break;
        }//end switch

        $keys .= ' + '.$key;

        return $keys;

    }//end _getAccessKeys()


    /**
     * Executes the specified JavaScript and returns its result.
     *
     * @param string $js The JavaScript to execute.
     *
     * @return string
     */
    protected function execJS($js)
    {
        // If Selenium is being used then use it to execute the JavaScript.
        if (self::$_useSelenium === TRUE) {
            usleep(100000);
            $result = self::$_selenium->execute(
                array(
                 'script' => 'return dfx.jsonEncode(window.'.$js.');',
                 'args'   => array(),
                )
            );

            $result = json_decode($result, TRUE);

            return $result;
        }//end if

        $this->_switchWindow('js');

        usleep(50000);
        $this->keyDown($this->_getAccessKeys('j'));

        if (isset(self::$_jsExecCache[$js]) === TRUE) {
            $this->type(self::$_jsExecCache[$js]);
        } else {
            $this->type($js);
            self::$_jsExecCache[$js] = count(self::$_jsExecCache);

            file_put_contents(dirname(__FILE__).'/tmp/js_cache.inc', serialize(self::$_jsExecCache));
        }

        usleep(50000);
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.CMD + a');
        usleep(50000);
        $this->keyDown('Key.CMD + c');
        usleep(50000);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SPACE');
        usleep(50000);

        $this->_switchWindow('main');

        $text = $this->getClipboard();
        if (strpos($text, "u'") === 0) {
            $text = substr($text, 2, -1);
        }

        $text = str_replace("\n", '\n', $text);
        $text = str_replace('\\\\"', '\\"', $text);
        $text = str_replace('\xa0', ' ', $text);

        $text = json_decode($text, TRUE);

        return $text;

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
     */
    protected function selectKeyword($startKeyword, $endKeyword=NULL)
    {
        $startKeywordImage = $this->_getKeywordImage($startKeyword);

        if ($endKeyword === NULL) {
            $this->doubleClick($this->find($startKeywordImage));
            return;
        }

        $endKeywordImage = $this->_getKeywordImage($endKeyword);

        $start = $this->find($startKeywordImage);
        $end   = $this->find($endKeywordImage);

        $this->click($start);

        $startLeft = $this->getTopLeft($start);
        $endRight  = $this->getTopRight($end);

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

    }//end selectKeyword()


    /**
     * Returns the region for the specified keyword.
     *
     * @param integer $keyword The keyword to find.
     *
     * @return object
     */
    protected function findKeyword($keyword)
    {
        return $this->find($this->_getKeywordImage($keyword));

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
        $fieldLabel   = $this->find($this->_getLabel($label), NULL, 0.7);
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
        $fieldLabel   = $this->find($this->_getLabel($label), NULL, 0.7);
        $fieldRegion  = $this->extendRight($fieldLabel, 400);
        $actionImage  = $this->getBrowserImagePath().'/textField_action_revert.png';
        $actionButton = $this->find($actionImage, $fieldRegion);

    }//end revertFieldValue()


    /**
     * Returns the label image for the specified label element.
     *
     * @param string $label The label of a field.
     *
     * @return string
     */
    private function _getLabel($label)
    {
        $labelImg  = preg_replace('#\W#', '_', $label);
        $imagePath = $this->getBrowserImagePath().'/label_'.$labelImg.'.png';

        if (file_exists($imagePath) === FALSE) {
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
     * Returns the HTML of the test page.
     *
     * @param string  $selector The jQuery selector to use for finding the element.
     * @param integer $index    The element index of the resulting array.
     *
     * @return string
     */
    protected function getHtml($selector=NULL, $index=0)
    {
        if ($selector === NULL) {
            $text = $this->execJS('gHtml()');
        } else {
            $text = $this->execJS('gHtml("'.$selector.'", '.$index.')');
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
     * @param string  $selector The jQuery selector to use for finding the element.
     * @param integer $index    The element index of the resulting array.
     *
     * @return void
     */
    protected function clickElement($selector, $index)
    {
        $elemRect = $this->getBoundingRectangle($selector, $index);
        $region   = $this->getRegionOnPage($elemRect);

        // Click the element.
        $this->click($region);

    }//end clickElement()


}//end class

?>
