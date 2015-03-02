<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_ViperTestDocUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the ViperTestDoc for word correctly.
     *
     * @return void
     */
    public function testViperTestDocFromWord()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/ViperTestDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/ViperTestDoc.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/ViperTestDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->pasteFromURL($testFile);
        sleep(5);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<h1>Lorem Ipsum</h1><p>Lorem Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.<a href="http://www.google.com.au">Suspendisse</a> vehicula tortor a purus vestibulum eget bibendum est auctor. Donec neque turpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p style="text-indent:36.0pt;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum</h2><p><img alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" height="137" hspace="9" src="" width="92" />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ul type="disc"><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.<ul type="circle"><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.<ul type="square"><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien.</li></ul><h3>Lorem ipsum</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p style="text-align:center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p style="text-align:right;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.e.</p><p style="text-align:justify;">Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><table border="1" style="width:100%;"><thead><tr><th><p style="text-align:justify;"><strong>Col1 Header</strong></p></th><th><p style="text-align:justify;"><strong>Col2 Header</strong></p></th><th><p style="text-align:justify;"><strong>Col3 Header</strong></p></th></tr></thead><tbody><tr><td><p style="text-align:justify;">nec porta ante</p></td><td><p style="text-align:justify;">sapien vel aliquet</p></td><td><ul><li>purus neque luctus ligula, vel molestie   arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><p style="text-align:justify;">nec porta ante</p></td><td colspan="2"><p style="text-align:justify;">purus neque luctus<a href="http://www.google.com"><strong>ligula</strong></a>,   vel molestie arcu</p></td></tr><tr><td><p style="text-align:justify;">nec<strong>porta</strong> ante</p></td><td><p style="text-align:justify;">sapien vel aliquet</p></td><td rowspan="2"><p style="text-align:justify;">purus neque luctus   ligula, vel molestie arcu</p></td></tr><tr><td colspan="2"><p style="text-align:justify;">sapien vel aliquet</p></td></tr></tbody></table><p><strong></strong></p><h2>Lorem ipsum</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol start="1" type="1"><li>Lorem ipsum dolor sit amet, consectetur      adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.<ol start="1" type="a"><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li></ol></li><li>Praesent in sapien sapien.</li></ol><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol start="1" type="1"><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.<ul type="circle"><li>Phasellus ornare ipsum nec felis       lacinia a feugiat lectus pellentesque.</li><li>Praesent in sapien sapien.</li></ul></li><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li></ol>');

    }//end testViperTestDocFromWord()


    /**
     * Test that copying/pasting from the ViperTestDoc for google docs correctly.
     *
     * @return void
     */
    public function testViperTestDocFromGoogleDocs()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/GoogleDocs/ViperTestDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/ViperTestDoc.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/ViperTestDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->pasteFromURL($testFile);
        sleep(5);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<h1>Lorem Ipsum</h1><p></p><p><a href="https://docs.google.com/document/d/1DDQJFrZY2Eanb8Xb9DUFoO7VJ2yAzpJ_98AktrxZZes/edit#heading=h.tmgvruiv680s">Lorem Ipsum</a></p><p><a href="https://docs.google.com/document/d/1DDQJFrZY2Eanb8Xb9DUFoO7VJ2yAzpJ_98AktrxZZes/edit#heading=h.83e52c4bamuc">Lorem ipsum</a></p><p><a href="https://docs.google.com/document/d/1DDQJFrZY2Eanb8Xb9DUFoO7VJ2yAzpJ_98AktrxZZes/edit#heading=h.t7jnslynqd3u">Lorem ipsum</a></p><p><a href="https://docs.google.com/document/d/1DDQJFrZY2Eanb8Xb9DUFoO7VJ2yAzpJ_98AktrxZZes/edit#heading=h.oe7h0parjkek">Lorem ipsum</a></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.<a href="http://www.google.com.au"> Suspendisse</a> vehicula tortor a purus vestibulum eget bibendum est auctor. Donec neque turpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p style="text-indent:36pt;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum<img alt="Buzzinator - 2.png" height="64px;" src="https://lh3.googleusercontent.com/foUxGmAEtME7rD9nsLl2Kp2mPoJhWckhB9YO7JxMBXkPmv92bhRoSCxPPDwIJ_FIayMpRw8bHDMPSBZuthrAzp-wcUrVAJ3dk75IYA3a4l-N0ojrRfiKAwqnFjk5wDvf8U0CJrQ" style="border:none;" width="64px;" /></h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ul><li style="list-style-type:disc;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style="list-style-type:disc;">Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.<ul><li style="list-style-type:circle;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style="list-style-type:circle;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.<ul><li style="list-style-type:square;">Praesent in sapien sapien</li></ul></li><li style="list-style-type:circle;">Praesent in sapien sapien</li></ul></li><li style="list-style-type:disc;">Praesent in sapien sapien.</li></ul><h3>Lorem ipsum</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p style="text-align:center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p style="text-align:right;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.e.</p><p style="text-align:justify;">Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><div><table style="border:none; border-collapse:collapse;"><colgroup><col width="248"><col width="250"><col width="126"></colgroup><tbody><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;"><strong>Col1 Header</strong></p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;"><strong>Col2 Header</strong></p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;"><strong>Col3 Header</strong></p></td></tr><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">nec porta ante</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">sapien vel aliquet</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><ul><li style="list-style-type:disc;">purus neque luctus ligula, vel molestie arcu</li><li style="list-style-type:disc;">purus neque luctus</li><li style="list-style-type:disc;">vel molestie arcu</li></ul></td></tr><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">nec porta ante</p></td><td colspan="2" style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">purus neque luctus<a href="http://www.google.com"><strong>ligula</strong></a>, vel molestie arcu</p></td></tr><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">nec<strong>porta</strong> ante</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">sapien vel aliquet</p></td><td rowspan="2" style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">purus neque luctus ligula, vel molestie arcu</p></td></tr><tr style="height:0px;"><td colspan="2" style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p style="text-align:justify;">sapien vel aliquet</p></td></tr></tbody></table></div><p><strong></strong></p><h2>Lorem ipsum</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li style="list-style-type:decimal;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style="list-style-type:decimal;">Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.<ol><li style="list-style-type:lower-alpha;">Lorem ipsum dolor sit amet, consectetur adipiscing elit</li><li style="list-style-type:lower-alpha;">Lorem ipsum dolor sit amet, consectetur adipiscing elit</li></ol></li><li style="list-style-type:decimal;">Praesent in sapien sapien.</li></ol><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li style="list-style-type:decimal;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.<ul><li style="list-style-type:circle;">Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.</li><li style="list-style-type:circle;">Praesent in sapien sapien.</li></ul></li><li style="list-style-type:decimal;">Lorem ipsum dolor sit amet, consectetur adipiscing elit</li></ol>');

    }//end testViperTestDocFromGoogleDocs()

}//end class

?>