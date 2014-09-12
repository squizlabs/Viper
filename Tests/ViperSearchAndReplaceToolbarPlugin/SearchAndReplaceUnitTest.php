<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperSearchAndReplaceToolbarPlugin_SearchAndReplaceUnitTest extends AbstractViperUnitTest
{


    /**
     * Test icon states.
     *
     * @return void
     */
    public function testIconStates()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->assertTrue($this->topToolbarButtonExists('searchReplace'), 'Toolbar button icon is not correct');

        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', 'disabled', TRUE), 'Find Next Icon should be disabled.');

        $this->type('federal');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', NULL, TRUE), 'Replace Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', NULL, TRUE), 'Replace All Icon should be enabled.');

    }//end testIconStates()


    /**
     * Test replace buttons are not active when it can't find the text.
     *
     * @return void
     */
    public function testReplaceButtonsNotActive()
    {
        $this->sikuli->click($this->findKeyword(1));


        $this->clickTopToolbarButton('searchReplace');
        $this->type('blah');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

    }//end testReplaceButtonsNotActive()


    /**
     * Test that you can perform a search wihtout replacing content.
     *
     * @return void
     */
    public function testSearchForContentAndEditingSearch()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('government');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('government', $this->getSelectedText(), 'government was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('webguide');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('webguide', $this->getSelectedText(), 'webguide was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('Audit');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('Audit', $this->getSelectedText(), 'Audit was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('endorsed');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('endorsed', $this->getSelectedText(), 'endorsed was not found in the content');

    }//end testSearchForContentAndEditingSearch()


    /**
     * Test that you can perform a search with FIND.
     *
     * @return void
     */
    public function testSearchForFindInContent()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);

        $this->assertEquals('find', $this->getSelectedText(), 'find was not found in the content');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('FIND', $this->getSelectedText(), 'FIND was not found in the content');

        // Check to see if it goes back to the top of the page
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('find', $this->getSelectedText(), 'find was not found in the content');

    }//end testSearchForFindInContent()


    /**
     * Test search and replace.
     *
     * @return void
     */
    public function testSearchAndReplace()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplace()


    /**
     * Test that you can find content and then replace it.
     *
     * @return void
     */
    public function testFindAndThenReplace()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);

        $this->clickField('Replace');
        $this->type('replace');
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testFindAndThenReplace()


    /**
     * Test that you can find content and then replace all.
     *
     * @return void
     */
    public function testFindAndThenReplaceAll()
    {
        $this->moveToKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('websites');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);

        $this->clickField('Replace');
        $this->type('test');
        $this->clickTopToolbarButton('Replace All', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government test (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal test to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testFindAndThenReplaceAll()


    /**
     * Test search and replace all.
     *
     * @return void
     */
    public function testSearchAndReplaceAll()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace All', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceAll()


    /**
     * Test undo after you perform a replace.
     *
     * @return void
     */
    public function testUndoAfterReplace()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testUndoAfterReplace()


    /**
     * Test that you can undo after you perform a replace all.
     *
     * @return void
     */
    public function testUndoAfterReplaceAll()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace All', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceAll()


    /**
     * Test search and replace last word in list.
     *
     * @return void
     */
    public function testSearchAndReplaceLastWordInList()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('templates');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional replace</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceLastWordInList()


    /**
     * Test performing a search and replace, closing the fields and opening them again.
     *
     * @return void
     */
    public function testSearchAndReplaceAfterClosingFields()
    {
        $this->sikuli->click($this->findKeyword(1));

        $this->clickTopToolbarButton('searchReplace');
        $this->type('FIND');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        // Close the search fields
        $this->clickTopToolbarButton('searchReplace', 'selected');
        $this->sikuli->click($this->findKeyword(1));

        // Open the search fields again and make sure only the Find Next button is enabled
        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceAfterClosingFields()

}//end class

?>
