<?php
function out($string) { echo "$string\n"; }

$opts = getopt("i");

$install = isset($opts["i"]) ? true : false;

if (!file_exists("/etc/arkmanager/.installed") || $install) {
#    system("chmod 777 -R /data"); # Volume folders are not writeable by steam
    chdir("/");
    system("/create-folders.sh");

    out("Installing Ark Server Tools from https://github.com/arkmanager/");
    system("curl -sL https://git.io/arkmanager | bash -s steam");

    system("cp /arkmanager.default.configs/arkmanager.cfg /etc/arkmanager/arkmanager.cfg");
    system("cp /arkmanager.default.configs/instances/main.cfg /etc/arkmanager/instances/main.cfg");
  
    out("Installing Ark Server Files");
    system("arkmanager install --verbose");

    system("touch /etc/arkmanager/.installed");
    out("Please update your config files. appdata/shared/arkmanager/instances/main.cfg and appdata/server1/saved/Config/LinuxServer/Game*.ini");
    exit();
}
else {
    out("Ark Server Tools already installed. Remove appdata/shared/arkmanager/.installed to reinstall");
}


out("Updating mods");
system("arkmanager update --update-mods --verbose");

out("Starting server:");
system("arkmanager run");

