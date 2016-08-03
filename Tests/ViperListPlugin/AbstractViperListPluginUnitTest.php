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
     * @param mixed $listUL                     The status of the unordered list button.
     * @param mixed $listOL                     The status of the ordered list button.
     * @param mixed $listIndent                 The status of the list indent button.
     * @param mixed $listOutdent                The status of the list outdent button.
     * @param mixed $inlineCreateListVisible    FALSE if the create list buttons are not visible in the inline toolbar.
     * @param mixed $inlineIndentOutdentVisible FALSE if the indent/outdent list buttons are not visible in the inline toolbar.
     *
     * @return void
     */
    protected function assertIconStatusesCorrect(
        $listUL=NULL,
        $listOL=NULL,
        $listIndent=NULL,
        $listOutdent=NULL,
        $inlineCreateListVisible=TRUE,
        $inlineIndentOutdentVisible=TRUE
    ) {
        $icons = array(
                  'listUL',
                  'listOL',
                  'listIndent',
                  'listOutdent',
                 );

        $statuses = $this->sikuli->execJS('gListBStatus()');

        $toolbars = array(
                     'vitp'       => 'Inline Toolbar',
                     'topToolbar' => 'Top Toolbar',
                    );

        foreach ($toolbars as $toolbar => $toolbarName) {
            if ($statuses[$toolbar] !== FALSE) {
                foreach ($statuses[$toolbar] as $btn => $status) {
                    $expectedStatus = $$btn;

                    if ($toolbar === 'vitp') {
                        if (($btn === 'listUL' || $btn === 'listOL') && $inlineCreateListVisible === FALSE) {
                            if ($status !== NULL) {
                                $this->fail('Expected '.$btn.' button to be not visible in Inline Toolbar');
                            } else {
                                continue;
                            }
                        } else if (($btn === 'listIndent' || $btn === 'listOutdent') && $inlineIndentOutdentVisible === FALSE) {
                            if ($status !== NULL) {
                                $this->fail('Expected '.$btn.' button to be not visible in Inline Toolbar');
                            } else {
                                continue;
                            }
                        }
                    }

                    if ($expectedStatus !== $status) {
                        $msg = 'Expected '.$btn.' button to be ';

                        if ($expectedStatus === NULL) {
                            $msg .= 'not visible';
                        } else if ($expectedStatus === TRUE) {
                            $msg .= 'enabled';
                        } else if ($expectedStatus === FALSE) {
                            $msg .= 'disabled';
                        } else if ($expectedStatus === 'active') {
                            $msg .= 'active';
                        }

                        $msg .= ' in '.$toolbarName.' but it was ';

                        if ($status === NULL) {
                            $msg .= 'not visible.';
                        } else if ($status === TRUE) {
                            $msg .= 'enabled.';
                        } else if ($status === FALSE) {
                            $msg .= 'disabled.';
                        } else if ($status === 'active') {
                            $msg .= 'active.';
                        }

                        $this->fail($msg);
                    }
                }
            }
        }

    }//end assertIconStatusesCorrect()


    /**
     * Get the content of Viper without stripping the blank LI tags.
     *
     * @return string
     */
    protected function getHtmllWithBlankLiTags()
    {
        $html = $this->sikuli->execJS('Viper.Util.getHtml(Viper.Util.getid(\'content\'))');
        $html = str_replace('<br>', '', $html);

        return $html;

    }//end _getHtmllWithBlankLiTags


}//end class

?>
