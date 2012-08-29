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
     * @param integer $imageIndex The image index on the page.
     * @param integer $width      The new width of the image.
     *
     * @return array
     */
    public function resizeImage($imageIndex, $size)
    {
        $selector = 'img';

        $imageRect   = $this->getBoundingRectangle($selector, $imageIndex);
        $rightHandle = $this->findImage('ImageHandle-se', '.Viper-image-handle-se');

        $width  = ($imageRect['x2'] - $imageRect['x1']);
        $diff   = ($size - $width);
        $newX   = ($this->getX($rightHandle) + $diff + 9);
        $newY   = $this->getY($rightHandle);

        $loc = $this->createLocation($newX, $newY);

        $this->dragDrop($rightHandle, $loc);

        $imageRect = $this->getBoundingRectangle($selector, $imageIndex);
        return $imageRect;

    }//end resizeImage()

}//end class

?>
