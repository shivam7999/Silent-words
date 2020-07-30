
create table data(
	user_id int(11) auto_increment primary key not null,
	user varchar(256) not null,
	user_pwd varchar( 256 ) not null,
	user_name varchar(256) not null UNIQUE,
	email varchar(256) not null,
	yesno varchar(256) not null
);
