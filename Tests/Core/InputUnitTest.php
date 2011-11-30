<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_InputUnitTest extends AbstractViperUnitTest
{


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testTextType()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.DELETE');
        $this->type('Testing input');

        $this->assertHTMLMatch('<p>Testing input</p><p>EIB MOZ</p>');

    }//end testNoToolbarAtStart()


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testTextTypeReplaceSelection()
    {
        $text = $this->selectText('Lorem');

        $this->type('Testing input');

        $this->assertHTMLMatch('<p>Testing input</p><p>EIB MOZ</p>');

    }//end testTextTypeReplaceSelection()


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testKeyboradNavigation()
    {
        $text = $this->selectText('Lorem');
        $this->type('Testing input');

        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->type('L');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->type('R');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.DOWN');
        $this->type('D');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.UP');
        $this->type('U');
        $this->keyDown('Key.CMD + Key.RIGHT');
        $this->type('X');
        $this->keyDown('Key.CMD + Key.LEFT');
        $this->type('X');

        $this->assertHTMLMatch('<p>XTUesting LinRputX</p><p>EIB MODZ</p>');

    }//end testKeyboradNavigation()


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testBackspace()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.CMD + b');
        $this->type('test');
        $this->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->keyDown('Key.ENTER');
        $this->type('Testing...');

        for ($i = 0; $i < 30; $i++) {
            $this->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p><br></p><p>EIB MOZ</p>');

    }//end testBackspace()


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testDelete()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.CMD + b');
        $this->type('test');
        $this->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->keyDown('Key.ENTER');
        $this->type('Testing...');

        for ($i = 0; $i < 30; $i++) {
            $this->keyDown('Key.LEFT');
        }

        for ($i = 0; $i < 30; $i++) {
            $this->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>IB MOZ</p>');

    }//end testBackspace()


    /**
     * Unit Test for Viper.
     *
     * @return void
     */
    public function testKeyboardSelection()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->type('p');
        $text = $this->selectText('MOZ');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->type('p');
        $this->assertHTMLMatch('<p>pp</p>');

    }//end testBackspace()


}//end class

?>
