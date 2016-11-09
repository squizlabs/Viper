<?php
require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarIFrameUnitTest extends AbstractViperUnitTest
{

    /**
     * Use the iframe template for these tests.
     *
     * @var string
     */
    protected $templateMode = 'Web/test-iframe-template';


    /**
     * Test that VITP appears in the correct position when the Viper element is inside an iframe.
     *
     * @return void
     */
    public function testInlineToolbarPosition()
    {
        $this->useTest(1);
        $this->selectKeyword(1);

    }//end testInlineToolbarPosition()


}//end class
