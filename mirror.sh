#!/bin/bash


#rm -rf ./mirror
#mkdir mirror
cd mirror

httrack http://ecoprom.dev -%! -K3 -o0 --connection-per-second 1000 --max-rate 1000000000 --disable-security-limits

cd ecoprom.dev

cp ../../favicon.ico ./

#find . -name '*.html' -exec sed -i 's/<!-- .*-->//g' {} \;
#os x
find . -name '*.html' -exec sed -i '' -e 's/<!-- M.*-->//g' {} \;

