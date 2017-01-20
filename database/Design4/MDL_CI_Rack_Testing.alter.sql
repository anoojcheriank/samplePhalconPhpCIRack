/* Step #1: New model MDL_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #1 */

/* Step #2: New diagram DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #2 */

/* Step #3: New table tbl_slot_config */

CREATE TABLE tbl_slot_config
(
  uint_slot_index integer unsigned NOT NULL AUTO_INCREMENT,
  char_ser_name varchar(100) NOT NULL DEFAULT s13034hv16,
  int_server_slot_number bigint NOT NULL DEFAULT 1,
  bool_slot_availability bit(1) NOT NULL DEFAULT 1,
  uint_box_index integer unsigned NOT NULL DEFAULT 1,
  CONSTRAINT int_slot_index PRIMARY KEY (uint_slot_index)
);

/* End of Step #3 */

/* Step #4: Attach table tbl_slot_config to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #4 */

/* Step #5: Modify column uint_server_slot_number of tbl_slot_config */

ALTER TABLE tbl_slot_config
  CHANGE int_server_slot_number uint_server_slot_number bigint NOT NULL DEFAULT 1;

ALTER TABLE tbl_slot_config
  ALTER uint_server_slot_number DROP DEFAULT;

ALTER TABLE tbl_slot_config
  MODIFY uint_server_slot_number integer unsigned NOT NULL;

/* End of Step #5 */

/* Step #6: New table tbl_box_details */

CREATE TABLE tbl_box_details
(
  uint_box_index integer unsigned NOT NULL AUTO_INCREMENT,
  char_box_ip varchar(100) NOT NULL DEFAULT xxx.xxx.xxx.xxx,
  uint_box_platform integer unsigned NOT NULL DEFAULT 1,
  char_mac varchar(100) DEFAULT XX:XX:XX:XX:XX:XX,
  CONSTRAINT uint_box_index PRIMARY KEY (uint_box_index)
);

/* End of Step #6 */

/* Step #7: Attach table tbl_box_details to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #7 */

/* Step #8: New foreign key fk_tbl_slot_config_ of tbl_slot_config */

ALTER TABLE tbl_slot_config ADD CONSTRAINT fk_tbl_slot_config_
  FOREIGN KEY (uint_box_index) REFERENCES tbl_box_details (uint_box_index) ON DELETE RESTRICT;

/* End of Step #8 */

/* Step #9: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #9 */

/* Step #10: New table tbl_binary_details */

CREATE TABLE tbl_binary_details
(
  uint_binary_index integer unsigned NOT NULL AUTO_INCREMENT,
  char_binary_name varchar(100) NOT NULL,
  uint_box_platform integer unsigned NOT NULL DEFAULT 1,
  char_md5sum varchar(100),
  uint_build_type integer unsigned NOT NULL,
  char_middleware_version varchar(100) NOT NULL,
  CONSTRAINT uint_binary_index PRIMARY KEY (uint_binary_index)
);

/* End of Step #10 */

/* Step #11: Attach table tbl_binary_details to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #11 */

/* Step #12: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #12 */

/* Step #13: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #13 */

/* Step #14: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #14 */

/* Step #15: Move box of table tbl_binary_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #15 */

/* Step #16: Modify table tbl_build_details */

ALTER TABLE tbl_binary_details RENAME TO tbl_build_details;

/* End of Step #16 */

/* Step #17: Modify column uint_build_index of tbl_build_details */

ALTER TABLE tbl_build_details
  CHANGE uint_binary_index uint_build_index integer unsigned NOT NULL AUTO_INCREMENT;

/* End of Step #17 */

/* Step #18: Modify column char_build_md5sum of tbl_build_details */

ALTER TABLE tbl_build_details
  CHANGE char_md5sum char_build_md5sum varchar(100);

/* End of Step #18 */

/* Step #19: Modify primary key uint_build_index of tbl_build_details */

ALTER TABLE tbl_build_details
  MODIFY uint_build_index integer unsigned NOT NULL;

