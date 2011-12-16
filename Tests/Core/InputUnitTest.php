<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_InputUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that typing standard characters work.
     *
     * @return void
     */
    public function testTextType()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.DELETE');

        $chars  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $chars .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $chars .= '~!@#$%^&*()_+{}|:"<>?   . ';

        $this->type($chars);

        $expected  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $expected .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $expected .= '~!@#$%^&amp;*()_+{}|:"&lt;&gt;?   . ';

        $this->assertHTMLMatch('<p>'.$expected.'</p><p>EIB MOZ</p>');

    }//end testTextType()


    /**
     * Test that typing replaces the selected text.
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
     * Test that using UP, DOWN, RIGHT, and LEFT arrows move caret correctly.
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
     * Test that removing characters using BACKSPACE works.
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
     * Test that removing characters using DELETE works.
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

    }//end testDelete()


    /**
     * Test that holding down SHIFT does select text.
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

    }//end testKeyboardSelection()


    /**
     * Test that selecting the whole content is possible with short cut.
     *
     * @return void
     */
    public function testSelectAllAndRemove()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');

        $this->type('abc');
        $this->assertHTMLMatch('<p>abc</p>');

    }//end testSelectAllAndRemove()


}//end class

?>
