#!/bin/bash

fichier="photosfinal"

if [ $# -eq 1 ] then
    if [ ! -d photos/output ]; then
        mkdir -p photos/output;
    fi

    for photo in photos/*.svg; do
        nomSvg=$(echo $photo | cut -d '/' -f2)
        nomFichier=$(echo $nomSvg | cut -d '.' -f1)
        echo ./photos/output/$nomFichier.png
        docker run --rm -v $(pwd)/photos:/work bigpapoo/sae103-imagick "magick $nomSvg -resize 200x200^ -gravity North -extent 200x185 -colorspace Gray ./output/$nomFichier.png"
    done
else
    echo "Utilisation: ./avatars.sh [dossier-images]"
fi
