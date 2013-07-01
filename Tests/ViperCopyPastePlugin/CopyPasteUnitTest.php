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
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>%1%A%1%B%1%C</p>');

    }//end testSimpleTextCopyPaste()


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
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
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
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(1);

        $this->assertHTMLMatch('<p><em>%1%A%1%B%1%C</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that you can copy and paste in a PRE tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPreTag()
    {
        $this->useTest(2);

        // Change paragraph to pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%%1% to test %2%</pre>');

    }//end testCopyAndPasteInPreTag()


    /**
     * Test that you can copy and paste in a Div tag.
     *
     * @return void
     */
    public function testCopyAndPasteInDivTag()
    {
        $this->useTest(2);

        // Change paragraph to div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%%1% to test %2%</div>');

    }//end testCopyAndPasteInDivTag()


    /**
     * Test that you can copy and paste in a Quote tag.
     *
     * @return void
     */
    public function testCopyAndPasteInQuoteTag()
    {
        $this->useTest(2);

        // Change paragraph to blockquote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%%1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteInQuoteTag()


    /**
     * Test copy and paste for a paragraph.
     *
     * @return void
     */
    public function testCopyAndPasteForAParagraphSection()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForAParagraph()


    /**
     * Test copy and paste for a div.
     *
     * @return void
     */
    public function testCopyAndPasteForADivSection()
    {
        $this->useTest(2);

        // Change paragraph to div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForADiv()


    /**
     * Test copy and paste for a quote.
     *
     * @return void
     */
    public function testCopyAndPasteForAQuoteSection()
    {
        $this->useTest(2);

        // Change paragraph to quote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteForAQuote()


    /**
     * Test copy and paste for a pre.
     *
     * @return void
     */
    public function testCopyAndPasteForAPreSection()
    {
        $this->useTest(2);

        // Change paragraph to pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        sleep(1);
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForAPre()


    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForTable()
    {
        $this->useTest(4);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" style="width: 100%;"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p></p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Check that the cursor is under the new table
        $this->type('type some more content');
        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" style="width: 100%;"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>type some more content</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteForTable()


    /**
     * Test that copying/pasting from the HtmlTablesInPage works correctly.
     *
     * @return void
     */
    public function testHtmlTablesInPageCopyPaste()
    {
        $this->useTest(1);

        // Open HTML doc, copy its contents.
        if ($this->openFile(dirname(__FILE__).'/HtmlTablesInPage.html', $this->getBrowserName()) === FALSE) {
            $this->markTestSkipped('MS Word is not available');
        }

        sleep(2);

        // Copy text.
        $this->keyDown('Key.CMD + a');
        sleep(1);
        $this->keyDown('Key.CMD + c');
        sleep(1);
        $this->closeApp($this->getBrowserName());
        sleep(1);

        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->removeTableHeaders();
        sleep(1);

        $this->assertHTMLMatch('<h1>Viper Table Plugin Examples</h1><p>Insert &gt; None &gt; Manual insertion of non breaking space in each empty cell</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Left</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Top</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Both</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; None &gt; Custom Headers &gt; Top left and bottom right cells.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><th></th></tr></tbody></table><p>Insert &gt; Headers Top &gt; Custom Heads &gt; Middle columns.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><th></th><th></th><td></td></tr><tr><td></td><th></th><th></th><td></td></tr></tbody></table><p>Blah.</p>');

    }//end testSpecialCharactersDocCopyPaste()


    /**
     * Test that right click menu and paste works.
     *
     * @return void
     */
    public function testRightClickPaste()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->selectKeyword(2);
        $this->paste(TRUE);

        sleep(1);
        $this->assertHTMLMatch('<p>test %1% test %1%</p>');

    }//end testRightClickPaste()


    /**
     * Test that copying/pasting German content.
     *
     * @return void
     */
    public function testCopyPasteGermanContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->paste(TRUE, $this->getTestURL('/ViperCopyPastePlugin/GermanContent.txt'));

        $this->assertHTMLMatch('<p>%1%</p><p>  Am letzten Tag der 62. Tagung des WHO-Regionalkomitees fŸr Europa verabschiedeten die Mitgliedstaaten die Strategie und den Aktionsplan fŸr gesundes Altern in der EuropŠischen Region (2012&ndash;2020) (nach der Eršrterung dieses Dokuments am dritten Tag) sowie den EuropŠischen Aktionsplan zur StŠrkung  der KapazitŠten und Angebote im Bereich der šffentlichen Gesundheit.<br />EuropŠischer Aktionsplan zur StŠrkung der KapazitŠten und Angebote im Bereich der šffentlichen Gesundheit<br />In seiner Vorstellung des Aktionsplans sagte Dr. Hans Kluge, Direktor der Abteilung fŸr Gesundheitssysteme und šffentliche Gesundheit, dass dies ein gro§artiger Moment sei, ãweil die  Thematik šffentliche Gesundheit in der EuropŠischen Region wieder mit Leben gefŸllt" werde. Er fŸhrte aus, dass der Plan in umfassenden Konsultationen in der Absicht entwickelt worden sei, die integrierte Leistungserbringung fŸr Gesundheitsschutz, KrankheitsprŠvention und Gesundheitsfšrderung zu stŠrken.<br  />Angesichts der VerŠnderungen der Gesellschaften des 21. Jahrhunderts (Globalisierung, †beralterung der Bevšlkerung, Klimawandel) sei eine erneute Betonung der šffentlichen Gesundheit zeitlich und inhaltlich angebracht, weil so trotz knapper Kassen optimale gesundheitliche Ergebnisse mšglich seien.<br  />Der Plan sei in †bereinstimmung mit dem Rahmenkonzept ãGesundheit 2020" aufgestellt worden und baue auf einer soliden Grundlage aus Erkenntnissen auf, unter anderem durch Untersuchungen zu den Angeboten im Bereich der šffentlichen Gesundheit in 41 der 53 Mitgliedstaaten. Das KernstŸck des Aktionsplans  bildeten die zehn Ÿberarbeiteten grundlegenden gesundheitspolitischen Ma§nahmen (EPHO):<br />&nbsp;&nbsp; &nbsp;1.&nbsp;&nbsp; &nbsp;Surveillance von Gesundheit und Wohlbefinden der Bevšlkerung<br />&nbsp;&nbsp; &nbsp;2.&nbsp;&nbsp; &nbsp;Beobachtung von Gesundheitsgefahren und gesundheitlichen Notlagen  und Gegenma§nahmen<br />&nbsp;&nbsp; &nbsp;3.&nbsp;&nbsp; &nbsp;Gesundheitsschutzma§nahmen (u. a. in den Bereichen Umwelt-, Arbeits- und Nahrungsmittelsicherheit)<br />&nbsp;&nbsp; &nbsp;4.&nbsp;&nbsp; &nbsp;Gesundheitsfšrderung, einschlie§lich Ma§nahmen in Bezug auf soziale Determinanten und gesundheitliche  Benachteiligung<br />&nbsp;&nbsp; &nbsp;5.&nbsp;&nbsp; &nbsp;KrankheitsprŠvention, einschlie§lich FrŸherkennung<br />&nbsp;&nbsp; &nbsp;6.&nbsp;&nbsp; &nbsp;GewŠhrleistung von Politikgestaltung und Steuerung fŸr mehr Gesundheit und Wohlbefinden<br />&nbsp;&nbsp; &nbsp;7.&nbsp;&nbsp; &nbsp;GewŠhrleistung  einer ausreichenden Zahl von fachkundigem Personal im Bereich der šffentlichen Gesundheit<br />&nbsp;&nbsp; &nbsp;8.&nbsp;&nbsp; &nbsp;GewŠhrleistung von nachhaltigen Organisationsstrukturen und Finanzierung<br />&nbsp;&nbsp; &nbsp;9.&nbsp;&nbsp; &nbsp;†berzeugungsarbeit, Kommunikation und soziale Mobilisierung  fŸr die Gesundheit<br />&nbsp;&nbsp; &nbsp;10.&nbsp;&nbsp; &nbsp;Fšrderung der Forschung im Bereich der šffentlichen Gesundheit zwecks Anwendung in Politik und Praxis</p>');

    }//end testCopyPasteGermanContent()


    /**
     * Test that copying/pasting french content.
     *
     * @return void
     */
    public function testCopyPasteFrenchContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');

        $this->clickNextLine();

        $this->paste(TRUE, $this->getTestURL('/ViperCopyPastePlugin/FrenchContent.txt'));

        $this->assertHTMLMatch('<p>XAX</p><p>Lors de la dernière journée de la soixante-deuxième session du Comité régional de l\'OMS pour l\'Europe, les États membres de la Région européenne ont adopté la Stratégie (Plan d\'action) pour vieillir en bonne santé en Europe, 2012-2020 (examinée lors de la 3e journée), et le Plan d\'action européen pour le renforcement des capacités et services de santé publique. Plan d\'action européen pour le renforcement des capacités et services de santé publique En présentant le Plan d\'action européen, le docteur Hans Kluge, directeur de la Division des systèmes de santé et de la santé publique, fait remarquer qu\'il s\'agit &laquo; d\'un grand moment, étant donné la nouveau souffle accordé à la santé publique dans la Région européenne. &raquo; Il explique que le Plan d\'action a été élaboré dans le cadre d\'un vaste processus de consultation pour renforcer la prestation de services intégrés en matière de protection de la santé, de prévention des maladies et de promotion de la santé. Compte tenu des défis confrontés par la société au XXIe siècle (mondialisation, vieillissement de la population, changement climatique), un recentrage sur la santé publique est à la fois opportun et approprié afin d\'obtenir les meilleurs résultats sanitaires avec des ressources limitées. Le Plan d\'action a été formulé conformément au cadre politique de la santé, Santé 2020, et s\'inspire d\'informations factuelles solides, notamment de plusieurs études réalisées sur les services de santé publique dans 41 des 53 États membres de la Région européenne. Dix opérations essentielles de santé publique révisées sont à la base du Plan d\'action :  1.  surveillance de la santé et du bien-être de la population ;     2.  surveillance et intervention en cas de risques et d\'urgences sanitaires ;   3.  protection de la santé (sécurité de l\'environnement et du travail, sécurité sanitaire des aliments, etc.) ;     4.  promotion de la santé, dont l\'action sur les déterminants de la santé et le manque d\'équité en santé ;  5.  prévention des maladies, dont le dépistage rapide ;     6.  garantir la gouvernance pour la santé et le bien-être ; 7.  s\'assurer de disposer d\'un personnel compétent dans le domaine de la santé publique et d\'effectifs suffisants ; 8.  garantir des structures organisationnelles et un financement durables ;     9.  sensibilisation, communication et mobilisation sociale pour la santé ;  10. faire progresser la recherche en santé publique pour élaborer des politiques et des pratiques en conséquence.</p>');

    }//end testCopyPasteFrenchContent()


    /**
     * Test that copying/pasting links works.
     *
     * @return void
     */
    public function testCopyPasteLinks()
    {
        $this->useTest(1);

        // Open HTML doc, copy its contents.
        if ($this->openFile(dirname(__FILE__).'/ExampleLinks.html', $this->getBrowserName()) === FALSE) {
            $this->markTestSkipped('MS Word is not available');
        }

        sleep(2);

        // Copy text.
        $this->keyDown('Key.CMD + a');
        sleep(1);
        $this->keyDown('Key.CMD + c');
        sleep(1);
        $this->closeApp($this->getBrowserName());
        sleep(1);

        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<p>link with http - <a href="http://www.squizlabs.com">http://www.squizlabs.com</a></p><p>link with https - <a href="https://www.squizlabs.com">https://www.squizlabs.com</a></p><p>blocked link with http - <a href="http://www.squizlabs.com">blocked::http://www.squizlabs.com</a></p><p>blocked link with https - <a href="https://www.squizlabs.com">blocked::https://www.squizlabs.com</a></p>');

    }//end testCopyPasteLinks()


}//end class

?>
