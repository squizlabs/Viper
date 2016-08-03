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

        $toolbars = array(
                     'vitp'       => 'Inline Toolbar',
                     'topToolbar' => 'Top Toolbar',
                    );

        foreach ($toolbars as $toolbar => $toolbarName) {
            if ($statuses[$toolbar] !== FALSE) {
                foreach ($statuses[$toolbar] as $btn => $status) {
                    if ($$btn !== $status) {
                        $msg = 'Expected '.$btn.' button to be ';

                        if ($$btn === NULL) {
                            $msg .= 'not visible';
                        } else if ($$btn === TRUE) {
                            $msg .= 'enabled';
                        } else if ($$btn === FALSE) {
                            $msg .= 'disabled';
                        } else if ($$btn === 'active') {
                            $msg .= 'active';
                        }

                        $msg .= ' in '.$toolbarName.'.';
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
