Put `*.sql`, `*.sql.gz` or `*.sh` files here to seed the database.

MySQL runs them in alphabetical order **only the first time** the `mysql-data`
volume is created. To re-run them: `docker compose down -v && docker compose up -d`.

Do not commit dumps that contain real user data or passwords.
