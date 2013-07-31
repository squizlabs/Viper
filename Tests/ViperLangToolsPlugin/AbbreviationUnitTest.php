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
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');

        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation icon in Top Toolbar should be active.');

        $this->sikuli->click($this->findKeyword(1));
        $this->selectKeyword(1);
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
        $textLoc = $this->findKeyword(2);

        $this->selectKeyword(1);
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

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);

        $this->clickField('Abbreviation');

        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->sikuli->click($this->findKeyword(2));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation icon in Top Toolbar should be active.');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> <abbr title="def">%3%</abbr></p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->sikuli->click($this->findKeyword(3));
        $this->selectKeyword(3);
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

        $this->selectKeyword(5);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz %5% is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->sikuli->click($this->findKeyword(5));
        $this->selectKeyword(5);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the abbreviation so we can delete it by using the update changes icon
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->sikuli->click($this->findKeyword(5));
        $this->selectKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz %5% is orsm</p><p>The <em>%6%</em> brown fox</p>');

    }//end testRemovingAbbreviationAttributeFromAWord()


    /**
     * Test that you can edit an abbreviation that has been applied to a word.
     *
     * @return void
     */
    public function testEditingAbbreviation()
    {

        $this->selectKeyword(5);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abcdef">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->sikuli->click($this->findKeyword(5));
        $this->selectKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('ghi');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abcdefghi">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

    }//end testEditingAbbreviation()


    /**
     * Test that you can apply an abbreviation to a word that is bold.
     *
     * @return void
     */
    public function testAddingAbbreviationToABoldWord()
    {

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <abbr title="abc"><strong>%4%</strong></abbr></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

    }//end testAddingAbbreviationToABoldWord()


    /**
     * Test that you can apply an abbreviation to a word that is italic.
     *
     * @return void
     */
    public function testAddingAbbreviationToAItalicWord()
    {

        $this->selectKeyword(6);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <abbr title="abc"><em>%6%</em></abbr> brown fox</p>');

    }//end testAddingAbbreviationToAItalicWord()


    /**
     * Test that selection is maintained when switching between abbreviation and class.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->assertEquals('%2%', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('%2%', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('langTools');
        $this->assertEquals('%2%', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()


    /**
     * Test undo and redo for abbreviation.
     *
     * @return void
     */
    public function testUndoAndRedoForAbbreviation()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);

        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

    }//end testUndoAndRedoForAbbreviation()


    /**
     * Test applying abbreviation, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testUndoAfterDeletingAbbreviation()
    {
        // Apply abbreviation
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        // Delete abbreviation
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('langTools', 'selected');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        // Press undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <abbr title="abc">%2%</abbr> %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Squiz <abbr title="abc">%5%</abbr> is orsm</p><p>The <em>%6%</em> brown fox</p>');

    }//end testUndoAfterDeletingAbbreviation()


}//end class

?>
