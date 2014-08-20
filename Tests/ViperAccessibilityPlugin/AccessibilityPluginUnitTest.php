<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperAccessibilityPlugin_AccessibilityPluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the accessibility auditor opens when you click the icon.
     *
     * @return void
     */
    public function testOpeningAccessibilityAuditor()
    {
        $this->useTest(1);

        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit'), 'Accessibility auditor icon should be active.');

        $this->clickTopToolbarButton('accessAudit');

        sleep(1);

        // Check to make sure the auditor appear.
        try {
            $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        } catch (Exception $e) {
            $this->fail('The accessibility auditor was not found');
        }

        $this->clickTopToolbarButton('accessAudit', 'selected');

        sleep(1);
        try
        {
            $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        } catch (Exception $e) {
            // Expecting the expection as we closed the sub toolbar
            $imageFound = false;
        }

        $this->assertFalse($imageFound, 'The accessibility auditor was found');

    }//end testOpeningAccessibilityAuditor()


    /**
     * Test the you can open source view from the accessibility auditor.
     *
     * @return void
     */
    public function testViewingSourceFromAccessibilityAuditor()
    {
        $this->useTest(1);

        $this->sikuli->click($this->findKeyword(1));
        $this->clickTopToolbarButton('accessAudit');

        sleep(2);

        // View Report.
        $viewReportButton = $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        $this->sikuli->click($viewReportButton);

        // Click warning.
        $warningIcon = $this->findImage('HTMLCS-report-warning', '.HTMLCS-issue-type.HTMLCS-warning');
        $this->sikuli->click($warningIcon);

        $bubble = $this->getActiveBubble();

        // View source.
        $this->clickButton('sourceView', NULL, FALSE, $bubble);
        sleep(2);

        // Check to make sure the source view appears.
        try {
            $image = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }
        //$this->assertTrue($this->buttonExists('Apply Changes', NULL, TRUE), 'Source view did not appear');

    }//end testViewingSourceFromAccessibilityAuditor()


    /**
     * Test the carret position in the accessibility auditor.
     *
     * @return void
     */
    public function testCaretPositionInAccessibilityAuditor()
    {
        $this->useTest(2);

        $this->sikuli->click($this->findKeyword(1));
        $this->clickTopToolbarButton('accessAudit');

        sleep(2);

        // View Report.
        $viewReportButton = $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        $this->sikuli->click($viewReportButton);

        // Click error.
        $warningIcon = $this->findImage('HTMLCS-report-error', '.HTMLCS-issue-type.HTMLCS-error');
        $this->sikuli->click($warningIcon);

        sleep(1);

        // Click alt field.
        $this->clickField('Alt');
        $this->type('alt');

        // Click title field.
        $this->clickField('Title');
        $this->type('test');
        sleep(2);

        // Click Apply Changes.
        $bubble = $this->getActiveBubble();
        $this->clickButton('Apply Changes', NULL, TRUE, $bubble);
        sleep(5);

        $this->assertHTMLMatch('<p>%1%</p><p><img src="http://placebox.es/150/150/666666/f1f1f1/" alt="alt" title="Link title texttest" /></p>');


    }//end testCaretPositionInAccessibilityAuditor()


    /**
     * Test that when you copy the example content into Viper, that the number of expected errors is 8.
     *
     * @return void
     */
    public function testTableIdErrorCountInHTMLCS()
    {
        $this->useTest(1);
        $this->sikuli->click($this->findKeyword(1));

        // Open and copy the text file
        $this->openFile($this->getTestURL().'/ViperAccessibilityPlugin/TableIdErrorCountExampleContent.txt', $this->sikuli->getBrowserName());
        sleep(1);

        // Copy text.
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.CMD + w');
        sleep(2);

        // Open source view and paste the content in.
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $this->sikuli->keyDown('Key.CMD + v');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickButton('Apply Changes', NULL, TRUE);

        // Check error count
        $this->clickTopToolbarButton('accessAudit');
        sleep(5);
        $errorCount = (int) $this->getHtml('.HTMLCS-error strong');

        // The true error count should be 8 but it is 9 in unit tests due to the styling of the unit test page
        $this->assertEquals(9, $errorCount, 'The page should have 8 errors');

    }//end testTableIdErrorCountInHTMLCS()



}//end class

?>