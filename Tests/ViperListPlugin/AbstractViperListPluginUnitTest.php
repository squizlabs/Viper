<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all ViperListPlugin unit tests should extend.
 */
abstract class AbstractViperListPluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Returns the full path of the specified image file name.
     *
     * @param string $img The image file name.
     *
     * @return string
     */
    protected function getImg($img)
    {
        $path = dirname(__FILE__).'/Images/'.$img;
        return $path;

    }//end getImg()


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

        $statuses = $this->execJS('gListBStatus()');

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


    /**
     * Test that unordered list icon is displayed for paragraph and text selection.
     *
     * @return void
     */
    public function testListIconsOnSelection()
    {
        $this->selectText('XabcX', 'VmumV');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectText('XabcX', 'TicT');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectText('VmumV');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListIconsOnSelection()


    /**
     * Test that list tools are not available when selection is inside a non P element.
     *
     * @return void
     */
    public function testNoToolsForNonPTag()
    {
        $this->selectText('SoD');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testNoToolsForNonPTag()
    
    
     /**
     * Test that the heading icon is not available for a list.
     *
     * @return void
     */
    public function testHeadingIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

    }//end testHeadingIconNotAvailableForList()
    
    
     /**
     * Test that the formats icon is not available for a list.
     *
     * @return void
     */
    public function testFormatsIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_disabled.png'), 'Formats icon should not appear in the top toolbar.');

    }//end testFormatsIconNotAvailableForList()


}//end class

?>
