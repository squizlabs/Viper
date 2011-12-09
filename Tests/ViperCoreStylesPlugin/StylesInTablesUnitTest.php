<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StylesInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMouseSelect()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU TiuT <strong>XabcX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text, $text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testStylingInTableMouseSelect()


    /**
     * Test that style can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testStylingInTableShortcut()
    {
        $text = 'XabcX';
        $this->selectText($text);

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU TiuT <strong>XabcX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->keyDown('Key.CMD + b');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testStylingInTableShortcut()


    /**
     * Test that style can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMultiWord()
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

    }//end testStylingInTableMultiWord()


    /**
     * Test that style can be applied to whole cell.
     *
     * @return void
     */
    public function testStylingForWholeCell()
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

    }//end testStylingForWholeCell()


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
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->mouseMove($this->createLocation(0, 0));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->click($textLoc);
        $this->dragDrop($this->getTopLeft($textLoc), $this->getBottomRight($textLoc));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->doubleClick($textLoc);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png');
        $this->assertEquals('UnaU TiuT XabcX Mnu', $this->getHtml('td,th', 3));

    }//end testStylingInTableMultipleStyles()


}//end class

?>
