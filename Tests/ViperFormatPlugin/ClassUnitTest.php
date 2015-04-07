<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add the class attribute to a word.
     *
     * @return void
     */
    public function testAddingAndRemovingClassAttributeToAWord()
    {
        $this->useTest(1);

        // Add class using inline toolbar and pressing enter
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="test">%1%</span> in my unit test %2%</p>');

        // Re-select the word and remove class using inline toolbar and pressing enter
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        // Add class using inline toolbar and pressing Apply Changes.
        $this->selectKeyword(2);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="class">%2%</span></p>');

        // Remove class using inline toolbar and pressing Apply Changes, without re-selecting the word
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        // Check that the P icon is not active in the top toolbar. This was reported as a bug.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));

        // Add class using top toolbar and pressing enter
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="test">%1%</span> in my unit test %2%</p>');

        // Re-select the word and remove class using top toolbar and pressing enter
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

         // Add class using top toolbar and pressing Apply Changes
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="class">%2%</span></p>');

        // Remove class using top toolbar and pressing Apply Changes, without re-selecting the word
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        // Check that the P icon is not active in the top toolbar. This was reported as a bug.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));

    }//end testAddingAndRemovingClassAttributeToAWord()


    /**
     * Test that you can add the class attribute to a word and then edit the value without closing the pop up.
     *
     * @return void
     */
    public function testAddAndEditClassToWordWithoutClosingPopUp()
    {

        // Add class and edit it using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="test">%1%</span> in my unit test %2%</p>');
        $this->type('abc');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="testabc">%1%</span> in my unit test %2%</p>');

        // Add class and edit it using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('my');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="my">%1%</span> in my unit test %2%</p>');
        $this->type('class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="myclass">%1%</span> in my unit test %2%</p>');

    }//end testAddAndEditClassToWordWithoutClosingPopUp()


    /**
     * Test that you can add and remove the class attribute to a paragraph.
     *
     * @return void
     */
    public function testAddingAndRemovingClassAttributeToAParagraph()
    {

        $this->useTest(1);

        // Add class using inline toolbar and pressing enter
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test">This is some content %1% in my unit test %2%</p>');

        // Remove class using inline toolbar and pressing enter
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        // Add class using inline toolbar and pressing Apply Changes
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="class">This is some content %1% in my unit test %2%</p>');

        // Remove class using inline toolbar and pressing Apply Changes
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        // Add class using top toolbar and pressing enter
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test">This is some content %1% in my unit test %2%</p>');

        // Remove class using top toolbar and pressing enter
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

         // Add class using top toolbar and pressing Apply Changes
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="class">This is some content %1% in my unit test %2%</p>');

        // Remove class using top toolbar and pressing Apply Changes
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

    }//end testAddingAndRemovingClassAttributeToAParagraph()


    /**
     * Test that you can add the class attribute to a paragraph and then edit the value without closing the pop up.
     *
     * @return void
     */
    public function testAddAndEditClassToParagraphWithoutClosingPopUp()
    {

        // Add class and edit it using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="test">This is some content %1% in my unit test %2%</p>');
        $this->type('abc');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="testabc">This is some content %1% in my unit test %2%</p>');

        // Add class and edit it using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('my');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="my">This is some content %1% in my unit test %2%</p>');
        $this->type('class');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="myclass">This is some content %1% in my unit test %2%</p>');

    }//end testAddAndEditClassToParagraphWithoutClosingPopUp()


    /**
     * Test adding a class to a paragraph that has a class applied to a word.
     *
     * @return void
     */
    public function testAddingClassToParagraphWithClassAppliedToWord()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('testclass');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="testclass">This is some content <span class="myclass">%1%</span> with classes applied %2%.</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

    }//end testAddingClassToParagraphWithClassAppliedToWord()


    /**
     * Test that the class icon appears in the toolbar for the last word of a new paragraph.
     *
     * @return void
     */
    public function testClassIconAppearsForLastWordInParagraph()
    {
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a new line of %3%');

        $this->selectKeyword(3);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be active in the top toolbar.');

    }//end testClassIconAppearsForLastWordInParagraph()


    /**
     * Test that the class icon is disabled when you copy and paste a paragraph
     *
     * @return void
     */
    public function testClassIconDisabledWhenCopyParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should be disabled in the top toolbar.');

    }//end testClassIconDisabledWhenCopyParagraph()


    /**
     * Test that the apply changes button is disabled when you initially click on the class icon.
     *
     * @return void
     */
    public function testApplyChangesButtonIsDisabled()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Apply Changes button should be disabled.');

        $this->selectKeyword(2);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Apply Changes button should be disabled.');

    }//end testApplyChangesButtonIsDisabled()


    /**
     * Test that you can update the class applied to a word.
     *
     * @return void
     */
    public function testUpdatingClassAppliedToWord()
    {

        // Updating a class using inline toolbar and pressing enter
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="myclassabc">%1%</span> with classes applied %2%.</p>');

        // Updating a class using top toolbar and pressing enter
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="myclasstest">%1%</span> with classes applied %2%.</p>');

        // Updating a class using inline toolbar and pressing Apply Changes
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->type('abc');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="abc">%1%</span> with classes applied %2%.</p>');

        // Updating a class using top toolbar and pressing Apply Changes
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->type('testclass');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="testclass">%1%</span> with classes applied %2%.</p>');


    }//end testUpdatingClassAppliedToWord()


    /**
     * Test that you can update the class applied to a paragraph.
     *
     * @return void
     */
    public function testUpdatingClassAppliedToParagraph()
    {

        // Updating a class using inline toolbar and pressing enter
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="myclassabc">This is some content %1% with classes applied.</p>');

        // Updating a class using top toolbar and pressing enter
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="myclasstest">This is some content %1% with classes applied.</p>');

        // Updating a class using inline toolbar and pressing Apply Changes
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->type('abc');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="abc">This is some content %1% with classes applied.</p>');

        // Updating a class using top toolbar and pressing Apply Changes
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->type('testclass');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="testclass">This is some content %1% with classes applied.</p>');

    }//end testUpdatingClassAppliedToParagraph()


    /**
     * Test that you can apply a class to bold word.
     *
     * @return void
     */
    public function testAddingClassToBoldWord()
    {

        // Using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <strong class="test">%1%</strong> content with a bold word %2%</p>');

        // Using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <strong class="myclass">%1%</strong> content with a bold word %2%</p>');

    }//end testAddingClassToBoldWord()


    /**
     * Test that you can apply a class to a pargraph where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphWhereFirstWordBold()
    {

        // Using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test">Test <strong>%1%</strong> content with a bold word %2%</p>');

        // Using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="myclass">Test <strong>%1%</strong> content with a bold word %2%</p>');

    }//end testAddingClassToAParagraphWhereFirstWordBold()


    /**
     * Test that you can apply a class to italic word.
     *
     * @return void
     */
    public function testAddingClassToItalicWord()
    {

        // Using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <em class="test">%1%</em> content with an italic word %2%</p>');

        // Using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <em class="myclass">%1%</em> content with an italic word %2%</p>');

    }//end testAddingClassToItalicWord()


    /**
     * Test that the class field remamins open in the inline toolbar when applying a class to a word after applying bold and italic.
     *
     * @return void
     */
    public function testClassFieldRemainsOpenAfterApplyingBoldAndItalic()
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');

        // Select bold in the lineage
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content<strong class="test"><em>%1%</em></strong> in my unit test %2%</p>');

        // Check that the class field stayed open in the inline toolbar has remaind open with the class field
        $this->clickField('Class');
        $this->type('class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <strong class="testclass"><em>%1%</em></strong> in my unit test %2%</p>');

    }//end testClassFieldRemainsOpenAfterApplyingBoldAndItalic()


    /**
     * Test that you can apply a class to a pargraph where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphWhereFirstWordItalic()
    {

        // Using the inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test">Test <em>%1%</em> content with an italic word %2%</p>');

        // Using the top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="myclass">Test <em>%1%</em> content with an italic word %2%</p>');


    }//end testAddingClassToAParagraphWhereFirstWordItalic()


    /**
     * Test that you can apply and remove a class to a section without closing the pop up.
     *
     * @return void
     */
    public function testAddAndRemoveClassWithoutClosingPopUp()
    {

        // Using the inline toolbar with a section containing a bold word
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <span class="test"><strong>%1%</strong> content with a bold word %2%</span></p>');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <strong>%1%</strong> content with a bold word %2%</p>');

        // Using the top toolbar with a section containing a bold word
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <span class="myclass"><strong>%1%</strong> content with a bold word %2%</span></p>');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <strong>%1%</strong> content with a bold word %2%</p>');

         // Using the inline toolbar with a section containing an italic word
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <span class="test"><em>%1%</em> content with an italic word %2%</span></p>');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <em>%1%</em> content with an italic word %2%</p>');

        // Using the top toolbar with a section containing an italic word
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <span class="myclass"><em>%1%</em> content with an italic word %2%</span></p>');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test <em>%1%</em> content with an italic word %2%</p>');

    }//end testAddAndRemoveClassWithoutClosingPopUp()


    /**
     * Test applying a class to one word where two words are bold
     *
     * @return void
     */
    public function testAddingClassToAOneBoldWord()
    {
        // Using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><strong>%1% <span class="test">%2%</span></strong> Content with two bold words</p>');

        // Using top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><strong><span class="myclass">%1%</span> %2%</strong> Content with two bold words</p>');

    }//end testAddingClassToAOneBoldWord()


    /**
     * Test applying a class to one word where two words are italics
     *
     * @return void
     */
    public function testAddingClassToAOneBoldItalic()
    {
        // Using inline toolbar
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><em>%1% <span class="test">%2%</span></em> Content with two italic words</p>');

        // Using top toolbar
        $this->useTest(7);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><em><span class="myclass">%1%</span> %2%</em> Content with two italic words</p>');

    }//end testAddingClassToAOneBoldItalic()


    /**
     * Test that selection is maintained when opening and closing the class icon for a word.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenUsingClassIcon()
    {
        $this->useTest(1);

        // Using inline toolbar for a word
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickInlineToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickInlineToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');

        // Using top toolbar for a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Using inline toolbar for a paragraph
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickInlineToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickInlineToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Using top toolbar for a word for a paragraph
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('This is some content %1% in my unit test %2%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectionIsMaintainedWhenUsingClassIcon()


    /**
     * Test that class attribute is not added to the source code when you remove italics formatting.
     *
     * @return void
     */
    public function testClassAttributeNotAddedWhenRemovingItalics()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');
        $this->clickInlineToolbarButton('cssClass');
        $this->clickInlineToolbarButton('italic', 'active');

        $viperBookmarkElements = $this->sikuli->execJS('viperTest.getWindow().ViperUtil.getClass("viperBookmark").length');
        $this->assertEquals(0, $viperBookmarkElements, 'There should be no viper bookmark elements');

        // Only strong tag should appear around keyword 2
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <strong>%2%</strong></p>');

        // Italic icon should not be active as it was removed
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italics icon in VITP should not be active.');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italics icon should not be active.');

    }//end testClassAttributeNotAddedWhenRemovingItalics()


    /**
     * Test applying a class to an image.
     *
     * @return void
     */
    public function testApplyingAClassToAnImage()
    {

        // Add a class using the inline toolbar
        $this->useTest(8);

        $this->clickElement('img');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with an image</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" class="test"/></p><p>End of content</p>');

        // Edit the class using the inline toolbar
        $this->clickElement('img');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with an image</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" class="testmyclass"/></p><p>End of content</p>');

        // Add a class using the top toolbar
        $this->useTest(8);

        $this->clickElement('img');
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with an image</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" class="test"/></p><p>End of content</p>');

        // Edit the class using the top toolbar
        $this->clickElement('img');
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with an image</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" class="testmyclass"/></p><p>End of content</p>');

    }//end testApplyingAClassToAnImage()


    /**
     * Test inserting an image and applying a class.
     *
     * @return void
     */
    public function testInsertImageAndApplyClass()
    {
        $this->useTest(9);

        // Insert an image
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/editing.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->assertHTMLMatch('<p>Content to test insert an image and add a class %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /></p><p>Another paragraph</p><p>Another paragraph</p><p>End of content %2%</p>');

        // Add a class to the image
        $this->clickElement('img');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->moveToKeyword(2, 'right');
        $this->assertHTMLMatch('<p>Content to test insert an image and add a class %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="" class="test"/></p><p>Another paragraph</p><p>Another paragraph</p><p>End of content %2%</p>');

        // Check that class icon is active for image
        $this->clickElement('img');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

    }//end testInsertImageAndApplyClass()


    /**
     * Test undo and redo for Class.
     *
     * @return void
     */
    public function testUndoAndRedoForClass()
    {
        $this->useTest(1);

        // Test a word
        $this->selectKeyword(2);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

        // Test a paragraph
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('myclass');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="myclass">This is some content %1% in my unit test <span class="test">%2%</span></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p class="myclass">This is some content %1% in my unit test <span class="test">%2%</span></p>');

    }//end testUndoAndRedoForClass()


    /**
     * Test that reverting the value in the class field.
     *
     * @return void
     */
    public function testRevertClassValueIcon()
    {
        $this->useTest(2);

        // Remove class value and revert using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        sleep(2);
        $this->clearFieldValue('Class');
        sleep(2);
        $this->revertFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="myclass">%1%</span> with classes applied %2%.</p>');

        // Remove class value and revert using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->revertFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="myclass">%1%</span> with classes applied %2%.</p>');

        // Apply class value, clear field and revert using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clearFieldValue('Class');
        $this->revertFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="test">%1%</span> in my unit test %2%</p>');

        // Apply anchor value and revert using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('abc');
        $this->revertFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');

    }//end testRevertClassValueIcon()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you click away from a previous selection.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClickingAwayFromClassPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the class for the first selection
        $this->selectKeyword(1);
        sleep(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');

        // Click away from the class by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the class was not created
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');
        $this->clickInlineToolbarButton('cssClass');

        // Check apply change button
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the class for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('id');

        // Click away from the class by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the anchor was not created
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');
        $this->clickTopToolbarButton('cssClass');

        // Check apply change button
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

    }//end testApplyChangesButtonWhenClickingAwayFromClassPopUp()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you close the class pop without saving the changes.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClosingTheClassPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the class for the first selection
        $this->selectKeyword(1);
        sleep(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('id');

        // Close pop up without saving changes and make new select
        $this->clickInlineToolbarButton('cssClass', 'selected');
        $this->selectKeyword(2);

        // Make sure the class was not created
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');
        $this->clickInlineToolbarButton('cssClass');

        // Check icons
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the class for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('id');

        // Close pop up without saving changes and make new select
        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->selectKeyword(2);

        // Make sure the class was not created
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test %2%</p>');
        $this->clickTopToolbarButton('cssClass');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test <span class="test">%2%</span></p>');

    }//end testApplyChangesButtonWhenClosingTheClassPopUp()


    /**
     * Test that the Apply Changes button is inactive after you cancel changes to a class.
     *
     * @return void
     */
    public function testApplyChangesButtonIsDisabledAfterCancellingChangesToAClass()
    {
        // Using the inline toolbar
        $this->useTest(2);

        // Select class and make changes without saving
        $this->selectKeyword(1);
        sleep(2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('222');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>This is some content <span class="myclass">%1%</span> with classes applied %2%.</p>');

        // Select the class again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        // Edit the class and make sure the Apply Changes button still works.
        $this->type('123');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="myclass123">%1%</span> with classes applied %2%.</p>');

        // Using the top toolbar
        $this->useTest(2);

        // Select class and make changes without saving
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('333');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>This is some content <span class="myclass">%1%</span> with classes applied %2%.</p>');

        // Select the class again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        // Edit the class and make sure the Apply Changes button still works.
        $this->type('123');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content <span class="myclass123">%1%</span> with classes applied %2%.</p>');

    }//end testApplyChangesButtonIsDisabledAfterCancellingChangesToAClass()


}//end class

?>
