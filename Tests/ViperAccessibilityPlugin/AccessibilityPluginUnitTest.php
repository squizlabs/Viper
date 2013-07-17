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

        $this->click($this->findKeyword(1));
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

        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('accessAudit');

        // View Report.
        $viewReportButton = $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        $this->click($viewReportButton);

        // Click warning.
        $warningIcon = $this->findImage('HTMLCS-report-warning', '.HTMLCS-issue-type.HTMLCS-warning');
        $this->click($warningIcon);

        $bubble = $this->getActiveBubble();

        // View source.
        $this->clickButton('sourceView', NULL, FALSE, $bubble);
        sleep(2);

        // Check to make sure the source view appears.
        $this->assertTrue($this->buttonExists('Apply Changes', NULL, TRUE), 'Source view did not appear');

    }//end testViewingSourceFromAccessibilityAuditor()


    /**
     * Test the carret position in the accessibility auditor.
     *
     * @return void
     */
    public function testCaretPositionInAccessibilityAuditor()
    {
        $this->useTest(2);

        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('accessAudit');

        // View Report.
        $viewReportButton = $this->findImage('HTMLCSViewReport', '#HTMLCS-settings-view-report');
        $this->click($viewReportButton);

        // Click error.
        $warningIcon = $this->findImage('HTMLCS-report-error', '.HTMLCS-issue-type.HTMLCS-error');
        $this->click($warningIcon);

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
        sleep(2);

        $this->assertHTMLMatch('<p>%1%</p><p><img src="http://placebox.es/150/150/666666/f1f1f1/" alt="alt" title="Link title texttest" /></p>');


    }//end testCaretPositionInAccessibilityAuditor()


}//end class

?>