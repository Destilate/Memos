# Memos - Symfony aplikace s Dockerem

## Spustit v rootu projektu:

```bash
docker-compose up
```
nebo
```bash
docker-compose up -d
```

## Docker vytvoří a spustí tyto kontejnery:

- **app** — PHP-FPM běžící PHP 8.2
- **webserver** — Nginx, nasměrovaný na PHP-FPM
- **db** — MySQL databáze
- **adminer** — Webové rozhraní pro správu databáze na portu 8080(pro prod odstranit z důvodu bezpečnosti)

---

## Přístup k aplikaci

- Webová aplikace je dostupná na adrese:
  [http://localhost:8000](http://localhost:8000)

- Pro správu databáze použijte Adminer na:
  [http://localhost:8080](http://localhost:8080)

  Přihlašovací údaje jsou nastavené v `docker-compose.yml`
  (server: `db`, user: `user`, password: `user_password`, databáze: `memos`).

  Pokud porty použité pro kontainery máte obsazeny upravte docker-compose.yml, na nich pak bude běžet aplikace.

---

## Přístup do PHP kontejneru

Chcete-li spustit příkazy Symfony CLI nebo Composer, přihlaste se do běžícího PHP kontejneru:

```bash
docker exec -it php_container bash
```

## V PHP kontejneru spustit příkazy

```bash
composer install

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load
```

## Aplikace by měla nyní normálně běžet

## Kontakt
V případě problémů nebo otázek mě kontaktujte na:
[tomas.burzal@gmail.com]
