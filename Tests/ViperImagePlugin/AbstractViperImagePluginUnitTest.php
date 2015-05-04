<?php
require_once 'AbstractViperUnitTest.php';

/**
 * An abstract class that all ViperImagePlugin unit tests should extend.
 */
abstract class AbstractViperImagePluginUnitTest extends AbstractViperUnitTest
{


     /**
      * Resize specified image to given width.
      *
      * Returns the rectangle of the image after resize.
      *
      * @param integer $size       The new width of the image.
      * @param integer $imageIndex The image index on the page.
      *
      * @return array
      */
    public function resizeImage($size, $imageIndex=0)
    {
        $selector = 'img';

        $imageRect   = $this->getBoundingRectangle($selector, $imageIndex);
        $rightHandle = $this->findImage('ImageHandle-se', '.Viper-image-handle-se', 0, true);

        $width = ($imageRect['x2'] - $imageRect['x1']);
        $diff  = ($size - $width);
        $newX  = ($this->sikuli->getX($rightHandle) + $diff + 9);
        $newY  = $this->sikuli->getY($rightHandle);

        $loc = $this->sikuli->createLocation($newX, $newY);

        $this->sikuli->dragDrop($rightHandle, $loc);

        $imageRect = $this->getBoundingRectangle($selector, $imageIndex);
        return $imageRect;

    }//end resizeImage()


    /**
     * Asserts that the resize handles are in the correct position for selected image.
     *
     * @param string  $selector The jQuery selector to use for finding the element.
     * @param integer $index    The element index of the resulting array.
     *
     * @return void
     */
    public function checkResizeHandles($selector, $index=0)
    {
        // Get the image rectangle.
        $image = $this->getBoundingRectangle($selector, $index);

        // Get both of the resize handles rectangles.
        $leftHandle  = $this->getBoundingRectangle('.Viper-image-handle-sw');
        $rightHandle = $this->getBoundingRectangle('.Viper-image-handle-se');

        $this->assertEquals(($image['x1'] - 10), $leftHandle['x1']);
        $this->assertEquals(($image['y2'] - 10), $leftHandle['y1']);

        $this->assertEquals(($image['x2'] - 10), $rightHandle['x1']);
        $this->assertEquals(($image['y2'] - 10), $rightHandle['y1']);

    }//end checkResizeHandles()


}//end class
