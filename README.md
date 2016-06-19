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

### New Entity and Endpoint process

1. Create a new Entity called `Qux` in the `Entity` directory, with columns/fields.
1. Run `./bin/console migrations:diff` to generate a new migration that will create the table for your new Entity
1. Migrate `make migrate` to create that table.
1. Run the dev server `make start-dev`
1. Hit `POST localhost:8000/qux` with a JSON request body of only the non-nullable fields with the correct type. You should get a JSON response with an `id`
1. Hit `GET localhost:8000/qux/{id}` where `{id}` is the `id` returned from the succesfull `POST` response. The response should be a `OK 200` response.
1. Hit `DELETE localhost:8000/qux/{id}`, the response should be a `ACCEPTED 202`
1. Hit `GET localhost:8000/qux/{id}`, the response should be a `NOT_FOUND 404`
