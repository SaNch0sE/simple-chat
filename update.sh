#!/bin/bash
gitChat='https://github.com/SaNch0sE/simple-chat.git'
path='/var/www/html'

download() {
	echo "git clone $gitChat"
	git clone $gitChat &&
}

backup(){
	echo "move $path/chat to $path/chat_backup_last"
	rm -rf '$path/chat_backup_last/*' &&
	cp $path/chat/* $path/chat_backup_last -f &&
	mkdir $path/chat_backup_last/js &&
	cp $path/chat/js/* $path/chat_backup_last/js -f &&
	mkdir $path/chat_backup_last/models &&
	cp $path/chat/models/* $path/chat_backup_last/models -f &&
	mkdir $path/chat_backup_last/styles &&
	cp $path/chat/styles/* $path/chat_backup_last/styles -f &&
	rm -rf $path/chat &&
	echo "move new simple-chat to $path/chat"
}

restoreServer(){
	#mkdir $path/chat
	if [ -d "$path/chat" ]; then
	  ### Take action if $DIR exists ###
	  echo "$path/chat already exist"
	else
	  ###  Control will jump here if $DIR does NOT exists ###
	  mkdir $path/chat
	  exit 1
	fi
	cp simple-chat/* $path/chat/ -f &&
	mkdir $path/chat/js &&
	cp simple-chat/js/* $path/chat/js -f &&
	mkdir $path/chat/models &&
	cp simple-chat/models/* $path/chat/models -f &&
	mkdir $path/chat/styles &&
	cp simple-chat/styles/* $path/chat/styles -f &&
	echo "mv old config"
	rm -rf $path/chat/config.php &&
	cp $path/chat_backup_last/config.php $path/chat/config.php &&
}

start(){
	echo 'Update start:'
	download &&
	backup &&
	restoreServer &&
	ls $path
	echo "done"
}
