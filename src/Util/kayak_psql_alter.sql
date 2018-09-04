ALTER TABLE event
ADD CONSTRAINT event_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id)
ON DELETE CASCADE;

ALTER TABLE event
ADD CONSTRAINT event_plan_id_fkey
FOREIGN KEY (plan_id)
REFERENCES plan (id)
ON DELETE CASCADE;

ALTER TABLE log
ADD CONSTRAINT log_feedback_id_fkey
FOREIGN KEY (feedback_fk)
REFERENCES feedback (id);

ALTER TABLE plan
ADD CONSTRAINT plan_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id)
ON DELETE CASCADE;

ALTER TABLE plan_element
ADD CONSTRAINT plan_element_plan_id_fkey
FOREIGN KEY (plan_id)
REFERENCES plan (id)
ON DELETE CASCADE;

ALTER TABLE push_token
ADD CONSTRAINT push_token_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id)
ON DELETE CASCADE;

ALTER TABLE sumTraining
ADD CONSTRAINT sumtraining_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id);

ALTER TABLE sumTraining
ADD CONSTRAINT sumtraining_session_id_fkey
FOREIGN KEY (session_id)
REFERENCES newtraining (id);

ALTER TABLE sumTraining
ADD CONSTRAINT sumtraining_plan_id_fkey
FOREIGN KEY (plan_training_id)
REFERENCES plan (id);

ALTER TABLE system_info
ADD CONSTRAINT system_info_feedback_id_fkey
FOREIGN KEY (feedback_fk)
REFERENCES feedback (id);

ALTER TABLE training
ADD CONSTRAINT training_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id);

ALTER TABLE trainingAvg
ADD CONSTRAINT training_avg_session_id_fkey
FOREIGN KEY (session_id)
REFERENCES training (id);

ALTER TABLE trainingAvg
ADD CONSTRAINT training_avg_user_id_fkey
FOREIGN KEY (user_id)
REFERENCES "user" (id);

ALTER TABLE "user" ADD CONSTRAINT user_username_canonical_ukey UNIQUE (username_canonical);
ALTER TABLE "user" ADD CONSTRAINT user_email_canonical_ukey UNIQUE (email_canonical);
ALTER TABLE "user" ADD CONSTRAINT user_confirmation_token_ukey UNIQUE (confirmation_token);

CREATE INDEX appmsg_id_idx ON app_message (id);

CREATE INDEX event_id_idx ON event (id);
CREATE INDEX event_user_id_idx ON event (user_id);
CREATE INDEX event_session_id_idx ON event (session_id);
CREATE INDEX event_plan_id_idx ON event (plan_id);
CREATE INDEX event_session_user_id_idx ON event (session_id, user_id);
CREATE INDEX event_session_plan_id_idx ON event (session_id, plan_id);
CREATE INDEX event_session_plan_user_id_idx ON event (session_id, plan_id, user_id);

CREATE INDEX feedback_id_idx ON feedback (id);

CREATE INDEX log_id_idx ON log (id);
CREATE INDEX log_feedback_id_idx ON log (feedback_fk);

CREATE INDEX newtraining_id_idx ON newtraining (id);
CREATE INDEX newtraining_user_id_idx ON newtraining (user_id);
CREATE INDEX newtraining_session_id_idx ON newtraining (session_id);
CREATE INDEX newtraining_session_user_id_idx ON newtraining (session_id, user_id);

CREATE INDEX newtrainingavg_id_idx ON newtrainingavg (id);
CREATE INDEX newtrainingavg_user_id_idx ON newtrainingavg (user_id);
CREATE INDEX newtrainingavg_session_id_idx ON newtrainingavg (session_id);
CREATE INDEX newtrainingavg_session_user_id_idx ON newtrainingavg (session_id, user_id);

CREATE INDEX plan_id_idx ON plan (id);
CREATE INDEX plan_user_id_idx ON plan (user_id);
CREATE INDEX plan_session_id_idx ON plan (session_id);
CREATE INDEX plan_session_user_id_idx ON plan (session_id, user_id);

CREATE INDEX plan_element_id_idx ON plan_element (id);
CREATE INDEX plan_element_plan_id_idx ON plan_element (plan_id);

CREATE INDEX push_token_id_idx ON push_token (id);
CREATE INDEX push_token_user_id_idx ON push_token (user_id);

CREATE INDEX refresh_tokens_id_idx ON refresh_tokens (id);

CREATE INDEX sumtraining_id_idx ON sumtraining (id);
CREATE INDEX sumtraining_user_id_idx ON sumtraining (user_id);
CREATE INDEX sumtraining_session_id_idx ON sumtraining (session_id);
CREATE INDEX sumtraining_plan_id_idx ON sumtraining (plan_training_id);
CREATE INDEX sumtraining_session_user_id_idx ON sumtraining (session_id, user_id);
CREATE INDEX sumtraining_session_plan_id_idx ON sumtraining (session_id, plan_training_id);
CREATE INDEX sumtraining_session_plan_user_id_idx ON sumtraining (session_id, plan_training_id, user_id);

CREATE INDEX system_info_id_idx ON system_info (id);
CREATE INDEX system_info_feedback_id_idx ON system_info (feedback_fk);

CREATE INDEX trainingavg_id_idx ON trainingavg (id);
CREATE INDEX trainingavg_user_id_idx ON trainingavg (user_id);
CREATE INDEX trainingavg_session_id_idx ON trainingavg (session_id);
CREATE INDEX trainingavg_session_user_id_idx ON trainingavg (session_id, user_id);

CREATE INDEX training_id_idx ON training (id);
CREATE INDEX training_user_id_idx ON training (user_id);
CREATE INDEX training_session_id_idx ON training (session_id);
CREATE INDEX training_session_user_id_idx ON training (session_id, user_id);

CREATE INDEX user_id_idx ON "user" (id);
CREATE INDEX user_email_idx ON "user" (email);
