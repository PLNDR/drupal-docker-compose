TARTALOM
--------

 * Bevezetés
 * Követelmények
 * Installálás


BEVEZETÉS
---------

A Naptár modul naptár nézetben jeleníti meg az adatbázisban szereplő eseményeket.

A következő nézetei vannak:

 * hónap (alapértelmezett),
 * hét,
 * nap.

Alapértelmezetten, bármely nézetben az első jövőbeli eseményt mutatja. Ha nem létezik jövőbeli esemény, akkor a mai napot mutatja.


KÖVETELMÉNYEK
-------------

Esemény tartalomtípus hozzáadása:

 * név: Esemény
 * programok által használt név: esemeny
 * mezők:

 1. Esemény helye:
   * címke: Hely
   * programok által használt név: field_hely
   * mező típusa: Szöveg (egyszerű)
   * kötelező mező
   * értékek megengedett száma: 1

2. Esemény kezdeti időpontja:
   * címke: Kezdeti Időpont
   * programok által használt név: field_kezdeti_idopont
   * mező típusa: Dátum
   * kötelező mező
   * értékek megengedett száma: 1

 3. Leírása:
   * címke: Leírás
   * programok által használt név: body
   * mező típusa: Szöveg (formázott, hosszú, összefoglalóval)
   * nem kötelező megadni
   * nincs összefoglalója
   * értékek megengedett száma: 1

 4. Leírása:
   * címke: Esemény plakátja
   * programok által használt név: field_image
   * mező típusa: Kép
   * nem kötelező megadni
   * legnagyobb képfelbontás: 640x480 képpont
   * legkisebb képfelbontás: 220x220 képpont
   * Alt mező engedélyezve és kötelező
   * értékek megengedett száma: 1


INSTALLÁLÁS
-----------

 * Az installálás más Drupal modulok installálásához hasonlóan történik. Toábbi információk a következő hivatkozáson: https://www.drupal.org/node/1897420.
