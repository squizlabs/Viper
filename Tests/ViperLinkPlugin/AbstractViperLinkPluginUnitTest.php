<?php

require_once 'AbstractViperUnitTest.php';

/**
 * An abstract class that all sub unit tests should extend.
 */
abstract class AbstractViperLinkPluginUnitTest extends AbstractViperUnitTest
{

    /**
     * Returns the Apply Changes button text.
     *
     * @return array
     */
    protected function getButtonText($name, $toolbar=null)
    {
        if ($name === 'update') {
            $name = 'Update Link';
        } else {
            $name = 'Insert Link';
        }

        return $name;

    }//end getButtonText()


}//end class