<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_TrackChangesUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

    /**
     * Test that copying/pasting from the Track Changes doc from word with aggressive off.
     *
     * @return void
     */
    public function testTrackChangesFromWordWithAggressiveOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));
        
        $this->copyAndPasteFromWordDoc('TrackChanges.txt', '<p>Try to find a sexy image of JP to put in this article, just use content if there is none.</p><p>We\'re delighted to announce the launch of our newly designed website! Take a look around and let us know what you think.</p><p>Our main goals for the website were to make it easier for you to navigate, with a&nbsp;more attractive design and an&nbsp;engaging user experience with enhanced search and navigation. But most of all, we wanted to help you get to know us better and make life easier for you.</p><p>The new website is full of resources to help&nbsp;those who are looking to use Squiz for their digital transformation needs. We\'ll be regularly updating our content to help you find out about creating&nbsp;digital strategies&nbsp;to help drive growth and gain a competitive advantage.</p><p>We hope you find the website engaging, fresh and relevant.</p><p>Enjoy!</p>');

    }//end testTrackChangesFromWordWithAggressiveOff()


    /**
     * Test that copying/pasting from the Track Changes doc from word with aggressive on.
     *
     * @return void
     */
    public function testTrackChangesFromWordWithAggressiveOn()
    {
        $this->copyAndPasteFromWordDoc('TrackChanges.txt', '<p>Try to find a sexy image of JP to put in this article, just use content if there is none.</p><p>We\'re delighted to announce the launch of our newly designed website! Take a look around and let us know what you think.</p><p>Our main goals for the website were to make it easier for you to navigate, with a&nbsp;more attractive design and an&nbsp;engaging user experience with enhanced search and navigation. But most of all, we wanted to help you get to know us better and make life easier for you.</p><p>The new website is full of resources to help&nbsp;those who are looking to use Squiz for their digital transformation needs. We\'ll be regularly updating our content to help you find out about creating&nbsp;digital strategies&nbsp;to help drive growth and gain a competitive advantage.</p><p>We hope you find the website engaging, fresh and relevant.</p><p>Enjoy!</p>');

    }//end testTrackChangesFromWordWithAggressiveOn()

}//end class

?>