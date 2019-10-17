# XCaliber Senior PHP developer assessment task

## Project start
Just run the
```
make cold-start
```
to build up all the Docker images, run tests, make migrations and populate fixtures.

Then open your browser at http://localhost to see the frontend. Backend is running on port 8080 by default.

If you using Docker Machine you may to change the backend URL in the frontend configuration. To do this go to `./frontend` dir, open a `.env` and change the URL environmental constant as you need. You need to do this before building the project.

This project doesn't provide Docker configuration for development purposes.

## Build images
```
make build-images
```

## Start containers
```
make start
```

## Run tests
```
make tests
```

## Run migrations
```
make migrate
```

## Install fixtures bundle and populate fixtures
```
make install-fixtures-bundle && make populate-fixtures
```

## Open bash in backend container
```
make bash
```
