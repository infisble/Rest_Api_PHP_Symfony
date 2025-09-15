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
# из корня проекта
```bash
composer install
```
убедись, что в .env:
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```bash
php bin/console doctrine:schema:validate
```
# если сущности новые:
```bash
php bin/console make:migration
```
 OR
```bash
php bin/console doctrine:migrations:migrate -n
```
# сервер разработки
```bash
php -S 127.0.0.1:8000 -t public
```
