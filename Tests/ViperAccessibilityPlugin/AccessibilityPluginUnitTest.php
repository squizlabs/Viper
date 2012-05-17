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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->click($this->find($text));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit'), 'Accessibility auditor icon should be active.');

        $this->clickTopToolbarButton('accessAudit');

        sleep(1);

        // Check to make sure the auditor appear.
        $imageFound = true;
        try
        {
            $this->find($dir.'accessibility_auditor.png');
        }
        catch(Exception $e)
        {
            $imageFound = false;
        }

        $this->assertTrue($imageFound, 'The accessibility auditor were not found');

        $this->clickTopToolbarButton('accessAudit', 'selected');

        sleep(1);
        try
        {
            $this->find($dir.'accessibility_auditor.png');
        }
        catch(Exception $e)
        {
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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->click($this->find($text));
        $this->clickTopToolbarButton('accessAudit');

        // View Report
        $viewReportButton = $this->find($dir.'view_report_button.png');
        $this->click($viewReportButton);

        // Click warning
        $warningButton = $this->find($dir.'auditor_warning.png');
        $this->click($warningButton);

        // Wait for pointer to stop
        sleep(5);

        // View source
        $viewSourceButton = $this->find($dir.'view_source_button.png');
        $this->click($viewSourceButton);


        // Check to make sure the source view appears.
        $imageFound = true;
        try
        {
            $this->find($dir.'source_view.png');
        }
        catch(Exception $e)
        {
            $imageFound = false;
        }

        $this->assertTrue($imageFound, 'Source view did not appear');

    }//end testViewingSourceFromAccessibilityAuditor()


}//end class

?>
