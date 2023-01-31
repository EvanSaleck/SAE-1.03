#!/bin/bash

cd imgs
# Convertion des images.svg en .png

 for objets in *.svg    # On parcours toutes les images.svg
 do
     convert "$objets" "${objets:0:3}.png"    # On convertit les images.svg en .png tout en recupérant les 3 premiers caractères du f

for objets in *.png   
do
    convert $objets -colorspace Gray $objets    # On convertit les images en nuances de gris.

    convert $objets -resize 200x200 $objets     # On redimensionne l'image pour qu'elle soit au format 200x200px.

    convert $objets -crop 200x185+0+0 $objets   # On rogne l'image en partant dans haut à gauche (+0+0) et en coupant un rectangle de 200x185px (zone image sans le bandeau "Created on Face Co").

    convert $objets -resize 200x200 $objets     # On redimensionne une nouvelle foix l'image (actuellement au format 200x185px) pour qu'elle soit de nouveau au format 200x200px.

done

#script de Gwendal
# Permet de créer un qrcode a partir de chaque codes de region.conf
while read line; do
    iso=$(echo $line | cut -d ":" -f1)
    echo "https://bigbrain.biz/$iso"
    docker run --rm -v $(pwd)/qrcode:/qrcode sae103-qrcode qrencode -o /qrcode/"$iso" "https://bigbrain.biz/$iso"
done <  region.conf

docker container prune -f

cd Traitement

echo "Nom du fichier avec l'extension que vous voulez convetir en PDF: *"
read nom_fic
echo "Nom du fichier PDF: *"
read nompdf
echo " Code région du fichier: *"
read code
fin=*

    cp $nom_fic FIC.txt
    php extract-data.php
    php index.php $code  > index.html
    rm FIC.txt
    rm comm.dat
    rm Tableau.dat
    rm Texte.dat


    docker container run --rm -ti -v /Docker/"$USER"/dossier/Traitement:/work sae103-html2pdf "html2pdf index.html "$nompdf".pdf"

    
echo "Voici le fichier PDF !"
    

