curl -vX POST -d @./simple.json  --header "Content-Type: application/json" http://172.16.4.132:8081/projects/test_ciSystem_20170120/ciRack/scheduleJob

curl http://172.16.4.132:8081/projects/test_ciSystem_20170120/ciRack/listJobs
curl -vX POST  http://172.16.4.132:8081/projects/test_ciSystem_20170120/ciRack/cancelJob -d "8"
curl -vX POST http://172.16.4.132:8081/projects/test_ciSystem_20170120/ciRack/processJobQueue


Git commands
------------
git init
git add citesting hostProject.sh README.txt run_Xampp.sh simple.json test_ciSystem_20170112
git commit -m "first commit"
git remote add origin https://github.com/anoojcheriank/samplePhalconPhpCIRack.git
git push -u origin master

git push


commit modifirf files
---------------------
git commit -m "git commnds added" ./README.txt


save table with foreign key
---------------------------
http://stackoverflow.com/questions/32741402/how-to-get-last-insert-id-with-phalcon
$yourModel = new YourModel();
$yourModel->save() // Or create();
$newId = $yourModel->getWriteConnection()->lastInsertId();

http://stackoverflow.com/questions/4775520/mysql-how-to-insert-values-in-a-table-which-has-a-foreign-key

http://stackoverflow.com/questions/24311249/how-to-find-by-multiple-criteria-with-phalcon-findfirst


