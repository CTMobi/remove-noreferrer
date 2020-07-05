#!/bin/bash

set -euo pipefail

TESTS="${BIN}/../tests"

$TESTS/test-widget-text.sh
$TESTS/test-widget-custom-html.sh
$TESTS/test-homepage.sh
$TESTS/test-post.sh
$TESTS/test-post-comment.sh
$TESTS/test-page.sh
$TESTS/test-page-comment.sh
$TESTS/test-debug-log.sh
$TESTS/test-uninstall-removes-plugin-options.sh
$TESTS/test-uninstall-does-not-remove-plugin-options.sh
