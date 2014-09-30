<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_RemoveFormatUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that bold, italics, strike through, sub script, super script, alignment and classes are removed when you click the Remove Format icon.
     *
     * @return void
     */
    public function testRemoveFormatIcon()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        sleep(1);

        $this->sikuli->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<div><h1>%1% First Heading</h1><p>Lorem XuT dolor sit amet test</p><h2>Second Heading</h2><p>This is SOME information for <a href="http://www.google.com" title="Google">testing</a></p><ul><li>purus oNo luctus</li></ul><div></div><hr /><p>This is a sub script. This is a super script</p><table border="1" cellpadding="2" cellspacing="3"><caption>Table 1.2: The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WoW sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li></ul></td></tr><tr><td><h3>Squiz Labs</h3></td><td colspan="2">purus neque luctus <a href="http://www.google.com">ligula</a>, vel molestie arcu</td></tr><tr><td>nec porta ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr></tbody></table></div>');

    }//end testRemoveFormatIcon()


    /**
     * Test that alignment is removed for a list.
     *
     * @return void
     */
    public function testRemoveAlignmentForAList()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>This is a list</p><ul><li>Test removing bullet points</li><li>purus %1% luctus</li><li>vel molestie arcu</li></ul>');

    }//end testRemoveAlignmentForAList()


    /**
     * Test that selection is maintained when you click the remove format icon.
     *
     * @return void
     */
    public function testSelectionMaintainedWhenClickingRemoveFormat()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Lorem %1% dolor sit amet WoW</p>');
        $this->assertEquals($this->replaceKeywords('Lorem %1% dolor sit amet WoW'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectionMaintainedWhenClickingRemoveFormat()


    /**
     * Test remove format for a paragraph.
     *
     * @return void
     */
    public function testRemoveFormatForAParagraph()
    {
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% government agencies must update all government websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance. Agencies should use the principle of progressive enhancement when building and managing websites, and test for conformance across multiple browsers and operating system configurations.</p>');

    }//end testRemoveFormatForAParagraph()


    /**
     * Test remove format for a style element.
     *
     * @return void
     */
    public function testRemoveFormatForAStyleElement()
    {
        $this->useTest(5);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);

        $this->clickTopToolbarButton('removeFormat');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar be enabled');
        $this->assertHTMLMatch('<p>test test %1% test test</p>');

        // Test that undo and redo works.
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test test <strong><em>%1%</em></strong> test test</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>test test %1% test test</p>');

    }//end testRemoveFormatForAStyleElement()


    /**
     * Test remove format for a nested style element.
     *
     * @return void
     */
    public function testRemoveFormatForANestedStyleElement()
    {
        $this->useTest(5);
        
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('removeFormat');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar be enabled');
        $this->assertHTMLMatch('<p>test test %1% test test</p>');

        // Test that undo and redo works.
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test test <strong><em>%1%</em></strong> test test</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>test test %1% test test</p>');

    }//end testRemoveFormatForANestedStyleElement()


     /**
     * Test remove format for a nested style element.
     *
     * @return void
     */
    public function testRemoveFormatOnContentWithMultipleFormats()
    {
        $this->useTest(6);
        
        // Apply italic, subscript and superscript to the word
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>Test content with <em><sub><sup>%1%</sup></sub></em> no styles applied</p>');

        // Remove format for the content
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

        // Try removing content from the content again to make sure it is not deleted
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

        // Apply bold, italic, subscript and superscript to the word
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>Test content with <strong><em><sub><sup>%1%</sup></sub></em></strong> no styles applied</p>');

        // Remove format for the content
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

        // Select content again and make sure icons are not active
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('subscript'));
        $this->assertTrue($this->topToolbarButtonExists('superscript'));

        // Click remove format again to make sure content is not broken
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

    }//end testRemoveFormatOnContentWithMultipleFormats()


}//end class


?>
