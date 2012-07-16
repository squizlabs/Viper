<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_CleanDOMUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that cleanDOM method of Viper works correctly.
     *
     * @return void
     */
    public function testCleanDOM()
    {
        $this->execJS('viper.cleanDOM()');

        $expected = '<p>test</p><p><img src="" /><br /><span>test</span></p><ul><li>test</li></ul><table><tbody><tr><td></td></tr></tbody></table><table><tbody><tr><td>test</td></tr></tbody></table><h2>test</h2><p><br /><a name="test"></a><a id="test2" href="">test</a></p>';

        $this->assertHTMLMatch($expected);

    }//end testCleanDOM()


    /**
     * Test that cleanDOM method of Viper works correctly.
     *
     * @return void
     */
    public function testCleanDOMFiltered()
    {
        $this->execJS('viper.cleanDOM(dfx.getTag("p")[3])');

        $expected = '<p>test</p><p><img src="" /><br /><span>test</span></p><ul><li>test</li></ul><table><tbody><tr><td></td></tr></tbody></table><table><tbody><tr><td>test</td></tr></tbody></table><h2>test</h2><p><br /><a name="test"></a><a id="test2" href="">test</a></p>';

        $this->assertHTMLMatch($expected);

    }//end testCleanDOMFiltered()


}//end class

?>
