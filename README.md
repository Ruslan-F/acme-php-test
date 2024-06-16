# ACME Test
This was built on base [Docker's PHP Language Guide](https://docs.docker.com/language/php/).

# To build
`$ docker compose build`

# To run development in watch mode:
`$ docker compose watch`
- http://localhost:9000 to check it's working

# To run tests:
`$ docker build -t php-ruslan-acme-test --progress plain --no-cache --target test .`
- the asserts output in terminal should be ok