ALTER TABLE tbl_build_details
  DROP PRIMARY KEY;

ALTER TABLE tbl_build_details ADD CONSTRAINT uint_build_index
  PRIMARY KEY (uint_build_index);

ALTER TABLE tbl_build_details
  MODIFY uint_build_index integer unsigned NOT NULL AUTO_INCREMENT;

/* End of Step #19 */

/* Step #20: New table tbl_job_queue */

CREATE TABLE tbl_job_queue
(
  uint_job_id integer unsigned NOT NULL AUTO_INCREMENT,
  uint_priority integer unsigned NOT NULL DEFAULT 1,
  uint_number_of_boxes integer unsigned NOT NULL DEFAULT 1,
  uint_bin integer unsigned NOT NULL DEFAULT 1,
  char_job_start_time varchar(100),
  char_job_finish_time varchar(100),
  uint_state integer unsigned NOT NULL DEFAULT 1,
  uint_status integer unsigned NOT NULL DEFAULT 1,
  CONSTRAINT uint_job_id PRIMARY KEY (uint_job_id)
);

/* End of Step #20 */

/* Step #21: Attach table tbl_job_queue to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #21 */

/* Step #22: Move box of table tbl_job_queue of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #22 */

/* Step #23: Modify column uint_build_index of tbl_job_queue */

ALTER TABLE tbl_job_queue
  CHANGE uint_bin uint_build_index integer unsigned NOT NULL DEFAULT 1;

/* End of Step #23 */

/* Step #24: New foreign key fk_tbl_job_queue_ of tbl_job_queue */

ALTER TABLE tbl_job_queue ADD CONSTRAINT fk_tbl_job_queue_
  FOREIGN KEY (uint_build_index) REFERENCES tbl_build_details (uint_build_index) ON DELETE RESTRICT;

/* End of Step #24 */

/* Step #25: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #25 */

/* Step #26: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #26 */

/* Step #27: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #27 */

/* Step #28: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #28 */

/* Step #29: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #29 */

/* Step #30: Move box of table tbl_box_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #30 */

/* Step #31: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #31 */

/* Step #32: New table tbl_test_details */

CREATE TABLE tbl_test_details
(
  uint_test_details integer unsigned NOT NULL AUTO_INCREMENT,
  uint_test_type integer unsigned NOT NULL DEFAULT 1,
  uint_test_check_job_type integer unsigned NOT NULL DEFAULT 1,
  uint_test_wait_time integer unsigned,
  uint_test_mode bigint NOT NULL DEFAULT 1,
  varchar_test_description bigint,
  CONSTRAINT uint_test_index PRIMARY KEY (uint_test_details)
);

/* End of Step #32 */

/* Step #33: Attach table tbl_test_details to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #33 */

/* Step #34: New table tbl_test_seg_mapping_of_job */

CREATE TABLE tbl_test_seg_mapping_of_job
(
  uint_job_mapping_index integer unsigned NOT NULL AUTO_INCREMENT,
  uint_job_id integer unsigned NOT NULL DEFAULT 1,
  uint_seq_order integer unsigned NOT NULL DEFAULT 1,
  uint_test_index integer unsigned NOT NULL DEFAULT 1,
  uint_slot_index integer unsigned,
  time_test_start time,
  time_test_finish time,
  uint_test_status integer unsigned,
  uint_monitor_test_index integer unsigned,
  time_monitor_job_start time,
  time_monitor_job_finish time,
  uint_monitor_status bigint,
  char_description text,
  CONSTRAINT uint_job_mapping_index PRIMARY KEY (uint_job_mapping_index)
);

/* End of Step #34 */

/* Step #35: Attach table tbl_test_seg_mapping_of_job to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #35 */

/* Step #36: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #36 */

/* Step #37: New foreign key fk_tbl_test_seg_mapping_of_job_ of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT fk_tbl_test_seg_mapping_of_job_
  FOREIGN KEY (uint_slot_index) REFERENCES tbl_slot_config (uint_slot_index) ON DELETE RESTRICT;

/* End of Step #37 */

