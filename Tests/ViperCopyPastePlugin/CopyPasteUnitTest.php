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

        $this->assertHTMLMatch('<p>%1%A%1%B%1%C</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test that right click menu and paste works.
     *
     * @return void
     */
    public function testRightClickPaste()
    {
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->paste(TRUE);

        sleep(1);
        $this->assertHTMLMatch('<p>%1%%1%</p>');

    }//end testRightClickPaste()


    /**
     * Test that copying/pasting bold text works.
     *
     * @return void
     */
    public function testBoldTextCopyPaste()
    {
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

        $this->assertHTMLMatch('<p><strong>%1%A%1%B%1%C</strong></p>');

    }//end testBoldTextCopyPaste()


   /**
     * Test that copying/pasting italic text works.
     *
     * @return void
     */
    public function testItalicTextCopyPaste()
    {
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

        $this->assertHTMLMatch('<p><em>%1%A%1%B%1%C</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that copying/pasting German content.
     *
     * @return void
     */
    public function testCopyPasteGermanContent()
    {
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
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/FrenchContent.txt'));
        $this->assertHTMLMatch('<p>Lors de la dernière journée de la soixante-deuxième session du Comité régional de l\'OMS pour l\'Europe, les États membres de la Région européenne ont adopté la Stratégie (Plan d\'action) pour vieillir en bonne santé en Europe, 2012-2020 (examinée lors de la 3e journée), et le Plan d\'action européen pour le renforcement des capacités et services de santé publique. Plan d\'action européen pour le renforcement des capacités et services de santé publique  En présentant le Plan d\'action européen, le docteur Hans Kluge, directeur de la Division des systèmes de santé et de la santé publique, fait remarquer qu\'il s\'agit d\'un grand moment, étant donné la nouveau souffle accordé à la santé publique dans la Région européenne. Il explique que le Plan d\'action a été élaboré dans le cadre d\'un vaste processus de consultation pour renforcer la prestation de services intégrés en matière de protection de la santé, de prévention des maladies et de promotion de la santé.  Compte tenu des défis confrontés par la société au XXIe siècle (mondialisation, vieillissement de la population, changement climatique), un recentrage sur la santé publique est à la fois opportun et approprié afin d\'obtenir les meilleurs résultats sanitaires avec des ressources limitées.  Le Plan d\'action a été formulé conformément au cadre politique de la santé, Santé 2020, et s\'inspire d\'informations factuelles solides, notamment de plusieurs études réalisées sur les services de santé publique dans 41 des 53 États membres de la Région européenne. Dix opérations essentielles de santé publique révisées sont à la base du Plan d\'action :</p>');

    }//end testCopyPasteFrenchContent()


    /**
     * Test that copying/pasting links works.
     *
     * @return void
     */
    public function testCopyPasteLinks()
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/ExampleLinks.txt'));
        $this->assertHTMLMatch('<p>link with http - <a href="http://www.squizlabs.com">http://www.squizlabs.com</a></p><p>link with https - <a href="https://www.squizlabs.com">https://www.squizlabs.com</a></p><p>blocked link with http - <a href="http://www.squizlabs.com">blocked::http://www.squizlabs.com</a></p><p>blocked link with https - <a href="https://www.squizlabs.com">blocked::https://www.squizlabs.com</a></p>');

    }//end testCopyPasteLinks()


    /**
     * Test that copying/pasting a LibreOffice document works.
     *
     * @return void
     */
    public function testCopyPasteLibreOfficeDoc()
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/LibreOfficeDoc.txt'));
        $this->assertHTMLMatch('<h1>Heading 1</h1><p>This is a document that has been created using LibreOffice</p><h2>Heading 2</h2><p>More text under heading two.</p><p>Numbered list:</p><ol><li>One</li><li>Two</li><li>Three</li></ol><p>Ordered List:</p><ul><li>One</li><li>Two</li><li>Three</li></ul>');

    }//end testCopyPasteLibreOfficeDoc()


}//end class

?>
