DROP TABLE IF EXISTS app_message;
DROP TABLE IF EXISTS version;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS log;
DROP TABLE IF EXISTS system_info;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS newTrainingAvg;
DROP TABLE IF EXISTS sumTraining;
DROP TABLE IF EXISTS plan_element;
DROP TABLE IF EXISTS plan;
DROP TABLE IF EXISTS push_token;
DROP TABLE IF EXISTS refresh_tokens;
DROP TABLE IF EXISTS trainingAvg;
DROP TABLE IF EXISTS newtraining;
DROP TABLE IF EXISTS training;
DROP TABLE IF EXISTS "user";


CREATE TABLE app_message (
  id serial NOT NULL PRIMARY KEY,
  language_code character varying(45) NOT NULL,
  message_localized text
);

CREATE TABLE event (
  id character varying(180) NOT NULL PRIMARY KEY,
  user_id integer,
  session_id bigint NOT NULL,
  timestamp bigint NOT NULL,
  name character varying(255) NOT NULL,
  plan_id character varying(180),
  plan_type character varying(180) NOT NULL
);

CREATE TABLE feedback (
  id serial NOT NULL PRIMARY KEY,
  message text
);

CREATE TABLE log (
  id serial NOT NULL PRIMARY KEY,
  log text,
  ts bigint,
  system_info_ts bigint,
  feedback_fk integer
);

CREATE TABLE newTrainingAvg (
  id serial NOT NULL PRIMARY KEY,
  session_id bigint,
  _force double precision DEFAULT NULL,
  speed double precision DEFAULT NULL,
  strokes double precision DEFAULT NULL,
  t_200 double precision DEFAULT NULL,
  user_id integer
);

CREATE TABLE newtraining (
  id serial NOT NULL PRIMARY KEY,
  session_id bigint DEFAULT NULL,
  timestamp bigint DEFAULT NULL,
  _force double precision DEFAULT NULL,
  speed double precision DEFAULT NULL,
  distance integer DEFAULT NULL,
  strokes double precision DEFAULT NULL,
  t_200 double precision DEFAULT NULL,
  old_version_switch double precision DEFAULT NULL,
  user_id integer DEFAULT NULL
);

CREATE TABLE plan (
  id character varying(180) NOT NULL PRIMARY KEY,
  user_id integer DEFAULT NULL,
  type character varying(180) NOT NULL,
  name character varying(255) DEFAULT NULL,
  notes text,
  session_id bigint DEFAULT NULL
);

CREATE TABLE plan_element (
  id character varying(255) NOT NULL PRIMARY KEY,
  plan_id character varying(180) DEFAULT NULL,
  position integer NOT NULL,
  intensity integer NOT NULL,
  value double precision NOT NULL
);

CREATE TABLE push_token (
  id bigserial NOT NULL PRIMARY KEY,
  user_id integer DEFAULT NULL,
  token_type character varying(45) NOT NULL,
  token character varying(255) NOT NULL,
  version_code bigint DEFAULT NULL
);

CREATE TABLE refresh_tokens (
  id serial NOT NULL PRIMARY KEY,
  refresh_token character varying(128) NOT NULL,
  username character varying(255) NOT NULL,
  valid timestamp NOT NULL
);

ALTER TABLE refresh_tokens ADD CONSTRAINT refresh_tokens_refresh_token_ukey UNIQUE (refresh_token);

CREATE TABLE sumTraining (
  id serial NOT NULL PRIMARY KEY,
  session_id bigint DEFAULT NULL,
  user_id integer DEFAULT NULL,
  art_of_paddle character varying(32) DEFAULT NULL,
  training_environment_type character varying(64) DEFAULT NULL,
  training_count integer DEFAULT NULL,
  plan_training_id character varying(180) DEFAULT NULL,
  plan_training_type character varying(255) DEFAULT NULL,
  start_time bigint DEFAULT NULL,
  duration bigint DEFAULT NULL,
  distance integer DEFAULT NULL
);

CREATE TABLE system_info (
  id serial NOT NULL PRIMARY KEY,
  version_code integer DEFAULT NULL,
  version_name character varying(64) DEFAULT NULL,
  ts bigint DEFAULT NULL,
  locale character varying(32) DEFAULT NULL,
  brand character varying(32) DEFAULT NULL,
  model character varying(32) DEFAULT NULL,
  os_version character varying(16) DEFAULT NULL,
  user_name character varying(64) DEFAULT NULL,
  feedback_fk integer DEFAULT NULL
);

CREATE TABLE training (
  id bigint NOT NULL PRIMARY KEY,
  user_id integer DEFAULT NULL,
  session_id bigint NOT NULL,
  training_type character varying(255) NOT NULL,
  data text,
  hash character varying(255),
  training_env_type character varying(255) NOT NULL
);

CREATE TABLE trainingAvg (
  id serial NOT NULL PRIMARY KEY,
  user_id integer DEFAULT NULL,
  session_id bigint NOT NULL,
  data_type character varying(255) NOT NULL,
  data_value double precision NOT NULL
);

CREATE TABLE "user" (
  id serial NOT NULL PRIMARY KEY,
  username character varying(180) NOT NULL,
  email character varying(180) NOT NULL,
  password character varying(255) NOT NULL,
  first_name character varying(60) DEFAULT NULL,
  last_name character varying(60) DEFAULT NULL,
  birth_date date DEFAULT NULL,
  body_weight double precision NOT NULL,
  country character varying(255) NOT NULL,
  gender character varying(255) NOT NULL,
  pw_reset_token character varying(150) DEFAULT NULL,
  facebook_id character varying(255) DEFAULT NULL,
  username_canonical character varying(180) NOT NULL,
  email_canonical character varying(180) NOT NULL,
  enabled boolean NOT NULL,
  salt character varying(255) DEFAULT NULL,
  last_login timestamp DEFAULT NULL,
  confirmation_token character varying(180) DEFAULT NULL,
  password_requested_at timestamp DEFAULT NULL,
  roles text NOT NULL,
  google_id character varying(255) DEFAULT NULL,
  club character varying(255) DEFAULT NULL,
  art_of_paddling character varying(255) NOT NULL,
  unit_weight character varying(45) DEFAULT NULL,
  unit_distance character varying(45) DEFAULT NULL,
  unit_pace character varying(45) DEFAULT NULL
);

CREATE TABLE version (
  android integer DEFAULT NULL,
  ios integer DEFAULT NULL
);
