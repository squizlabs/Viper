<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarTABLEUnitTest extends AbstractViperUnitTest
{


    /**
     * Test the lineage in a caption of a table.
     *
     * @return void
     */
    public function testLineageInCaption()
    {
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">CAPTION</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%'), $this->getSelectedText(), 'TABLE caption is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">CAPTION</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">CAPTION</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">CAPTION</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">CAPTION</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageInCaption()


    /**
     * Test the lineage in a header section of a table.
     *
     * @return void
     */
    public function testLineageInHeader()
    {
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('Col2 %2%'), $this->getSelectedText(), 'Cell content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Header</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('Col1 HeaderCol2 %2%Col3 Header'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('Col1 HeaderCol2 %2%Col3 Header'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">THEAD</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Header</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageInHeader()


    /**
     * Test the lineage in a footer section of a table.
     *
     * @return void
     */
    public function testLineageInFooter()
    {
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('Note: this is the table footer %3%'), $this->getSelectedText(), 'Cell content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('Note: this is the table footer %3%'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('Note: this is the table footer %3%'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TFOOT</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageInFooter()


    /**
     * Test the lineage in the body of a table.
     *
     * @return void
     */
    public function testLineageInBody()
    {
        $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('sapien vel %4%'), $this->getSelectedText(), 'Cell content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcu'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'table content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageInBody()


    /**
     * Test the lineage in a list in a table.
     *
     * @return void
     */
    public function testLineageInAListInTable()
    {
        $this->selectKeyword(5);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(5);
        $this->assertEquals($this->replaceKeywords('purus neque luctus, vel %5%'), $this->getSelectedText(), 'List item is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem Viper-selected">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('purus neque luctus, vel %5%purus neque luctusvel molestie arcu'), $this->getSelectedText(), 'list items are not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('purus neque luctus, vel %5%purus neque luctusvel molestie arcu'), $this->getSelectedText(), 'list items are not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcu'), $this->getSelectedText(), 'row content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'table content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(6);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageInAListInTable()


    /**
     * Test the lineage in a link in a table.
     *
     * @return void
     */
    public function testLineageInALinkInTable()
    {
        $this->clickKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $this->assertEquals($this->replaceKeywords('%6%'), $this->getSelectedText(), 'Link text should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

        $this->clickKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('purus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Cell content should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->clickKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('nec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Row content should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->clickKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'table content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->clickKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

    }//end testLineageInALinkInTable()


    /**
     * Test the lineage for an image in a table.
     *
     * @return void
     */
    public function testLineageForAnImageInTable()
    {
        // Insert an image
        $this->moveToKeyword(4, 'right');
        $this->clickTopToolbarButton('image');
        $this->type('%url%/ViperImagePlugin/Images/html-codesniffer.png');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickElement('img', 0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertEquals($this->replaceKeywords('sapien vel %4%'), $this->getSelectedText(), 'Cell content should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcu'), $this->getSelectedText(), 'Row content should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'table content is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Table 1.2: The table caption text %1%Col1 HeaderCol2 %2%Col3 HeaderNote: this is the table footer %3%nec porta antesapien vel %4%purus neque luctus, vel %5%purus neque luctusvel molestie arcunec porta antepurus neque luctus %6%, vel molestie arcu'), $this->getSelectedText(), 'Table content is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Image</li>', $lineage);

    }//end testLineageForAnImageInTable()


    /**
     * Test the original lineage items remain the same when lineage is changed.
     *
     * @return void
     */
    public function testLineageSelectionAfterSelectingLineageItems()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem Viper-selected">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem Viper-selected">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem Viper-selected">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">TABLE</li><li class="ViperITP-lineageItem">TBODY</li><li class="ViperITP-lineageItem">Row</li><li class="ViperITP-lineageItem">Cell</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageSelectionAfterSelectingLineageItems()


}//end class

?>
