CREATE TABLE tbl_box_details
(
  uint_box_index integer unsigned NOT NULL AUTO_INCREMENT,
  char_box_ip varchar(50) NOT NULL DEFAULT "xxx.xxx.xxx.xxx",
  uint_box_platform integer unsigned NOT NULL DEFAULT 1,
  char_mac varchar(20) DEFAULT "XX:XX:XX:XX:XX:XX",
  CONSTRAINT uint_box_index PRIMARY KEY (uint_box_index)
);

CREATE TABLE tbl_build_details
(
  uint_build_index integer unsigned NOT NULL AUTO_INCREMENT,
  char_build_name varchar(100) NOT NULL,
  uint_box_platform integer unsigned NOT NULL DEFAULT 1,
  char_build_md5sum varchar(100),
  uint_build_type integer unsigned NOT NULL,
  char_middleware_version varchar(100) NOT NULL,
  CONSTRAINT uint_build_index PRIMARY KEY (uint_build_index)
);

CREATE TABLE tbl_internal_queue
(
  uint_internalQ_mapping_index integer unsigned NOT NULL AUTO_INCREMENT,
  uint_job_id integer unsigned NOT NULL DEFAULT 1,
  uint_seq_order integer unsigned NOT NULL DEFAULT 1,
  uint_test_index integer unsigned NOT NULL DEFAULT 1,
  uint_slot_index integer unsigned,
  datetime_test_start datetime,
  datetime_test_finish datetime,
  uint_test_status integer unsigned,
  text_error_description text,
  CONSTRAINT uint_job_mapping_index PRIMARY KEY (uint_internalQ_mapping_index)
);

CREATE TABLE tbl_job_queue
(
  uint_job_id integer unsigned NOT NULL,
  uint_priority integer unsigned NOT NULL DEFAULT 1,
  uint_number_of_boxes integer unsigned NOT NULL DEFAULT 1,
  uint_build_index integer unsigned NOT NULL DEFAULT 1,
  uint_job_status integer unsigned,
  CONSTRAINT uint_job_id PRIMARY KEY (uint_job_id)
);

CREATE TABLE tbl_monitoring_task_seq_of_test
(
  uint_monitror_test_mapping_index integer unsigned NOT NULL AUTO_INCREMENT,
  uint_internalQ_mapping_index integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_task_seq_order integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_test_index integer unsigned NOT NULL DEFAULT 1,
  uint_monitor_test_wait integer unsigned,
  datetime_monitor_test_start datetime,
  datetime_monitor_test_finish datetime,
  uint_monitor_test_status integer unsigned NOT NULL,
  text_error_description text,
  CONSTRAINT uint_monitoring_test_index PRIMARY KEY (uint_monitror_test_mapping_index)
);

CREATE TABLE tbl_slot_config
(
  uint_slot_index integer unsigned NOT NULL AUTO_INCREMENT,
  rack_name varchar(50) NOT NULL DEFAULT "s13034hv16",
  rack_number integer unsigned NOT NULL,
  bool_slot_availability bit(1) NOT NULL DEFAULT 1,
  uint_box_index integer unsigned NOT NULL DEFAULT 1,
  uint_rack_type integer unsigned,
  CONSTRAINT int_slot_index PRIMARY KEY (uint_slot_index)
);

CREATE TABLE tbl_test
(
  uint_test_index integer unsigned NOT NULL AUTO_INCREMENT,
  uint_test_type integer unsigned NOT NULL DEFAULT 1,
  uint_test_mode integer unsigned NOT NULL,
  text_test_description text,
  char_test_name varchar(100) NOT NULL DEFAULT "default",
  CONSTRAINT uint_test_index PRIMARY KEY (uint_test_index)
);

ALTER TABLE tbl_internal_queue ADD CONSTRAINT fk_uint_job_id
  FOREIGN KEY (uint_job_id) REFERENCES tbl_job_queue (uint_job_id) ON DELETE RESTRICT;

ALTER TABLE tbl_internal_queue ADD CONSTRAINT fk_uint_slot_index
  FOREIGN KEY (uint_slot_index) REFERENCES tbl_slot_config (uint_slot_index) ON DELETE RESTRICT;

ALTER TABLE tbl_internal_queue ADD CONSTRAINT fk_uint_test_index
  FOREIGN KEY (uint_test_index) REFERENCES tbl_test (uint_test_index) ON DELETE RESTRICT;

ALTER TABLE tbl_job_queue ADD CONSTRAINT fk_uint_build_index
  FOREIGN KEY (uint_build_index) REFERENCES tbl_build_details (uint_build_index) ON DELETE RESTRICT;

ALTER TABLE tbl_monitoring_task_seq_of_test ADD CONSTRAINT fk_monitor_test_index
  FOREIGN KEY (uint_monitor_test_index) REFERENCES tbl_test (uint_test_index) ON DELETE RESTRICT;

ALTER TABLE tbl_monitoring_task_seq_of_test ADD CONSTRAINT fk_uint_job_mapping_index
  FOREIGN KEY (uint_internalQ_mapping_index) REFERENCES tbl_internal_queue (uint_internalQ_mapping_index) ON DELETE RESTRICT;

ALTER TABLE tbl_slot_config ADD CONSTRAINT fk_uint_box_index
  FOREIGN KEY (uint_box_index) REFERENCES tbl_box_details (uint_box_index) ON DELETE RESTRICT;

