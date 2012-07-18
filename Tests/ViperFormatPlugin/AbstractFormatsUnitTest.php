<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all ViperListPlugin unit tests should extend.
 */
abstract class AbstractFormatsUnitTest extends AbstractViperUnitTest
{


    /**
     * Checks the status of the format icons.
     *
     * @param $pStatus     The status of the P icon
     * @param $divStatus   The status of the DIV icon
     * @param $preStatus   The status of the PRE icon
     * @param $quoteStatus The status of the quote icon
     *
     * @return void
     */
    protected function checkStatusOfFormatIcons($pStatus=NULL, $divStatus=NULL, $preStatus=NULL, $quoteStatus=NULL)
    {
        $this->assertTrue($this->topToolbarButtonExists('P', $pStatus, TRUE), 'P icon should be '.$pStatus);
        $this->assertTrue($this->topToolbarButtonExists('DIV', $divStatus, TRUE), 'Div icon should be '.$divStatus);
        $this->assertTrue($this->topToolbarButtonExists('PRE', $preStatus, TRUE), 'PRE icon should be '.$preStatus);
        $this->assertTrue($this->topToolbarButtonExists('Quote', $quoteStatus, TRUE), 'Quote icon should be '.$quoteStatus);

    }//end checkStatusOfFormatIcons()

}//end class

?>
