#!/bin/bash
mkdir /data/arkmanager
ln -s /data/arkmanager /etc/arkmanager


mkdir -p /data/cluster /data/server-files
chmod -R 777 /data/* /backup
