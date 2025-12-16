# Lost & Found — Projekta ceļvedis

## Projekta apraksts
**Lost & Found** ir tīmekļa lietotne, kas palīdz cilvēkiem atrast un atgūt pazaudētas mantas.
Platforma ļauj lietotājiem:
- publicēt paziņojumus par atrastām vai pazaudētām mantām,
- meklēt citus paziņojumus,
- un sazināties ar citiem lietotājiem privāti, ja ir atrasta vai atgūta manta.

---

## Projekta mērķis
Izveidot drošu, lietotājam draudzīgu sistēmu, kas apvieno cilvēkus, kuri ir pazaudējuši vai atraduši priekšmetus, vienā platformā, lai veicinātu mantu atgriešanu to īpašniekiem.

---

## Galvenās funkcijas

### Postu (ierakstu) pārvaldība
- Lietotāji var izveidot jaunu postu (ierakstu) par pazaudētu vai atrastu mantu.
- Ierakstam var pievienot attēlu vai atstāt bez attēla.
- Postus var rediģēt un dzēst.
- Ierakstos tiek norādīts statuss: “Lost” vai “Found”.
- Ierakstiem var pievienot pilsētu..

### Privātā čatošana
- Kad lietotājs atrod savu mantu, viņš var privāti sazināties ar personu, kas to ievietoja.
- Ziņas notiek drošā iekšējā čata sistēmā, nepublicējot kontaktinformāciju.

### Meklēšana 
- Lietotāji var izmantot meklēšanas joslu (search bar), lai atrastu noteiktus priekšmetus pēc nosaukuma vai apraksta.


### Lietotāju konti
- Ir reģistrācijas un pieteikšanās lapas.
- Katram lietotājam ir profila lapa.
- Lietotājs var rediģēt profila informāciju un iestatījumus.


---

## Tehniskā struktūra

Laravel 12 (PHP) – MVC arhitektūra, drošība, validācija

Laravel Breeze – autentifikācija (login / register)

SQLite – vienkārša datubāze izstrādei

Blade templates – UI veidošana

Tailwind CSS – ātrs un responsīvs dizains

Alpine.js – interaktivitāte (dropdown, notifikācijas, AJAX)

Laravel Notifications – sistēmas paziņojumi

GitHub – versiju kontrole

---

## Papildu funkcionalitāte
- “Atzīmēt kā atrisinātu” poga, kad manta atgūta.
- Statistika: biežākās mantu kategorijas, aktīvākās pilsētas.

---

## Drošība un lietojamība
- Droša lietotāju datu apstrāde .
- Attēlu tipa un izmēra pārbaude pirms augšupielādes.
- Responsīvs dizains .
.

---

## Plānotā izstrādes secība
1. Projekta izveide (Laravel instalācija, Breeze auth)
2. Modeļu un migrāciju izveide (Users, Items, Messages)
3. CRUD sistēma ierakstiem
4. Meklēšana un filtrēšana
5. Čata funkcionalitāte
6. Profila panelis
7. Testēšana un UI uzlabojumi

---

## Rezultāts
Gala produkts būs funkcionāla **Lost & Found** platforma, kur lietotāji var ērti ievietot, meklēt un pārvaldīt pazaudēto un atrasto mantu paziņojumus, kā arī sazināties droši platformas ietvaros.
