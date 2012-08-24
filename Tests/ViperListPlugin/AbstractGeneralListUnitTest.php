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
        $this->selectKeyword(10);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testNoToolsForNonPTag()


     /**
     * Test that the heading icon is not available for a list.
     *
     * @return void
     */
    public function testHeadingIconNotAvailableForList()
    {
        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar.');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test that the table icon is not available for a list.
     *
     * @return void
     */
    public function testTableIconNotAvailableForList()
    {
        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('table'), 'Table icon should be active in the top toolbar.');

        $this->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not active in the top toolbar.');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Table icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('table'), 'Table icon should appear in the top toolbar.');

    }//end testTableIconNotAvailableForList()


}//end class

?>
