BEGIN;

--
-- sequences
--

CREATE SEQUENCE seq_master;
CREATE SEQUENCE seq_ticket;

--
-- master
--

CREATE TABLE master (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	createdate timestamp DEFAULT localtimestamp,
	createuserid integer ,
	changedate timestamp DEFAULT localtimestamp,
	changedby integer,
	disabled integer DEFAULT 0,
	deleted integer DEFAULT 0
);

--
-- users and groups with mapping
--

CREATE TABLE "user" (
	username varchar(255) NOT NULL,
	password varchar(32) NOT NULL,
	salt varchar(255) DEFAULT '',
	firstname varchar(255) DEFAULT '',
	name varchar(255) DEFAULT '',
	email varchar(255) DEFAULT '',
	language varchar(10),
	lastlogin timestamp DEFAULT localtimestamp
) INHERITS (master);

CREATE TABLE "group" (
	name varchar(255) NOT NULL,
	description text DEFAULT ''
) INHERITS (master);

CREATE TABLE usergroupmapping (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	userid integer NOT NULL,
	groupid integer NOT NULL
);

--
-- acl
--

CREATE TABLE "right" (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	name varchar(255) NOT NULL,
	description text DEFAULT ''
);

CREATE TABLE resource (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	name varchar(255) NOT NULL,
	description text DEFAULT ''
) INHERITS (master);

CREATE TABLE acl (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	resourceid integer NOT NULL,
	who integer NOT NULL,
	allow integer DEFAULT 0,
	disable integer DEFAULT 0,
	rightid integer NOT NULL
);

--
-- address
--

CREATE TABLE company (
	name varchar(255) NOT NULL,
	street varchar(255) DEFAULT '',
	zip varchar(10) DEFAULT '',
	city varchar(255) DEFAULT '',
	state varchar(255) DEFAULT '',
	country varchar(255) DEFAULT '',
	phone varchar(255) DEFAULT '',
	fax varchar(255) DEFAULT '',
	email varchar(255) DEFAULT '',
	url varchar(255) DEFAULT '',
	note text DEFAULT ''
) INHERITS (master);

CREATE TABLE companyline (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	name varchar(255) DEFAULT '',
	description text DEFAULT ''
);

CREATE TABLE companylinemapping (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	companyid integer NOT NULL,
	companylineid integer NULL
);

CREATE TABLE companycontact (
	companyid integer NOT NULL,
	firstname varchar(255) DEFAULT '',
	name varchar(255) DEFAULT '',
	salution varchar(10) DEFAULT '',
	title varchar(10) DEFAULT '',
	position varchar(255) DEFAULT '',
	url varchar(255) DEFAULT '',
	email varchar(255) DEFAULT '',
	phone varchar(255) DEFAULT '',
	mobilephone varchar(255) DEFAULT '',
	fax varchar(255) DEFAULT '',
	privatestreet varchar(255) DEFAULT '',
	privatezip varchar(255) DEFAULT '',
	privatecity varchar(255) DEFAULT '',
	birthday varchar(11) DEFAULT '',
	note text DEFAULT ''
) INHERITS (master);

--
-- projects
--
CREATE TABLE project (
	name varchar(255) NOT NULL,
	description text DEFAULT '',
	supervisorid integer NOT NULL,
	statusid integer NOT NULL,
	priority integer NOT NULL,
	companyid integer,
	contactpersonid integer,
	ticketprefix varchar(50) DEFAULT '',
	starttime timestamp,
	endtime timestamp,
	targethours integer DEFAULT 0,
	targetminutes integer DEFAULT 0,
	private boolean DEFAULT false
) INHERITS (master);

CREATE TABLE projectusermapping (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	projectid integer NOT NULL,
	userid integer NOT NULL
);

CREATE TABLE projecttask (
	projectid integer NOT NULL,
	ticketid varchar(255) DEFAULT '',
	name varchar(255) NOT NULL,
	description text DEFAULT '',
	starttime timestamp,
	endtime timestamp,
	targethours integer DEFAULT 0,
	targetminutes integer DEFAULT 0,
	ishours integer DEFAULT 0,
	isminutes integer DEFAULT 0,
	statusid integer NOT NULL,
	private boolen DEFAULT false
) INHERITS (master);

CREATE TABLE projecttaskfeedback (
	projecttaskid integer NOT NULL,
	statusid integer NOT NULL,
	note text DEFAULT '',
	hours integer DEFAULT 0,
	minutes integer DEFAULT 0,
	feedbacktime timestamp DEFAULT localtimestamp
) INHERITS (master);

CREATE TABLE projecttstatus (
	id integer PRIMARY KEY DEFAULT nextval('seq_master'),
	name varchar(255) NOT NULL,
	description text DEFAULT ''
);

--
-- calendar
--

CREATE TABLE calendar (
	title varchar(255) NOT NULL,
	description text DEFAULT '',
	datefrom timestamp DEFAULT localtimestamp,
	dateto timestamp DEFAULT localtimestamp,
	userid integer NOT NULL
) INHERITS (master);

--
-- files
--

CREATE TABLE files (
        object oid,
        filename varchar(255) DEFAULT '',
	filemd5sum varchar(32) DEFAULT '',
        filesize integer DEFAULT 0,
        filetype varchar(255) DEFAULT 'application/octet-stream'
) INHERITS (master);

--
-- notes
--

CREATE TABLE notes (
	title varchar(255) NOT NULL,
	description text DEFAULT ''
) INHERITS (master);

--
-- INSERTS
--

INSERT INTO "group" (name, description) VALUES ('admin', 'admin group');
INSERT INTO "user" (username, password, language) VALUES ('admin', md5('admin'), 'en_US');
INSERT INTO usergroupmapping (userid, groupid) VALUES ((SELECT id FROM "user" WHERE username='admin'), (SELECT id FROM "group" WHERE name='admin'));

INSERT INTO "right" (name, description) VALUES ('read', 'read rights');
INSERT INTO "right" (name, description) VALUES ('write', 'write rights');

--
-- Index
--

COMMIT;
