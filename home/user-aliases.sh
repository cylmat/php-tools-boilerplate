#!/bin/bash

# COLORS #
alias egrep='egrep --color=auto'
alias fgrep='fgrep --color=auto'
alias grep='grep --color=auto'

export LS_OPTIONS='--color=auto'
alias la='ls $LS_OPTIONS -lA'
alias ll='ls $LS_OPTIONS -l'
alias ls='ls $LS_OPTIONS'

# COMMANDS #
alias ..='cd ..'
alias .bashrc="vim ~/.bashrc"
alias c="clear"
alias dfh='df -h'
alias home='cd ~'
alias g="git"
alias root='cd /'
alias q="exit"

# Configfortne
alias .vimrc='vim ~/.vimrc'
alias .bashrc='vim ~/.bashrc'

# Some more alias to avoid making mistakes:
# alias rm='rm -i'
# alias cp='cp -i'
# alias mv='mv -i'
