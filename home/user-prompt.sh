#!/bin/bash

############
# GIT PROMPT
############

# https://raw.githubusercontent.com/git/git/master/contrib/completion/git-completion.bash
# https://github.com/git/git/blob/master/contrib/completion/git-prompt.sh

### CHANGE PROMPT
if [[ ! -f ~/prompt/git-prompt.sh ]] || [[ ! -f ~/prompt/git-completion.bash ]]; then
  echo "git-prompt or git-completion not found!"
  return 1
fi

source ~/prompt/git-completion.bash
source ~/prompt/git-prompt.sh

# CHOOSE ONE PROMPT FILE
CUSTOM_PROMPT=default.sh

if [[ -f ~/prompt/$CUSTOM_PROMPT ]]; then
  source ~/prompt/$CUSTOM_PROMPT
  echo "Prompt to $CUSTOM_PROMPT"
fi
