.PHONY: php-cs-fixer
php-cs-fixer:
	docker-compose exec php time ./vendor/bin/php-cs-fixer fix --config="config/.php-cs-fixer.php"

.PHONY: rector
rector:
	docker-compose exec php time ./vendor/bin/rector --config="config/rector.php"

.PHONY: phpstan
phpstan:
	docker-compose exec php time ./vendor/bin/phpstan --configuration="config/phpstan.neon"

.PHONY: phan
phan:
	docker-compose exec php time ./vendor/bin/phan --allow-polyfill-parser --config-file="config/phan.php"

.PHONY: psalm
psalm:
	docker-compose exec php time ./vendor/bin/psalm --config="config/psalm.xml"

.PHONY: phpcs
phpcs:
	docker-compose exec php time ./vendor/bin/phpcs src --standard="config/phpcs.xml"

.PHONY: phpmd
phpmd:
	docker-compose exec php time ./vendor/bin/phpmd config ansi config/phpmd.xml
	docker-compose exec php time ./vendor/bin/phpmd src ansi config/phpmd.xml
	docker-compose exec php time ./vendor/bin/phpmd tests ansi config/phpmd.xml

.PHONY: phplint
phplint:
	docker-compose exec php time ./vendor/bin/phplint --configuration="config/.phplint.yml"

.PHONY: deptrac
deptrac:
	docker-compose exec php time ./vendor/bin/deptrac analyse --config-file="config/depfile.yaml" --report-uncovered --fail-on-uncovered --cache-file=".build/.deptrac.cache"

.PHONY: behat
behat:
	docker-compose exec php time ./vendor/bin/behat

.PHONY: phpunit
phpunit:
	docker-compose exec php time ./vendor/bin/phpunit --configuration="config/phpunit.xml"

.PHONY: infection
infection: phpunit
	docker-compose exec php time ./vendor/bin/infection --configuration="./config/infection.json" --min-msi=100 --min-covered-msi=100 --coverage="../.build/.phpunit.cache/code-coverage"

.PHONY: phpunit-test-coverage
phpunit-test-coverage: phpunit
	docker-compose exec php time ./vendor/bin/coverage-check .build/clover.xml 100

.PHONY: behat-test-coverage
behat-test-coverage: behat
	docker-compose exec php time ./vendor/bin/coverage-check .build/behat/clover.xml 100

.PHONY: ci
ci: rector php-cs-fixer phplint deptrac phpstan phan psalm phpcs phpmd phpunit-test-coverage infection behat-test-coverage

.PHONY: cleanup
cleanup:
	docker-compose down --rmi all -v --remove-orphans
	rm -rf vendor

.PHONY: start
start: cleanup
	docker-compose pull
	docker-compose run --rm composer install
	docker-compose up -d
