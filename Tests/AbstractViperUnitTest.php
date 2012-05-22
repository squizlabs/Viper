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
    private static $_similarity = 0.95;

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
        }//end if

        $baseDir = dirname(__FILE__);

        // Get the test HTML file.
        $htmlFilePath    = $this->_getTestFile('html');
        $testFileContent = '';
        if ($htmlFilePath !== NULL) {
            $testFileContent = trim(file_get_contents($htmlFilePath));
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

        // Put the current test file contents to the main test file.
        $contents = str_replace('__TEST_CONTENT__', $testFileContent, self::$_testContent);
        $contents = str_replace('__TEST_TITLE__', $this->getName(), $contents);
        $contents = str_replace('__TEST_JS_INCLUDE__', $jsInclude, $contents);
        $dest     = $baseDir.'/test_tmp.html';
        file_put_contents($dest, $contents);

        // Change browser and then change the URL.
        if (self::$_testRun === TRUE) {
            $this->setAutoWaitTimeout(1);
            $this->resizeWindow();
            $this->setDefaultRegion(self::$_window);

            // URL is already changed to the test runner, so just reload.
            $this->reloadPage();
        } else {
            $this->selectBrowser(self::$_browser);
            $this->resizeWindow();

            $calibrate = getenv('VIPER_TEST_CALIBRATE');
            if ($calibrate === 'TRUE' || file_exists($this->getBrowserImagePath()) === FALSE) {
                try {
                    $this->_calibrate();
                } catch (Exception $e) {
                    echo $e;
                    exit;
                }
            }

            $this->setAutoWaitTimeout(1);
            $this->goToURL($dest);
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
        self::goToURL($dest);

        // Create image for the inline toolbar pattern (the arrow on top).
        $this->selectText('PyP');

        usleep(500);
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

        // Find each of the icons, if any fails it will throw an exception.
        foreach ($buttonNames as $buttonName) {
            $testImage = $imgPath.'/'.$buttonName.'.png';
            $this->find($testImage);
        }

        // Remove the temp calibrate file.
        unlink($tmpFile);

    }//end _calibrate()


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
     * @param string $html          The HTML string to compare.
     * @param string $alternateHtml An alternate HTML incase the first argument does
     *                              not match. This can be used to provide a similar
     *                              HTML for different browsers
     *                              (e.g. order of attributes in different browsers).
     *
     * @return void
     */
    protected function assertHTMLMatch($html, $alternateHtml=NULL)
    {
        $pageHtml = str_replace('\n', '', $this->getHtml());
        $html     = str_replace("\n", '', $html);

        if ($html !== $pageHtml) {
            if ($alternateHtml === NULL) {
                $this->assertEquals($html, $pageHtml);
            } else {
                $this->assertEquals($alternateHtml, $pageHtml);
            }
        } else {
            $this->assertEquals($html, $pageHtml);
        }

    }//end assertHTMLMatch()


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
        if ($browser === 'Firefox') {
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
            }
        }

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

        // Find the toolbar pattern.
        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Core/Images/topToolbarPattern.png');
        $toolbarPattern = $this->similar($toolbarPattern, self::$_similarity);
        $match          = $this->find($toolbarPattern, self::$_window);

        // Create a new region.
        // X is the start of the browser window.
        $x = $this->getX($this->getTopLeft(self::$_window));

        // Y is a few pixels above the found pattern.
        $y = ($this->getY($match) - 22);

        // Width is the width of the browser window.
        $w = $this->getW(self::$_window);

        // Height is about 50px.
        $h = 180;

        // Create the region object.
        $region = $this->createRegion($x, $y, $w, $h);

        self::$_topToolbar = $region;

        return $region;

    }//end getTopToolbar()


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
        $button  = $this->_getButton($buttonIcon, $state, $isText);
        $toolbar = $this->getInlineToolbar();

        return $this->exists($button, $toolbar);

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
        $button  = $this->_getButton($buttonIcon, $state, $isText);
        $toolbar = $this->getTopToolbar();

        return $this->exists($button, $toolbar);

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
     * Clicks the specified  button on the page.
     *
     * @param string  $buttonIcon The name of the button.
     * @param string  $state      The name of the button state (active, selected).
     * @param boolean $isText     If TRUE then the button is a text button (i.e. no icon).
     * @param string  $location   The location of the button (topToolbar, inlineToolbar, etc.).
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
        }

        $match = $this->find($buttonObj, $region);
        $this->click($match);

        // Move the mouse pointer away from the button so that its tooltip does not
        // cause issues.
        $this->mouseMove($this->createLocation($this->getX($match), $this->getY($match)));

    }//end _clickButton()


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
                $jsFn = 'gBtn';

                if ($location === 'topToolbar') {
                    $jsFn = 'gTPBtn';
                } else if ($location === 'inlineToolbar') {
                    $jsFn = 'gITPBtn';
                }

                if ($state !== NULL) {
                    $rect = $this->execJS($jsFn.'("'.$buttonIcon.'", "'.$state.'")');
                } else {
                    $rect = $this->execJS($jsFn.'("'.$buttonIcon.'")');
                }

                if (is_array($rect) === FALSE) {
                    throw new Exception('Could not find button with text: '.$buttonIcon);
                }

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
        $button      = preg_replace('#[^a-zA-Z0-9_-]#', '_', $button);
        $buttonImage = $this->capture($this->getRegionOnPage($rect));
        $filePath    = $this->getBrowserImagePath().'/'.$button;

        if ($state !== NULL) {
            $filePath .= '_'.$state;
        }

        $filePath .= '.png';
        copy($buttonImage, $filePath);

        return $filePath;

    }//end _createButtonImageFromRectangle()


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
        $this->keyDown($this->_getAccessKeys('j'));
        $this->type($js);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SPACE');
        sleep(1);
        $this->keyDown($this->_getAccessKeys('r'));
        usleep(500);
        $this->keyDown('Key.CMD + a');
        sleep(1);
        $this->keyDown('Key.CMD + c');

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
     * Clicks the field with specified label.
     *
     * @param string $label The label of the field.
     *
     * @return void
     */
    protected function clickField($label)
    {
        $this->click($this->_getLabel($label));

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
        $fieldLabel   = $this->find($this->_getLabel($label));
        $fieldRegion  = $this->extendRight($fieldLabel, 400);
        $actionImage  = $this->getBrowserImagePath().'/textField_action_clear.png';
        $actionButton = $this->find($actionImage, $fieldRegion);

        $this->click($actionButton);

        //$rect       = $this->execJS('gField("'.$label.'")');
        //$rect['x1'] = ($rect['x2'] - 12);

        //$this->click($this->getRegionOnPage($rect));

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
        $fieldLabel   = $this->find($this->_getLabel($label));
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
     * Reloads the page.
     *
     * @return void
     */
    protected function reloadPage()
    {
        $this->keyDown('Key.CMD + r');
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
