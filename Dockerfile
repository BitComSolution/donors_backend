FROM dunglas/frankenphp



COPY . /app

RUN rm -Rf tests/

