<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_EmbeddingVideoUnitTest extends AbstractViperUnitTest
{

    /**
     * Test embedding a youtube video that has iframe tags.
     *
     * @return void
     */
    public function testEmbeddingVideoWithIframeTags()
    {
        // Test Youtube video
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        sleep(5);

        // Check that you can enter content after new video
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a new paragraph after the video');

        // The HTML from IE is slightly different to other browsers
        if ($this->sikuli->getBrowserid() === 'ie11' || $this->sikuli->getBrowserid() === 'ie10' || $this->sikuli->getBrowserid() === 'ie9' || $this->sikuli->getBrowserid() === 'ie8') {
            $this->assertHTMLMatch('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M?wmode=opaque" allowfullscreen="" frameborder="0" height="315" width="420"></iframe><p>This is a new paragraph after the video</p>');
        }
        else {
            $this->assertHTMLMatch('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe><p>This is a new paragraph after the video</p>');
        }

        // Test Vimeo video
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<iframe src="//player.vimeo.com/video/92198436" width="500" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        sleep(5);

        // Check that you can enter content after new video
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a new paragraph after the video');

        // The HTML from IE is slightly different to other browsers
        if ($this->sikuli->getBrowserid() === 'ie11' || $this->sikuli->getBrowserid() === 'ie10' || $this->sikuli->getBrowserid() === 'ie9' || $this->sikuli->getBrowserid() === 'ie8') {
            $this->assertHTMLMatch('<iframe src="//player.vimeo.com/video/92198436?wmode=opaque" width="500" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe><p>This is a new paragraph after the video</p>');
        }
        else {
            $this->assertHTMLMatch('<iframe src="//player.vimeo.com/video/92198436" width="500" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe><p>This is a new paragraph after the video</p>');
        }

    }//end testEmbeddingVideoWithIframeTags()


    /**
     * Test embedding a youtube video that has object tags.
     *
     * @return void
     */
    public function testEmbeddingVideoWithObjectTags()
    {
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video using object tags
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<object width="560" height="315"><param name="movie" value="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        sleep(5);

        // Check that you can enter content after new video
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a new paragraph after the video');

        $this->assertHTMLMatch('<object width="560" height="315"><param name="movie" value="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object><p>This is a new paragraph after the video</p>');

    }//end testEmbeddingVideoWithObjectTags()


}//end class

?>
