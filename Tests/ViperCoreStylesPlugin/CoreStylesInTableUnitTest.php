<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_CoreStylesInTableUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that styles can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMultipleStyles()
    {
        $this->selectKeyword(4);

        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');
        $this->sikuli->mouseMove($this->sikuli->createLocation(0, 0));
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->clickKeyword(3);
        $this->selectKeyword(4);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->clickInlineToolbarButton('bold', 'active');
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testStylingInTableMultipleStyles()

}//end class

?>
