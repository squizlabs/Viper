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
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('Simple'));

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_searchAndReplace.png'), 'Toolbar button icon is not correct');

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('federal');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_findNext.png'), 'Find Next icon should be not be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replace_disabled.png'), 'Replace icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replaceAll_disabled.png'), 'Replace all icon should be disabled');

        $this->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_findNext.png'), 'Find Next icon should be not be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replace_disabled.png'), 'Replace icon should be not be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replaceAll_disabled.png'), 'Replace all icon should not be disabled');

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_findNext.png'), 'Find Next icon should be not be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replace.png'), 'Replace icon should be not be disabled');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_replaceAll.png'), 'Replace all icon should not be disabled');

    }//end testIconStates()


    /**
     * Test that you can perform a search wihtout replacing content.
     *
     * @return void
     */
    public function testSearchForContentAndEditingSearch()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('government');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('government', $this->getSelectedText(), 'government was not found in the content');

        $searchBox = $this->find($dir.'input_search.png', $this->getTopToolbar());
        $this->click($searchBox);

        for ($i = 11; $i >= 0; $i -= 1) {
            $this->keyDown('Key.BACKSPACE');
        }

        $this->type('webguide');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('webguide', $this->getSelectedText(), 'webguide was not found in the content');

        $searchBox = $this->find($dir.'input_search.png', $this->getTopToolbar());
        $this->click($searchBox);

        for ($i = 8; $i >= 0; $i -= 1) {
            $this->keyDown('Key.BACKSPACE');
        }

        $this->type('Audit');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('Audit', $this->getSelectedText(), 'Audit was not found in the content');

        $searchBox = $this->find($dir.'input_search.png', $this->getTopToolbar());
        $this->click($searchBox);

        for ($i = 6; $i >= 0; $i -= 1) {
            $this->keyDown('Key.BACKSPACE');
        }

        $this->type('endorsed');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('endorsed', $this->getSelectedText(), 'endorsed was not found in the content');

    }//end testSearchForContentAndEditingSearch()


    /**
     * Test that you can perform a search with FIND.
     *
     * @return void
     */
    public function testSearchForFindInContent()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('FIND');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');

        $this->assertEquals('find', $this->getSelectedText(), 'find was not found in the content');

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('FIND', $this->getSelectedText(), 'FIND was not found in the content');

        // Check to see if it goes back to the top of the page
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->assertEquals('find', $this->getSelectedText(), 'find was not found in the content');

    }//end testSearchForFindInContent()


    /**
     * Test search and replace.
     *
     * @return void
     */
    public function testSearchAndReplace()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('FIND');
        $this->keyDown('Key.TAB');
        $this->type('replace');
        $replaceButton = $this->find($dir.'toolbarIcon_replace.png', $this->getTopToolbar());

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->click($replaceButton);

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->click($replaceButton);

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplace()


    /**
     * Test search and replace all.
     *
     * @return void
     */
    public function testSearchAndReplaceAll()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('FIND');
        $this->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_replaceAll.png');

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceAll()


    /**
     * Test undo after you perform a replace.
     *
     * @return void
     */
    public function testUndoAfterReplace()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('FIND');
        $this->keyDown('Key.TAB');
        $this->type('replace');
        $replaceButton = $this->find($dir.'toolbarIcon_replace.png', $this->getTopToolbar());

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->click($replaceButton);

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/redoIcon_active.png');
        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testUndoAfterReplace()


    /**
     * Test that you can undo after you perform a replace all.
     *
     * @return void
     */
    public function testUndoAfterReplaceAll()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('FIND');
        $this->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_replaceAll.png');

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/redoIcon_active.png');
        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines replace at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of replace 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional templates</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceAll()


    /**
     * Test search and replace last word in list.
     *
     * @return void
     */
    public function testSearchAndReplaceLastWordInList()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->click($this->find('Simple'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_searchAndReplace.png');
        $this->type('templates');
        $this->keyDown('Key.TAB');
        $this->type('replace');
        $replaceButton = $this->find($dir.'toolbarIcon_replace.png', $this->getTopToolbar());

        $this->clickTopToolbarButton($dir.'toolbarIcon_findNext.png');
        $this->click($replaceButton);

        $this->assertHTMLMatch('<h1>Simple Viper Example</h1><p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines find at the minimum compliance level (Single A) by the end of 2012. In addition, the Australian Government requires all federal websites to meet the medium conformance level (Double A) by the end of FIND 2014.</p><p>Further information at <a href="http://webguide.gov.au/accessibility-usability/accessibility/%20">http://webguide.gov.au/accessibility-usability/accessibility/</a> and <a href="http://www.w3.org/TR/WCAG20/">http://www.w3.org/TR/WCAG20/</a>.</p><ul><li>Audit of Homepage and 6 Section Landing pages</li><li>4 additional replace</li><li>Audit of 20 additional pages for content</li><li>Accessibility audit report</li><li>Recommendations and action plan</li><li>Squiz Matrix content accessibility guide</li></ul>');

    }//end testSearchAndReplaceLastWordInList()


}//end class

?>
