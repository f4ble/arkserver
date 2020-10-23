FROM debian:stable-slim

#SteamCMD
RUN apt-get update && apt-get install -y software-properties-common && apt-add-repository non-free && dpkg --add-architecture i386
RUN echo steam steam/question select "I AGREE" | debconf-set-selections
RUN apt-get update && apt-get install -y lib32gcc1 steamcmd

#NORW Keyboard
RUN apt-get update && apt-get install -y locales && rm -rf /var/lib/apt/lists/* \
    && localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8
ENV LANG en_US.utf8

ENV TZ=Europe/Oslo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


RUN apt-get update && apt-get install -y \
    php-cli \
    git \
    vim \
    net-tools \
    perl \
    perl-modules-5.28 \
    lsof \ 
    bzip2 \
    rsync \
    sed \
    tar \
    coreutils \
    libc6-dev \
    curl \
    libsdl2-2.0-0 \
    procps \
    && rm -rf /var/lib/apt/lists/*

COPY root_bashrc /root/.bashrc


RUN useradd -ms /bin/bash steam
#USER steam
COPY --chown=steam:steam root_bashrc /home/steam/.bashrc


COPY init /init
COPY init.php /init.php
COPY create-folders.sh /create-folders.sh
COPY arkmanager /arkmanager.default.configs

# https://ark.gamepedia.com/Server_Configuration#Command_line_arguments
# https://ark.gamepedia.com/Dedicated_Server_Setup
# ENTRYPOINT ["/server-files/ShooterGame/Binaries/Linux/ShooterGameServer"]

