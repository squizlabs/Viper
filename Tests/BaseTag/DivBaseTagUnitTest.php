// <?php

// require_once 'AbstractViperUnitTest.php';

// class Viper_Tests_Core_DivBaseTagUnitTest extends AbstractViperUnitTest
// {

//     /**
//      * Test how the div base tag effects bold formatting.
//      *
//      * @return void
//      */
//     public function testBoldFormatting()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test adding content to bold content
//         $this->useTest(2);
//         $this->moveToKeyword(1, 'right');
//         $this->type(' test');
//         $this->assertHTMLMatch('<div><strong>%1% test</strong></div>');

//         // Test deleting bold content and adding new content wraps it in DIV tags
//         $this->useTest(2);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         $this->useTest(2);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.BACKSPACE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test highlighting and replacing bold content wraps text in DIV tags only
//         $this->useTest(2);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that enter key inside bold content splits the container.
//         $this->useTest(3);
//         $this->moveToKeyword(1, 'right');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->type('test');
//         $this->assertHTMLMatch('<p><strong>%1%</strong></p><p><strong>test %2%</strong></p><div><strong>test</strong></div>');

//         // Test that removing whole content by selecting all and typing characters uses the available block tag.
//         $this->useTest(4);
//         $this->selectKeyword(1);
//         $this->type('test');
//         sleep(1);
//         $this->assertHTMLMatch('<p>test</p>');

//         $this->useTest(4);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test applying bold using keyboard shortcuts
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.CMD + b');
//         $this->assertHTMLMatch('<div><strong>%1%</strong></div>');

//         // Test applying bold using the top toolbar
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold');
//         $this->assertHTMLMatch('<div><strong>%1%</strong></div>');

//         // Test applying bold to multiple tags using keyboard shortcuts
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.CMD + a');
//         sleep(1);
//         $this->sikuli->keyDown('Key.CMD + b');
//         sleep(1);
//         $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><div><strong>test</strong></div>');

//         // Test applying bold to multiple tags using the top toolbar
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->clickTopToolbarButton('bold');
//         $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><div><strong>test</strong></div>');

//     }// end testBoldFormatting()


//     /**
//      * Test how the div base tag effects italic formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputItalicFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test that typing characters in a node with a block parent remain in
//         // the block tag.
//         $this->useTest(7);
//         $this->moveToKeyword(1, 'right');
//         $this->type(' test');
//         $this->assertHTMLMatch('<div><em>%1% test</em></div>');

//         // Test that enter key inside a paragraph still splits the container.
//         $this->useTest(8);
//         $this->moveToKeyword(1, 'right');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->type('test');
//         $this->assertHTMLMatch('<p><em>%1%</em></p><p><em>test %2%</em></p><div><em>test</em></div>');

//         // Test that removing whole content and typing does wrap text in a block
//         // element.
//         $this->useTest(7);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // does wrap text in a block element if there is a block element already.
//         $this->useTest(7);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // uses the available block tag.
//         $this->useTest(10);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<p>test</p>');

//         $this->useTest(10);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test applying italic using keyboard shortcuts
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('Italic');
//         $this->assertHTMLMatch('<div><em>%1%</em></div>');

//         // Test applying italic using the top toolbar
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic');
//         $this->assertHTMLMatch('<div><em>%1%</em></div>');

//         // Test applying italic to multiple tags using keyboard shortcuts
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->getOSAltShortcut('Italic');
//         $this->assertHTMLMatch('<p><em>%1% %2%</em></p><div><em>test</em></div>');

//         // Test applying italic to multiple tags using the top toolbar
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->clickTopToolbarButton('italic');
//         $this->assertHTMLMatch('<p><em>%1% %2%</em></p><div><em>test</em></div>');

//     }// end testDivBaseTagInputItalicFormat()


//     /**
//      * Test how the div base tag effects strikethrough formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputStrikethroughFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test that typing characters in a node with a block parent remain in
//         // the block tag.
//         $this->useTest(11);
//         $this->moveToKeyword(1, 'right');
//         $this->type(' test');
//         $this->assertHTMLMatch('<div><del>%1% test</del></div>');

