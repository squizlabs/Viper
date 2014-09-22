<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that copying/pasting a simple text works.
     *
     * @return void
     */
    public function testSimpleTextCopyPaste()
    {
        // Copy and paste without deleteing text
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>%1%A</p><p>%1%B</p><p>%1%C</p>');

        // Delete all content, add new content and then copy and paste
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('%1% This is one line of content %2%');
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p>');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p>');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test that right click menu and paste works.
     *
     * @return void
     */
    public function testRightClickPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->paste(TRUE);

        sleep(1);
        $this->assertHTMLMatch('<p>%1%</p><p>%1%</p>');

    }//end testRightClickPaste()


    /**
     * Test that copying/pasting bold text works.
     *
     * @return void
     */
    public function testBoldTextCopyPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(1);

        $this->assertHTMLMatch('<p><strong>XAXA</strong></p><p><strong>XAXB</strong></p><p><strong>XAXC</strong></p>');

    }//end testBoldTextCopyPaste()


   /**
     * Test that copying/pasting italic text works.
     *
     * @return void
     */
    public function testItalicTextCopyPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(1);

        $this->assertHTMLMatch('<p><em>XAXA</em></p><p><em>XAXB</em></p><p><em>XAXC</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that copying/pasting German content.
     *
     * @return void
     */
    public function testCopyPasteGermanContent()
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/GermanContent.txt'));
        $this->assertHTMLMatch('<p>Am letzten Tag der 62. Tagung des WHO-Regionalkomitees für Europa verabschiedeten die Mitgliedstaaten die Strategie und den Aktionsplan für gesundes Altern in der Europäischen Region (2012 to 2020) (nach der Erörterung dieses Dokuments am dritten Tag) sowie den Europäischen Aktionsplan zur Stärkung der Kapazitäten und Angebote im Bereich der öffentlichen Gesundheit.  Europäischer Aktionsplan zur Stärkung der Kapazitäten und Angebote im Bereich der öffentlichen Gesundheit  In seiner Vorstellung des Aktionsplans sagte Dr. Hans Kluge, Direktor der Abteilung für Gesundheitssysteme und öffentliche Gesundheit, dass dies ein großartiger Moment sei, „weil die Thematik öffentliche Gesundheit in der Europäischen Region wieder mit Leben gefüllt" werde. Er führte aus, dass der Plan in umfassenden Konsultationen in der Absicht entwickelt worden sei, die integrierte Leistungserbringung für Gesundheitsschutz, Krankheitsprävention und Gesundheitsförderung zu stärken.  Angesichts der Veränderungen der Gesellschaften des 21. Jahrhunderts (Globalisierung, Überalterung der Bevölkerung, Klimawandel) sei eine erneute Betonung der öffentlichen Gesundheit zeitlich und inhaltlich angebracht, weil so trotz knapper Kassen optimale gesundheitliche Ergebnisse möglich seien.  Der Plan sei in Übereinstimmung mit dem Rahmenkonzept „Gesundheit 2020" aufgestellt worden und baue auf einer soliden Grundlage aus Erkenntnissen auf, unter anderem durch Untersuchungen zu den Angeboten im Bereich der öffentlichen Gesundheit in 41 der 53 Mitgliedstaaten. Das Kernstück des Aktionsplans bildeten die zehn überarbeiteten grundlegenden gesundheitspolitischen Maßnahmen (EPHO):</p>');

    }//end testCopyPasteGermanContent()


    /**
     * Test that copying/pasting french content.
     *
     * @return void
     */
    public function testCopyPasteFrenchContent()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/FrenchContent.txt'));
        $this->assertHTMLMatch('<p>Lors de la dernière journée de la soixante-deuxième session du Comité régional de l\'OMS pour l\'Europe, les États membres de la Région européenne ont adopté la Stratégie (Plan d\'action) pour vieillir en bonne santé en Europe, 2012-2020 (examinée lors de la 3e journée), et le Plan d\'action européen pour le renforcement des capacités et services de santé publique. Plan d\'action européen pour le renforcement des capacités et services de santé publique  En présentant le Plan d\'action européen, le docteur Hans Kluge, directeur de la Division des systèmes de santé et de la santé publique, fait remarquer qu\'il s\'agit d\'un grand moment, étant donné la nouveau souffle accordé à la santé publique dans la Région européenne. Il explique que le Plan d\'action a été élaboré dans le cadre d\'un vaste processus de consultation pour renforcer la prestation de services intégrés en matière de protection de la santé, de prévention des maladies et de promotion de la santé.  Compte tenu des défis confrontés par la société au XXIe siècle (mondialisation, vieillissement de la population, changement climatique), un recentrage sur la santé publique est à la fois opportun et approprié afin d\'obtenir les meilleurs résultats sanitaires avec des ressources limitées.  Le Plan d\'action a été formulé conformément au cadre politique de la santé, Santé 2020, et s\'inspire d\'informations factuelles solides, notamment de plusieurs études réalisées sur les services de santé publique dans 41 des 53 États membres de la Région européenne. Dix opérations essentielles de santé publique révisées sont à la base du Plan d\'action :</p>');

    }//end testCopyPasteFrenchContent()


    /**
     * Test that copying/pasting a LibreOffice document works.
     *
     * @return void
     */
    public function testCopyPasteLibreOfficeDoc()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/LibreOfficeDoc.txt'));
        $this->assertHTMLMatch('<h1>Heading 1</h1><p>This is a document that has been created using LibreOffice</p><h2>Heading 2</h2><p>More text under heading two.</p><p>Numbered list:</p><ol><li>One</li><li>Two</li><li>Three</li></ol><p>Ordered List:</p><ul><li>One</li><li>Two</li><li>Three</li></ul>');

    }//end testCopyPasteLibreOfficeDoc()


    /**
     * Test copying and pasting different block elements.
     *
     * @return void
     */
    public function testCopyPasteBlockElements()
    {
        // Test paragraph
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>This is a paragraph section %1%</p>');

        // Test div
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><div>This is a div section %2%</div>');

        // Test pre
        $this->useTest(2);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><pre>This is a pre section %3%</pre>');

        // Test quote
        $this->useTest(2);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><blockquote><p>This is a quote section %4%</p></blockquote><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote>');

    }//end testCopyPasteBlockElements()


    /**
     * Test copy and pasting a heading.
     *
     * @return void
     */
    public function testCopyPasteHeading()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>This is a paragraph %2%</p><h1>Heading One %1%</h1><h2>Heading Two %3%</h2><p>This is another paragraph %4%</p>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>This is a paragraph %2%</p><h1>Heading One %1%</h1><h2>Heading Two %3%</h2><p>This is another paragraph %4%</p><h2>Heading Two %3%</h2>');

    }//end testCopyPasteHeading()


    /**
     * Test copy and pasting an image.
     *
     * @return void
     */
    public function testCopyPasteImage()
    {
        $this->useTest(4);

        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /><p>This is the second paragraph in the content of the page %1%</p><p></p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" />');

    }//end testCopyPasteImage()


    /**
     * Test copy and pasting acroynm, abbreviation and language.
     *
     * @return void
     */
    public function testCopyPasteLanguageSettings()
    {
        $this->useTest(5);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is the <span lang="en">first</span> <acronym title="abc">paragraph</acronym> in the <abbr title="def">content</abbr> of the page %2%</p><p>This is the second one %2%</p><p>%1% This is the <span lang="en">first</span> <acronym title="abc">paragraph</acronym> in the <abbr title="def">content</abbr> of the page %2%</p>');

    }//end testCopyPasteLanguageSettings()


    /**
     * Test copy and pasting direction settings.
     *
     * @return void
     */
    public function testCopyPasteDirectionSettings()
    {
        $this->useTest(6);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p dir="rtl">Write this text right-to-left %1%</p><p dir="ltr">Write this text left-to-right %2%</p><p dir="auto">Auto setting for direction %3%</p><p>Last paragraph %4%</p><p dir="rtl">Write this text right-to-left %1%</p>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p dir="rtl">Write this text right-to-left %1%</p><p dir="ltr">Write this text left-to-right %2%</p><p dir="auto">Auto setting for direction %3%</p><p>Last paragraph %4%</p><p dir="ltr">Write this text left-to-right %2%</p><p dir="rtl">Write this text right-to-left %1%</p>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p dir="rtl">Write this text right-to-left %1%</p><p dir="ltr">Write this text left-to-right %2%</p><p dir="auto">Auto setting for direction %3%</p><p>Last paragraph %4%</p><p dir="auto">Auto setting for direction %3%</p><p dir="ltr">Write this text left-to-right %2%</p><p dir="rtl">Write this text right-to-left %1%</p>');

    }//end testCopyPasteDirectionSettings()

}//end class

?>
