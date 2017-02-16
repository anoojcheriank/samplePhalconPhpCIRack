Alter database coloum type
--------------------------
ALTER TABLE <tablename> MODIFY <columnname> INTEGER;
http://stackoverflow.com/questions/1356866/how-do-i-change-the-data-type-for-a-column-in-mysql

ALTER TABLE <tablename>  CHANGE <columnname> <new_columnname> INT;
http://stackoverflow.com/questions/4002340/error-renaming-a-column-in-mysql

sed find and replace string in directory
========================================
find ./ -type f -exec sed -i -e 's/apple/orange/g' {} \;


update tbl_slot_config  set uint_slot_availability=1 where rack_number=1;


