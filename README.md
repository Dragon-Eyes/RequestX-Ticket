# Request X - Ticket
Request X Ticketing application

Procedural PHP 7 using mysqli
(Mailservice API connection is object oriented)

You need to create a db_credentials.php from db_credentials_template.php to provide your own database credentials.
Please also adapt the "SUPPORT_EMAIL" in configuration.php

## Notifications
E-mail notifications are send
* when a new ticket is created (to the responsible) and
* when the status is changed to done (to the requester)
* when a new comment is created (without the %%silent%% option)

If the %%noemailreply%% option is added into the comment, a non-existing email is used instead of the email address of the comment creator.

## Compatability
Database tested: MariaDB 10

The version on Master is working fine.

[Dev / Demo instance](https://dev.requestx.ch)<br>User: "Demo"<br>Pw: "DragonClaw1"

Helpful how-to if you want to contribute (it would be awesome!): https://github.com/MarcDiethelm/contributing/blob/master/README.md
