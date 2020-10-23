<?php
echo "\nMerging ini files....\n";
$options = getopt("tb:n:o:");

if (array_key_exists("t",$options)) {
    $file_baseIni = "/home/fable/ark-server-config/GameUserSettings.ini";
    $file_newIni = "/home/fable/ark-server-config/server1/ShooterGame/Saved/Config/WindowsServer/GameUserSettings.ini";
    $file_outputIni = "";
    echo "Using test mode.\n";
}
elseif (!array_key_exists("b",$options) || !file_exists($options["b"])) exit("Missing base ini file path: use option -b [file]\n");
elseif (!array_key_exists("n",$options) || !file_exists($options["n"])) exit("Missing new ini file path: use option -n [file]\n"); 
else {
    $file_baseIni = $options["b"];
    $file_newIni = $options["n"];
    if (!isset($options["o"])) {
        echo "No output file specified. Using base file.\n";
        $file_outputIni = $file_baseIni;
    }
    else $file_outputIni = $options["o"];

}

echo "Base ini: $file_baseIni\n";
echo "New ini: $file_newIni\n";
echo "Output ini: $file_outputIni\n";
echo "\n";

$baseIni = parse_ini_file($file_baseIni,true);
$newIni = parse_ini_file($file_newIni,true);

if ($baseIni === false) exit("Fatal error: Unable to parse base ini: " . $file_baseIni);
if ($newIni === false) exit("Fatal error: Unable to parse new ini: " . $file_newIni);

#print_r($baseIni);
$processedIni = array_merge($baseIni,$newIni);

#echo "####################\n\n";
#print_r($processedIni);

function create_ini($array) {
    $output = "";
    foreach($array as $section=>$values) {
        $output .= "[$section]\n";
        foreach($values as $k=>$v) {
            $output .= "$k=$v\n";
        }
        $output .= "\n";
    }
    return $output;
}

$result = create_ini($processedIni);
if (array_key_exists("t",$options)) {
    echo "New ini file:\n" . $result;
}
else {
    $save = file_put_contents($file_outputIni,$result);
    if (!$save) exit("FATAL ERROR: Unable to save file: " . $file_outputIni . "\n");
    echo "File saved.\n";
}
