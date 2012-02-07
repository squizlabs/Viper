<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StylesInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that bold can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testBoldInTableMouseSelect()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU TiuT <strong>XabcX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableMouseSelect()


    /**
     * Test that italics can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMouseSelect()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU TiuT <em>XabcX</em> Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicInTableMouseSelect()


    /**
     * Test that bold can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testBoldInTableShortcut()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU TiuT <strong>XabcX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableShortcut()


    /**
     * Test that italics can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testItalicsInTableShortcut()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU TiuT <em>XabcX</em> Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicsInTableShortcut()


    /**
     * Test that bold can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testBoldInTableMultiWord()
    {
        $this->selectText('TiuT', 'XabcX');

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU <strong>TiuT XabcX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->click($this->find('TiuT'));
        $this->doubleClick($this->find('XabcX'));
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->click($this->find('XabcX'));
        $this->doubleClick($this->find('TiuT'));
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->click($this->find('XabcX'));
        $this->doubleClick($this->find('TiuT'));
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertEquals('UnaU TiuT<strong> XabcX</strong> Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableMultiWord()


    /**
     * Test that italics can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMultiWord()
    {
        $this->selectText('TiuT', 'XabcX');

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU <em>TiuT XabcX</em> Mnu', $this->getHtml('td,th', 3));

        $this->click($this->find('TiuT'));
        $this->doubleClick($this->find('XabcX'));
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($this->find('XabcX'));
        $this->doubleClick($this->find('TiuT'));
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($this->find('XabcX'));
        $this->doubleClick($this->find('TiuT'));
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertEquals('UnaU TiuT<strong> XabcX</strong> Mnu', $this->getHtml('td,th', 3));

    }//end testItalicInTableMultiWord()


    /**
     * Test that bold can be applied to whole cell.
     *
     * @return void
     */
    public function testBoldForWholeCell()
    {
        $first  = $this->find('UnaU');
        $second = $this->find('Mnu');

        $this->selectText('XabcX');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('<strong>UnaU TiuT XabcX Mnu</strong>', $this->getHtml('td,th', 3));

        $end = $this->getTopRight($second);
        $this->setLocation($end, ($this->getX($end) + 10), $this->getY($end));
        $this->dragDrop($this->getTopLeft($first), $end);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->keyDown('Key.CMD + b');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldForWholeCell()


    /**
     * Test that italics can be applied to whole cell.
     *
     * @return void
     */
    public function testItalicForWholeCell()
    {
        $first  = $this->find('UnaU');
        $second = $this->find('Mnu');

        $this->selectText('XabcX');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('<em>UnaU TiuT XabcX Mnu</em>', $this->getHtml('td,th', 3));

        $end = $this->getTopRight($second);
        $this->setLocation($end, ($this->getX($end) + 10), $this->getY($end));
        $this->dragDrop($this->getTopLeft($first), $end);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->keyDown('Key.CMD + i');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicForWholeCell()


    /**
     * Test that styles can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMultipleStyles()
    {
        $text    = 'XabcX';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->mouseMove($this->createLocation(0, 0));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($textLoc);
        $this->dragDrop($this->getTopLeft($textLoc), $this->getBottomRight($textLoc));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->doubleClick($textLoc);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testStylingInTableMultipleStyles()


    /**
     * Test that styles can be applied and removed to a word in a table cell.
     *
     * @return void
     */
    public function testRemoveStylesInTable()
    {
        // Remove bold and italics
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeFormat.png');

        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->assertEquals('WoW sapien vel aliquet', $this->getHtml('td,th', 4));

        $this->click($textLoc);

        // Remove heading styles
        $this->selectText('SQUIZ LABS');
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeFormat.png');
        $this->assertEquals('Squiz LABS', $this->getHtml('td,th', 6));

        $this->click($textLoc);

        // Remove unordered list
        $this->selectText('REMOVING');
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeFormat.png');
        $this->assertEquals('<p>Test removing bullet points</p><p>purus neque luctus</p><p>vel molestie arcu</p>', $this->getHtml('td,th', 5));


    }//end testRemoveStylesInTable()


}//end class

?>
