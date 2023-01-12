 #!/bin/bash
 for values in *.svg
 do 
     filename=$(basename "$values" .svg)
     convert "$values" "$values.png"
 done



# Vérifier si ImageMagick est installé
# if ! [ -x "$(command -v convert)" ]; then
#   echo 'Error: ImageMagick is not installed.' >&2
#   exit 1
# fi

# Spécifier le nom de l'image d'entrée et de sortie
for values in *.png
do 
convert $values -colorspace Gray $values
done

# Convertir l'image en nuance de gris


echo "L'image a été convertie en nuance de gris et enregistrée sous le nom de $values"
