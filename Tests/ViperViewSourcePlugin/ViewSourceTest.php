<?php

require_once 'AbstractViperViewSourcePluginUnitTest.php';

class Viper_Tests_ViperViewSourcePlugin_ViewSourceTest extends AbstractViperViewSourcePluginUnitTest
{


   /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testOpenAndCloseSourceEditor()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        $sourceEditorFound = true;
        try
        {
            $this->find($dir.'source_editor.png');
        }
        catch(Exception $e)
        {
            $sourceEditorFound = false;
        }

        $this->assertTrue($sourceEditorFound, 'Source editor did not appear on the screen');

        $closeSourceIcon = $this->find($dir.'icon_close_source.png');
        $this->click($closeSourceIcon);

        // Check to make sure the source editor does not appear.
        $sourceEditorNotFound = false;
        try
        {
            $this->find($dir.'source_editor.png');
        }
        catch(Exception $e)
        {
            // Expecting the exception as the source editor should be closed
            $sourceEditorNotFound = True;
        }

        $this->assertTrue($sourceEditorNotFound, 'Source editor still appears on the screen');

    }//end testSourceCodeAppears()


   /**
     * Test that Viper is responsive after you close the source editor.
     *
     * @return void
     */
    public function testEditingAfterClosingSourceEditor()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('sourceView');

        $closeSourceIcon = $this->find($dir.'icon_close_source.png');
        $this->click($closeSourceIcon);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->click($this->findKeyword(3));
        $this->assertHTMLMatch('<p>Lorem <em>%1%</em> dolor</p><p><strong>%2%</strong> sit amet</p><p>%3% p <em>XuT</em></p>');

    }//end testEditingAfterClosingSourceEditor()


   /**
     * Test that you can edit the source code.
     *
     * @return void
     */
    public function testEditingTheSourceCode()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');

        $applyChangesIcon = $this->find($dir.'icon_applyChanges.png');
        $this->click($applyChangesIcon);

        $this->assertHTMLMatch('<p></p>');

    }//end testEditingTheSourceCode()


   /**
     * Test that you can still edit the content once you deleted some the source code.
     *
     * @return void
     */
    public function testEditingContentAfterDeletingSourceCode()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.DELETE');


        $applyChangesIcon = $this->find($dir.'icon_applyChanges.png');
        $this->click($applyChangesIcon);

        $this->assertHTMLMatch('<p>Lorem %1% dolor</p>');

        $this->selectKeyword(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Keyword is not selected');

    }//end testEditingContentAfterDeletingSourceCode()


}//end class

?>
