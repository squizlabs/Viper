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
    private static $_similarity = NULL;


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
            $this->resizeWindow();
            $this->setDefaultRegion(self::$_window);

            // URL is already changed to the test runner, so just reload.
            $this->reloadPage();
        } else {
            $this->selectBrowser(self::$_browser);
            $this->resizeWindow();

            $similarity = getenv('VIPER_TEST_SIMILARITY');
            if (is_numeric($similarity) === TRUE) {
                self::$_similarity = (float) $similarity;
            } else {
                try {
                    $this->_calibrate();
                } catch (Exception $e) {
                    echo $e;
                    exit;
                }
            }

            $this->goToURL($dest);
            self::$_testRun = TRUE;
        }//end if

    }//end setUp()


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
     * @throws Exception If it fails to calibrate.
     */
    private function _calibrate()
    {
        // Calibrate image recognition.
        $baseDir = dirname(__FILE__);
        $dest    = $baseDir.'/calibrate.html';
        self::goToURL($dest);

        $this->selectText('TpT');
        sleep(1);
        $this->setAutoWaitTimeout(0.5);

        $similarity = NULL;
        for ($i = 0.99; $i >= 0; $i -= 0.01) {
            try {
                $f = $this->find($baseDir.'/Core/Images/vitpPattern.png', NULL, $i);
            } catch (Exception $e) {
                continue;
            }

            $similarity = $i;
            break;
        }

        for ($i = $similarity; $i >= 0; $i -= 0.01) {
            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate2.png', NULL, $i);
            } catch (Exception $e) {
                continue;
            }

            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate1.png', NULL, $i);
            } catch (Exception $e) {
                $similarity = $i;
                break;
            }

            throw new Exception('Failed to calibrate.');
        }

        $this->keyDown('Key.DOWN');
        sleep(2);

        for ($i = $similarity; $i >= 0; $i -= 0.01) {
            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate2.png', NULL, $i);
            } catch (Exception $e) {
                continue;
            }

            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate1.png', NULL, $i);
            } catch (Exception $e) {
                $similarity = $i;
                break;
            }

            throw new Exception('Failed to calibrate.');
        }

        $this->keyDown('Key.UP');
        $this->keyDown('Key.UP');
        sleep(1);

        for ($i = $similarity; $i >= 0; $i -= 0.01) {
            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate1.png', NULL, $i);
            } catch (Exception $e) {
                continue;
            }

            try {
                $f = $this->find($baseDir.'/Core/Images/calibrate2.png', NULL, $i);
            } catch (Exception $e) {
                $similarity = $i;
                break;
            }

            throw new Exception('Failed to calibrate.');
        }

        $this->find($baseDir.'/Core/Images/calibrate1.png', NULL, $similarity);
        $this->keyDown('Key.DOWN');
        sleep(2);
        $this->find($baseDir.'/Core/Images/calibrate2.png', NULL, $similarity);
        $this->find($baseDir.'/Core/Images/topToolbarPattern.png', NULL, $similarity);

        $this->setAutoWaitTimeout(2);

        $this->keyDown('Key.UP');

        $this->selectText('TpT');
        $this->find($baseDir.'/Core/Images/vitpPattern.png', NULL, $similarity);

        self::$_similarity = $similarity;

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
        $newLocation = $this->createLocation(
            ($this->getX($window) + $w),
            ($this->getY($window) + $h)
        );

        $this->dragDrop($bottomRight, $newLocation);

        // Update the self::$_window object.
        $this->selectBrowser($this->getBrowserName());

        $size = $this->getBrowserWindowSize();

    }//end resizeWindow()


    /**
     * Returns the location of the page relative to the screen.
     *
     * @return array
     */
    protected function getPageTopLeft()
    {
        $targetIcon = $this->find(dirname(__FILE__).'/Core/Images/window-target.png');
        $topLeft    = $this->getTopLeft($targetIcon);
        $loc        = array(
                       'x' => $this->getX($topLeft),
                       'y' => $this->getY($topLeft),
                      );

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

        $app       = $this->switchApp($browser);
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

        $this->setDefaultRegion(self::$_window);

    }//end selectBrowser()


    /**
     * Returns the match object variable of the inline toolbar.
     *
     * @return string
     */
    protected function getInlineToolbar()
    {
        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Core/Images/vitpPattern.png');
        $toolbarPattern = $this->similar($toolbarPattern, self::$_similarity);

        $match = $this->find($toolbarPattern, self::$_window);
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
     * @param string $buttonIcon Path to the image file.
     *
     * @return boolean
     */
    protected function inlineToolbarButtonExists($buttonIcon)
    {
        $toolbar = $this->getInlineToolbar();

        $pattern = $this->createPattern($buttonIcon);
        $pattern = $this->similar($pattern, self::$_similarity);

        return $this->exists($pattern, $toolbar);

    }//end inlineToolbarButtonExists()


    /**
     * Returns TRUE if the specified button icon exists in the Toolbar.
     *
     * @param string $buttonIcon Path to the image file.
     *
     * @return boolean
     */
    protected function topToolbarButtonExists($buttonIcon)
    {
        $toolbar = $this->getTopToolbar();

        $pattern = $this->createPattern($buttonIcon);
        $pattern = $this->similar($pattern, self::$_similarity);

        return $this->exists($pattern, $toolbar);

    }//end topToolbarButtonExists()


    /**
     * Clicks the specified button icon in the Inline Toolbar.
     *
     * @param string $buttonIcon Path to the image file.
     *
     * @return void
     */
    protected function clickTopToolbarButton($buttonIcon)
    {
        $toolbar = $this->getTopToolbar();
        $match   = $this->find($buttonIcon, $toolbar);
        $this->click($match);

    }//end clickTopToolbarButton()


    /**
     * Clicks the specified button icon in the Inline Toolbar.
     *
     * @param string $buttonIcon Path to the image file.
     *
     * @return void
     * @throws Exception If the specified icon file not found.
     */
    protected function clickInlineToolbarButton($buttonIcon)
    {
        if (file_exists($buttonIcon) === FALSE) {
            throw new Exception('File not found: '.$buttonIcon);
        }

        $toolbar = $this->getInlineToolbar();
        $match   = $this->find($buttonIcon, $toolbar);
        $this->click($match);

    }//end clickInlineToolbarButton()


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
        $this->keyDown('Key.ENTER');
        sleep(1);
        $this->keyDown($this->_getAccessKeys('r'));
        usleep(500);
        $this->keyDown('Key.CMD + a');
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
     * @return string
     */
    protected function clickElement($selector, $index)
    {
       $elemRect = $this->getBoundingRectangle($selector, $index);
       $region     = $this->getRegionOnPage($elemRect);

       // Click the element.
       $this->click($region);

    }//end clickElement()

}//end class

?>
