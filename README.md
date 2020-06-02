# Przykładowy projekt modularnego monolitu z wykorzystanie Symfony 5 + DDD, CQRS
Architektura modularnego monolitu(więcej o architekturze: [tutaj](http://www.kamilgrzybek.com/design/modular-monolith-primer/)) w którym moduł będą oparte na architekturze heksagonalnej. Projekt będzie oparty o Symfony 5.0 dostosowanym do modularnego rozbijania aplikacji i wycinania ich w łatwy sposób do oddzielnych microserwisów. Modyfikacja obejmuje też dostosowanie obsługi środowiska multi-tenancy(wielu kont klientów).

# Core
Zawiera kod współdzielony przez wszystkie moduły ułatwiający budowanie modularnego monolitu, w tym zawiera kod do obsługi zmiany kontekstu konta(proces zmiany kontekstu konta powinien być niewidoczny dla modułów).

## Doctrine ORM
### Konfiguracja
#### Bazy danych:
-  **system** - zawiera tabele z modułów systemowych, ma własne połączenie i EntityManagera, który rejestruje tylko elementy ze wszystkich modułów oznaczonych jako systemowe.
-  **account_<id-konta>** - zawiera tabele z modułów konta, ma własne połączenie(specjalny mechanizm dynamicznie wybiera bazę na podstawie przekazanego id konta - mechanizm przewiduje wiele hostów baz) i EntityManagera, który rejestruje tylko elementy ze wszystkich modułów oznaczonych jako moduł konta.


# Moduł
## Podział
- **Systemowy**  - to moduły, które nie potrzebuje do swojego działania żadnego konta, są to jakieś moduły administracyjne.
- **Konta**  - to moduły, które potrzebują do swojego działania kontekstu konta. Ważne, moduł nie powinien wiedzieć, które obecnie konto jest wybrane.
## Struktura katalogów
- **Domain**  - zawiera logikę biznesową(jest nie powiązana z żadnym frameworkiem) wystawia porty.
-  **Application** - zawiera punkty wejścia do domeny(Serwisy Aplikacji, CQRS).
-  **Infrastructure** - zawiera adaptery do komunikacji ze światem zew. np. RestApi, obsługę Doctrina, Messaging itp.

## Domain
Serce każdego modułu zawiera logikę biznesową nie powiązaną z żadnym frameworkiem. W katalogu obowiązuje podział pod względem building bloków DDD:
- **Entity** - zawiera wszystkie encje domeny
- **Repository** - zawiera wszystkie repozytoria domeny
- **ValueObject** - tutaj znajdziemy wszystkie obiekty wartości danej domeny
- **SharedKernel** - zawiera elementy domeny które mogą wykorzystywać inne moduły
- **Service** - serwisy domenowe
- **Exception** - wyjątki ściśle powiązane z daną domeną
- **Policy** - polityki

## Application
Symfony w projekcie jest tak skonfigurowane, że z automatu zarejestruje wszystkie handlery komend, zapytań i eventów dla danego modułu, muszą tylko zaimplementować odpowiednie interfejsy markerów z Core.

- **Command**  - zawiera wszystkie komendy do domeny, które można wykonać w danym module, struktura: podfolder z nazwą komendy i klasy:
  - **\<nazwa-komendy>Command**
    - implementuje: App\Core\Message\Command\Command,
    - zawiera dane do wykonania komendy,
    - immutable - tylko gettery
  - **\<nazwa-komendy>CommandHandler**
    - implementuje: **App\Core\Message\Command\CommandHandler**
    - **__invoke(<\nazwa-komendy>Command $command): void**
- **Query** - zawiera wszystkie zapytania do domeny, które można zadać w danym module, struktura: podfolder z nazwą komendy i klasy:
  - **\<nazwa-zapytania>Query**
    - implementuje: **App\Core\Message\Query\Query**,
    - zawiera dane do wykonania zapytania,
    - immutable - tylko gettery
  - **\<nazwa-zapytania>QueryHandler**
    - implementuje: **App\Core\Message\Query\QueryHandler**
    - **__invoke(<\nazwa-zapytania>Query $query): void**

## Infrastructure
Zawiera wszystko co potrzebne do kontaktu ze światem zewnętrznym(obsługa bazy danych, rest api).
Moduły które udostępniają REST api komunikują się z domeną poprzez komendy i zapytania, kontroler musi:
- znajdować się w **App\Module\<nazwa-modułu>\Infrastructure\Rest\Controller**
- dziedziczyć po wybranej bazie kontrolera z **App\Core\Rest\Controller**

Symfony jest tak skonfigurowane że automatycznie zarejestruje routy kontrolera na podstawie markera: **App\Core\Rest\Controller\Controller**

## Config
Część rzeczy, które da się zrobić ogólnie dla wszystkich modułów  jak automatycznie rejestrowanie kontrolerów są robione w domyślnym Symfonowym config/services.yaml.
Elementy specyficzne dla danego modułu znajdują się w **config/modules/<nazwa-modułu>**:
- **services.yaml**  - importowany w głównych serwisach
- **doctrine.php**  - zawiera dodatkową konfigurację Doctrina dla modułu
  - **isAccountModule** - definiuje czy moduł działa w kontekście konta - wtedy rejestrowane jest mapowania dla EntityManagera od kont
  - **enumTypes** - lista klas które należy zarejestrować jak typ enum w Doctrinie


## Przygotowanie środowiska

#### Narzędzia

Należy zainstalować niezbędne narzędzia:

- Docker
- bash (Cygwin dla Windows)
- make
- curl

#### Make

Przed rozpoczęciem korzystania z make uruchom:

```bash
make deps
```

Wszelkie potrzebne operację podczas testów jaki i na produkcji
wykonać poprzez wywołanie make z odpowiednimi parametrami,
żeby zobaczyć wszystkie target wywołaj:

```bash
make help
```

Dla targetów można wybrać środowisko uruchomienia:

```bash
make ENVIRONMENT=test|prod [SUBPROJECT=<subproject>] <target>
```

Domyślnym subprojectem w tym serwisie jest **api**.

#### Budowanie obrazu i wypchanie do rejestru

Obraz można zbudować dla wybranego środowiska poprzez wywołanie:

```bash
make SUBPROJECT=<subproject> deploy_image
```

#### Uruchomienie lokalne

Zainicjowanie lokalnego środowiska testowego:

```bash
    make test_init
```

Usuwanie lokalnego środowiska testowego:

```bash
    make test_clean
```

Aby uruchomić serwis subprojektu należy wywołać:

```bash
    make SUBPROJECT=<subproject> deploy_service
```


## Symfony console
Projekt zawiera dodatkowe komendy Symfony, dostępne pod prefiksem app:
