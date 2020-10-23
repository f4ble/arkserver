<?php

$options = getopt("i:s:");

$inifile = isset($options["i"]) ? $options["i"] : null;
if (!$inifile) exit("No ini file to read mod ids from: use -i [file]");
#$inifile = "/root/docker/ark-survival/appdata/Saves/server1/Config/LinuxServer/GameUserSettings.ini";

$savepath = isset($options["s"]) ? $options["s"] : null;
if (!$savepath) exit("No path to save mods: use -s [path]");



$basecmd_p1 = "docker run " .
    "-v $savepath:/data " .
    "-it --rm --name=steamcmd cm2network/steamcmd " .
    "bash /home/steam/steamcmd/steamcmd.sh +login anonymous +force_install_dir /data/ ";

$modcmd = "+workshop_download_item 346110 ";

$basecmd_p2 = " +quit";

$array = parse_ini_file($inifile,true);
if (!$array) exit("Unable to load ini file: $inifile");

if (!isset($array["ServerSettings"]["ActiveMods"])) exit("Unable to find list of mods in INI file.");

$modIds = explode(",",$array["ServerSettings"]["ActiveMods"]);

print_r($modIds);

$modcmd_parsed = "";
foreach($modIds as $id) {
    $modcmd_parsed .= $modcmd . $id . " ";
}


$exec = $basecmd_p1 . $modcmd_parsed . $basecmd_p2;
echo "Executing: " . $exec . "\n";
system($exec);
