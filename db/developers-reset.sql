begin;
drop table mdl_cvent_apicalls_log;
drop table mdl_cvent_event;
drop table mdl_cvent_registration;
drop table mdl_cvent_contact;
drop table mdl_cvent_registration_guest;
delete from mdl_config where name = 'enrol_cvent_version';
commit;
