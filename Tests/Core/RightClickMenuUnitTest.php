<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_RightClickMenuUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that the cut menu is active.
     *
     * @return void
     */
    public function testCutMenuItem()
    {
        $this->selectKeyword(1);
        $this->cut(true);
        $this->assertHTMLMatch('<p>EIB MOZ %2%</p>');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>EIB MOZ %2%</p><p>%1%</p>');

    }//end testCutMenuItem()


        /**
     * Test that the copy menu is active.
     *
     * @return void
     */
    public function testCopyMenuItem()
    {
        $this->selectKeyword(1);
        $this->copy(true);
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ %2%</p>');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ %2%</p><p>%1%</p>');

    }//end testCopyMenuItem()


}//end class