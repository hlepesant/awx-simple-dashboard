# Install AWX SD

## Web server

Choose between :
 - nginx + PHP-FPM
 - Apache2 + PHP 

AWS-SD have been developped on PHP version 8.0

REquire PHP modules :
 - php8.0-xml
 - php8.0-mbstring
 - php8.0-intl
 - php8.0-zip
 - php8.0-mysql (even if not used)


## Install Symfony CLI
```
sudo apt-get install git unzip
wget https://get.symfony.com/cli/installer -O - | bash
sudo mv /home/hugues/.symfony/bin/symfony /usr/local/bin/symfony
```

## Install Composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

sudo mv composer.phar /usr/local/bin/composer
```

## Install NodeJS
```
sudo -i
apt-get install gcc g++ make build-essential
curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
sudo apt-get install -y nodejs
```

## Install Yarn
```
apt-get install gpg2
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
apt-get update
apt-get install yarn
```

## Clone the Repo
```
sudo mkdir -p /opt/websites/
sudo chown -R <username>:<usergroup> /opt/websites
cd /opt/websites/
git@git.fr.clara.net:hugues.lepesant/awx-simple-dashboard.git
```

## Composer Install
```
cd awx-simple-dashboard
composer install
```

## Yarn Install
```
yarn install
yarn encore production
npm run build
```