//         // Test that enter key inside a paragraph still splits the container.
//         $this->useTest(12);
//         $this->moveToKeyword(1, 'right');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->type('test');
//         $this->assertHTMLMatch('<p><del>%1%</del></p><p><del>test %2%</del></p><div><del>test</del></div>');


//         // Test that removing whole content and typing does wrap text in a block
//         // element.
//         $this->useTest(11);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // does wrap text in a block element if there is a block element already.
//         $this->useTest(11);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // uses the available block tag.
//         $this->useTest(14);
//         $this->selectKeyword(1);
//         $this->type('test');
//         sleep(1);
//         $this->assertHTMLMatch('<p>test</p>');

//         $this->useTest(14);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test applying italic
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough');
//         $this->assertHTMLMatch('<div><del>%1%</del></div>');

//         // Test applying italic to multiple tags
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->clickTopToolbarButton('strikethrough');
//         $this->assertHTMLMatch('<p><del>%1% %2%</del></p><div><del>test</del></div>');
//     }// end testDivBaseTagInputStrikethroughFormat()


//     /**
//      * Test how the div base tag effects subscript formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputSubscriptFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test that typing characters in a node with a block parent remain in
//         // the block tag.
//         $this->useTest(15);
//         sleep(1);
//         $this->moveToKeyword(1, 'right');
//         sleep(1);
//         $this->type(' test');
//         $this->assertHTMLMatch('<div><sub>%1% test</sub></div>');

//         // Test that enter key inside a paragraph still splits the container.
//         $this->useTest(16);
//         $this->moveToKeyword(1, 'right');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->type('test');
//         $this->assertHTMLMatch('<p><sub>%1%</sub></p><p><sub>test %2%</sub></p><div><sub>test</sub></div>');

//         // Test that removing whole content and typing does wrap text in a block
//         // element.
//         $this->useTest(15);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // does wrap text in a block element if there is a block element already.
//         $this->useTest(15);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // uses the available block tag.
//         $this->useTest(18);
//         $this->selectKeyword(1);
//         $this->type('test');
//         sleep(1);
//         $this->assertHTMLMatch('<p>test</p>');

//         $this->useTest(18);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test applying italic using the top toolbar
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript');
//         $this->assertHTMLMatch('<div><sub>%1%</sub></div>');

//         // Test applying italic to multiple tags using the top toolbar
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->clickTopToolbarButton('subscript');
//         $this->assertHTMLMatch('<p><sub>%1% %2%</sub></p><div><sub>test</sub></div>');
//     }// end testDivBaseTagInputSubscriptFormat()


//     /**
//      * Test how the div base tag effects superscript formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputSuperscriptFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test that typing characters in a node with a block parent remain in
//         // the block tag.
//         $this->useTest(19);
//         $this->moveToKeyword(1, 'right');
//         sleep(1);
//         $this->type(' test');
//         $this->assertHTMLMatch('<div><sup>%1% test</sup></div>');

//         // Test that enter key inside a paragraph still splits the container.
//         $this->useTest(20);
//         $this->moveToKeyword(1, 'right');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->type('test');
//         $this->assertHTMLMatch('<p><sup>%1%</sup></p><p><sup>test %2%</sup></p><div><sup>test</sup></div>');

//         // Test that removing whole content and typing does wrap text in a block
//         // element.
//         $this->useTest(19);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // does wrap text in a block element if there is a block element already.
//         $this->useTest(19);
//         $this->selectKeyword(1);
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test that removing whole content by selecting all and typing characters
//         // uses the available block tag.
//         $this->useTest(22);
//         $this->selectKeyword(1);
//         $this->type('test');
//         sleep(1);
//         $this->assertHTMLMatch('<p>test</p>');

//         $this->useTest(22);
//         $this->selectKeyword(1);
//         $this->sikuli->keyDown('Key.DELETE');
//         $this->type('test');
//         $this->assertHTMLMatch('<div>test</div>');

//         // Test applying italic using the top toolbar
//         $this->useTest(1);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript');
//         $this->assertHTMLMatch('<div><sup>%1%</sup></div>');

