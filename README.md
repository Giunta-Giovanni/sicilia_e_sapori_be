# Sicilia e Sapori - Backend

Backend dell’applicazione Sicilia e Sapori, sviluppato in Laravel 12.16. Fornisce API REST per la gestione del menu, delle categorie, degli allergeni e supporta un backoffice amministrativo per la gestione completa dei prodotti.

---

# Tecnologie utilizzate

-   PHP 8.2.28 con Laravel 12.16
-   PhpMyAdmin come database relazionale
-   Laravel Breeze per autenticazione (utente) e verifica (email) (creazione di nuovi utenti disabilitata appositamente)
-   Blade per le view del backoffice
-   Vite per la gestione degli asset lato front del backoffice
-   Middleware per sicurezza, validazione e CORS

---

# [API principali](/routes/api.php)

-   GET /api/products → restituisce tutti i prodotti con output ottimizzato
-   GET /api/products?category=num → restituisce tutti i prodotti di una singola categoria
-   GET /api/db_products → restituisce tutti i prodotti con output grezzo
-   GET /api/products/{id} → restituisce un singolo prodotto

Nota: le API disponibili sono solo **GET**; tutte le altre operazioni **REST** vengono gestite direttamente tramite il backoffice.

Le API sono protette con CORS e accettano richieste solo da origini autorizzate.

---

# Sicurezza

-   Protezione **CSRF** nei form di creazione e modifica dei prodotti
-   Middleware per **validazioni** e gestione errori centralizzata
-   Modelli protetti tramite **fillable**
-   Autenticazione con email e password, con verifica dell’email tramite messaggio di conferma
-   Creazione di nuovi utenti disabilitata appositamente
-   Filtraggio dei dati nelle API tramite **metodo privato filter**

---

# Backoffice []()

-   Layout separati per utenti loggati e non loggati ([default] e [app])
-   [Dashboard] amministrativa accessibile solo dopo login;
-   Tre pagine principali:
    -   [Prodotti] → gestione completa con CRUD;
    -   [Allergeni] → gestione minima;
    -   [Categorie] → gestione minima;

---

# CRUD dei prodotti:

-   [index]: mostra tutti i prodotti con nome categoria e altre informazioni, pulsante per vedere i dettagli, colore in base alla categoria, selettore per filtrare per categoria e pulsanti per scegliere il tipo di prodotto da aggiungere
-   [show](/resources/views/products/show.blade.php): mostra il singolo prodotto con informazioni condizionali in base al tipo (cibo o bevanda), con pulsanti per tornare indietro, modificare o eliminare
-   [create](/resources/views/products/create.blade.php): form con metodo POST e protezione CSRF; i dati vengono validati e in caso di errori si ritorna alla pagina con valori precedenti e messaggi custom
-   [edit](/resources/views/products/edit.blade.php)Edit: simile a create, ma con metodo PUT per indicare a Laravel che si tratta di un aggiornamento, valori base del prodotto già caricati nel form
-   [show](/resources/views/products/show.blade.php): eliminazione tramite modal di conferma con messaggio di successo dentro la view show

---

# Database

-   Tabelle principali:

    -   [Product](/app/Models/Product.php),
    -   [Category](/app/Models/Category.php),
    -   [Food](/app/Models/Food.php),
    -   [Beverage](/app/Models/Beverage.php),
    -   [Allergen](/app/Models/Allergen.php),
    -   [User](/app/Models/User.php),

-   Relazioni corrette tra prodotti, categorie, allergeni, cibi e bevande
    -   Categorie prodotti (one to many)
    -   Prodotti cibi(one to one)
    -   Prodotti bevande(one to one)
    -   Prodotti allergeni (many to many)
-   [Seeder](/database/seeders/) per popolare dati di test (tramite [config.data])
-   [Migrazioni](/database/migrations/) per uno schema sicuro con foreign key e constraints

---

[config.data]: /config/data/
[Prodotti]: /resources/views/products/
[Allergeni]: /resources/views/allergens/index.blade.php
[Categorie]: /resources/views/categories/index.blade.php
[index]: /resources/views/products/index.blade.php
[default]: /resources/views/layouts/default.blade.php
[app]: /resources/views/layouts/app.blade.php
[Dashboard]: /resources/views/dashboard.blade.php
