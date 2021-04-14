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

##########################
# CHOOSE ONE PROMPT FILE #
# default, fancygit, git, informative, matthew
##########################

# Set your own custom prompt file
SET_CUSTOM_PROMPT="fancygit"
if [[ $SET_CUSTOM_PROMPT != 'default' ]]; then

  CUSTOM_PROMPT="${SET_CUSTOM_PROMPT}.sh"

  if [[ -f ~/prompt/$CUSTOM_PROMPT ]]; then
    export PROMPT_COMMAND=''
    source ~/prompt/$CUSTOM_PROMPT
    # echo "Prompt to $CUSTOM_PROMPT"
  else 
    echo "~/prompt/$CUSTOM_PROMPT not found!"
  fi
else
  export PROMPT_COMMAND=''
  export PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
fi
