<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperImagePlugin_ImagesInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the image icon is available in different circumstances.
     *
     * @return void
     */
    public function testImageIconIsAvailable()
    {
        $text = 1;
        $this->selectKeyword($text);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

        $this->click($this->findKeyword($text));
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

        $this->selectKeyword(3);
        $this->type('Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testImageIconIsAvailable()


    /**
     * Test inserting and deleting an image in a table using the delete key.
     *
     * @return void
     */
    public function testInsertingAndDeletingAnImageUsingDelete()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> FoX %3%', $this->getHtml('td', 0));

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertEquals('UnaU %1% FoX %3%', $this->getHtml('td,th', 3));

    }//end testInsertingAndDeletingAnImageUsingDelete()


    /**
     * Test inserting and then changing the URL for an image.
     *
     * @return void
     */
    public function testInsertingAndEditingTheUrlForAnImage()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertEquals('UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /> FoX %3%', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/editing.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(1));

        $this->assertEquals('UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/editing.png" alt="" /> FoX %3%', $this->getHtml('td,th', 3));

    }//end testInsertingAndEditingTheUrlForAnImage()


    /**
     * Test inserting and deleting an image in a table using the update changes button.
     *
     * @return void
     */
    public function testInsertingAndEditingAnImageUsingTheUpdateChangesButton()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->assertEquals('UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> FoX %3%', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');

        $this->clickField('Image is decorative');
        $this->click($updateChanges);
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertEquals('UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /> FoX %3%', $this->getHtml('td,th', 3));

    }//end testInsertingAndEditingAnImageUsingTheUpdateChangesButton()


    /**
     * Test replacing the content in a cell with an image.
     *
     * @return void
     */
    public function testReplacingContentInCellWithImage()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertEquals('', $this->getHtml('td,th', 3));

    }//end testReplacingContentInCellWithImage()


    /**
     * Test editing an image in a cell.
     *
     * @return void
     */
    public function testEditingAnImageInCell()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(2));

        $this->assertEquals('<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd" />', $this->getHtml('td,th', 3));

    }//end testEditingAnImageInCell()


}//end class

?>
