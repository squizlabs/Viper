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
        sleep(1);
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
        sleep(1);
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

        // Select content again and make sure icons are not active
        $this->selectKeyword(1);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('subscript'));
        $this->assertTrue($this->topToolbarButtonExists('superscript'));

        // Click remove format again to make sure content is not broken
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content with %1% no styles applied</p>');

    }//end testRemoveFormatOnContentWithMultipleFormats()


    /**
     * Test remove format for a link in a paragraph.
     *
     * @return void
     */
    public function testRemoveFormatForLink()
    {
        $this->useTest(7);
        
        // Test the remove format doesn't remove the link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply bold formatting to the link and then remove it using remove format
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs"><strong>%1%</strong></a> more test content.</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply bold formatting to the paragraph and then remove it from the link using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</strong></p>');
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p><strong>Test content </strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a><strong> more test content.</strong></p>');

        // Apply italics formatting to the link and then remove it using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs"><em>%1%</em></a> more test content.</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply italics formatting to the paragraph and then remove it from the link using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</em></p>');
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p><em>Test content </em><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a><em> more test content.</em></p>');

        // Apply strikethrough formatting to the link and then remove it using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs"><del>%1%</del></a> more test content.</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply strikethrough formatting to the paragraph and then remove it from the link using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><del>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</del></p>');
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p><del>Test content </del><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a><del> more test content.</del></p>');

        // Apply subscript formatting to the link and then remove it using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs"><sub>%1%</sub></a> more test content.</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply subscript formatting to the paragraph and then remove it from the link using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p><sub>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</sub></p>');
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p><sub>Test content </sub><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a><sub> more test content.</sub></p>');

         // Apply superscript formatting to the link and then remove it using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs"><sup>%1%</sup></a> more test content.</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</p>');

        // Apply superscript formatting to the paragraph and then remove it from the link using remove format
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup>Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> more test content.</sup></p>');
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p><sup>Test content </sup><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a><sup> more test content.</sup></p>');

    }//end testRemoveFormatForANestedStyleElement()


    /**
     * Test that remove format works with different types of list
     *
     * @return void
     */
    public function testRemoveFormatAndLists()
    {
        // test removing a single unordered list
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test list:</p><p>%1%</p><p>Test content.</p><p>More test content.</p><p>Another list:</p><ul><li>%3%</li><li>Test content.</li><li>More test content.</li></ul>');

         // test removing all unordered lists from content
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test list:</p><p>%1%</p><p>Test content.</p><p>More test content.</p><p>Another list:</p><p>%3%</p><p>Test content.</p><p>More test content.</p>');

        // test removing a single ordered list
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test list:</p><p>%1%</p><p>Test content.</p><p>More test content.</p><p>Another list:</p><ol><li>%3%</li><li>Test content.</li><li>More test content.</li></ol>');

        // test removing all ordered lists from content
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test list:</p><p>%1%</p><p>Test content.</p><p>More test content.</p><p>Another list:</p><p>%3%</p><p>Test content.</p><p>More test content.</p>');

        // test removing a mix of lists from the content
        $this->useTest(10);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>Test list:</p><p>%1%</p><p>Test content.</p><p>More test content.</p><p>Another list:</p><p>%3%</p><p>Test content.</p><p>More test content.</p>');

    }//end testRemoveFormatAndLists()


}//end class


?>
