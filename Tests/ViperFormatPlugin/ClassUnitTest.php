<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add the class attribute to a word using the inline toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWordUsingTheInlineToolbar()
    {
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <span class="test">%2%</span> %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% <span class="test">%2%</span> <span class="class">%3%</span></p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassAttributeToAWordUsingTheInlineToolbar()


    /**
     * Test that the class icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testClassIconAppearsInTheInlineToolbar()
    {
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('This is a new line of %12%');

        $this->selectKeyword(12);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should appear in the inline toolbar.');

    }//end testClassIconAppearsInTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a word using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWordUsingTheTopToolbar()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <span class="test">%2%</span> %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% <span class="test">%2%</span> <span class="class">%3%</span></p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');


    }//end testAddingClassAttributeToAWordUsingTheTopToolbar()


    /**
     * Test that the update changes button is disabled when you initially click on the class icon.
     *
     * @return void
     */
    public function testUpdateChangesButtonIsDisabledForClassIcon()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

    }//end testUpdateChangesButtonIsDisabledForClassIcon()


    /**
     * Test that you can remove a class from a word using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheInlineToolbar()
    {
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz %6% is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="test">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(7));
        $this->selectKeyword(6);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz %6% is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a word using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheTopToolbar()
    {
        $text = 'lABs';

        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz %6% is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="test">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(6);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz %6% is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheTopToolbar()


    /**
     * Test that you can update the class applied to a word using the inline toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheInlineToolbar()
    {
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclassabc">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(6);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclassabcdef">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testUpdatingAClassUsingTheInlineToolbar()


    /**
     * Test that you can update the class applied to a word using the top toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheTopToolbar()
    {
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclassabc">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(6);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclassabcdef">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testUpdatingAClassUsingTheTopToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->findKeyword(2));

        // Need to add the sleep so that the test passes in Firefox otherwise it doesn't click AbC
        sleep(1);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="test">%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p class="class"><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheTopToolbar()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->findKeyword(2));

        // Need to add the sleep so that the test passes in Firefox otherwise it doesn't click AbC
        sleep(1);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="test">%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p class="class"><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheTopToolbar()


    /**
     * Test adding a class to a paragraph that was a class applied to a word.
     *
     * @return void
     */
    public function testAddingClassToParagraphWithClassAppliedToWord()
    {
        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p class="test">Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->findKeyword(7));
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingInlineToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete again using the Update Changes button.
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testRemovingClassAttributeFromParagraphUsingInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        //Reapply the class so that we can delete again using the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testRemovingClassAttributeFromParagraphUsingTopToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testEditingTheClassForAParagraphUsingInlineToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="testabc">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="testabcdef">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testEditingTheClassUsingInlineToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testEditingTheClassUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="testabc">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="testabcdef">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testEditingTheClassUsingTopToolbar()


    /**
     * Test that you can apply a class to a pargraph using the inline toolbar where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingInlineToolbarWithBoldFirstWord()
    {
        $this->selectKeyword(9);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p class="test"><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAParagraphUsingInlineToolbarWithBoldFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the top toolbar where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingTopToolbarWithBoldFirstWord()
    {
        $this->selectKeyword(9);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p class="test"><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAParagraphUsingTopToolbarWithBoldFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the inline toolbar where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingInlineToolbarWithItalicFirstWord()
    {

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p class="test"><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAParagraphUsingInlineToolbarWithItalicFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the top toolbar where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingTopToolbarWithItalicFirstWord()
    {

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p class="test"><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAParagraphUsingTopToolbarWithItalicFirstWord()


    /**
     * Test that you can apply a class to bold word.
     *
     * @return void
     */
    public function testAddingClassToABoldWord()
    {

        $this->selectKeyword(8);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong class="test">%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply a class to italac word.
     *
     * @return void
     */
    public function testAddingClassToAItalicWord()
    {

        $this->selectKeyword(5);
        $this->keyDown('Key.CMD + i');

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> <em class="test">%5%</em></p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAItalicWord()


    /**
     * Test applying a class to one word out of two words that are bold.
     *
     * @return void
     */
    public function testAddingClassToAOneBoldWord()
    {
        $this->selectKeyword(8, 9);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8% %9%</strong> the lazy dog</p>');

        $this->selectKeyword(9);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8% <span class="test">%9%</span></strong> the lazy dog</p>');

    }//end testAddingClassToAOneBoldWord()


    /**
     * Test applying a class to one word out of two words that are italics.
     *
     * @return void
     */
    public function testAddingClassToAOneItalicWord()
    {
        $this->selectKeyword(2, 3);
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% <em>%2% %3%</em></p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <em><span class="test">%2%</span> %3%</em></p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

    }//end testAddingClassToAOneItalicWord()


    /**
     * Test that selection is maintained when opening and closing the class icon for a word.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()


    /**
     * Test that selection is maintained when opening and closing the class icon for a paragraph.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%1% %2% %3%'), $this->getSelectedText(), 'Original selection is not selected');

        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals($this->replaceKeywords('%1% %2% %3%\n'), $this->getSelectedText(), 'Original selection is not selected');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals($this->replaceKeywords('%1% %2% %3%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()


    /**
     * Test that class info is not added to the source code when you remove italics formatting.
     *
     * @return void
     */
    public function testApplyingBoldAndItalicsClickingClassRemovingBold()
    {
        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');
        $this->clickInlineToolbarButton('cssClass');
        $this->clickInlineToolbarButton('italic', 'active');

        $viperBookmarkElements = $this->execJS('viperTest.getWindow().dfx.getClass("viperBookmark").length');
        $this->assertEquals(0, $viperBookmarkElements, 'There should be no viper bookmark elements');

        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p class="test">sit amet <strong>%4%</strong></p><p><em>Test</em> %5%</p><p>Squiz <span class="myclass">%6%</span> is %7%</p><p><strong>%8%</strong> %9% the lazy dog</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italics icon in VITP should not be active.');

    }//end testApplyingBoldAndItalicsClickingClassRemovingBold()


    /**
     * Test applying a class to an image.
     *
     * @return void
     */
    public function testApplyingAClassToAnImage()
    {
        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="369" height="167" class="test" /></p><p>LABS is ORSM</p>');
        $this->clickInlineToolbarButton('cssClass', 'selected');

        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should not be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="369" height="167" class="testabc" /></p><p>LABS is ORSM</p>');

    }//end testApplyingAClassToAnImage()


}//end class

?>
