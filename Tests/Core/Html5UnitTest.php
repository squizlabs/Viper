<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_Html5UnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can use HTML5 in VIper
     *
     * @return void
     */
    public function testInsertingHtml5Code()
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5Examples.txt'));

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<section><article><header><h1>Article #1</h1></header><section>This is the first article. This is<mark>highlighted</mark>.</section></article><article><header><h1>Article #2</h1></header><section>This is the second article. These articles could be blog posts, etc.</section></article></section><embed src="../Core/Html5TestFiles/test.swf" /><input list="browsers" /><form action="demo_keygen.asp" method="get">Username:<input name="usr_name" type="text" />Encryption:<select name="security"><option>High Grade</option><option>Medium Grade</option></select><input type="submit" /></form><form oninput="x.value=parseInt(a.value)+parseInt(b.value)">0<input id="a" type="range" value="50" />100+<input id="b" type="number" value="50" />=</form><article><header><h1>Internet Explorer 9</h1></header><p>Windows Internet Explorer 9 (abbreviated as IE9) was released to the public on March 14, 2011 at 21:00 PDT.....</p></article><nav><a href="/html">HTML</a>|<a href="/css">CSS</a>|<a href="/js">JavaScript</a>|<a href="/jquery">jQuery</a></nav><section><h1>WWF</h1><p>The World Wide Fund for Nature (WWF) is....</p></section><main><h1>Web Browsers</h1><p>Google Chrome, Firefox, and Internet Explorer are the most used browsers today.</p><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><article><h1>Internet Explorer</h1><p>Internet Explorer is a free web browser from Microsoft, released in 1995.</p></article><article><h1>Mozilla Firefox</h1><p>Firefox is a free, open-source web browser from Mozilla, released in 2004.</p></article></main><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><p>My family and I visited The Epcot center this summer.</p><aside><h4>Epcot Center</h4><p>The Epcot Center is a theme park in Disney World, Florida.</p></aside><footer><p>Posted by: Hege Refsnes</p><p>Contact information:<a href="mailto:someone@example.com">someone@example.com</a>.</p></footer><details><summary>Copyright 1999-2014.</summary><p>- by Refsnes Data. All Rights Reserved.</p><p>All content and graphics on this web site are the property of the company Refsnes Data.</p></details><figure><img alt="The Pulpit Rock" height="228" src="../Core/Html5TestFiles/editing.jpg" width="304" /><figcaption>Fig1. - A view of the pulpit rock in Norway.</figcaption></figure><p>Do not forget to buy<mark>milk</mark> today.</p><p>We open at<time>10:00</time> every morning.</p><p>I have a date on<time datetime="2008-02-14">Valentines day</time>.</p><ul><li>User<bdi>hrefs</bdi>: 60 points</li><li>User<bdi>jdoe</bdi>: 80 points</li><li>User<bdi>Ø¥ÙŠØ§Ù†</bdi>: 90 points</li></ul><p>To learn AJAX, you must be familiar with the XMLHttpRequest Object.</p><table border="1" style="width:100%;"><tbody><tr><th>January<dialog open="">This is an open dialog window</dialog></th><th>February</th><th>March</th></tr><tr><td>31</td><td>28</td><td>31</td></tr></tbody></table><meter max="10" min="0" value="2">2 out of 10</meter><br/><meter value="0.6">60%</meter><ruby>æ&frac14;¢<rt>ã&bdquo;ã&bdquo;¢Ë‹</rt></ruby><ruby>æ&frac14;¢<rp>(</rp>ã&bdquo;ã&bdquo;¢Ë‹<rp>)</rp></ruby>');

    }//end testInsertingHtml5Code()


    /**
     * Test embedding videos in Chrome
     *
     * @return void
     */
    public function testHtml5VideoEmbeddingInChrome()
    {
        $this->runTestFor(NULL, 'chrome');

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5VideoEmbedding.txt'));
        sleep(1);
        $this->assertHTMLMatch('<audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio tag.</audio><video controls="" height="240" width="320"><source src="http://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg">Your browser does not support the video tag.</video><audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio><video controls="" height="240" width="320"><source src="fhttp://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg"><track kind="subtitles" label="English" src="../Core/Html5TestFiles/subtitles_en.vtt" srclang="en"></track><track kind="subtitles" label="Norwegian" src="../Core/Html5TestFiles/subtitles_no.vtt" srclang="no"></track></video>');

    }//end testHtml5VideoEmbeddingInChrome()


    /**
     * Test embedding videos in Firefox
     *
     * @return void
     */
    public function testHtml5VideoEmbeddingInFirefox()
    {
        $this->runTestFor(NULL, 'firefox');

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5VideoEmbedding.txt'));
        sleep(1);
        $this->assertHTMLMatch('<audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio tag.</audio><video controls="" height="240" width="320"><source src="http://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg">Your browser does not support the video tag.</video><audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio><video controls="" height="240" width="320"><source src="fhttp://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg"><track kind="subtitles" label="English" src="../Core/Html5TestFiles/subtitles_en.vtt" srclang="en"><track kind="subtitles" label="Norwegian" src="../Core/Html5TestFiles/subtitles_no.vtt" srclang="no"></video>');

    }//end testHtml5VideoEmbeddingInFirefox()


    /**
     * Test embedding videos in Safari
     *
     * @return void
     */
    public function testHtml5VideoEmbeddingInSafari()
    {
        $this->runTestFor(NULL, 'safari');

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5VideoEmbedding.txt'));
        sleep(3);
        $this->assertHTMLMatch('<audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio tag.</audio><video controls="" height="240" width="320"><source src="http://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg">Your browser does not support the video tag.</video><audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio><video controls="" height="240" width="320"><source src="fhttp://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg"><track kind="subtitles" label="English" src="../Core/Html5TestFiles/subtitles_en.vtt" srclang="en"></track><track kind="subtitles" label="Norwegian" src="../Core/Html5TestFiles/subtitles_no.vtt" srclang="no"></track></video>');

    }//end testHtml5VideoEmbeddingInSafari()


    /**
     * Test embedding videos in IE
     *
     * @return void
     */
    public function testHtml5VideoEmbeddingInIE()
    {
        $this->runTestFor(NULL, 'ie');

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5VideoEmbedding.txt'));
        sleep(3);
        $this->assertHTMLMatch('<audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio tag.</audio><video controls="" height="240" width="320"><source src="http://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg">Your browser does not support the video tag.</video><audio controls=""><source src="http://upload.wikimedia.org/wikipedia/en/0/04/Rayman_2_music_sample.ogg" type="audio/ogg"><source src="http://www.stephaniequinn.com/Music/Allegro%20from%20Duet%20in%20C%20Major.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio><video controls="" height="240" width="320"><source src="fhttp://techslides.com/demos/sample-videos/small.mp4" type="video/mp4"><source src="http://techslides.com/demos/sample-videos/small.ogv" type="video/ogg"><track kind="subtitles" label="English" src="../Core/Html5TestFiles/subtitles_en.vtt" srclang="en"></track><track kind="subtitles" label="Norwegian" src="../Core/Html5TestFiles/subtitles_no.vtt" srclang="no"></track></video>');

    }//end testHtml5VideoEmbeddingInIE()


    /**
     * Test viewing the source code of HTML5 code does not delete the elements
     *
     * @return void
     */
    public function testViewingHtml5SourceCode()
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/Core/Html5TestFiles/Html5Examples.txt'));

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<section><article><header><h1>Article #1</h1></header><section>This is the first article. This is<mark>highlighted</mark>.</section></article><article><header><h1>Article #2</h1></header><section>This is the second article. These articles could be blog posts, etc.</section></article></section><embed src="../Core/Html5TestFiles/test.swf" /><input list="browsers" /><form action="demo_keygen.asp" method="get">Username:<input name="usr_name" type="text" />Encryption:<select name="security"><option>High Grade</option><option>Medium Grade</option></select><input type="submit" /></form><form oninput="x.value=parseInt(a.value)+parseInt(b.value)">0<input id="a" type="range" value="50" />100+<input id="b" type="number" value="50" />=</form><article><header><h1>Internet Explorer 9</h1></header><p>Windows Internet Explorer 9 (abbreviated as IE9) was released to the public on March 14, 2011 at 21:00 PDT.....</p></article><nav><a href="/html">HTML</a>|<a href="/css">CSS</a>|<a href="/js">JavaScript</a>|<a href="/jquery">jQuery</a></nav><section><h1>WWF</h1><p>The World Wide Fund for Nature (WWF) is....</p></section><main><h1>Web Browsers</h1><p>Google Chrome, Firefox, and Internet Explorer are the most used browsers today.</p><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><article><h1>Internet Explorer</h1><p>Internet Explorer is a free web browser from Microsoft, released in 1995.</p></article><article><h1>Mozilla Firefox</h1><p>Firefox is a free, open-source web browser from Mozilla, released in 2004.</p></article></main><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><p>My family and I visited The Epcot center this summer.</p><aside><h4>Epcot Center</h4><p>The Epcot Center is a theme park in Disney World, Florida.</p></aside><footer><p>Posted by: Hege Refsnes</p><p>Contact information:<a href="mailto:someone@example.com">someone@example.com</a>.</p></footer><details><summary>Copyright 1999-2014.</summary><p>- by Refsnes Data. All Rights Reserved.</p><p>All content and graphics on this web site are the property of the company Refsnes Data.</p></details><figure><img alt="The Pulpit Rock" height="228" src="../Core/Html5TestFiles/editing.jpg" width="304" /><figcaption>Fig1. - A view of the pulpit rock in Norway.</figcaption></figure><p>Do not forget to buy<mark>milk</mark> today.</p><p>We open at<time>10:00</time> every morning.</p><p>I have a date on<time datetime="2008-02-14">Valentines day</time>.</p><ul><li>User<bdi>hrefs</bdi>: 60 points</li><li>User<bdi>jdoe</bdi>: 80 points</li><li>User<bdi>Ø¥ÙŠØ§Ù†</bdi>: 90 points</li></ul><p>To learn AJAX, you must be familiar with the XMLHttpRequest Object.</p><table border="1" style="width:100%;"><tbody><tr><th>January<dialog open="">This is an open dialog window</dialog></th><th>February</th><th>March</th></tr><tr><td>31</td><td>28</td><td>31</td></tr></tbody></table><meter max="10" min="0" value="2">2 out of 10</meter><br /><meter value="0.6">60%</meter><ruby>æ&frac14;¢<rt>ã„ã„¢Ë‹</rt></ruby><ruby>æ&frac14;¢<rp>(</rp>ã„ã„¢Ë‹<rp>)</rp></ruby>');

        // Open and close the source view
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<section><article><header><h1>Article #1</h1></header><section>This is the first article. This is<mark>highlighted</mark>.</section></article><article><header><h1>Article #2</h1></header><section>This is the second article. These articles could be blog posts, etc.</section></article></section><embed src="../Core/Html5TestFiles/test.swf" /><input list="browsers" /><form action="demo_keygen.asp" method="get">Username:<input name="usr_name" type="text" />Encryption:<select name="security"><option>High Grade</option><option>Medium Grade</option></select><input type="submit" /></form><form oninput="x.value=parseInt(a.value)+parseInt(b.value)">0<input id="a" type="range" value="50" />100+<input id="b" type="number" value="50" />=</form><article><header><h1>Internet Explorer 9</h1></header><p>Windows Internet Explorer 9 (abbreviated as IE9) was released to the public on March 14, 2011 at 21:00 PDT.....</p></article><nav><a href="/html">HTML</a>|<a href="/css">CSS</a>|<a href="/js">JavaScript</a>|<a href="/jquery">jQuery</a></nav><section><h1>WWF</h1><p>The World Wide Fund for Nature (WWF) is....</p></section><main><h1>Web Browsers</h1><p>Google Chrome, Firefox, and Internet Explorer are the most used browsers today.</p><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><article><h1>Internet Explorer</h1><p>Internet Explorer is a free web browser from Microsoft, released in 1995.</p></article><article><h1>Mozilla Firefox</h1><p>Firefox is a free, open-source web browser from Mozilla, released in 2004.</p></article></main><article><h1>Google Chrome</h1><p>Google Chrome is a free, open-source web browser developed by Google, released in 2008.</p></article><p>My family and I visited The Epcot center this summer.</p><aside><h4>Epcot Center</h4><p>The Epcot Center is a theme park in Disney World, Florida.</p></aside><footer><p>Posted by: Hege Refsnes</p><p>Contact information:<a href="mailto:someone@example.com">someone@example.com</a>.</p></footer><details><summary>Copyright 1999-2014.</summary><p>- by Refsnes Data. All Rights Reserved.</p><p>All content and graphics on this web site are the property of the company Refsnes Data.</p></details><figure><img alt="The Pulpit Rock" height="228" src="../Core/Html5TestFiles/editing.jpg" width="304" /><figcaption>Fig1. - A view of the pulpit rock in Norway.</figcaption></figure><p>Do not forget to buy<mark>milk</mark> today.</p><p>We open at<time>10:00</time> every morning.</p><p>I have a date on<time datetime="2008-02-14">Valentines day</time>.</p><ul><li>User<bdi>hrefs</bdi>: 60 points</li><li>User<bdi>jdoe</bdi>: 80 points</li><li>User<bdi>Ø¥ÙŠØ§Ù†</bdi>: 90 points</li></ul><p>To learn AJAX, you must be familiar with the XMLHttpRequest Object.</p><table border="1" style="width:100%;"><tbody><tr><th>January<dialog open="">This is an open dialog window</dialog></th><th>February</th><th>March</th></tr><tr><td>31</td><td>28</td><td>31</td></tr></tbody></table><meter max="10" min="0" value="2">2 out of 10</meter><br /><meter value="0.6">60%</meter><ruby>æ&frac14;¢<rt>ã„ã„¢Ë‹</rt></ruby><ruby>æ&frac14;¢<rp>(</rp>ã„ã„¢Ë‹<rp>)</rp></ruby>');

    }//end testViewingHtml5SourceCode()

}//end class

?>