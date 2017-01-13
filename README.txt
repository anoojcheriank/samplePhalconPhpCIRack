curl -vX POST -d @./simple.json  --header "Content-Type: application/json" http://172.16.4.132:8081/projects/test_ciSystem_20170112/ciRack/scheduleJob


Git commands
------------
git init
git add citesting hostProject.sh README.txt run_Xampp.sh simple.json test_ciSystem_20170112
git commit -m "first commit"
git remote add origin https://github.com/anoojcheriank/samplePhalconPhpCIRack.git
git push -u origin master

commit modifirf files
---------------------
git commit -m "git commnds added" ./README.txt
