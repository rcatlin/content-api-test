### Content Api Test

The repository you are currently viewing is a proof-of-concept.

My aim is to create an API who's validation, hydration, and transformation is directed by the Entity definition.

The API is based off of refinery29/piston.

The endpoints are defined as "actions".


### Developer setup

1. Clone the repo: `git clone git@github.com:rcatlin/content-api-test`
1. cd into the repo: `cd content-api-test`
1. Install PHP dependencies: `make composer`
1. Instantiate the DB and run migrations: `make db`
1. Start a local instance: `make start-dev`
1. Hit `locahost:8000/api/ping` in your browser and you should see a JSON response with `{"result": ["pong"]}`