//         // Test applying italic to multiple tags using the top toolbar
//         $this->useTest(6);
//         $this->selectKeyword(1);
//         $this->getOSAltShortcut('SelectAll');
//         $this->clickTopToolbarButton('superscript');
//         $this->assertHTMLMatch('<p><sup>%1% %2%</sup></p><div><sup>test</sup></div>');
//     }// end testDivBaseTagInputSuperscriptFormat()


//     /**
//      * Test how div base tag is effected by links
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinks()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Test links in top toolbar
//         // Test applying links
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');
//         $this->clickTopToolbarButton('link', 'active-selected');

//         // Test removing link without title
//         $this->clickTopToolbarButton('linkRemove');
//         $this->assertHTMLMatch('<div>%1% test content</div>');

//         // Test removing link with title
//         $this->useTest(25);
//         sleep(2);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('linkRemove');
//         $this->assertHTMLMatch('<div>%1%test content</div>');

//         // Test adding title
//         $this->useTest(24);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a>test content</div>');

//         // Test removing title
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a>test content</div>');

//         // Test modifying title
//         $this->useTest(25);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link" title="modified-title">%1%</a>test content</div>');

//         // Test links in inline toolbar
//         // Test applying links
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test removing link without title
//         $this->clickTopToolbarButton('linkRemove');
//         $this->assertHTMLMatch('<div>%1% test content</div>');

//         // Test removing link with title
//         $this->useTest(25);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('linkRemove');
//         $this->assertHTMLMatch('<div>%1%test content</div>');

//         // Test adding title
//         $this->useTest(24);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a>test content</div>');

//         // Test removing title
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a>test content</div>');

//         // Test modifying title
//         $this->useTest(25);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><a href="test-link" title="modified-title">%1%</a>test content</div>');

//     }// end testDivBaseTagInputLinks()


//     /**
//      * Test how the div base tag effects bold and link formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinkBoldFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Using top toolbar
//         // Test applying link to bold formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold', NULL);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//         // Test removing bold from linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying bold to linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold', NULL);
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//         // Test removing link from bold formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

//         // Test applying link and title to bold formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

//         // Test removing bold format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling bold format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('bold', NULL);
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

//         // Test modifying title of link with bold formatting
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="modified-title">%1%</a></strong> test content</div>');

//         // Test removing title of link from bold formatted content
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//         // Using inline toolbar
//         // Test applying link to bold formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('bold', NULL);
//         $this->clickInlineToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//         // Test removing bold from linked content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('bold', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying bold to linked content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('bold', NULL);
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//         // Test removing link from bold formatted content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

//         // Test applying link and title to bold formatted content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

//         // Test removing bold format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('bold', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling bold format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('bold', NULL);
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

//         // Test modifying title of link with bold formatting
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         sleep(1);
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickInlineToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><strong><a href="test-link" title="modified-title">%1%</a></strong> test content</div>');

//         // Test removing title of link from bold formatted content
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

//     }// end testDivBaseTagInputLinkBoldFormat()


//     /**
//      * Test how the div base tag effects italic and link formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinkItalicFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Using top toolbar
//         // Test applying link to italic formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic', NULL);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//         // Test removing italic from linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying italic to linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic', NULL);
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//         // Test removing link from italic formatted content
//         $this->selectKeyword(1);
//         sleep(2);
//         $this->clickTopToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

//         // Test applying link and title to italic formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

//         // Test removing italic format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling italic format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('italic', NULL);
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

//         // Test modifying title of link with italic formatting
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="modified-title">%1%</a></em> test content</div>');

//         // Test removing title of link from italic formatted content
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//         // Using inline toolbar
//         // Test applying link to italic formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('italic', NULL);
//         $this->clickInlineToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//         // Test removing italic from linked content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('italic', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying italic to linked content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('italic', NULL);
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//         // Test removing link from italic formatted content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

//         // Test applying link and title to italic formatted content
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

//         // Test removing italic format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('italic', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling italic format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickInlineToolbarButton('italic', NULL);
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