/* Step #38: Modify column uint_job_id_1 of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  CHANGE uint_job_id uint_job_id_1 integer unsigned NOT NULL DEFAULT 1;

/* End of Step #38 */

/* Step #39: Modify column uint_job_id of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  CHANGE uint_job_id_1 uint_job_id integer unsigned NOT NULL DEFAULT 1;

/* End of Step #39 */

/* Step #40: New foreign key uint_job_id_1 of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT uint_job_id_1
  FOREIGN KEY (uint_job_id) REFERENCES tbl_job_queue (uint_job_id) ON DELETE RESTRICT;

/* End of Step #40 */

/* Step #41: Modify foreign key uint_job_id_fk of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP FOREIGN KEY uint_job_id_1;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_test_seg_mapping_of_job' AND index_name = 'uint_job_id_1');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX uint_job_id_1 ON tbl_test_seg_mapping_of_job');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT uint_job_id_fk
  FOREIGN KEY (uint_job_id) REFERENCES tbl_job_queue (uint_job_id) ON DELETE RESTRICT;

/* End of Step #41 */

/* Step #42: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #42 */

/* Step #43: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #43 */

/* Step #44: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #44 */

/* Step #45: Modify column uint_test_index of tbl_test_details */

ALTER TABLE tbl_test_details
  CHANGE uint_test_details uint_test_index integer unsigned NOT NULL AUTO_INCREMENT;

/* End of Step #45 */

/* Step #46: New foreign key fk_uint_test_index of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT fk_uint_test_index
  FOREIGN KEY (uint_test_index) REFERENCES tbl_test_details (uint_test_index) ON DELETE RESTRICT;

/* End of Step #46 */

/* Step #47: Modify foreign key fk_uint_job_id of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP FOREIGN KEY uint_job_id_fk;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_test_seg_mapping_of_job' AND index_name = 'uint_job_id_fk');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX uint_job_id_fk ON tbl_test_seg_mapping_of_job');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT fk_uint_job_id
  FOREIGN KEY (uint_job_id) REFERENCES tbl_job_queue (uint_job_id) ON DELETE RESTRICT;

/* End of Step #47 */

/* Step #48: New foreign key fk_test_monitor_test_index of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT fk_test_monitor_test_index
  FOREIGN KEY (uint_monitor_test_index) REFERENCES tbl_test_details (uint_test_index) ON DELETE NO ACTION;

/* End of Step #48 */

/* Step #49: Modify column time_job_start of tbl_job_queue */

ALTER TABLE tbl_job_queue
  ADD time_job_start time;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_job_queue SET time_job_start = char_job_start_time;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_job_queue
  DROP char_job_start_time;

/* End of Step #49 */

/* Step #50: Modify column time_job_finish of tbl_job_queue */

ALTER TABLE tbl_job_queue
  ADD time_job_finish time;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_job_queue SET time_job_finish = char_job_finish_time;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_job_queue
  DROP char_job_finish_time;

/* End of Step #50 */

/* Step #51: Modify column char_build_name of tbl_build_details */

ALTER TABLE tbl_build_details
  CHANGE char_binary_name char_build_name varchar(100) NOT NULL;

/* End of Step #51 */

/* Step #52: Modify foreign key fk_uint_build_index of tbl_job_queue */

ALTER TABLE tbl_job_queue
  DROP FOREIGN KEY fk_tbl_job_queue_;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_job_queue' AND index_name = 'fk_tbl_job_queue_');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX fk_tbl_job_queue_ ON tbl_job_queue');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_job_queue ADD CONSTRAINT fk_uint_build_index
  FOREIGN KEY (uint_build_index) REFERENCES tbl_build_details (uint_build_index) ON DELETE RESTRICT;

/* End of Step #52 */

/* Step #53: Modify foreign key fk_uint_box_index of tbl_slot_config */

