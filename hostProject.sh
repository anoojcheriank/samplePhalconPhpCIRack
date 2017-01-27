#!/bin/sh

BASE=/home/acherian/study/projects
XAMPP_HOST_DIR=/opt/lampp/htdocs/projects

if [ "$1" = "" ];then
    echo "usage: $0 <project name>"
    exit 0;
fi
PROJECT=$1

chmod 777 -R  $BASE/$PROJECT
ln -s $BASE/$PROJECT $XAMPP_HOST_DIR/$PROJECT

echo "service hosted at:  http://172.16.4.132:8081/projects/$PROJECT/"

