<?php

// Get the input files and output file.
$inputFiles = array();
$outFile    = NULL;
for ($i = 1; $i < count($argv); $i++) {
    if ($argv[$i] === '-o' && isset($argv[($i + 1)]) === TRUE) {
        $outFile = $argv[($i + 1)];
        $i++;
    } else if ($argv[$i] === '-k' && isset($argv[($i + 1)]) === TRUE) {
        // Not supported..
        $i++;
    } else {
        $inputFiles[] = $argv[$i];
    }
}

if ($outFile === NULL || empty($inputFiles) === TRUE) {
	exit;
}

$strings = array();
foreach ($inputFiles as $file) {
	if (is_readable($file) === FALSE || preg_match('#\.js$#', $file) === FALSE) {
		continue;
	}

	$strings = array_merge($strings, getStrings($file));
}

$strings = array_unique($strings);

$data = '';
foreach ($strings as $string) {
	$data .= 'msgid "'.addcslashes($string, '"').'"'."\n";
	$data .= 'msgstr ""'."\n\n";
}

file_put_contents($outFile, $data);

exit;


/**
 * Returns the translatable strings from the specified file.
 *
 * @param string $filePath The path of the file to scan.
 *
 * @return array
 */
function getStrings($filePath)
{
	$strings = array();
	$file    = fopen($filePath,"r");

	while(!feof($file)) {
	  	$line    = trim(fgets($file));
	  	$matches = array();
		preg_match_all('/_\([\'"](.+?)[\'"]\)/i', $line, $matches);

		foreach ($matches[1] as $match) {
	    	$strings[] = stripcslashes($match);
	    }
	}

	fclose($file);
	return $strings;

}//end getStrings()

?>