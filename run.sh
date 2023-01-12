# Description: Script de lancement du container
#!/bin/bash
# Installation de docker 
if ! [ -x "$(command -v docker)" ]; then
  curl -fsSL https://get.docker.com -o get-docker.sh
  sh get-docker.sh
  rm get-docker.sh
else
  echo "Docker is already installed."
fi
#Telechargement de l'image du container 
docker pull docker.io/bigpapoo/sae103-php:latest

# Lancement du container
docker run --rm -v -it  -d --name sae103-php  docker.io/bigpapoo/sae103-php:latest

# Delai pour laisser le temps au container de se lancer
sleep 5

# envoi de fichier au container
docker cp ./sae103.php sae103-php:/app 
docker cp ./fichiers.txt sae103-php:/app
docker cp ./data_extraite sae103-php:/app  

# Execution du script php
docker exec -it sae103-php php sae103.php

# Copie du fichier resultat dans le repertoire courant
docker cp sae103-php:/app/data_extraite ./

# Suppression du container
docker rm -f sae103-php


