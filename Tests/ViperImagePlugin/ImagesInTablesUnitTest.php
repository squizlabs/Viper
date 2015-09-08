<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_ImagesInTablesUnitTest extends AbstractViperImagePluginUnitTest
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

        $this->sikuli->click($this->findKeyword($text));
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

        $this->moveToKeyword(2, 'right');
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testImageIconIsAvailable()


    /**
     * Test inserting and deleting an image in a table using the delete key.
     *
     * @return void
     */
    public function testInsertingAndDeletingAnImageUsingDelete()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testInsertingAndDeletingAnImageUsingDelete()


    /**
     * Test inserting and then changing the URL for an image.
     *
     * @return void
     */
    public function testInsertingAndEditingTheUrlForAnImage()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'active-selected');
        $this->sikuli->click($this->findKeyword(3));

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testInsertingAndEditingTheUrlForAnImage()


    /**
     * Test inserting and editing an image in a table using the update changes button.
     *
     * @return void
     */
    public function testInsertingAndEditingAnImageUsingTheUpdateChangesButton()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');

        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickTopToolbarButton('image', 'active-selected');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

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
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

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
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');

        // use backspace to delete the content for IE and Firefox
        for ($i = 1; $i <= 7; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('Abcd');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->click($this->findKeyword(3));

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Abcd" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingAnImageInCell()


    /**
     * Test image resize handles exist.
     *
     * @return void
     */
    public function testImageResizeHandles()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickElement('img', 0);

        $this->findImage('ImageHandle-sw', '.Viper-image-handle-sw', 0, true);
        $this->findImage('ImageHandle-se', '.Viper-image-handle-se', 0, true);

    }//end testImageResizeHandles()


    /**
     * Test resizing an image.
     *
     * @return void
     */
    public function testResizingAnImageInATable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickElement('img', 0);

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->resizeImage(200);

        $this->checkResizeHandles('img');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" width="200" height="180" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testResizingAnImageInATable()


    /**
     * Test resizing an image and then editing it.
     *
     * @return void
     */
    public function testResizingAnImageAndEditingItInATable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickElement('img', 0);

        $this->resizeImage(50);

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" width="50" height="45" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" width="50" height="45" title="Title tag"/></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testResizingAnImageAndEditingItInATable()


    /**
     * Test resizing an image and then clicking undo.
     *
     * @return void
     */
    public function testResizingAnImageAndClickingUndoInATable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickElement('img', 1);
        $this->resizeImage(50);

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img alt="Alt tag" height="45" src="%url%/ViperImagePlugin/Images/editing.png" width="50" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>XCX</h3></td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img alt="Alt tag" height="45" src="%url%/ViperImagePlugin/Images/editing.png" width="50" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>XCX</h3></td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testResizingAnImageAndClickingUndoInATable()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image.
     *
     * @return void
     */
    public function testImageIconInInlineToolbar()
    {
        // First insert the image
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img alt="Alt tag" src="%url%/ViperImagePlugin/Images/editing.png" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>XCX</h3></td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 0);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbar()


    /**
     * Test editing an image using the inline toolbar.
     *
     * @return void
     */
    public function testEditingAnImageInTableUsingInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingAnImageInTableUsingInlineToolbar()


    /**
     * Test moving an image.
     *
     * @return void
     */
    public function testMovingAnImageInATable()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->click($this->findKeyword(2));

        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        $this->sikuli->click($this->sikuli->getMouseLocation());

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la </caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>&nbsp;</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu </td></tr></tbody></table>');

        // Undo the move
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la </caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu </td></tr></tbody></table>');

        // Redo the move
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la </caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>&nbsp;</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu </td></tr></tbody></table>');

    }//end testMovingAnImageInATable()


    /**
     * Test undo and redo for an image in the table.
     *
     * @return void
     */
    public function testUndoAndRedoForImageInTable()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/editing.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="0" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%3%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testUndoAndRedoForImageInTable()


}//end class

?>
