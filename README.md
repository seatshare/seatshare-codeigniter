# SeatShare

## Objective

This project is a mock SaaS to allow a group of people to manage a pool of tickets to events. The most common use case is to share season tickets to a sports team.

## Installation Instructions

1. You need to have a working PHP/MySQL stack available.
2. Clone the project into a working directory and connect the relevant virtual hosts
3. Move a few configuration files around
  * Copy `application/config/config.php.dist` to `application/config/config.php` and make necessary edits
  * Copy `application/config/database.php.dist` to `application/config/database.php` and make necessary edits
  * Copy `application/config/api_keys.php.dist` to `application/config/api_keys.php` and make necessary edits
  * (Optional) Copy `application/config/email.php.dist` to `application/config/email.php` and make necessary edits
4. From your command line in the project directory, run `php index.php migration`

**Important**: There is currently no system administrator tools for adding entities (teams, venues) or events. These will have to be done by hand in the interim. Some sample data is loaded for two local teams by default.

If all went well, you should now be able to navigate to the project URL and register for an account. You will want to select 'Create a New Group' for the first user.

## Database Migrations

1. Run from the project directory root: `php index.php migration`
2. You can compare code versions in `application/config/migration.php` and the `migrations.version` database field.

## Deploying

1. Send me a public key to add to the server
2. Deployments use `whiskey_disk`
3. `wd deploy --to=staging --path=application/config/deploy.yml` for seatshare.yearg.in
4. `wd deploy --to=production --path=application/config/deploy.yml` for seatsha.re