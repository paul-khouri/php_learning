/**
*Database creation script
*/

drop table if exists post;

create table post(
    id integer primary key not null,
    title text not null,
    body text not null,
    user_id integer not null,
    created_at date not null,
    updated_at date
);

insert into post(title, body, user_id, created_at)
values(
    "Here is our first post",
    "This is the body text for the first post.
    
    It is split into paragraphs.",
    1,
    date('now', '-2 months')
);

insert into post(title, body, user_id, created_at)
values(
    "Here is our second post",
    "This is the body text for the second post.
    
    It is split into paragraphs.",
    1,
    date('now', '-1 months')
);

insert into post(title, body, user_id, created_at)
values(
    "Here is our third post",
    "This is the body text for the third post.
    
    It is split into paragraphs.",
    1,
    date('now', '-19 days')
);
