### Требования

Docker desktop, 
Git

### Запуск: 

SQL дамп находится в docker/mysql/init/projects.sql и импортируется автоматически при запуске контейнера
1. Запустить терминал
2. Скопировать репозиторий: git clone https://github.com/edfherae/bath-catalog
3. cd bath-catalog
4. Поднять Докер окружение: docker compose up -d --build  
5. Установить php зависимости: docker compose exec php composer install
6. Скомпилировать TS код: docker compose exec php php bin/console typescript:build
7. В браузере перейти по адресу http://localhost:8080/
