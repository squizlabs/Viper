<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_AbbreviationUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the abbreviation icon is not active when you don't select some text and when you select a block of text.
     *
     * @return void
     */
    public function testAbbreviationIconIsDisabled()
    {
        $text = 'LOREM';
        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');

        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation icon in Top Toolbar should be active.');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon in Top Toolbar should not be active.');

        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation icon in Top Toolbar should not be active.');

    }//end testAbbreviationIconIsDisabled()


    /**
     * Test that the Update Changes button remains inactvie.
     *
     * @return void
     */
    public function testUpdateChangesButton()
    {
        $text    = 'XuT';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);

        // Check to make sure the update changes button is disabled.
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'The update changes button should be disabled.');

    }//end testUpdateChangesButton()


    /**
     * Test that you can apply the abbreviation attribute to a word.
     *
     * @return void
     */
    public function testAddingAbbreviationToAWord()
    {
        $text = 'XuT';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);

        $this->clickField('Abbreviation');

        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM <abbr title="abc">XuT</abbr> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation icon in Top Toolbar should be active.');

        $text = 'dolor';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM <abbr title="abc">XuT</abbr> <abbr title="def">dolor</abbr></p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation icon in Top Toolbar should be active.');

    }//end testAddingAbbreviationToAWord()


    /**
     * Test that you can remove an abbreviation from a word.
     *
     * @return void
     */
    public function testRemovingAbbreviationAttributeFromAWord()
    {
        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the abbreviation so we can delete it by using the update changes icon
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testRemovingAbbreviationAttributeFromAWord()


    /**
     * Test that you can edit an abbreviation that has been applied to a word.
     *
     * @return void
     */
    public function testEditingAbbreviation()
    {
        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abcdef">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('ghi');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abcdefghi">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testEditingAbbreviation()


    /**
     * Test that you can apply an abbreviation to a word that is bold.
     *
     * @return void
     */
    public function testAddingAbbreviationToABoldWord()
    {
        $text = 'WoW';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <abbr title="abc"><strong>WoW</strong></abbr></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testAddingAbbreviationToABoldWord()


    /**
     * Test that you can apply an abbreviation to a word that is italic.
     *
     * @return void
     */
    public function testAddingAbbreviationToAItalicWord()
    {
        $text = 'QUICK';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <abbr title="abc"><em>QUICK</em></abbr> brown fox</p>');

    }//end testAddingAbbreviationToAItalicWord()


    /**
     * Test that selection is maintained when switching between abbreviation and class.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('langTools');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()


}//end class

?>