ALTER TABLE tbl_slot_config
  DROP FOREIGN KEY fk_tbl_slot_config_;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_slot_config' AND index_name = 'fk_tbl_slot_config_');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX fk_tbl_slot_config_ ON tbl_slot_config');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_slot_config ADD CONSTRAINT fk_uint_box_index
  FOREIGN KEY (uint_box_index) REFERENCES tbl_box_details (uint_box_index) ON DELETE RESTRICT;

/* End of Step #53 */

/* Step #54: Modify foreign key fk_uint_slot_index of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP FOREIGN KEY fk_tbl_test_seg_mapping_of_job_;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_test_seg_mapping_of_job' AND index_name = 'fk_tbl_test_seg_mapping_of_job_');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX fk_tbl_test_seg_mapping_of_job_ ON tbl_test_seg_mapping_of_job');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_test_seg_mapping_of_job ADD CONSTRAINT fk_uint_slot_index
  FOREIGN KEY (uint_slot_index) REFERENCES tbl_slot_config (uint_slot_index) ON DELETE RESTRICT;

/* End of Step #54 */

/* Step #55: Modify column datetime_job_start of tbl_job_queue */

ALTER TABLE tbl_job_queue
  ADD datetime_job_start datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_job_queue SET datetime_job_start = time_job_start;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_job_queue
  DROP time_job_start;

/* End of Step #55 */

/* Step #56: Modify column datetime_job_finish of tbl_job_queue */

ALTER TABLE tbl_job_queue
  ADD datetime_job_finish datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_job_queue SET datetime_job_finish = time_job_finish;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_job_queue
  DROP time_job_finish;

/* End of Step #56 */

/* Step #57: Modify column datetime_test_start of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD datetime_test_start datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_seg_mapping_of_job SET datetime_test_start = time_test_start;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP time_test_start;

/* End of Step #57 */

/* Step #58: Modify column datetime_test_finish of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD datetime_test_finish datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_seg_mapping_of_job SET datetime_test_finish = time_test_finish;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP time_test_finish;

/* End of Step #58 */

/* Step #59: Modify column datetime_monitor_job_start of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD datetime_monitor_job_start datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_seg_mapping_of_job SET datetime_monitor_job_start = time_monitor_job_start;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP time_monitor_job_start;

/* End of Step #59 */

/* Step #60: Modify column datetime_monitor_job_finish of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD datetime_monitor_job_finish datetime;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_seg_mapping_of_job SET datetime_monitor_job_finish = time_monitor_job_finish;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP time_monitor_job_finish;

/* End of Step #60 */

/* Step #61: Modify column time_test_wait of tbl_test_details */

ALTER TABLE tbl_test_details
  ADD time_test_wait time;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_details SET time_test_wait = uint_test_wait_time;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_details
  DROP uint_test_wait_time;

/* End of Step #61 */

/* Step #62: Modify column char_box_ip of tbl_box_details */

ALTER TABLE tbl_box_details
  ALTER char_box_ip DROP DEFAULT;

ALTER TABLE tbl_box_details
  MODIFY char_box_ip varchar(50) NOT NULL DEFAULT xxx.xxx.xxx.xxx;

/* End of Step #62 */

/* Step #63: Modify column char_mac of tbl_box_details */

ALTER TABLE tbl_box_details
  ALTER char_mac DROP DEFAULT;

ALTER TABLE tbl_box_details
  MODIFY char_mac varchar(20) DEFAULT XX:XX:XX:XX:XX:XX;

/* End of Step #63 */

/* Step #64: Modify column char_ser_name of tbl_slot_config */

ALTER TABLE tbl_slot_config
  ALTER char_ser_name DROP DEFAULT;

ALTER TABLE tbl_slot_config
  MODIFY char_ser_name varchar(50) NOT NULL DEFAULT s13034hv16;

/* End of Step #64 */

/* Step #65: Modify column uint_test_mode of tbl_test_details */

ALTER TABLE tbl_test_details
  ALTER uint_test_mode DROP DEFAULT;

ALTER TABLE tbl_test_details
  MODIFY uint_test_mode integer unsigned NOT NULL;

/* End of Step #65 */

