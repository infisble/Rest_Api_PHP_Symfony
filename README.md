#  Book API (Symfony 6.4 + SQLite + Messenger)

REST API на Symfony (6.4) + SQLite:
- Сущности: **Author**, **Book** (Many-to-Many)
- CRUD как REST
- `#[MapRequestPayload]` для автоматического маппинга JSON → DTO
- Изменяющие операции возвращают **202 Accepted** и идут через **Symfony Messenger**
- Транспорт: `sync://` (по умолчанию) либо `doctrine://default` для фоновой обработки

---

##  Требования
- PHP ≥ 8.1 (CLI) c расширениями: `pdo_sqlite`, `sqlite3`
- Composer
- SQLite (входит в PHP)
- Git

---

##  Локальный запуск
```bash
# из корня проекта
composer install

# убедись, что в .env:
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

php bin/console doctrine:schema:validate

# если сущности новые:
php bin/console make:migration
php bin/console doctrine:migrations:migrate -n

# сервер разработки
php -S 127.0.0.1:8000 -t public
