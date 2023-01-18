# Description: Script de lancement du container
#!/bin/bash
# Installation de docker 
if ! [ -x "$(command -v docker)" ]; then
  curl -fsSL https://get.docker.com -o get-docker.sh
  sh get-docker.sh
  rm get-docker.sh
else
  echo "Docker est déjà installé."
fi
#Telechargement de l'image du container 
docker pull docker.io/bigpapoo/sae103-php:latest

# Lancement du container
mv fichiers.txt Docker/$(whoami):/work
mv sae103.php Docker/$(whoami):/work
mv data_extraite Docker/$(whoami):/work

# Delai pour laisser le temps au container de se lancer
sleep 5


docker run --rm -ti -v /Docker/$(whoami):/work -w /work sae103-php ./sae103.php

# Delai pour laisser le temps au container de se lancer
sleep 5

mv Docker/$(whoami):/work/data_extraite ./

# Suppression du container
docker rmi sae103-php

# Suppression de l'image
docker rmi docker.io/bigpapoo/sae103-php:latest

echo "Fin du script"

#!/bin/bash

#Conversion des fichiers svg en png
for values in *.svg
do 
    convert "$values" "$values.png"
done

#Changement taille de l'image + mise en nuance de gris
for values in *.png
do 
    convert $values -colorspace Gray $values
    convert $values -resize 200x200 $values
    convert $values -crop 200x185+0+0 $values 
    convert $values -resize 200x200 $values
done

#Renommer les fichiers pour enlever .svg de leur nom
rename 's/.svg.png/.png/' *.svg.png





