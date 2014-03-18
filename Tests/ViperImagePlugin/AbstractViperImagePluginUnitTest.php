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
        $rightHandle = $this->findImage('ImageHandle-se', '.Viper-image-handle-se');

        $width  = ($imageRect['x2'] - $imageRect['x1']);
        $diff   = ($size - $width);
        $newX   = ($this->sikuli->getX($rightHandle) + $diff + 9);
        $newY   = $this->sikuli->getY($rightHandle);

        $loc = $this->sikuli->createLocation($newX, $newY);

        $this->sikuli->dragDrop($rightHandle, $loc);

        $imageRect = $this->getBoundingRectangle($selector, $imageIndex);
        return $imageRect;

    }//end resizeImage()

}//end class

?>