/* Step #66: New column uint_test_check_job_type of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD uint_test_check_job_type integer unsigned NOT NULL DEFAULT 1;

/* End of Step #66 */

/* Step #67: New column time_test_wait of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  ADD time_test_wait time;

/* End of Step #67 */

/* Step #68: Delete column uint_test_check_job_type of tbl_test_details */

ALTER TABLE tbl_test_details
  DROP uint_test_check_job_type;

/* End of Step #68 */

/* Step #69: Delete column time_test_wait of tbl_test_details */

ALTER TABLE tbl_test_details
  DROP time_test_wait;

/* End of Step #69 */

/* Step #70: Delete foreign key fk_test_monitor_test_index of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP FOREIGN KEY fk_test_monitor_test_index;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_test_seg_mapping_of_job' AND index_name = 'fk_test_monitor_test_index');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX fk_test_monitor_test_index ON tbl_test_seg_mapping_of_job');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

/* End of Step #70 */

/* Step #71: Delete column char_description of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP char_description;

/* End of Step #71 */

/* Step #72: Delete column uint_monitor_status of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP uint_monitor_status;

/* End of Step #72 */

/* Step #73: Delete column datetime_monitor_job_finish of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP datetime_monitor_job_finish;

/* End of Step #73 */

/* Step #74: Delete column datetime_monitor_job_start of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP datetime_monitor_job_start;

/* End of Step #74 */

/* Step #75: Delete column uint_monitor_test_index of tbl_test_seg_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job
  DROP uint_monitor_test_index;

/* End of Step #75 */

/* Step #76: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #76 */

/* Step #77: Move box of table tbl_test_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #77 */

/* Step #78: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #78 */

/* Step #79: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #79 */

/* Step #80: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #80 */

/* Step #81: Move box of table tbl_slot_config of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #81 */

/* Step #82: Move box of table tbl_job_queue of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #82 */

/* Step #83: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #83 */

/* Step #84: Move box of table tbl_job_queue of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #84 */

/* Step #85: New table tbl_monitoring_task_seq_of_test */

CREATE TABLE tbl_monitoring_task_seq_of_test
(
  uint_monitror_test_mapping_index integer unsigned NOT NULL AUTO_INCREMENT,
  uint_job_mapping_index integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_task_seq_order integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_test_index integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_test_mode integer unsigned NOT NULL DEFAULT 1,
  time_monitor_test_wait time,
  datetime_monitor_test_start datetime,
  datetime_monitor_test_finish datetime,
  uint_monitor_test_status integer unsigned NOT NULL,
  char_monitor_test_description bigint,
  CONSTRAINT uint_monitoring_test_index PRIMARY KEY (uint_monitror_test_mapping_index)
);

/* End of Step #85 */

/* Step #86: Attach table tbl_monitoring_task_seq_of_test to DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #86 */

/* Step #87: Move box of table tbl_monitoring_task_seq_of_test of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #87 */

/* Step #88: New foreign key fk_uint_job_mapping_index of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test ADD CONSTRAINT fk_uint_job_mapping_index
  FOREIGN KEY (uint_job_mapping_index) REFERENCES tbl_test_seg_mapping_of_job (uint_job_mapping_index) ON DELETE RESTRICT;

/* End of Step #88 */

/* Step #89: Move box of table tbl_monitoring_task_seq_of_test of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #89 */

/* Step #90: Move box of table tbl_monitoring_task_seq_of_test of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #90 */

/* Step #91: New foreign key fk_monitor_test_index of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test ADD CONSTRAINT fk_monitor_test_index
  FOREIGN KEY (uint_monitor_test_index) REFERENCES tbl_test_details (uint_test_index) ON DELETE RESTRICT;

/* End of Step #91 */

/* Step #92: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #92 */

/* Step #93: Move box of table tbl_test_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #93 */

/* Step #94: Move box of table tbl_test_seg_mapping_of_job of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #94 */

/* Step #95: Move box of table tbl_monitoring_task_seq_of_test of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #95 */

