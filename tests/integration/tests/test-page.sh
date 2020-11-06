#!/bin/bash

export red='\033[0;31m'
export green='\033[0;32m'
export NC='\033[0m'

BANNER="[${WP_VERSION}][Page]"

PAGE_ID=$(docker-compose $COMPOSER_ARGS exec $TTY wordpress wp post list --allow-root --post_type='page' --format=ids)

URL="$WP_HOST/?page_id=$PAGE_ID"

$INSTALL_PLUGIN > /dev/null

if ! $PLUGIN_IS_INSTALLED; then
	echo -e "${BANNER}:               ${red}Plugin is not installed${red}"
	exit 1
fi

if ! curl -XGET $URL --silent | grep page_link | grep noreferrer > /dev/null; then
	echo -e "${BANNER}:               ${red}Noreferrer must be exist${NC}"
	exit 1
fi

$ACTIVATE_PLUGIN > /dev/null

if ! $PLUGIN_IS_ACTIVE; then
	echo -e "${BANNER}:               ${red}Plugin is not active${red}"
	exit 1
fi

docker-compose $COMPOSER_ARGS exec $TTY wordpress wp option update remove_noreferrer '{"where_should_the_plugin_work":["page"]}' --format=json --allow-root > /dev/null

if curl -XGET $URL --silent | grep page_link | grep noreferrer > /dev/null; then
	echo -e "${BANNER}:               ${red}Noreferrer must not be exist${NC}"
	exit 1
fi

echo -e "${BANNER}:               ${green}Passed${NC}"

#
# CLEANUP
#
$DELETE_OPTIONS > /dev/null
$DEACTIVATE_PLUGIN > /dev/null
$UNINSTALL_PLUGIN > /dev/null

exit 0
