<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all ViperViewSourcePlugin unit tests should extend.
 */
abstract class AbstractViperViewSourcePluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Returns the full path of the specified image file name.
     *
     * @param string $img The image file name.
     *
     * @return string
     */
    protected function getImg($img)
    {
        $path = dirname(__FILE__).'/Images/'.$img;
        return $path;

    }//end getImg()


    /**
     * Overrides the default window size of the browser for list tests.
     *
     * @return array
     */
    protected function getDefaultWindowSize()
    {
        $size = array(
                 'w' => 1300,
                 'h' => 900,
                );

        return $size;

    }//end getDefaultWindowSize()


}//end class

?>
