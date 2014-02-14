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
        $this->assertHTMLMatch('<<p>  Am letzten Tag der 62. Tagung des WHO-Regionalkomitees fŸr Europa verabschiedeten die Mitgliedstaaten die Strategie und den Aktionsplan fŸr gesundes Altern in der EuropŠischen Region (2012&ndash;2020) (nach der Eršrterung dieses Dokuments am dritten Tag) sowie den EuropŠischen Aktionsplan zur StŠrkung  der KapazitŠten und Angebote im Bereich der šffentlichen Gesundheit.<br />EuropŠischer Aktionsplan zur StŠrkung der KapazitŠten und Angebote im Bereich der šffentlichen Gesundheit<br />In seiner Vorstellung des Aktionsplans sagte Dr. Hans Kluge, Direktor der Abteilung fŸr Gesundheitssysteme und šffentliche Gesundheit, dass dies ein gro§artiger Moment sei, ãweil die  Thematik šffentliche Gesundheit in der EuropŠischen Region wieder mit Leben gefŸllt" werde. Er fŸhrte aus, dass der Plan in umfassenden Konsultationen in der Absicht entwickelt worden sei, die integrierte Leistungserbringung fŸr Gesundheitsschutz, KrankheitsprŠvention und Gesundheitsfšrderung zu stŠrken.<br  />Angesichts der VerŠnderungen der Gesellschaften des 21. Jahrhunderts (Globalisierung, †beralterung der Bevšlkerung, Klimawandel) sei eine erneute Betonung der šffentlichen Gesundheit zeitlich und inhaltlich angebracht, weil so trotz knapper Kassen optimale gesundheitliche Ergebnisse mšglich seien.<br  />Der Plan sei in †bereinstimmung mit dem Rahmenkonzept ãGesundheit 2020" aufgestellt worden und baue auf einer soliden Grundlage aus Erkenntnissen auf, unter anderem durch Untersuchungen zu den Angeboten im Bereich der šffentlichen Gesundheit in 41 der 53 Mitgliedstaaten. Das KernstŸck des Aktionsplans  bildeten die zehn Ÿberarbeiteten grundlegenden gesundheitspolitischen Ma§nahmen (EPHO):<br />&nbsp;&nbsp; &nbsp;1.&nbsp;&nbsp; &nbsp;Surveillance von Gesundheit und Wohlbefinden der Bevšlkerung<br />&nbsp;&nbsp; &nbsp;2.&nbsp;&nbsp; &nbsp;Beobachtung von Gesundheitsgefahren und gesundheitlichen Notlagen  und Gegenma§nahmen<br />&nbsp;&nbsp; &nbsp;3.&nbsp;&nbsp; &nbsp;Gesundheitsschutzma§nahmen (u. a. in den Bereichen Umwelt-, Arbeits- und Nahrungsmittelsicherheit)<br />&nbsp;&nbsp; &nbsp;4.&nbsp;&nbsp; &nbsp;Gesundheitsfšrderung, einschlie§lich Ma§nahmen in Bezug auf soziale Determinanten und gesundheitliche  Benachteiligung<br />&nbsp;&nbsp; &nbsp;5.&nbsp;&nbsp; &nbsp;KrankheitsprŠvention, einschlie§lich FrŸherkennung<br />&nbsp;&nbsp; &nbsp;6.&nbsp;&nbsp; &nbsp;GewŠhrleistung von Politikgestaltung und Steuerung fŸr mehr Gesundheit und Wohlbefinden<br />&nbsp;&nbsp; &nbsp;7.&nbsp;&nbsp; &nbsp;GewŠhrleistung  einer ausreichenden Zahl von fachkundigem Personal im Bereich der šffentlichen Gesundheit<br />&nbsp;&nbsp; &nbsp;8.&nbsp;&nbsp; &nbsp;GewŠhrleistung von nachhaltigen Organisationsstrukturen und Finanzierung<br />&nbsp;&nbsp; &nbsp;9.&nbsp;&nbsp; &nbsp;†berzeugungsarbeit, Kommunikation und soziale Mobilisierung  fŸr die Gesundheit<br />&nbsp;&nbsp; &nbsp;10.&nbsp;&nbsp; &nbsp;Fšrderung der Forschung im Bereich der šffentlichen Gesundheit zwecks Anwendung in Politik und Praxis</p>');

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


}//end class

?>
