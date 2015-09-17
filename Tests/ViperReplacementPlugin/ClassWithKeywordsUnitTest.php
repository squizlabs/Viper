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

        $expectedRawHTML = '<p>Test content <span data-viper-attribite-keywords="true" class="footnote-ref replaced-className ((prop:className))" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);
        $this->assertHTMLMatch('<p>Test content <span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content</p>');

        $expectedRawHTML = '<p>Test content <span data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className)) ((prop:className))" class="footnote-ref replaced-className ((prop:className))">%1%</span> more test content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

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
        $this->sikuli->KeyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');

        $expectedRawHTML = '<p>Test content %1% more test content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->clearFieldValue('Class');
        $this->sikuli->KeyDown('Key.ENTER');
        
        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');

        $expectedRawHTML = '<p>Test content %1% more test content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testRemoveKeywordClassNames()

}