#!/bin/bash

if [ $# -eq 1 ]; then
    if [ ! -d $1/output ]; then
        mkdir -p $1/output;
    fi

    for photo in $1/*.svg; do
        nomSvg=$(echo $photo | cut -d '/' -f2)
        nomFichier=$(echo $nomSvg | cut -d '.' -f1)
        echo ./$1/output/$nomFichier.png
        docker run --rm -v $(pwd)/$1:/work bigpapoo/sae103-imagick "magick $nomSvg -resize 200x200^ -gravity North -extent 200x185 -colorspace Gray ./output/$nomFichier.png"
    done
else
    echo "Utilisation: ./avatars.sh [dossier-images]"
fi
