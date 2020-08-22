#!/bin/bash

export red='\033[0;31m'
export green='\033[0;32m'
export NC='\033[0m'

BANNER="Page"

PAGE_ID=$(docker-compose $COMPOSER_ARGS exec $TTY wordpress wp post list --allow-root --post_type='page' --format=ids)

URL="$WP_HOST/?page_id=$PAGE_ID"

$DEACTIVATE_PLUGIN > /dev/null

if ! curl -XGET $URL --silent | grep page_link | grep noreferrer > /dev/null; then
	echo -e "[${BANNER}]: ${red}Noreferrer must be exist${NC}"
	exit 1
fi

$DELETE_OPTIONS > /dev/null

docker-compose $COMPOSER_ARGS exec $TTY wordpress wp option add remove_noreferrer '{"where_should_the_plugin_work":["page"]}' --format=json --allow-root > /dev/null

$ACTIVATE_PLUGIN > /dev/null

if curl -XGET $URL --silent | grep page_link | grep noreferrer > /dev/null; then
	echo -e "[${BANNER}]: ${red}Noreferrer must not be exist${NC}"
	exit 1
fi

echo -e "[${BANNER}]:               ${green}Passed${NC}"

exit 0
