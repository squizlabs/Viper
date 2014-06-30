<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AlignmentInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can apply and remove justification when clicking inside a list item.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenClickingInListItem()
    {
        $this->useTest(1);

        // Apply left justify to unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply left justify to ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: center;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: center;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: right;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove right justify for unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: right;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: justify;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');
        
        // Remove block justify for unordered list item
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: justify;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove block justify for ordered list item
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveJustificationWhenClickingInListItem()


    /**
     * Test that you can apply and remove justification when selecting the list item.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingListItem()
    {
        $this->useTest(1);

        // Apply left justify to unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply left justify to ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: center;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: center;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: right;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove right justify for unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: right;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: justify;">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');
        
        // Remove block justify for unordered list item
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: justify;">item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove block justify for ordered list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveJustificationWhenSelectingListItem()


    /**
     * Test that you can apply and remove justification when selecting a list.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingList()
    {
        $this->useTest(1);

        // Apply left justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: left;"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply left justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol style="text-align: left;"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: center;"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply center justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol style="text-align: center;"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: right;"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove right justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply right justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol style="text-align: right;"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: justify;"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');
        
        // Remove block justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply block justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol style="text-align: justify;"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove block justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveJustificationWhenSelectingList()


    /**
     * Test applying different justifications to the list when the list items have different justifications applied.
     *
     * @return void
     */
    public function testApplyJustificationToListWithJustificationOnListItems()
    {
        $this->useTest(2);

        // Apply left justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: left;"><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply left justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol style="text-align: left;"><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');
        
        // Remove left justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply center justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: center;"><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply center justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol style="text-align: center;"><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');
        
        // Remove center justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply right justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: right;"><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove right justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply right justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol style="text-align: right;"><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove right justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply block justify to unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul style="text-align: justify;"><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');
        
        // Remove block justify for unordered list
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

        // Apply block justify to ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol style="text-align: justify;"><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');
        
        // Remove block justify for ordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li style="text-align: left;">item 2 %1%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ul><p>Ordered list:</p><ol><li>item 1</li><li style="text-align: left;">item 2 %2%</li><li style="text-align: center;">item 3</li><li style="text-align: right;">item 4</li><li style="text-align: justify;">item 5</li></ol>');

    }//end testApplyJustificationToListWithJustificationOnListItems()


}//end class

?>
