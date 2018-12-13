#!/bin/bash

plugin="$1"

nothing=""
shortpath="${plugin/app\/public\/wp-content\//$nothing}"

echo "/$shortpath" >> .gitignore
git rm -r "$shortpath"
git commit -am "Composerify $shortpath"
rm -Rf "$shortpath" # Make sure it's gone
echo "---------------"