/* Step #96: Modify column char_monitor_test_description of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  ADD char_monitor_test_description_TMP text;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_monitoring_task_seq_of_test SET char_monitor_test_description_TMP = char_monitor_test_description;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_monitoring_task_seq_of_test
  DROP char_monitor_test_description;

ALTER TABLE tbl_monitoring_task_seq_of_test
  CHANGE char_monitor_test_description_TMP char_monitor_test_description text;

/* End of Step #96 */

/* Step #97: Modify column text_monitor_test_description of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  CHANGE char_monitor_test_description text_monitor_test_description text;

/* End of Step #97 */

/* Step #98: Modify table tbl_test_seq_mapping_of_job */

ALTER TABLE tbl_test_seg_mapping_of_job RENAME TO tbl_test_seq_mapping_of_job;

/* End of Step #98 */

/* Step #99: Modify column text_test_description of tbl_test_details */

ALTER TABLE tbl_test_details
  ADD text_test_description text;

/* TODO FOR DBDIFFO USER: MAYBE YOU SHOULD MODIFY THE FOLLOWING COPY SCRIPT TO CONVERT DATA. */

SET SQL_SAFE_UPDATES = 0;

UPDATE tbl_test_details SET text_test_description = varchar_test_description;

/* TODO FOR DBDIFFO USER: UNCOMMENT THE FOLLOWING STATEMENT IF YOU WANT TO ENABLE SQL SAFE UPDATES. */

/* SET SQL_SAFE_UPDATES = 1; */

ALTER TABLE tbl_test_details
  DROP varchar_test_description;

/* End of Step #99 */

/* Step #100: Modify column rack_name of tbl_slot_config */

ALTER TABLE tbl_slot_config
  CHANGE char_ser_name rack_name varchar(50) NOT NULL DEFAULT s13034hv16;

/* End of Step #100 */

/* Step #101: Modify column slot_number of tbl_slot_config */

ALTER TABLE tbl_slot_config
  CHANGE uint_server_slot_number slot_number integer unsigned NOT NULL;

/* End of Step #101 */

/* Step #102: Modify table tbl_test */

ALTER TABLE tbl_test_details RENAME TO tbl_test;

/* End of Step #102 */

/* Step #103: Modify table tbl_internal_queue */

ALTER TABLE tbl_test_seq_mapping_of_job RENAME TO tbl_internal_queue;

/* End of Step #103 */

/* Step #104: Delete column uint_status of tbl_job_queue */

ALTER TABLE tbl_job_queue
  DROP uint_status;

/* End of Step #104 */

/* Step #105: Delete column uint_state of tbl_job_queue */

ALTER TABLE tbl_job_queue
  DROP uint_state;

/* End of Step #105 */

/* Step #106: Delete column datetime_job_finish of tbl_job_queue */

ALTER TABLE tbl_job_queue
  DROP datetime_job_finish;

/* End of Step #106 */

/* Step #107: Delete column datetime_job_start of tbl_job_queue */

ALTER TABLE tbl_job_queue
  DROP datetime_job_start;

/* End of Step #107 */

/* Step #108: Move box of table tbl_job_queue of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #108 */

/* Step #109: Move box of table tbl_internal_queue of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #109 */

/* Step #110: New column uint_job_status of tbl_job_queue */

ALTER TABLE tbl_job_queue
  ADD uint_job_status integer unsigned;

/* End of Step #110 */

/* Step #111: Modify column rack_number of tbl_slot_config */

ALTER TABLE tbl_slot_config
  CHANGE slot_number rack_number integer unsigned NOT NULL;

/* End of Step #111 */

/* Step #112: New column uint_rack_type of tbl_slot_config */

ALTER TABLE tbl_slot_config
  ADD uint_rack_type integer unsigned;

/* End of Step #112 */

/* Step #113: Move box of table tbl_build_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #113 */

/* Step #114: Move box of table tbl_build_details of DIG_CI_Rack_Testing */

/* THIS STEP DOES NOT GENERATE AN SQL SCRIPT. */

/* End of Step #114 */

/* Step #115: Modify column uint_job_id of tbl_job_queue */

