<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_SpecialQuotesUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can different styles of quotes in the content
     *
     * @return void
     */
    public function testSepcialQuotes()
    {
        
        $this->moveToKeyword(1);
        sleep(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<p>First &rdquo;style&rdquo; and  &ldquo;second&ldquo; style</p>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>First &rdquo;style&rdquo; and  &ldquo;second&ldquo; style</p>');

    }//end testSepcialQuotes()


}//end class

?>