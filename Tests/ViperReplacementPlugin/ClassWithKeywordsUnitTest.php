<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ClassWithKeywordsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that classes can use keyword names.
     *
     * @return void
     */
    public function testApplyKeywordClassNames()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content <span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content <span data-viper-class="footnote-ref ((prop:className)) ((prop:className))" class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true">%1%</span> more test content</p>');

        // Using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content <span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content <span data-viper-class="footnote-ref ((prop:className)) ((prop:className))" class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true">%1%</span> more test content</p>');

    }//end testApplyKeywordClassNames()


    /**
     * Test that classes using keyword names can be removed.
     *
     * @return void
     */
    public function testRemoveKeywordClassNames()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass','active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content %1% more test content</p>');

        // Using top toolbar
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass','active');
        sleep(1);
        $this->clearFieldValue('Class');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content %1% more test content</p>');

    }//end testRemoveKeywordClassNames()


    /**
     * Test that classes using keyword names can be formatted.
     *
     * @return void
     */
    public function testFormattingKeywordClassNames()
    {
        // Test bold
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');

        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }

        $this->clickTopToolbarButton('bold', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));

        $this->assertHTMLMatch('<p>%1% <strong><span class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></strong> %2%</p>');
        $this->assertRawHTMLMatch('<p>%1% <strong><span class="footnote-ref replaced-className replaced-className" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></strong> %2%</p>');

        // Test for remove format
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');

        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }

        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NULL));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));

        // Revert
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');

        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }

        $this->clickInlineToolbarButton('cssClass', NULL);
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');

        // Test italic
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));

        $this->assertHTMLMatch('<p>%1% <em><span class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></em> %2%</p>');
        $this->assertRawHTMLMatch('<p>%1%<em><span class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></em> %2%</p>');

        // Test for remove format
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));

        // Revert
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickInlineToolbarButton('cssClass', NULL);
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');

        // Test strikethrough
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));

        $this->assertHTMLMatch('<p>%1% <del><span class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></del> %2%</p>');
        $this->assertRawHTMLMatch('<p>%1%<del><span class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></del> %2%</p>');

        // Test for remove format
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));

        // Revert
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickInlineToolbarButton('cssClass', NULL);
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');

        // Test superscript
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));

        $this->assertHTMLMatch('<p>%1% <sup><span class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></sup> %2%</p>');
        $this->assertRawHTMLMatch('<p>%1%<sup><span class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></sup> %2%</p>');

        // Test for remove format
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));

        // Revert
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickInlineToolbarButton('cssClass', NULL);
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');

        // Test subscript
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));

        $this->assertHTMLMatch('<p>%1% <sub><span class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></sub> %2%</p>');
        $this->assertRawHTMLMatch('<p>%1%<sub><span class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">Test content.</span></sub> %2%</p>');

        // Test for remove format
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', NUll));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
    }//end testFormattingKeywordClassNames()

}