ALTER TABLE tbl_internal_queue
  DROP FOREIGN KEY fk_uint_job_id;

SET @exist := (SELECT count(*) FROM information_schema.statistics WHERE table_name = 'tbl_internal_queue' AND index_name = 'fk_uint_job_id');
SET @sqlstmt := IF( @exist = 0, 'SELECT ''INFO: Index does not exist.''', 'DROP INDEX fk_uint_job_id ON tbl_internal_queue');
PREPARE stmt FROM @sqlstmt;
EXECUTE stmt;

ALTER TABLE tbl_job_queue
  MODIFY uint_job_id integer unsigned NOT NULL;

ALTER TABLE tbl_internal_queue ADD CONSTRAINT fk_uint_job_id
  FOREIGN KEY (uint_job_id) REFERENCES tbl_job_queue (uint_job_id) ON DELETE RESTRICT;

/* End of Step #115 */

/* Step #116: New column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ADD char_test_name char(100);

/* End of Step #116 */

/* Step #117: Modify column char_test_name of tbl_test */

/* TODO FOR DBDIFFO USER: char_test_name WAS A NULLABLE COLUMN. SEVERAL ROWS MAY CONTAIN NULL VALUES. YOU MUST SET NON-NULL VALUES FOR THIS COLUMN BEFORE CHANGING IT TO NON-NULLABLE! */

ALTER TABLE tbl_test
  MODIFY char_test_name char(100) NOT NULL;

/* End of Step #117 */

/* Step #118: Modify column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ALTER char_test_name SET DEFAULT noname;

/* End of Step #118 */

/* Step #119: Delete column uint_test_check_job_type of tbl_internal_queue */

ALTER TABLE tbl_internal_queue
  DROP uint_test_check_job_type;

/* End of Step #119 */

/* Step #120: Delete column time_test_wait of tbl_internal_queue */

ALTER TABLE tbl_internal_queue
  DROP time_test_wait;

/* End of Step #120 */

/* Step #121: Modify column uint_internalQ_mapping_index of tbl_internal_queue */

ALTER TABLE tbl_internal_queue
  CHANGE uint_job_mapping_index uint_internalQ_mapping_index integer unsigned NOT NULL AUTO_INCREMENT;

/* End of Step #121 */

/* Step #122: Modify column uint_internalQ_mapping_index of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  CHANGE uint_job_mapping_index uint_internalQ_mapping_index integer unsigned NOT NULL DEFAULT 1;

/* End of Step #122 */

/* Step #123: Delete column uint_monitor_test_mode of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  DROP uint_monitor_test_mode;

/* End of Step #123 */

/* Step #124: Delete column text_monitor_test_description of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  DROP text_monitor_test_description;

/* End of Step #124 */

/* Step #125: Modify table text_error_description */

ALTER TABLE tbl_internal_queue RENAME TO text_error_description;

/* End of Step #125 */

/* Step #126: Modify table tbl_internal_queue */

ALTER TABLE text_error_description RENAME TO tbl_internal_queue;

/* End of Step #126 */

/* Step #127: New column text_error_description of tbl_internal_queue */

ALTER TABLE tbl_internal_queue
  ADD text_error_description text;

/* End of Step #127 */

/* Step #128: New column text_error_description of tbl_monitoring_task_seq_of_test */

ALTER TABLE tbl_monitoring_task_seq_of_test
  ADD text_error_description text;

/* End of Step #128 */

/* Step #129: Modify column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ALTER char_test_name SET DEFAULT notest;

/* End of Step #129 */

/* Step #130: Modify column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ALTER char_test_name SET DEFAULT default;

/* End of Step #130 */

/* Step #131: Modify column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ALTER char_test_name DROP DEFAULT;

ALTER TABLE tbl_test
  MODIFY char_test_name varchar(100) NOT NULL;

/* End of Step #131 */

/* Step #132: Modify column char_test_name of tbl_test */

ALTER TABLE tbl_test
  ALTER char_test_name SET DEFAULT default;

/* End of Step #132 */

