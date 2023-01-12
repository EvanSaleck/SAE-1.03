 #!/bin/bash
 for values in *.svg
 do 
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
    convert -rezise 200x200 $values 

done

