<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_WordTableExamplesUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the WordTableExamples works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testWordTableExamplesForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordTableExamples.txt'));

    }//end testWordTableExamplesForOSXFirefox()


	/**
     * Test that copying/pasting from the WordTableExamples works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testWordTableExamplesForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordTableExamples.txt'));

    }//end testWordTableExamplesForOSXChrome()


	/**
     * Test that copying/pasting from the WordTableExamples works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testWordTableExamplesForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordTableExamples.txt'));

    }//end testWordTableExamplesForOSXSafari()
 

  	/**
     * Test that copying/pasting from the WordTableExamples works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the WordTableExamples works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsChrome()

	/**
     * Test that copying/pasting from the WordTableExamples works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsIE8()


	/**
     * Test that copying/pasting from the WordTableExamples works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsIE9()


	/**
     * Test that copying/pasting from the WordTableExamples works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsIE10()

	/**
     * Test that copying/pasting from the WordTableExamples works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testWordTableExamplesForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordTableExamples.txt'));

    }//end testWordTableExamplesForWindowsIE11()


 	/**
     * Run the test for the WordTableExamples document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<h1>Built in Word 2010 Table Templates Test</h1><p>These are from Insert &gt; Table &gt; Quick Tables &gt; &hellip;</p><h2>Calendar 1 (No Header Row Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td colspan="7"><p><strong>December</strong></p></td></tr><tr><td><p>M</p></td><td><p>T</p></td><td><p>W</p></td><td><p>T</p></td><td><p>F</p></td><td><p>S</p></td><td><p>S</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td><p>1</p></td></tr><tr><td><p>2</p></td><td><p>3</p></td><td><p>4</p></td><td><p>5</p></td><td><p>6</p></td><td><p>7</p></td><td><p>8</p></td></tr><tr><td><p>9</p></td><td><p>10</p></td><td><p>11</p></td><td><p>12</p></td><td><p>13</p></td><td><p>14</p></td><td><p>15</p></td></tr><tr><td><p>16</p></td><td><p>17</p></td><td><p>18</p></td><td><p>19</p></td><td><p>20</p></td><td><p>21</p></td><td><p>22</p></td></tr><tr><td><p>23</p></td><td><p>24</p></td><td><p>25</p></td><td><p>26</p></td><td><p>27</p></td><td><p>28</p></td><td><p>29</p></td></tr><tr><td><p>30</p></td><td><p>31</p></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p><strong></strong></p><h2>Calendar 2 (Top Two Rows Set as Headers)</h2><table border="1" style="width: 100%;"><thead><tr><th colspan="7"><p>May</p></th></tr><tr><th><p>M</p></th><th><p>T</p></th><th><p>W</p></th><th><p>T</p></th><th><p>F</p></th><th><p>S</p></th><th><p>S</p></th></tr></thead><tbody><tr><td></td><td><p>1</p></td><td><p>2</p></td><td><p>3</p></td><td><p>4</p></td><td><p>5</p></td><td><p>6</p></td></tr><tr><td><p>7</p></td><td><p>8</p></td><td><p>9</p></td><td><p>10</p></td><td><p>11</p></td><td><p>12</p></td><td><p>13</p></td></tr><tr><td><p>14</p></td><td><p>15</p></td><td><p>16</p></td><td><p>17</p></td><td><p>18</p></td><td><p>19</p></td><td><p>20</p></td></tr><tr><td><p>21</p></td><td><p>22</p></td><td><p>23</p></td><td><p>24</p></td><td><p>25</p></td><td><p>26</p></td><td><p>27</p></td></tr><tr><td><p>28</p></td><td><p>29</p></td><td><p>30</p></td><td><p>31</p></td><td></td><td></td><td></td></tr></tbody></table><p><strong></strong></p><h2>Calendar 3 (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td colspan="13"><p>December</p></td><td></td></tr><tr><td><p>Sun</p></td><td></td><td><p>Mon</p></td><td></td><td><p>Tue</p></td><td></td><td><p>Wed</p></td><td></td><td><p>Thu</p></td><td></td><td><p>Fri</p></td><td></td><td colspan="2"><p>Sat</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"><p>1</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>2</p></td><td></td><td><p>3</p></td><td></td><td><p>4</p></td><td></td><td><p>5</p></td><td></td><td><p>6</p></td><td></td><td><p>7</p></td><td></td><td colspan="2"><p>8</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>9</p></td><td></td><td><p>10</p></td><td></td><td><p>11</p></td><td></td><td><p>12</p></td><td></td><td><p>13</p></td><td></td><td><p>14</p></td><td></td><td colspan="2"><p>15</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>16</p></td><td></td><td><p>17</p></td><td></td><td><p>18</p></td><td></td><td><p>19</p></td><td></td><td><p>20</p></td><td></td><td><p>21</p></td><td></td><td colspan="2"><p>22</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>23</p></td><td></td><td><p>24</p></td><td></td><td><p>25</p></td><td></td><td><p>26</p></td><td></td><td><p>27</p></td><td></td><td><p>28</p></td><td></td><td colspan="2"><p>29</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>30</p></td><td></td><td><p>31</p></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><br /><p><strong></strong></p><h2>Calendar 4 (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p><strong></strong></p></td><td><p><strong></strong></p></td><td><p><strong></strong></p></td></tr><tr><td rowspan="32"><p><strong>May </strong></p></td><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>1</strong></p></td><td><p><strong>16</strong></p></td></tr><tr><td><p><strong>Wednesday</strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong>2</strong></p></td><td><p><strong>17</strong></p></td></tr><tr><td><p><strong>Thursday</strong></p></td><td><p><strong>Friday</strong></p></td></tr><tr><td><p><strong>3</strong></p></td><td><p><strong>18</strong></p></td></tr><tr><td><p><strong>Friday</strong></p></td><td><p><strong>Saturday</strong></p></td></tr><tr><td><p><strong>4</strong></p></td><td><p><strong>19</strong></p></td></tr><tr><td><p><strong>Saturday</strong></p></td><td><p><strong>Sunday</strong></p></td></tr><tr><td><p><strong>5</strong></p></td><td><p><strong>20</strong></p></td></tr><tr><td><p><strong>Sunday</strong></p></td><td><p><strong>Monday</strong></p></td></tr><tr><td><p><strong>6</strong></p></td><td><p><strong>21</strong></p></td></tr><tr><td><p><strong>Monday</strong></p></td><td><p><strong>Tuesday</strong></p></td></tr><tr><td><p><strong>7</strong></p></td><td><p><strong>22</strong></p></td></tr><tr><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>8</strong></p></td><td><p><strong>23</strong></p></td></tr><tr><td><p><strong>Wednesday</strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong>9</strong></p></td><td><p><strong>24</strong></p></td></tr><tr><td><p><strong>Thursday</strong></p></td><td><p><strong>Friday</strong></p></td></tr><tr><td><p><strong>10</strong></p></td><td><p><strong>25</strong></p></td></tr><tr><td><p><strong>Friday</strong></p></td><td><p><strong>Saturday</strong></p></td></tr><tr><td><p><strong>11</strong></p></td><td><p><strong>26</strong></p></td></tr><tr><td><p><strong>Saturday</strong></p></td><td><p><strong>Sunday</strong></p></td></tr><tr><td><p><strong>12</strong></p></td><td><p><strong>27</strong></p></td></tr><tr><td><p><strong>Sunday</strong></p></td><td><p><strong>Monday</strong></p></td></tr><tr><td><p><strong>13</strong></p></td><td><p><strong>28</strong></p></td></tr><tr><td><p><strong>Monday</strong></p></td><td><p><strong>Tuesday</strong></p></td></tr><tr><td><p><strong>14</strong></p></td><td><p><strong>29</strong></p></td></tr><tr><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>15</strong></p></td><td><p><strong>30</strong></p></td></tr><tr><td><p><strong></strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong></strong></p></td><td><p><strong>31</strong></p></td></tr></tbody></table><br /><p><strong></strong></p><h2>Matrix (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p>City or Town</p></td><td><p>Point A</p></td><td><p>Point B</p></td><td><p>Point C</p></td><td><p>Point D</p></td><td><p>Point E</p></td></tr><tr><td><p>Point A</p></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td><p>Point B</p></td><td><p>87</p></td><td></td><td></td><td></td><td></td></tr><tr><td><p>Point C</p></td><td><p>64</p></td><td><p>56</p></td><td></td><td></td><td></td></tr><tr><td><p>Point D</p></td><td><p>37</p></td><td><p>32</p></td><td><p>91</p></td><td></td><td></td></tr><tr><td><p>Point E</p></td><td><p>93</p></td><td><p>35</p></td><td><p>54</p></td><td><p>43</p></td><td></td></tr></tbody></table><h2>Tabular List (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>ITEM</strong></p></td><td><p><strong>NEEDED</strong></p></td></tr><tr><td><p>Books</p></td><td><p>1</p></td></tr><tr><td><p>Magazines</p></td><td><p>3</p></td></tr><tr><td><p>Notebooks</p></td><td><p>1</p></td></tr><tr><td><p>Paper pads</p></td><td><p>1</p></td></tr><tr><td><p>Pens</p></td><td><p>3</p></td></tr><tr><td><p>Pencils</p></td><td><p>2</p></td></tr><tr><td><p>Highlighter</p></td><td><p>2 colors</p></td></tr><tr><td><p>Scissors</p></td><td><p>1 pair</p></td></tr></tbody></table><p><strong></strong></p><h2>With Subheads 1 (No Header Rows Set)</h2><p>Enrollment in local colleges, 2005</p><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>College</strong></p></td><td><p><strong>New   students</strong></p></td><td><p><strong>Graduating   students</strong></p></td><td><p><strong>Change</strong></p></td></tr><tr><td></td><td><p>Undergraduate</p></td><td></td><td></td></tr><tr><td><p>Cedar University</p></td><td><p>110</p></td><td><p>103</p></td><td><p>+7</p></td></tr><tr><td><p>Elm College</p></td><td><p>223</p></td><td><p>214</p></td><td><p>+9</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>197</p></td><td><p>120</p></td><td><p>+77</p></td></tr><tr><td><p>Pine College</p></td><td><p>134</p></td><td><p>121</p></td><td><p>+13</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>202</p></td><td><p>210</p></td><td><p>-8</p></td></tr><tr><td></td><td><p>Graduate</p></td><td></td><td></td></tr><tr><td><p>Cedar University</p></td><td><p>24</p></td><td><p>20</p></td><td><p>+4</p></td></tr><tr><td><p>Elm College</p></td><td><p>43</p></td><td><p>53</p></td><td><p>-10</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>3</p></td><td><p>11</p></td><td><p>-8</p></td></tr><tr><td><p>Pine College</p></td><td><p>9</p></td><td><p>4</p></td><td><p>+5</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>53</p></td><td><p>52</p></td><td><p>+1</p></td></tr><tr><td><p><strong>Total</strong></p></td><td><p><strong>998</strong></p></td><td><p><strong>908</strong></p></td><td><p><strong>90</strong></p></td></tr></tbody></table><p>Source: Fictitious data, for illustration purposes only</p><p><strong></strong></p><h2>With Subheads 2 (No Header Rows Set)</h2><p>Enrollment in local colleges, 2005</p><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>College</strong></p></td><td><p><strong>New students</strong></p></td><td><p><strong>Graduating students</strong></p></td><td><p><strong>Change</strong></p></td></tr><tr><td></td><td><p>Undergraduate</p></td><td></td><td></td></tr><tr><td><p>Cedar   University</p></td><td><p>110</p></td><td><p>103</p></td><td><p>+7</p></td></tr><tr><td><p>Elm College</p></td><td><p>223</p></td><td><p>214</p></td><td><p>+9</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>197</p></td><td><p>120</p></td><td><p>+77</p></td></tr><tr><td><p>Pine College</p></td><td><p>134</p></td><td><p>121</p></td><td><p>+13</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>202</p></td><td><p>210</p></td><td><p>-8</p></td></tr><tr><td></td><td><p>Graduate</p></td><td></td><td></td></tr><tr><td><p>Cedar   University</p></td><td><p>24</p></td><td><p>20</p></td><td><p>+4</p></td></tr><tr><td><p>Elm College</p></td><td><p>43</p></td><td><p>53</p></td><td><p>-10</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>3</p></td><td><p>11</p></td><td><p>-8</p></td></tr><tr><td><p>Pine College</p></td><td><p>9</p></td><td><p>4</p></td><td><p>+5</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>53</p></td><td><p>52</p></td><td><p>+1</p></td></tr><tr><td><p>Total</p></td><td><p>998</p></td><td><p>908</p></td><td><p>90</p></td></tr></tbody></table><p>Source: Fictitious data, for illustration purposes only</p><h2>Custom Table 1 (Row One as Header Row)</h2><table border="1" style="width: 100%;"><thead><tr><th><p>Heading One</p></th><th><p>Heading Two</p></th><th><p>Heading Three</p></th><th><p>Heading Four</p></th><th><p>Heading Five</p></th></tr></thead><tbody><tr><td><p>Col One, Row Two</p></td><td><p>Col Two, Row Two</p></td><td><p>Col Three, Row Two</p></td><td><p>Col Four, Row Two</p></td><td><p>Col Five, Row Two</p></td></tr><tr><td><p>Col One, Row Three</p></td><td><p>Col Two, Row Three</p></td><td><p>Col Three, Row Three</p></td><td><p>Col Four, Row Three</p></td><td><p>Col Five, Row Three</p></td></tr></tbody></table><h2>Custom Table 2 (Multiple Row Headers)</h2><p>Test special characters and symbols from Word &gt; Insert &gt; Symbols &gt; Special Characters.</p><table border="1" style="width: 100%;"><thead><tr><th colspan="4"><p>Special Characters (Including Smart Quotes)</p></th></tr><tr><th><p>Name</p></th><th><p>Character</p></th><th><p>Name</p></th><th><p>Character</p></th></tr></thead><tbody><tr><td><p>Em dash</p></td><td></td><td><p>En dash</p></td><td></td></tr><tr><td><p>Non breaking hyphen</p></td><td></td><td><p>Optional hyphen</p></td><td></td></tr><tr><td><p>Em space</p></td><td></td><td><p>En space</p></td><td></td></tr><tr><td><p>Quarter em space</p></td><td></td><td><p>Non breaking space</p></td><td></td></tr><tr><td><p>Copyright</p></td><td></td><td><p>Registered</p></td><td></td></tr><tr><td><p>Trademark</p></td><td></td><td><p>Section</p></td><td></td></tr><tr><td><p>Paragraph</p></td><td></td><td><p>Ellipses</p></td><td></td></tr><tr><td><p>Single opening quote</p></td><td></td><td><p>Single closing quote</p></td><td></td></tr><tr><td><p>Double opening quote</p></td><td></td><td><p>Double closing quote</p></td><td></td></tr><tr><td><p>No width optional break</p></td><td></td><td><p>No width non break</p></td><td></td></tr></tbody></table>');

    }//end _runTest()

}//end class

?>