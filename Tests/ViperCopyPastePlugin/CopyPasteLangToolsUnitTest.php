<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteLangToolsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test copy and pasting acroynm, abbreviation and language.
     *
     * @return void
     */
    public function testCopyPasteLanguageSettings()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is the <span lang="en">first</span> <acronym title="abc">paragraph</acronym> in the <abbr title="def">content</abbr> of the page %2%</p><p>This is the second one %2%</p><p>%1% This is the <span lang="en">first</span> <acronym title="abc">paragraph</acronym> in the <abbr title="def">content</abbr> of the page %2%</p>');

    }//end testCopyPasteLanguageSettings()

}//end class

?>
