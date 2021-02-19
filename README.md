# INSTALLATION

### Cloner le projet
```
git clone https://github.com/BaptisteAngot/SFDSFlorian.git
composer install
```
Pour l'utilisation du bundle jwt-authentication-bundle, veuillez créer une clé à l'aide de la commande

```
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
Dans le .env mettre à jours ses informations concernant la base de données et la configuration poru le bundle jwt.

### Lier sa base de donnée
```
php bin/console doctrine:database:create
```

### Peupler sa base de donnée
```
php bin/console doctrine:fixtures:load
```

### Lancer le serveur
```
symfony server:start
```

### Lancer les tests unitaires
```
php bin/phpunit tests/Controller/HomeController
```