<html>
<head>
    <style>
        body {
            background-color: #EEE;
            margin-bottom: 350px;
        }

        td {
            font-size: 9px;
            width: 9px;
            cursor: pointer;
            border: 1px solid transparent;
        }

        td:hover {
            border-color: #000;
            box-shadow: 0 0 5px #000;
        }

        td.pass {
            background-color: green;
        }

        td.error {
            background-color: red;
        }

        td.failure {
            background-color: brown;
        }

        td.skipped {
            background-color: #222;
        }

        td.incomplete {
            background-color: #999;
        }

        td.active {
            border: 1px solid #000;
            box-shadow: 0 0 6px 3px #FFF;
            z-index: 100;
            position: relative;
        }

        table {
            border-spacing: 1px;
        }

        #infoContainer {
            background-color: #DDDDDD;
            border-top: 1px solid;
            bottom: 0;
            height: 300px;
            left: 0;
            margin: 0;
            overflow: auto;
            position: fixed;
            width: 100%;
        }

        #infoContainer h2, p {
            margin: 0 10px;
        }

        #infoContainer pre {
            margin: 10px;
            margin-top: 0;
        }

        .wrapper {
            float: left;
            margin-right: 35px;
        }
    </style>
    <script type="text/javascript" src="../DfxJSLib/dfx.js"></script>

    <script>
    function showInfo(id, elem)
    {
        var idParts = id.split('__');
        var browser = idParts[0];
        id          = idParts[1];

        var infoContainer = dfx.getId('infoContainer');
        var info = _info[browser][id];

        dfx.removeClass(dfx.getTag('td'), 'active');

        var title = [];
        for (var browser in _info) {
            if (_info[browser][id]) {
                title.push(browser + ': ' + _info[browser][id].type);
            } else {
                title.push(browser + ': pass');
            }
        }

        title = title.join('<br /> ');

        if (!info) {
            dfx.setHtml(infoContainer, '');
            return;
        }

        dfx.addClass(elem, 'active');

        dfx.setHtml(infoContainer, '<h2>' + browser + ': ' + info.type +"</h2><p>" + title + "</p><pre>\n\n" + info.info + '</pre>');
    }
    </script>
</head>
<body>
<div style="overflow:hidden;">
<?php
    $errors   = array();
    $maxCol   = 60;
    $browsers = array(
                 'firefox'      => 'Firefox',
                 'googlechrome' => 'Google Chrome',
                 'safari'       => 'Safari',
                 'ie8'          => 'IE8',
                 'ie9'          => 'IE9',
                );

    foreach ($browsers as $browser => $browserName) {
        $logFile = dirname(__FILE__).'/tmp/'.$browser.'/test.log';
        if (file_exists($logFile) === FALSE) {
            continue;
        }

        $doc = new DOMDocument();
        if (@$doc->load($logFile) === FALSE) {
            continue;
        }

        echo '<div class="wrapper">';
        echo '<h1>'.$browserName.'</h1>';

        $testSuites = $doc->getElementsByTagName('testsuite')->item(0);

        echo '<p>Time: '.gmdate("H:i:s", $testSuites->getAttribute('time'));
        echo ',&nbsp;&nbsp;Tests: '.$testSuites->getAttribute('tests');
        echo ',&nbsp;&nbsp;Errors: '.$testSuites->getAttribute('errors');
        echo ',&nbsp;&nbsp;Failures: '.$testSuites->getAttribute('failures');
        echo ',&nbsp;&nbsp;Assertions: '.$testSuites->getAttribute('assertions');
        echo '</p>';

        echo '<table><tbody><tr>';
        $i = 0;

        foreach ($testSuites->childNodes as $testSuite) {
            if ($testSuite->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if (($i % $maxCol) === 0) {
                echo '</tr><tr>';
            }

            $testCases = $testSuite->getElementsByTagName('testcase');
            foreach ($testCases as $testCase) {
                if (($i % $maxCol) === 0) {
                    echo '</tr><tr>';
                }

                $i++;

                $id = $testCase->getAttribute('class').'-'.$testCase->getAttribute('name');
                echo '<td id="'.$browser.'__'.$id.'" title="'.$testCase->getAttribute('name').' ('.number_format($testCase->getAttribute('time'), 2).'s)"';

                // Check if it has errors or not.
                if ($testCase->hasChildNodes() === TRUE) {
                    foreach ($testCase->childNodes as $child) {
                        if ($child->nodeType !== XML_ELEMENT_NODE) {
                            continue;
                        }

                        if (isset($errors[$browser]) === FALSE) {
                            $errors[$browser] = array();
                        }

                        $errors[$browser][$id] = array(
                                                  'type' => $child->tagName,
                                                  'info' => htmlentities(trim($child->textContent)),
                                                 );

                        echo ' class="'.$child->tagName.'"';

                        break;
                    }
                } else {
                    echo ' class="pass"';
                }//end if

                echo ' onclick="showInfo(this.id, this);">&nbsp;</td>';
            }//end foreach

        }//end foreach

        echo '</tr></tbody></table></div>';

    }//end foreach

    echo '<div id="infoContainer"></div>';
    echo '<script>var _info = '.json_encode($errors).'</script>';
?>
</div>
</body>
</html>
