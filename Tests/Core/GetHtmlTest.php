<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_GetHtmlTest extends AbstractViperUnitTest
{


    /**
     * Test that getHTML handles blank table cell.
     *
     * @return void
     */
    public function testGetHtmlWithBlankTableCell()
    {
        $this->click($this->find('Lorem'));
        
        $originalHTML = '<table style="width: 100%; " id="test" border="1"><tbody><tr><th></th><th id="testr1c2">2</th></tr><tr><td headers="testr1c1">&nbsp; </td><td headers="testr1c2">&nbsp; </td></tr><tr><td headers="testr1c1">&nbsp; </td><td headers="testr1c2"></td></tr></tbody></table>';
        
        $this->execJS('setHtml("<table style="width: 100%; " id="test" border="1"><tbody><tr><th></th><th id="testr1c2">2</th></tr><tr><td headers="testr1c1">&nbsp; </td><td headers="testr1c2">&nbsp; </td></tr><tr><td headers="testr1c1">&nbsp; </td><td headers="testr1c2"></td></tr></tbody></table>")');
        
        sleep(3);
        
        $returnedHTML = $this->getHtml();
        
        $assertEqual($originalHTML, $returnedHTML);

    }//end testGetHtml()


}//end class

?>
