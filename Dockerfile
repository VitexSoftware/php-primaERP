FROM vitexsoftware/php-primaerp
COPY src/ /usr/share/php/primaERP
COPY debian/composer.json /usr/share/php/primaERP/composer.json
COPY docs/  /usr/share/doc/php-primaerp/html
