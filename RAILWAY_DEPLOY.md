# Railway Deployment for Pro Car

This PHP app uses a MySQL database and is deployable on Railway using Docker.

## Local test with Docker

```bash
docker compose up --build
```

Then open:

```bash
http://localhost:8080
```

## Railway deployment steps

1. Push your repo to GitHub.
2. On Railway, create a new project and choose "Deploy from GitHub repo."
3. Add the MySQL plugin in Railway.
4. In Railway project variables, add these values from the MySQL plugin:
   - `MYSQL_HOST`
   - `MYSQL_PORT`
   - `MYSQL_DB`
   - `MYSQL_USER`
   - `MYSQL_PASS`
5. Confirm Railway is using the repository `Dockerfile`.
6. Deploy and inspect logs.

## Verify

```bash
curl https://<your-project>.up.railway.app/backend/cars_api.php
curl https://<your-project>.up.railway.app/
```

## Notes

- `backend/db.php` creates the database and schema automatically on startup.
- Keep passwords in Railway Variables only.
