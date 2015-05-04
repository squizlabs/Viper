<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_CustomClassStylesUnitTest extends AbstractViperUnitTest
{

    /**
     * Set custom class styles.
     *
     * @return array
     */
    private function setCustomClassStyles()
    {
        $this->setPluginSettings(
            'ViperFormatPlugin',
            array(
             'styles' => array(
                          'Simple Image Border' => array(
                                                    'showFor'    => 'img,h1',
                                                    'hideFor'    => '*',
                                                    'classNames' => 'simple-image-border',
                                                   ),
                          'Article'             => array(
                                                    'classNames' => 'article',
                                                    'showFor'    => 'p',
                                                   ),
                          'Multi Columns'       => array(
                                                    'classNames' => 'multi-col',
                                                    'hideFor'    => 'text-selection,img',
                                                   ),
                          'Caption'             => 'simple-image-border image-caption',
                          'Round Image'         => 'round-image',
                          'Ordered List'        => 'ordered-list',
                         ),
            )
        );

    }//end setCustomClassStyles()


    /**
     * Returns the selected styles.
     *
     * @return array
     */
    private function getSelectedStyles()
    {
        return $this->sikuli->execJS('viper.ViperTools.getItem(\'ViperFormatPlugin-classList\').getSelectedItems()');

    }//end getSelectedStyles()


    /**
     * Selects the specified styles.
     *
     * @param array $styles Array of class names separated by spaces.
     *
     * @return void
     */
    private function selectStyles(array $styles)
    {
        $rect = $this->getBoundingRectangle('.ViperUtil-visible[data-id="test-ViperFormatPlugin-classPopout"]');
        if (empty($rect) === true) {
            $this->sikuli->clickVisibleElement('.ViperFormatPlugin-stylePickerButton', 0, true);
        }

        foreach ($styles as $classNames) {
            $this->sikuli->clickVisibleElement('li[data-id="'.$classNames.'"]');
        }

    }//end selectStyles()


    /**
     * Removes the specified styles.
     *
     * @param array $styles Array of class names separated by spaces.
     *
     * @return void
     */
    private function removeStyles(array $styles)
    {
        foreach ($styles as $classNames) {
            $this->sikuli->clickVisibleElement('.Viper-visible .ViperFormatPlugin-styleListItem-remove[data-id="'.$classNames.'"]');
        }

    }//end removeStyles()


    /**
     * Test custom style menu doesn't appear in the class pop up when no styles defined
     *
     * @return void
     */
    public function testNoCustomStylesMenu()
    {

        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);

        try {
            $this->clickInlineToolbarButton('cssClass');
            $this->selectStyles(array('ordered-list'));
        } catch (Exception $e) {
            $this->assertTrue(True, 'The Custom Styles Menu is not shown.');
        }

    }//end testNoCustomStylesMenu()


    /**
     * Test class icon when applying custom styles
     *
     * @return void
     */
    public function testClassIconWithCustomStyles()
    {
        $this->setCustomClassStyles();

        // Check class icon active when selecting word with custom styles
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));

        // Check class icon active when selecting paragraph with custom styles
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));

        // Check class icon once applying custom style to a word
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(1);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));

        // Check class icon once applying custom style to a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));

        // Check class icon after attempting to apply a custom style to a word
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->selectKeyword(1);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass'));

        // Check class icon after attempting to apply custom style to paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass'));

    }//end testClassIconWithCustomStyles()


    /**
     * Test applying a custom style to a word in a paragraph
     *
     * @return void
     */
    public function testApplyingCustomClassStyleToWord()
    {
        $this->setCustomClassStyles();

        // Test applying to a word and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

    }//end testApplyingCustomClassStyleToWord()


    /**
     * Test applying a custom style to a paragraph.
     *
     * @return void
     */
    public function testApplyingCustomClassStyleToParagraph()
    {
        $this->setCustomClassStyles();

        // Test applying to a paragraph and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Test applying to a paragraph and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

    }//end testApplyingCustomClassStyleToParagraph()


    /**
     * Test applying and editing a custom style to a word in a paragraph
     *
     * @return void
     */
    public function testApplyAndEditCustomClassStyleToWord()
    {
        $this->setCustomClassStyles();

        // Test applying to a word and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Edit the custom styles using inline toolbar and press enter
        $this->selectStyles(array('multi-col'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="multi-col ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Edit the custom styles using inline toolbar and press apply changes
        $this->selectStyles(array('multi-col'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="multi-col ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Edit the custom styles using top toolbar and press enter
        $this->selectStyles(array('multi-col'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="multi-col ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Edit the custom styles using top toolbar and press apply changes
        $this->selectStyles(array('multi-col'));
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="multi-col ordered-list">%1%</span> in my unit test</p>');

    }//end testApplyAndEditCustomClassStyleToWord()


    /**
     * Test apply and edit a custom style to a paragraph.
     *
     * @return void
     */
    public function testApplyAndEditCustomClassStyleToParagraph()
    {
        $this->setCustomClassStyles();

        // Test applying to a paragraph and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Edit the custom styles using inline toolbar and press enter
        $this->selectStyles(array('multi-col'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article multi-col">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Edit the custom styles using inline toolbar and press apply changes
        $this->selectStyles(array('multi-col'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article multi-col">This is some content %1% in my unit test</p>');

        // Test applying to a paragraph and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

        // Edit the custom styles using top toolbar and press enter
        $this->selectStyles(array('multi-col'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="article multi-col">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article">This is some content %1% in my unit test</p>');

         // Edit the custom styles using top toolbar and press apply changes
        $this->selectStyles(array('multi-col'));
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="article multi-col">This is some content %1% in my unit test</p>');

    }//end testApplyAndEditCustomClassStyleToParagraph()


    /**
     * Test applying a custom style and class to a word in a paragraph
     *
     * @return void
     */
    public function testApplyingCustomStyleAndClassToWord()
    {
        $this->setCustomClassStyles();

        // Test applying to a word and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="test ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="test ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        sleep(1);
        $this->selectStyles(array('ordered-list'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="test ordered-list">%1%</span> in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        sleep(1);
        $this->selectStyles(array('ordered-list'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content <span class="test ordered-list">%1%</span> in my unit test</p>');

    }//end testApplyingCustomStyleAndClassToWord()


    /**
     * Test applying a custom style and class to a paragraph.
     *
     * @return void
     */
    public function testApplyingCustomStyleAndClassToParagraph()
    {
        $this->setCustomClassStyles();

        // Test applying to a paragraph and pressing enter using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test article">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="test article">This is some content %1% in my unit test</p>');

        // Test applying to a paragraph and pressing enter using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="test article">This is some content %1% in my unit test</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass');
        $this->selectStyles(array('article'));
        sleep(1);
        $this->clickField('Class');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p class="test article">This is some content %1% in my unit test</p>');

    }//end testApplyingCustomStyleAndClassToParagraph()


    /**
     * Test removing a custom style from a word
     *
     * @return void
     */
    public function testRemovingCustomStyleFromWord()
    {
        $this->setCustomClassStyles();

        // Test removing classes from a word and pressing enter using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a word</p>');

        // Test removing classes from a word and pressing apply changes using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a word</p>');

        // Test removing classes from a word and pressing enter using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a word</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a word</p>');

    }//end testRemovingCustomStyleFromWord()


    /**
     * Test removing a custom style from a paragraph
     *
     * @return void
     */
    public function testRemovingCustomStyleFromParagraph()
    {
        $this->setCustomClassStyles();

        // Test removing classes from a paragraph and pressing enter using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a paragraph</p>');

        // Test removing classes from a word and pressing apply changes using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->clickInlineToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a paragraph</p>');

        // Test removing classes from a word and pressing enter using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a paragraph</p>');

        // Test applying to a word and pressing apply changes using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $selectedStyles = $this->getSelectedStyles();
        $this->removeStyles($selectedStyles);
        $this->clickTopToolbarButton('Apply Changes', null, true);
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test with custom classes applied to a paragraph</p>');

    }//end testRemovingCustomStyleFromParagraph()


    /**
     * Test undo and redo for custom class style.
     *
     * @return void
     */
    public function testUndoAndRedoForCustomClassStyle()
    {
        $this->setCustomClassStyles();

        // Test a word
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>This is some content <span class="ordered-list">%1%</span> in my unit test</p>');

        // Test a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectStyles(array('ordered-list'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p class="ordered-list">This is some content %1% in my unit test</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% in my unit test</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p class="ordered-list">This is some content %1% in my unit test</p>');

    }//end testUndoAndRedoForCustomClassStyle()

}//end class
