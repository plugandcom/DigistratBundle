## Digistrat Bundle (WIP)

Permet de faciliter la communication avec l'API Digistrat


### Installation 
Ajouter le repo privé dans composer.json

```json
    "repositories": [{
        "type": "vcs",
        "url": "git@github.com:plugandcom/DigistratBundle.git"
    }]
```

Puis ajouter le repo :

```json
    "require": {
        "plugandcom/digistrat-bundle": "^1.0"
    },
```

Ou

    composer require plugandcom/digistrat-bundle

### Configuration

#### Via variables d'environnement (recommandé) :

```
DIGISTRAT_TOKEN='aaa' # requis
DIGISTRAT_ENDPOINT=http://digistrat.test/api/v2/ # optionnel, est déjà sur la bonne URL par défault
```

#### En Yaml directement :

```yaml
digistrat:
    token: 'aaa'  
    endpoint: 'http://digistrat.test/app_dev.php/api/v2/'
```
    
### Utilisation

Tout est dans DigistratService.
- getLists
- newList
- editList
- deleteList
- addSubscribers
- addSubscriber