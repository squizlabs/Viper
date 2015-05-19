<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_DragAndDropUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test dragging an image into the content of the page.
     *
     * @return void
     */
    public function testDragAndDropImage()
    {
        $this->clickKeyword(1);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(1));
        sleep(1);

        $this->assertHTMLMatch('<p>X<img alt="dragDropImage.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content XBX</p>');

        // Edit the image using the inline toolbar 
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>X<img alt="Alt tag" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content XBX</p>');

        // Edit the image using the top toolbar 
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->clickField('Alt');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>X<img alt="test" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content XBX</p>');
        
    }//end testDragAndDropImage()


    /**
     * Test dragging multiple images into the content of the page.
     *
     * @return void
     */
    public function testDragAndDropMultipleImages()
    {
        // Drag and drop first image
        $this->clickKeyword(1);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(1));
        sleep(1);
        $this->assertHTMLMatch('<p>X<img alt="dragDropImage.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content XBX</p>');

        // Edit the image so we know the second image is different
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>X<img alt="Alt tag" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content XBX</p>');

        // Drag and drop second image
        $this->clickKeyword(2);
        sleep(1);
        $this->dragDropFromDesktop($this->findKeyword(2));
        sleep(1);
        $this->assertHTMLMatch('<p>X<img alt="Alt tag" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />AX Content to test drag and drop images</p><p>Another paragraph in the content X<img alt="dragDropImage.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" />BX</p>');
        
    }//end testDragAndDropMultipleImages()


    /**
     * Test dragging an image onto a page with no content.
     *
     * @return void
     */
    public function testDragAndDropImageOnEmptyPage()
    {
        $this->clickKeyword(1);
        $dragLocation = $this->findKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->dragDropFromDesktop($dragLocation);

        $this->assertHTMLMatch('<p><img alt="dragDropImage.png" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" /></p>');

        // Edit the image using the inline toolbar 
        $this->clickElement('img', 0);
        sleep(1);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><img alt="Alt tag" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAIAAAD2HxkiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArtJREFUeNrs1sENAiEQQFE10wcFOCXKiRYpQDrxYgkTNMt7BZAw7M/s/fl634DfeRgBiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAjUi6qD5mimyWmyL5sQ/I4CIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRgggBEYIIARGCCAERggiB7eIa18i+vOWx5mg2ISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhIEIQIYgQECGIEBAhiBAQIYgQECGIEBAhiBDYJoygxBzt5OtnX74BmxBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIIgRECCIERAgiBEQIfyiMoET2ZQjYhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQkCEIEJAhCBCQIQgQhAhIEIQISBCECEgQhAhIEIQISBCECEgQhAhsEVc4xpzNG+JTQiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECCIERAgiBEQIIgRECCIERAgiBEQIIgQ2iaqDsi/TBJsQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIiBBECIgQRAiIEEQIfH0EGAALzRF1eGaQ8QAAAABJRU5ErkJggg==" /></p>');
        
    }//end testDragAndDropImageOnEmptyPage()

}//end class

?>