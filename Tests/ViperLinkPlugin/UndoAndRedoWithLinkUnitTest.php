<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_UndoAndRedoWithLinkUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that clicking undo puts a link back correctly after you remove it.
     *
     * @return void
     */
    public function testUndoAfterRemovingLink()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Content with a link <a href="http://www.squizlabs.com">%1%</a></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

    }//end testUndoAfterRemovingLink()


    /**
     * Test undo and redo when creating a link.
     *
     * @return void
     */
    public function testUndoAfterCreatingLink()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content without a link <a href="http://www.squizlabs.com">%1%</a></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Content without a link %1%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Content without a link <a href="http://www.squizlabs.com">%1%</a></p>');

    }//end testUndoAfterCreatingLink()

}//end class

?>