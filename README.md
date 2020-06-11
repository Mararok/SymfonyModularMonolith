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

- **Command**  - zawiera wszystkie komendy do domeny, które można wykonać w danym module, struktura:
  - złożone komendy mają podfolder z nazwą komendy i odpowiednią klasę komendy i handlera do niej
  - **[nazwa]Command**
    - implementuje: App\Core\Message\Command\Command,
    - zawiera dane do wykonania komendy,
    - immutable - tylko gettery
  - **[nazwa]CommandHandler**
    - implementuje: **App\Core\Message\Command\CommandHandler**
    - **__invoke([nazwa]Command $command): void**
  - **BasicCommandHandlerService**
    - implementuje: **App\Core\Message\Command\CommandHandlerService**
    - powinien zawierać prostesze komendy
    - **handle[nazwa bez suffixa]\([nazwa]Command $command): void**
- **Query** - zawiera wszystkie zapytania do domeny, które można zadać w danym module
  - złożone zapytania mają podfolder z nazwą zapytania i odpowiednią klasę zapytania i handlera do niego
  - **[nazwa]Query**
    - implementuje: **App\Core\Message\Query\Query**,
    - zawiera dane do wykonania zapytania,
    - immutable - tylko gettery
  - **[nazwa]QueryHandler**
    - implementuje: **App\Core\Message\Query\QueryHandler**
    - **__invoke([nazwa]Query $query): void**
  - **BasicQueryHandlerService**
      - implementuje: **App\Core\Message\Query\QueryHandlerService**
      - powinien zawierać prostesze zapytania
      - **handle[nazwa bez suffixa]\([nazwa]Query $query): mixed**
- **Event** - zawiera wszystkie handlery zdarzeń dla domeny
  - **[nazwa]EventHandler**
    - implementuje: **App\Core\Message\Event\EventHandler**
    - **__invoke([nazwa]Event $event): void**
  - **BasicEventHandlerService**
      - implementuje: **App\Core\Message\Event\EventHandlerService**
      - powinien zawierać proste handlery zdarzeń
      - handle[nazwa bez suffixa]\([nazwa]Event $event): void**

## Infrastructure
Zawiera wszystko co potrzebne do kontaktu ze światem zewnętrznym(obsługa bazy danych, rest api).
### REST
Moduły które udostępniają REST api komunikują się z domeną poprzez komendy i zapytania, kontroler musi:
- znajdować się w **App\Module\<nazwa-modułu>\Infrastructure\Rest\Controller**
- dziedziczyć po wybranej bazie kontrolera z **App\Core\Rest\Controller**

Symfony jest tak skonfigurowane że automatycznie zarejestruje routy kontrolera na podstawie markera: **App\Core\Rest\Controller\Controller**

### Doctrine
- wszyskto co związane z Doctrinem wędruje do podkatalogu **Persistence\Doctrine**
- Dla uproszczenia mapowania zastosowano xmla.
  - format nazwy pliku: **[nazwa-encji].orm.xml**
- Można implementować własne typy, które będą potem rejestrowane poprzez odpowiedni wpis w configu modułu.
- Nazwy tabel posiadają prefix identyfikatora modułu.
- Repozytoria mogą korzystać z pomocniczych bazowych klas z Core.
## Config
Część rzeczy, które da się zrobić ogólnie dla wszystkich modułów  jak automatycznie rejestrowanie kontrolerów są robione w domyślnym Symfonowym config/services.yaml.
Elementy specyficzne dla danego modułu znajdują się w **config/modules/<nazwa-modułu>**:
- **services.yaml**  - importowany w głównych serwisach
- **doctrine.php**  - zawiera dodatkową konfigurację Doctrina dla modułu
  - **isAccountModule** - definiuje czy moduł działa w kontekście konta - wtedy rejestrowane jest mapowania dla EntityManagera od kont
  - **enumTypes** - lista klas które należy zarejestrować jako typ enum w Doctrinie
  - **customTypes** - lista klas które należy zarejestrować jako typ w Doctrinie


## Przygotowanie środowiska

#### Narzędzia

Należy zainstalować niezbędne narzędzia:

- Docker
- bash (Cygwin dla Windows)
- make
- curl

#### Wymagane dane środowiskowe
* Testowe konto smtp(może być gmail - symfony ma już zaciągnięte zależności) do wysyłki email
* Skopiować template_env.local pod env.local i wpisać dane

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

## Uruchamianie i testowanie przykładu
1. środowisko
```bash
    make test_init
    make sf_start_local_server
    php bin/console app:account:doctrine:create --account-id 1
```
2. Interaktywne api znajduje się po uruchomieniu pod adresem **http://127.0.0.1:8000/api/doc**

