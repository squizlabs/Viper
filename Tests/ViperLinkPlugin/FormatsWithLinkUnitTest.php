<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_FormatsWithLinkUnitTest extends AbstractViperUnitTest
{


   /**
     * Test that the class and id tags are added to the a tag when you create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTag()
    {
        // Add link
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Text with class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

        // Add link that opens in a new window
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Text with class and anchor tags <a href="http://www.squizlabs.com" target="_blank" class="class" id="anchor">%1%</a></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

        // Add link with a title tag
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Text with class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor" title="Squiz Labs">%1%</a></p>');
        
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTag()


    /**
     * Test that the class and id tags are removed when you remove the link.
     *
     * @return void
     */
    public function testClassAndIdAreRemovedWhenLinkIsRemoved()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Text with class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a></p>');
        $this->moveToKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Text with class and anchor tags %1%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Text with class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a></p>');
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Text with class and anchor tags %1%</p>');

    }//end testClassAndIdAreRemovedWhenLinkIsRemoved()


    /**
     * Test that the class and id tags are added to the a tag when you re-select the content and create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTagAfterReselect()
    {
        // Using the inline toolbar
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->sikuli->keyDown('Key.ENTER');

        // Click away before adding the link
        $this->moveToKeyword(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Text without class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a> more text %2%</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

        // Using the top toolbar
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('anchorID');
        $this->type('anchor');
        $this->sikuli->keyDown('Key.ENTER');

        // Click away before adding the link
        $this->moveToKeyword(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Text without class and anchor tags <a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a> more text %2%</p>');

        $this->moveToKeyword(2);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTagAfterReselect()

}//end class

?>