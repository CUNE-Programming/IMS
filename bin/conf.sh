#! /usr/bin/env bash
# Conf.sh - Configure the environment for the project
# Usage: source bin/conf.sh
# Author: Ian Kollipara <ian.kollipara@cune.edu>
# Date: 2024-05-08

REPO_HOME=$(git rev-parse --show-toplevel)

# Add Shell Alias for Duster
alias duster='$REPO_HOME/vendor/duster'
alias format='duster fix'
alias lint='duster lint'
alias artisan='php $REPO_HOME/artisan'
