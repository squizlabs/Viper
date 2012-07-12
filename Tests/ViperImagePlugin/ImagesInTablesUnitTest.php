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

        $this->selectKeyword(2);
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
        $this->type('http://www.squizlabs.com/__images/general/html-codesniffer.png');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

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
        $this->type('http://www.squizlabs.com/__images/general/html-codesniffer.png');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/editing.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(1));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="http://cms.squizsuite.net/__images/homepage-images/editing.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testInsertingAndEditingTheUrlForAnImage()


    /**
     * Test inserting and editing an image in a table using the update changes button.
     *
     * @return void
     */
    public function testInsertingAndEditingAnImageUsingTheUpdateChangesButton()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://www.squizlabs.com/__images/general/html-codesniffer.png');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="Alt tag" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');

        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->clickTopToolbarButton('image', 'selected');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1%<img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="" /> FoX %2%</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

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
        $this->type('http://www.squizlabs.com/__images/general/html-codesniffer.png');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

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
        $this->type('http://www.squizlabs.com/__images/general/html-codesniffer.png');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="Alt tag" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(2));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><img src="http://www.squizlabs.com/__images/general/html-codesniffer.png" alt="Abcd" /></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>Another cell</td></tr><tr><td><h3>%2%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingAnImageInCell()


}//end class

?>
