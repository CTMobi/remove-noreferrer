#!/bin/bash

set -euo pipefail

BANNER="debug.log"
DEBUG_LOG="debug.log"

curl -O $WP_HOST/wp-content/debug.log --silent > /dev/null

FILESIZE=$(wc -c < "$DEBUG_LOG")

if [ $FILESIZE -ne 0 ]; then
	echo -e "[${BANNER}]: ${red}Must be empty${NC}"
	echo
	echo "Content of $DEBUG_LOG:"
	cat $DEBUG_LOG

	rm $DEBUG_LOG

	exit 1
fi

echo -e "[${BANNER}]:          ${green}Passed${NC}"

rm $DEBUG_LOG

exit 0