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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LAbS';
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->click($this->find($text));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->selectText('Mnu');
        $this->type('Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

    }//end testImageIconIsAvailable()


    /**
     * Test inserting and deleting an image in a table using the delete key.
     *
     * @return void
     */
    public function testInsertingAndDeletingAnImageUsingDelete()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('UnaU LAbS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> FoX Mnu', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testInsertingAndDeletingAnImageUsingDelete()


    /**
     * Test inserting and deleting an image in a table using the image icon.
     *
     * @return void
     */
    public function testInsertingAndDeletingAnImageUsingImageIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('UnaU LAbS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /> FoX Mnu', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testInsertingAndDeletingAnImageUsingImageIcon()


    /**
     * Test inserting and deleting an image in a table using the update changes button.
     *
     * @return void
     */
    public function testInsertingAndDeletingAnImageUsingTheUpdateChangesButton()
    {
        // Stop here as we need a way to click the update changes button.
        $this->markTestIncomplete('Need a way to click update changes button.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertEquals('UnaU LAbS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> FoX Mnu', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testInsertingAndDeletingAnImageUsingTheUpdateChangesButton()


    /**
     * Test replacing the content in a cell with an image.
     *
     * @return void
     */
    public function testReplacingContentInCellWithImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />', $this->getHtml('td,th', 3));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');

        $this->assertEquals('<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd" />', $this->getHtml('td,th', 3));

    }//end testEditingAnImageInCell()


}//end class

?>
