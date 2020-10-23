#!/bin/bash
#if [ -d "/saves" ]
#then
#    ln -s /saves /server-files/ShooterGame/Saved
#else
#    echo "Missing saves folder! Please link volume ShooterGame/Saved to /saves"
#    exit 9999
#fi

echo "Starting server: $*"

cd /server-files/ShooterGame/Binaries/Linux/
./ShooterGameServer $*


