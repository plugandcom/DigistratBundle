## Digistrat Bundle

Permet de faciliter la communication avec l'API Digistrat


### Installation 
Ajouter le chemin du repo dans composer.json (il n'est pas sur packagist)

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

L'API est utilisable directement via DigistratService.
- getLists
- newList
- editList
- deleteList
- addSubscribers
- addSubscriber

Un formType est disponible pour les listes, `DigistratListType`, qui affiche toutes les listes liées à un utilisateur. 
En twig il peut être overridé pour afficher davantage d'informations comme le nombre d'abonnés, la date de mise à jour, etc.

### Etat

Attention, l'état abonné ou désabonné d'un subscriber se répercute uniquement en utilisant `addSubscriber` et non `addSubscribers` qui correspond à un ajout global

### Champs supplémentaires

```php
$subscriber->addExtraField('company', 'Plugandcom');
$subscriber->addExtraField('postalCode', '57330');
```
