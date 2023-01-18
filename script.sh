 #!/bin/bash

 #Convertion des fichiers svg en png
 for values in *.svg #On parcours toutes les images svg
 do 
     convert "$values" "${values:0:3}.png" #on convertit les images en png
 done


for values in *.png #On parcours toutes les images png
do 
        docker run --rm -v $(pwd)/tetes:/work bigpapoo/sae103-imagick "magick $nomSvg -resize 200x200 -gravity North -extent 200x185 -resize 200x200 -colorspace Gray ./output/$nomFichier.png"
done

