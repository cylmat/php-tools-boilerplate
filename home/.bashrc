# ~/.bashrc: executed by bash(1) for non-login shells.

###########
# SAMPLES #
# https://gist.github.com/zachbrowne/8bc414c9f30192067831fafebd14255c
###########

# Note: PS1 and umask are already set in /etc/profile. You should not
# need this unless you want different defaults for root.
# PS1='${debian_chroot:+($debian_chroot)}\h:\w\$ '
# umask 022

#########
# ALIAS #
#########
[[ -f ~/user-aliases.sh ]] && source ~/user-aliases.sh

#########
# LOCAL #
# export LANGUAGE=en_US.UTF-8
# export LANG=en_US.UTF-8
# export LC_ALL=en_US.UTF-8
#########

##################
# Autocompletion #
# Use "apt install bash-completion"

##############
# BASH-IT    #
# GIT PROMPT #
# OH MY BASH #
##############
[[ -f ~/user-bash_it.sh ]] && source ~/user-bash_it.sh || echo "~/user-bash_it.sh not found!"
#[[ -f ~/user-prompt.sh ]] && source ~/user-prompt.sh || echo "~/user-prompt.sh not found!"
#[[ -f ~/user-ohmybash.sh ]] && source ~/user-ohmybash.sh || echo "~/user-ohmybash.sh not found!"

##########
# OTHERS #
##########
if [[ -f ~/user-custom.sh ]]; then
  source ~/user-custom.sh
fi
