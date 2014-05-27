#!/bin/bash

#!/bin/bash

# Gets the directory in which this script is stored.
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done

DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"


# helper for stepping up a directory.
upto ()
{
    if [ -z "$1" ]; then
        return
    fi
    local upto=$1
    cd "${PWD/\/$upto\/*//$upto}"
}

# helper for stepping into folders relatively.
jump_down(){
    if [ -z "$1" ]; then
        echo "Usage: jd [directory]";
        return 1
    else
        cd **"/$1"
    fi
}

#helper for going to a directory
gotoD() {
  cd $(find -wholename $1 -type $2 | awk '{ print $0 }' | sort -k2 | head -1)
}

#build the container
docker build -t hootener/popuppopcorn .
echo -e '\E[34;47mPopCorn is built'; tput sgr0


sudo docker rm popcorn_server
sudo docker run --name popcorn_server -i -t -v ~/popuppopcorn/site:/etc/nginx/sites-enabled/popuppopcorn -p 80:80 hootener/popuppopcorn /bin/bash
sudo docker kill popcorn_server
