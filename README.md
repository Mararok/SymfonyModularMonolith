# Przykładowy projekt modularnego monolitu z wykorzystanie symfony

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
