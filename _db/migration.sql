SET @pos := 0;
create table sumtraining (
    id serial not null,
    session_id bigint not null,
    user_id bigint not null,
    art_of_paddle varchar(64) not null,
    training_environment_type text,
    training_count int not null,
    plan_training_id varchar(128),
    plan_training_type varchar(64),
    start_time bigint not null,
    duration int not null,
    distance double not null
)
select
    (SELECT @pos := @pos + 1) as id,
    n.session_id as session_id,
    n.user_id as user_id,
    'racing_kayaking' as art_of_paddle,
    t.training_environment_type,
    0 as training_count,
    p.id as plan_training_id,
    p.type as plan_training_type,
    min(n.timestamp) as start_time,
    (max(n.timestamp) - min(n.timestamp)) as duration,
    max(n.distance) as distance
from
    newtraining n
left outer join
    training t on n.session_id = t.session_id
left outer join
    plan p on n.session_id = p.session_id
group by
    n.session_id

update sumtraining nst
inner join (
    select session_id, training_env_type from training where training_env_type != '' group by session_id
) as nt on nst.session_id = nt.session_id
set nst.`training_environment_type` = nt.training_environment_type;

SET @pos := 0;
create table newtrainingavg (
    id serial not null,
    session_id bigint not null,
    user_id bigint not null,
    `force` double not null,
    `speed` double not null,
    `strokes` double not null,
    `t_200` double not null
)
select
    ( SELECT @pos := @pos + 1 ) as id,
    session_id,
    user_id,
    avg(`force`) as `force`,
    avg(`speed`) as `speed`,
    avg(`strokes`) as `strokes`,
    avg(`t_200`) as `t_200`
from
    newtraining n
group by
    session_id;

