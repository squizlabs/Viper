<?php
require_once 'AbstractViperListPluginUnitTest.php';


/**
 * An abstract class that the list unit tests should extend.
 */
abstract class AbstractGeneralListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that list tools are not available when selection is inside a non P element.
     *
     * @return void
     */
    public function testNoToolsForNonPTag()
    {
        $this->selectText('SoD');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testNoToolsForNonPTag()


     /**
     * Test that the heading icon is not available for a list.
     *
     * @return void
     */
    public function testHeadingIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'Heading icon should appear in the top toolbar.');

    }//end testHeadingIconNotAvailableForList()


     /**
     * Test that the formats icon is not available for a list.
     *
     * @return void
     */
    public function testFormatsIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats.png'), 'Formats icon should appear in the top toolbar.');

    }//end testFormatsIconNotAvailableForList()


    /**
     * Test that the table icon is not available for a list.
     *
     * @return void
     */
    public function testTableIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperTableEditorPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable.png'), 'Table icon should be active in the top toolbar.');

        $this->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not active in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_disabled.png'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable.png'), 'Table icon should appear in the top toolbar.');

    }//end testTableIconNotAvailableForList()


    /**
     * Test that the HR icon is not available for a list.
     *
     * @return void
     */
    public function testHRIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperCoreStylesPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should be active in the top toolbar.');

        $this->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not active in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule_disabled.png'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_horizontalRule.png'), 'HR icon should appear in the top toolbar.');

    }//end testHRIconNotAvailableForList()


}//end class

?>
