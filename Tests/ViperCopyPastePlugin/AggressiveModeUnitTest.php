<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_AggressiveModeUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

    /**
     * Test that copying/pasting from the Aggressive mode doc for word correctly with aggressive mode off.
     *
     * @return void
     */
    public function testAggressiveModeDocWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));

        $this->copyAndPasteFromWordDoc('AggressiveModeDoc.txt', '<h1>Word Document for Aggressive Mode Testing</h1><p>This is some content.</p><p style="text-align:center;">This is some content that has been centre aligned.</p><p style="text-align:right;">This is some content that has been right aligned.</p><p style="text-align:justify;">This is some<strong>content</strong> that has been justified.</p><p style="text-align:justify; text-indent:-14.2pt;"><img alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" height="137" hspace="9" src="" width="92" />Lorem ipsum<del>dolor</del> sit amet, consectetur adipiscing elit. Fusce consequat pellentesque aliquam. Phasellus hendrerit laoreet gravida. Suspendisse ac lectus sit amet neque luctus blandit quis eget quam. Maecenas maximus ullamcorper maximus. Nunc eu tortor turpis. Nulla pharetra tristique gravida. Suspendisse imperdiet quam arcu, quis interdum ipsum mattis non. Fusce a posuere elit. Pellentesque eget elit lorem. Duis gravida velit pulvinar nunc scelerisque, sed commodo mauris laoreet. Integer sodales lacus eget posuere dictum. Aenean imperdiet sagittis commodo. Donec convallis sem nisi, vel tincidunt risus efficitur eu. Cras id bibendum odio. Praesent laoreet malesuada lorem ut congue. Sed dignissim velit orci, vitae suscipit turpis rhoncus ac</p><p style="text-align:justify;">This is a list:</p><ol><li>Asdadsads<ol type="a"><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ol type="i"><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ol></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ol></li><li>Asdadsasd</li><li>Sfdsfds</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td><td><p>Cell 4</p></td><td><p>Cell 5</p></td></tr><tr><td><p>Cell 6</p></td><td><p>Cell 7</p></td><td><p>Cell 8</p></td><td><p>Cell 9</p></td><td><p>Cell 10</p></td></tr></tbody></table>');

    }//end testAggressiveModeDocWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the Aggressive Mode doc for word correctly with aggressive mode on.
     *
     * @return void
     */
    public function testAggressiveModeDocWithAggressiveModeOn()
    {
        $this->copyAndPasteFromWordDoc('AggressiveModeDoc.txt', '<h1>Word Document for Aggressive Mode Testing</h1><p>This is some content.</p><p>This is some content that has been centre aligned.</p><p>This is some content that has been right aligned.</p><p>This is some<strong>content</strong> that has been justified.</p><p><img alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" height="137" hspace="9" src="" width="92" />Lorem ipsum<del>dolor</del> sit amet, consectetur adipiscing elit. Fusce consequat pellentesque aliquam. Phasellus hendrerit laoreet gravida. Suspendisse ac lectus sit amet neque luctus blandit quis eget quam. Maecenas maximus ullamcorper maximus. Nunc eu tortor turpis. Nulla pharetra tristique gravida. Suspendisse imperdiet quam arcu, quis interdum ipsum mattis non. Fusce a posuere elit. Pellentesque eget elit lorem. Duis gravida velit pulvinar nunc scelerisque, sed commodo mauris laoreet. Integer sodales lacus eget posuere dictum. Aenean imperdiet sagittis commodo. Donec convallis sem nisi, vel tincidunt risus efficitur eu. Cras id bibendum odio. Praesent laoreet malesuada lorem ut congue. Sed dignissim velit orci, vitae suscipit turpis rhoncus ac</p><p>This is a list:</p><ol><li>Asdadsads<ol type="a"><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ol type="i"><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ol></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ol></li><li>Asdadsasd</li><li>Sfdsfds</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td><td><p>Cell 4</p></td><td><p>Cell 5</p></td></tr><tr><td><p>Cell 6</p></td><td><p>Cell 7</p></td><td><p>Cell 8</p></td><td><p>Cell 9</p></td><td><p>Cell 10</p></td></tr></tbody></table>');

    }//end testAggressiveModeDocWithAggressiveModeOn()


    /**
     * Test that copying/pasting from the Aggressive mode doc for google docs correctly with aggressive mode off.
     *
     * @return void
     */
    public function testAggressiveModeDocFromGoogleDocsWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));
        
        $this->copyAndPasteFromGoogleDocs('AggressiveModeDoc.txt', '<h1>Document for Aggressive Mode Testing</h1><p>This is some content.</p><p style="text-align:center;">This is some content that has been centre aligned.</p><p style="text-align:right;">This is some content that has been right aligned.</p><p style="text-align:justify;">This is some<strong>content</strong> that has been justified.</p><p style="text-align:justify; text-indent:-14pt;">Lorem ipsum<del>dolor</del> sit amet, consectetur adipiscing elit. Fusce consequat pellentesque aliquam. Phasellus hendrerit laoreet gravida. Suspendisse ac lectus sit amet neque luctus blandit quis eget quam. Maecenas maximus ullamcorper maximus. Nunc eu tortor turpis. Nulla pharetra tristique gravida. Suspendisse imperdiet quam arcu, quis interdum ipsum mattis non. Fusce a posuere elit. Pellentesque eget elit lorem. Duis gravida velit pulvinar nunc scelerisque, sed commodo mauris laoreet. Integer sodales lacus eget posuere dictum. Aenean imperdiet sagittis commodo. Donec convallis sem nisi, vel tincidunt risus efficitur eu. Cras id bibendum odio. Praesent laoreet malesuada lorem ut congue. Sed dignissim velit orci, vitae suscipit turpis rhoncus ac</p><p style="text-align:justify;">This is a list:</p><p style="text-indent:-18pt;">1)&nbsp;&nbsp;&nbsp;&nbsp;Asdadsads</p><p style="text-indent:-18pt;">a)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dsfsdfsfd</p><p style="text-indent:-18pt;">b)&nbsp;&nbsp;&nbsp;&nbsp;Sdfsdfsfd</p><p style="text-indent:-18pt;">i)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sfd</p><p style="text-indent:-18pt;">ii)&nbsp;&nbsp;&nbsp;&nbsp;Sfdsfd</p><p style="text-indent:-18pt;">iii)&nbsp;&nbsp;&nbsp;Dsfsdf</p><p style="text-indent:-18pt;">iv)&nbsp;&nbsp;&nbsp;sdfsdf</p><p style="text-indent:-18pt;">c)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sdfsdfsfd</p><p style="text-indent:-18pt;">d)&nbsp;&nbsp;&nbsp;&nbsp;sdfsdfsfd</p><p style="text-indent:-18pt;">2)&nbsp;&nbsp;&nbsp;&nbsp;Asdadsasd</p><p style="text-indent:-18pt;">3)&nbsp;&nbsp;&nbsp;&nbsp;Sfdsfds</p><p style="text-indent:-18pt;">4)&nbsp;&nbsp;&nbsp;&nbsp;Asdasdasd</p><p style="text-align:justify; text-indent:-18pt;">5)&nbsp;&nbsp;&nbsp;&nbsp;Asdasdasd</p><div><table style="border:none; border-collapse:collapse;"><colgroup><col width="114"><col width="114"><col width="115"><col width="115"><col width="115"></colgroup><tbody><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 1</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 2</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 3</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 4</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 5</p></td></tr><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 6</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 7</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 8</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 9</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:19px 19px 19px 19px;"><p>Cell 10</p></td></tr></tbody></table></div>');

    }//end testAggressiveModeDocFromGoogleDocsWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the Aggressive mode doc for google docs correctly with aggressive mode on.
     *
     * @return void
     */
    public function testAggressiveModeDocFromGoogleDocsWithAggressiveModeOn()
    {   
        $this->copyAndPasteFromGoogleDocs('AggressiveModeDoc.txt', '<h1>Document for Aggressive Mode Testing</h1><p>This is some content.</p><p>This is some content that has been centre aligned.</p><p>This is some content that has been right aligned.</p><p>This is some<strong>content</strong> that has been justified.</p><p>Lorem ipsum<del>dolor</del> sit amet, consectetur adipiscing elit. Fusce consequat pellentesque aliquam. Phasellus hendrerit laoreet gravida. Suspendisse ac lectus sit amet neque luctus blandit quis eget quam. Maecenas maximus ullamcorper maximus. Nunc eu tortor turpis. Nulla pharetra tristique gravida. Suspendisse imperdiet quam arcu, quis interdum ipsum mattis non. Fusce a posuere elit. Pellentesque eget elit lorem. Duis gravida velit pulvinar nunc scelerisque, sed commodo mauris laoreet. Integer sodales lacus eget posuere dictum. Aenean imperdiet sagittis commodo. Donec convallis sem nisi, vel tincidunt risus efficitur eu. Cras id bibendum odio. Praesent laoreet malesuada lorem ut congue. Sed dignissim velit orci, vitae suscipit turpis rhoncus ac</p><p>This is a list:</p><p>1)&nbsp;&nbsp;&nbsp;&nbsp;Asdadsads</p><p>a)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dsfsdfsfd</p><p>b)&nbsp;&nbsp;&nbsp;&nbsp;Sdfsdfsfd</p><p>i)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sfd</p><p>ii)&nbsp;&nbsp;&nbsp;&nbsp;Sfdsfd</p><p>iii)&nbsp;&nbsp;&nbsp;Dsfsdf</p><p>iv)&nbsp;&nbsp;&nbsp;sdfsdf</p><p>c)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sdfsdfsfd</p><p>d)&nbsp;&nbsp;&nbsp;&nbsp;sdfsdfsfd</p><p>2)&nbsp;&nbsp;&nbsp;&nbsp;Asdadsasd</p><p>3)&nbsp;&nbsp;&nbsp;&nbsp;Sfdsfds</p><p>4)&nbsp;&nbsp;&nbsp;&nbsp;Asdasdasd</p><p>5)&nbsp;&nbsp;&nbsp;&nbsp;Asdasdasd</p><div><table><colgroup><col width="114"><col width="114"><col width="115"><col width="115"><col width="115"></colgroup><tbody><tr style="height:0px;"><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td><td><p>Cell 4</p></td><td><p>Cell 5</p></td></tr><tr style="height:0px;"><td><p>Cell 6</p></td><td><p>Cell 7</p></td><td><p>Cell 8</p></td><td><p>Cell 9</p></td><td><p>Cell 10</p></td></tr></tbody></table></div>');

    }//end testAggressiveModeDocFromGoogleDocsWithAggressiveModeOn()

}//end class

?>