-- Global, per-event leaderboard
SELECT `groups`.`game_id`, `games`.`name`, `groups`.`group_id`, `groups`.`name`, `groups`.`state`, count(`assigned_locations`.`group_id`) AS `reached`, `groups`.`last_state_change` FROM `games` LEFT OUTER JOIN `groups` ON `games`.`game_id` = `groups`.`game_id` LEFT OUTER JOIN `assigned_locations` ON `assigned_locations`.`game_id` = `games`.`game_id` AND `assigned_locations`.`group_id` = `groups`.`group_id` WHERE `games`.`event_id` = 7 AND `games`.`state` >= 128 GROUP BY `assigned_locations`.`group_id` ORDER BY `reached` DESC, `groups`.`state` DESC, `groups`.`last_state_change` ASC;

-- After event leaderboard (via log)
SELECT `log`.`identity_id`, (SELECT `groups`.`name` FROM `groups` WHERE `groups`.`group_id` = `log`.`identity_id`) AS `team_name`, (SELECT `games`.`game_id`, `games`.`name` FROM `games` WHERE `games`.`game_id` = `log`.`game_id`), `log`.`message`, `log`.`timestamp` FROM `log` WHERE `log`.`game_id` IN (SELECT `games`.`game_id` FROM `games` WHERE `games`.`event_id` = 7) AND `log`.`message` LIKE 'Group has reached the prize%' ORDER BY `log`.`timestamp` ASC;

-- Number of groups and participants by game
SELECT `games`.`name`, count(*) AS `team_count`, SUM(`groups`.`participants_count`) AS `participant_count` FROM `games` LEFT OUTER JOIN `groups` ON `games`.`game_id` = `groups`.`game_id` WHERE `games`.`event_id` = 7 AND `games`.`state` >= 128 GROUP BY `games`.`game_id` HAVING `team_count` > 0 AND `participant_count` > 0;

-- Overview: Number of games, groups, participants, and std.dev by event
SELECT count(DISTINCT `games`.`game_id`) AS games_count, count(`groups`.`group_id`) AS groups_count, SUM(`groups`.`participants_count`) AS participant_count, AVG(`groups`.`participants_count`) AS participant_avg, STDDEV_POP(`groups`.`participants_count`) AS participant_stddev FROM `games` LEFT OUTER JOIN `groups` ON `games`.`game_id` = `groups`.`game_id` WHERE `games`.`event_id` = 7 AND `games`.`state` >= 128 AND `groups`.`state` >= 30;

-- Overview: starting locations for all games
SELECT `games`.`name`, `locations`.`lat`, `locations`.`lng` FROM `games` LEFT OUTER JOIN `locations` ON `games`.`game_id` = `locations`.`game_id` WHERE `games`.`event_id` IN (7, 8) AND `games`.`state` >= 128 AND `locations`.`location_id` = 1;

-- Game durations, by game and by group
SELECT `games`.`game_id`, `games`.`name`, `assigned_locations`.`group_id`, MIN(`assigned_locations`.`assigned_on`) AS `start`, MAX(`assigned_locations`.`reached_on`) AS `end`, TIMEDIFF(MAX(`assigned_locations`.`reached_on`), MIN(`assigned_locations`.`assigned_on`)) AS `duration` FROM `games` LEFT OUTER JOIN `assigned_locations` ON `games`.`game_id` = `assigned_locations`.`game_id` WHERE `games`.`event_id` IN (7,8) AND `games`.`state` >= 128 GROUP BY `assigned_locations`.`group_id`, `games`.`game_id` HAVING `start` IS NOT NULL AND `end` IS NOT NULL
