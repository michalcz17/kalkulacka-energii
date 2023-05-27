# Webová aplikace: Kalkulačka pro srovnání nabídek energií
## Popis funkčnosti
Program slouží k porovnání nabídky, kterou zadá uživatel, a těma co jsou zadané v databázi. Uživatel má na výběr ze dvou komodit - elektřina a plyn. Na úvodní stránce je uvítán formulářem, ve kterém vyplní údaje jako jsou komodita, roční spotřeba v MWh, cena za MWh a poplatek za opm. Tyto údaje se následně ověří, zda jsou validní, pokud ne tak se nad formulářem objeví chybová hláška. Dále se hodnoty sečtou do celkové ceny za rok a porovnají s ostatními nabídkami. Na nové stránce se zobrazí přehled toho, co uživatel zadal a ostatní nabídky. Pokud je nalezena výhodnější nabídka, je ze souhrnu ostatních nabídek vyloučena a má vyhrazen vlastní přehled. Uživatel má pak možnost se vrátit zpět na formulář pomocí tlačítka v horní části stránky.
## Databáze
### Popis
Databáze se skládá ze 3 tabulek, číselník dodavatelů (*dodavatele*), číselník komodit (*komodity*) a tabulka s nabídkami (*nabidky*), ve které je automatické ID (*id*) jako primární klíč, ID dodavatele (*dodavatel*), ID komodity (*komodita*) (oba atributy jsou cizí klíč z přidružených tabulek), minimální spotřeba (spotreba_od), které je nutné dosáhnout pro daný tarif, maximální spotřeba (*spotreba_do*), které může být dosáhnuto pro daný tarif, cena za MWH (*cena*) a poplatek za OPM (*poplatek*).
### Import databáze
Ve složce *server* je soubor *db-export.sql*, který slouží k naimportování databáze společně s daty do databáze. Po importu je nutné vytvořit účet v databázi, který bude mít oprávnění *SELECT* na danou databázi, následně v konfiguraci webové aplikace změníte údaje k databázi (*config/db.conf.php*) jako je adresa databázového serveru, uživatelské jméno účtu, heslo k účtu a databáze, ve které jsou data importovaná.
## Webová aplikace
### Struktura složek

```
praxe-kalkulacka		- Kořenová složka
|   .gitattributes		- Soubor Githubu
|   index.php			- Hlavní soubor, zobrazí se uživateli
|   README.md			- README soubor
|   
+---.git				- Složka Githubu
+---class				- Složka pro soubory s třídami
|   .htaccess			- .htacccess znemožňující přístup uživateli do složky
|   formError.class.php	- Třída FormError
|   loader.php			- Loader pro automatické načtení souborů ve složce s koncovkou .class.php
|   
+---config				- Složka s konfiguračnímy soubory
|   .htaccess			- .htacccess znemožňující přístup uživateli do složky
|   db.conf.php			- Konfigurační soubor databáze
|   loader.php			- Loader pro automatické načtení souborů ve složce s koncovkou .conf.php
|   
+---pages				- Složka se stránkami, které se následně zobrazí uživateli
|   .htaccess			- .htacccess znemožňující přístup uživateli do složky
|   home.page.php		- Domovská stránka, obsahuje hlavní formulář
|   req.footer.php		- Patička, která se načte na konci každé stránky
|   req.header.php		- Hlavička, která se načte na konci každé stránky
|   show.page.php		- Zobrazovací stránka, obsahuje následné zobrazení dat
|   
+---public				- Složka pro veřejně dostupné soubory (css, js, obrázky atd.)
\---server				- Složka se soubory pro server
    .htaccess			- .htacccess znemožňující přístup uživateli do složky
    db-export.sql		- Export databáze, slouží k importu databáze do nové (obsahuje tabulky včetně dat)
    formHandler.php		- Provádí validaci formuláře
```