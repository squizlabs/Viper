<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AlignmentWithImagesUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test that you can apply different alignments to an image.
     *
     * @return void
     */
    public function testAligningAnImage()
    {
        $this->useTest(1);

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight'), 'Right justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter'), 'Center justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'disabled'), 'Block justify icon appears in the top toolbar');

        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="float: left; margin: 1em 1em 1em 0px;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="margin: 1em auto; display: block;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="float: right; margin: 1em 0px 1em 1em;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');

    }//end testAligningAnImage()


    /**
     * Test that you can apply different alignments to a paragraph that has an image.
     *
     * @return void
     */
    public function testAligningAParagraphWithImage()
    {
        // Test with image and content in paragraph

        $this->useTest(1);

        $this->clickElement('img', 0);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight'), 'Right justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter'), 'Center justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock'), 'Block justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: left;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: center;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: right;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: justify;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');

        // Test with image only in paragraph
        $this->useTest(2);

        $this->clickElement('img', 0);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight'), 'Right justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter'), 'Center justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock'), 'Block justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: left;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" /></p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: center;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" /></p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: right;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" /></p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p style="text-align: justify;"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" /></p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" /></p>');

    }//end testAligningAParagraphWithImage()


    /**
     * Test dragging an image into the content of the page and changing its alignment.
     *
     * @return void
     */
    public function testDragAndDropImageAndChaningAlignment()
    {
        $this->skipTestFor('windows', array('ie9', 'ie8'));

        // Drag image in and left align it
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(1));
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>X<img alt="dragDropImage" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" style="float:left; margin:1em 1em 1em 0px;" />AX Content to test drag and drop images</p><p>Another paragraph</p><p>Another paragraph in the content %2%</p>');

        // Check the toolbar icon is active
        $this->clickElement('img', 0);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left justify icon is not active in the top toolbar');

        // Check the toolbar icon is not active when you click away
        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');

        // Drag image in and center align it
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(1));
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>X<img alt="dragDropImage" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" style="margin: 1em auto; display: block;" />AX Content to test drag and drop images</p><p>Another paragraph</p><p>Another paragraph in the content %2%</p>');

        // Check the toolbar icon is active
        $this->clickElement('img', 0);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center justify icon is not active in the top toolbar');

        // Check the toolbar icon is not active when you click away
        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');

        // Drag image in and right align it
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(1));
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>X<img alt="dragDropImage" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" style="margin: 1em 0px 1em 1em; float: right;" />AX Content to test drag and drop images</p><p>Another paragraph</p><p>Another paragraph in the content %2%</p>');

        // Check the toolbar icon is active
        $this->clickElement('img', 0);
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right justify icon is not active in the top toolbar');

        // Check the toolbar icon is not active when you click away
        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');

    }//end testDragAndDropImageAndChaningAlignment()

}//end class

?>
