<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_ScrollingUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that when you click outside of the window and back in, the cursor remains in the same location.
     *
     * @return void
     */
    public function testScrollWhenClickingOutsideWindow()
    {
        $this->clickKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');

        $this->clickKeyword(2);

        // Get the coordinates of the cursor before clicking outside of the window
        $initalCursorCoords = $this->getScrollCoords();

        // Click outside the window and back in
        $this->clickOutside();
        $this->clickKeyword(2);

        // Get the coordinates of the current cursor position
        $currentCursorCoords = $this->getScrollCoords();

        // Check the x coordinate
        $this->assertEquals($initalCursorCoords['x'], $currentCursorCoords['x']);

        // Check the y coordinate
        $this->assertEquals($initalCursorCoords['y'], $currentCursorCoords['y']);

    }//end testScollWhenClickingOutsideWindow()


}//end class

?>
