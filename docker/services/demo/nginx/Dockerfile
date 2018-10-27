# 1: Use Nginx stable as base:
FROM nginx:stable

# 2: We'll set the application path as the working directory
RUN set -ex && mkdir -p /usr/src/app
WORKDIR /usr/src/app

# 3: We'll add libs
RUN apt-get update \
    && apt-get install -y \
        bc \
        curl \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# 4: We'll copy the config.
COPY config/ /etc

# 5: ssl.
RUN echo 01 > ca.srl \
    && openssl genrsa -out ca-key.pem 2048 \
    && openssl req -new -x509 -days 365 -subj "/CN=*" -key ca-key.pem -out ca.pem \
    && openssl genrsa -out server-key.pem 2048 \
    && openssl req -subj "/CN=*" -new -key server-key.pem -out server.csr \
    && openssl x509 -req -days 365 -in server.csr -CA ca.pem -CAkey ca-key.pem -out server-cert.pem \
    && openssl rsa -in server-key.pem -out server-key.pem \
    && cp *.pem /etc/nginx/ \
    && cp *.csr /etc/nginx/
