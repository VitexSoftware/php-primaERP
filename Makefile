all: fresh build install

fresh:
	git pull
	composer update

install: build
	echo install
	
build: doc
	echo build

clean:
	rm -rf debian/php-primaerp
	rm -rf debian/php-primaerp-doc
	rm -rf debian/*.log
	rm -rf docs/*
	rm -rf vendor/*

doc:
	debian/apigendoc.sh

test:
	phpunit --bootstrap testing/bootstrap.php

deb:
	debuild -i -us -uc -b

.PHONY : install
	
