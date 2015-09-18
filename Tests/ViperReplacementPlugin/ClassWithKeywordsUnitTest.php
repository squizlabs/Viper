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
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass','active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickKeyword(1);
        
        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content %1% more test content</p>');
        
    }//end testRemoveKeywordClassNames()

}