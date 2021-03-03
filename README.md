# Demo project 

## Deploying on heroku

```bash
heroku create
heroku git:remote 

heroku config:set SYMFONY_ENV=prod
heroku config:set DB_URL=sqlite3:////app/var/data.sqlite
heroku config:set APP_SECRET=something_ecret

git push heroku master

heroku open
```