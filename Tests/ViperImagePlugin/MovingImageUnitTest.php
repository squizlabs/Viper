<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_MovingImageUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test moving an image.
     *
     * @return void
     */
    public function testMovingAnImage()
    {
        $this->useTest(1);
        $this->clickElement('img', 0);
        sleep(1);
        $this->clickInlineToolbarButton('move');
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        $this->sikuli->click($this->sikuli->getMouseLocation());
        $this->assertTrue($this->topToolbarButtonExists('bold', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NULL));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('image', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('link', NULL));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', NULL));
        $this->assertTrue($this->topToolbarButtonExists('charmap', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('langtools', NULL));
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1%<img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" /> XuT %2%</p><p>LABS is ORSM</p>');
        
        //Test for revert after disabling move and deselecting image
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listUL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1%<img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/> XuT %2%</p><p>LABS is ORSM</p>');

        //Test for image with a hyperlink
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        $this->sikuli->click($this->sikuli->getMouseLocation());
        $this->assertTrue($this->topToolbarButtonExists('bold', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NULL));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('image', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', NULL));
        $this->assertTrue($this->topToolbarButtonExists('charmap', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('langtools', NULL));
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1%<a href="www.youtube.com/watch?v=J---aiyznGQ" title="test"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" /></a> XuT %2%</p><p>LABS is ORSM</p>');

        //Test for revert after disabling move and deselecting image
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));;
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listUL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1%<a href="www.youtube.com/watch?v=J---aiyznGQ" title="test"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" /></a> XuT %2%</p><p>LABS is ORSM</p>');
    }//end testMovingAnImage()

}//end class

?>