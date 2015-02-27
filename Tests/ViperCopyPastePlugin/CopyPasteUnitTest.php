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
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>%1%A</p><p>%1%B</p><p>%1%C</p>');

        // Delete all content, add new content and then copy and paste
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('%1% This is one line of content %2%');
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2%</p>');
        // Type some content to make sure the cursor is at the end
        $this->type(' Added content');
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2% Added content</p>');

        // Paste again
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2% Added content</p><p>%1% This is one line of content %2%</p>');
        // Type some content to make sure the cursor is at the end
        $this->type(' More added content');
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2% Added content</p><p>%1% This is one line of content %2% More added content</p>');

        // Paste again
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2% Added content</p><p>%1% This is one line of content %2% More added content</p><p>%1% This is one line of content %2%</p>');
        // Type some content to make sure the cursor is at the end
        $this->type(' Last added content');
        $this->assertHTMLMatch('<p>%1% This is one line of content %2%</p><p>%1% This is one line of content %2% Added content</p><p>%1% This is one line of content %2% More added content</p><p>%1% This is one line of content %2% Last added content</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test partial copy and paste.
     *
     * @return void
     */
    public function testPartialCopyPaste()
    {
        // Test coping some content and pasting over the top of existing content
        $this->useTest(2);

        $this->selectKeyword(2);
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + v');

        sleep(1);
        $this->assertHTMLMatch('<p>This is some content to %2% test partial copy and paste. It %2% needs to be a really long paragraph.</p>');

        // Test coping some content and pasting it somewhere else in the existing content
        $this->useTest(2);

        $this->selectKeyword(2);
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CMD + v');

        sleep(1);
        $this->assertHTMLMatch('<p>This is some content to %2%%1% test partial copy and paste. It %2% needs to be a really long paragraph.</p>');

    }//end testPartialCopyPaste()


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
        $this->assertHTMLMatch('<p>Am letzten Tag der 62. Tagung des WHO-Regionalkomitees für Europa verabschiedeten die Mitgliedstaaten die Strategie und den Aktionsplan für gesundes Altern in der Europäischen Region (2012 to 2020) (nach der Erörterung dieses Dokuments am dritten Tag) sowie den Europäischen Aktionsplan zur Stärkung der Kapazitäten und Angebote im Bereich der öffentlichen Gesundheit.  Europäischer Aktionsplan zur Stärkung der Kapazitäten und Angebote im Bereich der öffentlichen Gesundheit  In seiner Vorstellung des Aktionsplans sagte Dr. Hans Kluge, Direktor der Abteilung für Gesundheitssysteme und öffentliche Gesundheit, dass dies ein großartiger Moment sei, &bdquo;weil die Thematik öffentliche Gesundheit in der Europäischen Region wieder mit Leben gefüllt&ldquo; werde. Er führte aus, dass der Plan in umfassenden Konsultationen in der Absicht entwickelt worden sei, die integrierte Leistungserbringung für Gesundheitsschutz, Krankheitsprävention und Gesundheitsförderung zu stärken.  Angesichts der Veränderungen der Gesellschaften des 21. Jahrhunderts (Globalisierung, Überalterung der Bevölkerung, Klimawandel) sei eine erneute Betonung der öffentlichen Gesundheit zeitlich und inhaltlich angebracht, weil so trotz knapper Kassen optimale gesundheitliche Ergebnisse möglich seien.  Der Plan sei in Übereinstimmung mit dem Rahmenkonzept &bdquo;Gesundheit 2020&ldquo; aufgestellt worden und baue auf einer soliden Grundlage aus Erkenntnissen auf, unter anderem durch Untersuchungen zu den Angeboten im Bereich der öffentlichen Gesundheit in 41 der 53 Mitgliedstaaten. Das Kernstück des Aktionsplans bildeten die zehn überarbeiteten grundlegenden gesundheitspolitischen Maßnahmen (EPHO):</p>');

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
        $this->assertHTMLMatch('<p>Lors de la dernière journée de la soixante-deuxième session du Comité régional de l\'OMS pour l\'Europe, les États membres de la Région européenne ont adopté la Stratégie (Plan d\'action) pour vieillir en bonne santé en Europe, 2012-2020 (examinée lors de la 3e journée), et le Plan d&rsquo;action européen pour le renforcement des capacités et services de santé publique. Plan d&rsquo;action européen pour le renforcement des capacités et services de santé publique  En présentant le Plan d\'action européen, le docteur Hans Kluge, directeur de la Division des systèmes de santé et de la santé publique, fait remarquer qu\'il s\'agit d\'un grand moment, étant donné la nouveau souffle accordé à la santé publique dans la Région européenne. Il explique que le Plan d\'action a été élaboré dans le cadre d\'un vaste processus de consultation pour renforcer la prestation de services intégrés en matière de protection de la santé, de prévention des maladies et de promotion de la santé.  Compte tenu des défis confrontés par la société au XXIe siècle (mondialisation, vieillissement de la population, changement climatique), un recentrage sur la santé publique est à la fois opportun et approprié afin d\'obtenir les meilleurs résultats sanitaires avec des ressources limitées.  Le Plan d\'action a été formulé conformément au cadre politique de la santé, Santé 2020, et s\'inspire d\'informations factuelles solides, notamment de plusieurs études réalisées sur les services de santé publique dans 41 des 53 États membres de la Région européenne. Dix opérations essentielles de santé publique révisées sont à la base du Plan d\'action :</p>');

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
     * Test copy and pasting direction settings.
     *
     * @return void
     */
    public function testCopyPasteDirectionSettings()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
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
