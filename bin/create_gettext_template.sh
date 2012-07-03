#!/bin/bash
#
# This script create the gettext .pot template file for translations.
# Usage:
# ./script.sh /path/to/charm
#

if ([ "$1" != "" ] && [ -d $1 ]); then
	true
	echo "Start creating gettext template file from source located in: $1"
	echo "1. Search Template files"
	find "$1/application" | grep ".php$" > "$1/langfiles"
	find "$1/application" | grep ".phtml$" >> "$1/langfiles"

	echo "2. Running xgettext"
	xgettext -o "$1/translation/charm.pot" --keyword=_ --keyword=translate --force-po --language=PHP --files-from="$1/langfiles" --from-code=utf-8

	echo "3. Cleanup"
	rm "$1/langfiles"

	echo "Work done!";

else
	echo
	echo "This script create the gettext .pot template file for translations."
	echo "Usage:"
	echo "./script.sh /path/to/charm"
	echo
fi
