
drop trigger if exists user_creation_timestamp;

delimiter $$

create trigger user_creation_timestamp
	after insert
    on `user` for each row
begin
 SET NEW.account_created = NOW();
end$$

delimiter ;    

