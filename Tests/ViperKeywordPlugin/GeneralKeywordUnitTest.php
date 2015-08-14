    <?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperKeywordPlugin_GeneralKeywordUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can be deleted.
     *
     * @return void
     */
    public function testDeleteKeyword()
    {

        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testDeleteKeyword()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testDeleteImagesThatUseKeywords()
    {
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" height="31" width="91"> even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoDeletingImagesThatUseKeywords()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testApplyingBoldToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('bold');
        
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);



    }//end testUndoAndRedoDeletingImagesThatUseKeywords()
}