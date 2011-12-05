<?php
require_once 'AbstractSikuliUnitTest.php';


/**
 * An abstract class that all Sikuli unit tests must extend.
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
     * Region object of the Viper Top toolbar.
     *
     * @var string
     */
    private static $_topToolbar = NULL;


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

        // Create a new Sikuli connection if its not connected already.
        parent::setUp();

        $baseDir   = dirname(__FILE__);
        $className = get_class($this);
        $paths     = explode('_', $className);
        array_shift($paths);
        array_shift($paths);

        // Find the HTML file for this test.
        $testFileContent = '';
        $count = count($paths);
        while ($count > 0) {
            $last     = array_pop($paths);
            $filePath = $baseDir.'/'.implode('/', $paths).'/'.$last.'.html';
            if (file_exists($filePath) === TRUE) {
                $testFileContent = trim(file_get_contents($filePath));
                break;
            } else if (count($paths) > 0) {
                // Check for HTML file that has the same name as the directory.
                $filePath = $baseDir.'/'.implode('/', $paths).'/'.$paths[(count($paths) - 1)].'.html';
                if (file_exists($filePath) === TRUE) {
                    $testFileContent = trim(file_get_contents($filePath));
                    break;
                }
            }

            $count = count($paths);
        }

        // Create the test file.
        if (self::$_testContent === NULL) {
            self::$_testContent = file_get_contents($baseDir.'/test.html');
        }

        // Put the current test file contents to the main test file.
        $contents = str_replace('__TEST_CONTENT__', $testFileContent, self::$_testContent);
        $dest     = $baseDir.'/test_tmp.html';
        file_put_contents($dest, $contents);

        // Change browser and then change the URL.
        if (self::$_testRun === TRUE) {
            $this->resizeWindow(1300, 800);
            $this->setDefaultRegion(self::$_window);
            // URL is already changed to the test runner, so just reload.
            $this->reloadPage();
        } else {
            $this->selectBrowser(self::$_browser);
            $this->resizeWindow(1300, 800);
            $this->goToURL($dest);
            self::$_testRun = TRUE;
        }

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
     * Resizes the browser window.
     *
     * @param integer $w The width of the window.
     * @param integer $h The height of the window.
     *
     * @return void
     */
    protected function resizeWindow($w, $h)
    {
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
     * Assert that given HTML string matches the test page's HTML.
     *
     * @param string $html The HTML string to compare.
     *
     * @return void
     */
    protected function assertHTMLMatch($html)
    {
        $pageHtml = $this->getHtml();
        $this->assertEquals($html, $pageHtml);

    }//end assertHTMLMatch()


    /**
     * Assert that given HTML string matches the test page's HTML.
     *
     * @param string $html The HTML string to compare.
     *
     * @return void
     */
    protected function assertHasHTML($html)
    {
        $pageHtml = $this->getHtml();
        $this->assertTrue(strpos($pageHtml, $html) !== FALSE);

    }//end assertHasHTML()


    /**
     * Changes the active application to the specified browser.
     *
     * @param string $browser The name of the browser.
     *
     * @return void
     */
    protected function selectBrowser($browser)
    {
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
        $toolbarPattern = $this->similar($toolbarPattern, 0.83);

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
        if (self::$_topToolbar === NULL) {
            return self::$_topToolbar;
        }

        // Find the toolbar pattern.
        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Core/Images/topToolbarPattern.png');
        $toolbarPattern = $this->similar($toolbarPattern, 0.83);
        $match          = $this->find($toolbarPattern, self::$_window);

        // Create a new region.
        // X is the start of the browser window.
        $x = $this->getX($this->getTopLeft(self::$_window));

        // Y is a few pixels above the found pattern.
        $y = ($this->getY($match) - 22);

        // Width is the width of the browser window.
        $w = $this->getW(self::$_window);

        // Height is about 50px.
        $h = 50;

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
        $pattern = $this->similar($pattern, 0.98);

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
        $pattern = $this->similar($pattern, 0.98);

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
     */
    protected function clickInlineToolbarButton($buttonIcon)
    {
        $toolbar = $this->getInlineToolbar();
        $match   = $this->find($buttonIcon, $toolbar);
        $this->click($match);

    }//end clickInlineToolbarButton()


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
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');

        $text = $this->getClipboard();
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
        if (empty($endWord) === TRUE || $startWord === $endWord) {
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
     * @param string $selector The jQuery selector to use for finding the element.
     *
     * @return string
     */
    protected function getHtml($selector=NULL)
    {
        if ($selector === NULL) {
            $text = $this->execJS('gHtml()');
        } else {
            $text = $this->execJS('gHtml("'.$selector.'")');
        }

        if (strpos($text, "u'") === 0) {
            $text = substr($text, 2, -1);
        }

        return $text;

    }//end getHtml()


}//end class

?>
