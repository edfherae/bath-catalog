### Запуск: 

SQL дамп уже импортирован в проект
1. Запустить терминал
2. Скопировать репозиторий: git clone https://github.com/edfherae/bath-catalog
3. Выполнить docker compose up -d --build  
4. Выполнить docker compose exec php composer install
5. Выполнить docker compose exec php php bin/console typescript:build
6. В браузере перейти по адресу http://localhost:8080/
