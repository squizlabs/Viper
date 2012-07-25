<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all ViperListPlugin unit tests should extend.
 */
abstract class AbstractFormatsUnitTest extends AbstractViperUnitTest
{


    /**
     * Checks the status of the format icons in the top toolbar.
     *
     * @param $pStatus     The status of the P icon
     * @param $divStatus   The status of the DIV icon
     * @param $quoteStatus The status of the quote icon
     * @param $preStatus   The status of the PRE icon
     *
     * @return void
     */
    protected function checkStatusOfFormatIconsInTheTopToolbar($pStatus=NULL, $divStatus=NULL, $quoteStatus=NULL, $preStatus=NULL)
    {
        $this->assertTrue($this->topToolbarButtonExists('P', $pStatus, TRUE), 'P icon should be '.$pStatus);
        $this->assertTrue($this->topToolbarButtonExists('DIV', $divStatus, TRUE), 'Div icon should be '.$divStatus);
        $this->assertTrue($this->topToolbarButtonExists('Quote', $quoteStatus, TRUE), 'Quote icon should be '.$quoteStatus);
        $this->assertTrue($this->topToolbarButtonExists('PRE', $preStatus, TRUE), 'PRE icon should be '.$preStatus);

    }//end checkStatusOfFormatIconsInTopToolbar()


    /**
     * Checks the status of the format icons in the inline toolbar.
     *
     * @param $pStatus     The status of the P icon
     * @param $divStatus   The status of the DIV icon
     * @param $quoteStatus The status of the quote icon
     * @param $preStatus   The status of the PRE icon
     *
     * @return void
     */
    protected function checkStatusOfFormatIconsInTheInlineToolbar($pStatus=NULL, $divStatus=NULL, $quoteStatus=NULL, $preStatus=NULL)
    {
        $this->assertTrue($this->inlineToolbarButtonExists('P', $pStatus, TRUE), 'P icon should be '.$pStatus);
        $this->assertTrue($this->inlineToolbarButtonExists('DIV', $divStatus, TRUE), 'Div icon should be '.$divStatus);
        $this->assertTrue($this->inlineToolbarButtonExists('Quote', $quoteStatus, TRUE), 'Quote icon should be '.$quoteStatus);
        $this->assertTrue($this->inlineToolbarButtonExists('PRE', $preStatus, TRUE), 'PRE icon should be '.$preStatus);

    }//end checkStatusOfFormatIconsInTheInlineToolbar()


}//end class

?>
