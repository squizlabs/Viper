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

        // Check to make sure the source view appears.
        $this->assertTrue($this->buttonExists('Apply Changes', NULL, TRUE), 'Source view did not appear');

    }//end testViewingSourceFromAccessibilityAuditor()


}//end class

?>
