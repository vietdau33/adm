run_ngrok(){
    curl -X POST -F url="$1"/listen-chat-telegram https://api.telegram.org/bot1715396243:AAG2rPKQNVAbnveJc47gL3G6DNe5xjF-8-k/setWebhook
}

route(){
    php artisan route:cache
}

make(){
    php artisan make:"$1" "$2"
}

run(){
    php artisan "$1"
}

cache(){
    run optimize:clear && run config:cache && run route:cache
}


push_all(){
    git add . && git commit -m "$1" && git push origin $(git branch --show-current)
}

serve(){
    php artisan serve --port=80
}

ssh_(){
    ssh root@192.248.166.73
}