//         // Test modifying title of link with italic formatting
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickInlineToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><em><a href="test-link" title="modified-title">%1%</a></em> test content</div>');

//         // Test removing title of link from italic formatted content
//         $this->clickInlineToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

//     }// end testDivBaseTagInputLinkItalicFormat()


//     /**
//      * Test how the div base tag effects strikethrough and link formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinkStrikethroughFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Using top toolbar
//         // Test applying link to strikethrough formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough', NULL);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

//         // Test removing strikethrough from linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying strikethrough to linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough', NULL);
//         $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

//         // Test removing link from strikethrough formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><del>%1%</del> test content</div>');

//         // Test applying link and title to strikethrough formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><del><a href="test-link" title="test-title">%1%</a></del> test content</div>');

//         // Test removing strikethrough format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling strikethrough format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('strikethrough', NULL);
//         $this->assertHTMLMatch('<div><del><a href="test-link" title="test-title">%1%</a></del> test content</div>');

//         // Test modifying title of link with strikethrough formatting
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><del><a href="test-link" title="modified-title">%1%</a></del> test content</div>');

//         // Test removing title of link from strikethrough formatted content
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

//     }// end testDivBaseTagInputLinkStrikethroughFormat()


//     /**
//      * Test how the div base tag effects subscript and link formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinkSubscriptFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Using top toolbar
//         // Test applying link to subscript formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript', NULL);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

//         // Test removing subscript from linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying subscript to linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript', NULL);
//         $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

//         // Test removing link from subscript formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><sub>%1%</sub> test content</div>');

//         // Test applying link and title to subscript formatted content
//         $this->selectKeyword(1);
//         sleep(3);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sub><a href="test-link" title="test-title">%1%</a></sub> test content</div>');

//         // Test removing subscript format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling subscript format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('subscript', NULL);
//         $this->assertHTMLMatch('<div><sub><a href="test-link" title="test-title">%1%</a></sub> test content</div>');

//         // Test modifying title of link with subscript formatting
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->clickField('Title');
//         $this->type('modified-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sub><a href="test-link" title="modified-title">%1%</a></sub> test content</div>');

//         // Test removing title of link from subscript formatted content
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

//     }// end testDivBaseTagInputLinkSubscriptFormat()


//     /**
//      * Test how the div base tag effects superscript and link formatting.
//      *
//      * @return void
//      */
//     public function testDivBaseTagInputLinkSuperscriptFormat()
//     {
//         $this->useTest(1);
//         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

//         // Using top toolbar
//         // Test applying link to superscript formatted content
//         $this->useTest(23);
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript', NULL);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

//         // Test removing superscript from linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

//         // Test applying superscript to linked content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript', NULL);
//         $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

//         // Test removing link from superscript formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('linkRemove', NULL);
//         $this->assertHTMLMatch('<div><sup>%1%</sup> test content</div>');

//         // Test applying link and title to superscript formatted content
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('link', NULL);
//         $this->type('test-link');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickField('Title');
//         $this->type('test-title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sup><a href="test-link" title="test-title">%1%</a></sup> test content</div>');

//         // Test removing superscript format from linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript', 'active');
//         $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

//         // Test appling superscript format to linked content with title
//         $this->selectKeyword(1);
//         $this->clickTopToolbarButton('superscript', NULL);
//         $this->assertHTMLMatch('<div><sup><a href="test-link" title="test-title">%1%</a></sup> test content</div>');

//         // Test modifying title of link with superscript formatting
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         sleep(1);
//         $this->clickField('Title');
//         $this->type('modified-title');
//         sleep(2);
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->clickTopToolbarButton('link', 'active-selected');
//         $this->assertHTMLMatch('<div><sup><a href="test-link" title="modified-title">%1%</a></sup> test content</div>');

//         // Test removing title of link from superscript formatted content
//         $this->clickTopToolbarButton('link', 'active');
//         $this->clearFieldValue('Title');
//         $this->sikuli->keyDown('Key.ENTER');
//         $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

//     }// end testDivBaseTagInputLinkSuperscriptFormat()


// }//end class
