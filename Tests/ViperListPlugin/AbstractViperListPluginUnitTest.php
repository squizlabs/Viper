<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all ViperListPlugin unit tests should extend.
 */
abstract class AbstractViperListPluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Overrides the default window size of the browser for list tests.
     *
     * @return array
     */
    protected function getDefaultWindowSize()
    {
        $size = array(
                 'w' => 1300,
                 'h' => 900,
                );

        return $size;

    }//end getDefaultWindowSize()


    /**
     * Checks that the icon statuses are correct.
     *
     * @param mixed $listUL      The status of the unordered list button.
     * @param mixed $listOL      The status of the ordered list button.
     * @param mixed $listIndent  The status of the list indent button.
     * @param mixed $listOutdent The status of the list outdent button.
     *
     * @return void
     */
    protected function assertIconStatusesCorrect(
        $listUL=NULL,
        $listOL=NULL,
        $listIndent=NULL,
        $listOutdent=NULL
    ) {
        $icons = array(
                  'listUL',
                  'listOL',
                  'listIndent',
                  'listOutdent',
                 );

        $statuses = $this->sikuli->execJS('gListBStatus()');

        if ($statuses['vitp'] !== FALSE) {
            foreach ($statuses['vitp'] as $btn => $status) {
                if ($status !== NULL && $$btn === NULL) {
                    $this->fail('Expected '.$btn.' button to be not visible in inline toolbar.');
                } else if ($status === 'active' && $$btn !== 'active') {
                    $this->fail('Expected '.$btn.' button to be active in inline toolbar.');
                } else if ($status === TRUE && $$btn === FALSE) {
                    $this->fail('Expected '.$btn.' button to be disabled in inline toolbar.');
                } else if ($status === FALSE && $$btn === TRUE) {
                    $this->fail('Expected '.$btn.' button to be enabled in inline toolbar.');
                }
            }
        }

        foreach ($statuses['topToolbar'] as $btn => $status) {
            if ($status === TRUE && ($$btn === FALSE || $$btn === NULL)) {
                $this->fail('Expected '.$btn.' button to be disabled in top toolbar.');
            } else if ($status === 'active' && $$btn !== 'active') {
                $this->fail('Expected '.$btn.' button to be active in top toolbar.');
            } else if ($status === FALSE && $$btn === TRUE) {
                $this->fail('Expected '.$btn.' button to be enabled in top toolbar.');
            }
        }

    }//end assertIconStatusesCorrect()


}//end class

?>
