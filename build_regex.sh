#!/bin/bash

# TO packages
TO_PACKAGES=`curl -s 'http://www.icpackage.org/TO-65/' curl -s 'http://www.interfacebus.com/semiconductor-transistor-packages.html'`

echo $TO_PACKAGES | grep -oE 'TO-[0-9A-Z]+' | grep -vE '92|220|236|247|252|261|263|277' | sort | uniq | cut -d'-' -f 2 | sort -n | tr "\n" '|' | sed 's/|$//g' | awk '{print "TO-?("$1")"}'
