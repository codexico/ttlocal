window.twttr=window.twttr||{};

twttr.languages={
    en:{
        ",":",",
        K:"K",
        "Twitter For Websites: Tweet Button":"Twitter For Websites: Tweet Button",
        Tweet:"Tweet",
        "The URL %{url} has been shared %{tweets} times.View these Tweets.":"The URL %{url} has been shared %{tweets} times.View these Tweets.",
        "Share %{url} on Twitter":"Share %{url} on Twitter"
    },
    fr:{
        ",":"",
        K:"K",
        "Twitter For Websites: Tweet Button":'Twitter pour votre site web : bouton "Tweeter"',
        Tweet:"Tweeter",
        "The URL %{url} has been shared %{tweets} times.View these Tweets.":"L'URL %{url} a été partagée %{tweets} fois. Voir ces Tweets.",
        "Share %{url} on Twitter":"Partager %{url} sur Twitter"
    },
    de:{
        ",":"",
        K:"K",
        "Twitter For Websites: Tweet Button":"Twitter für Webseiten: Tweet-Schaltfläche",
        Tweet:"Twittern",
        "The URL %{url} has been shared %{tweets} times.View these Tweets.":"Die URL-Adresse, %{url}, wurde %{tweets} Mal in Tweets veröffentlicht. Diese Tweets ansehen.",
        "Share %{url} on Twitter":"%{url} auf Twitter veröffentlichen"
    },
    es:{
        ",":"",
        K:"K",
        "Twitter For Websites: Tweet Button":"Twitter para sitios web: Botón para Twittear",
        Tweet:"Twittear",
        "The URL %{url} has been shared %{tweets} times.View these Tweets.":"Este enlace {url} ha sido compartido %{tweets} veces.Ver estos Tweets. ",
        "Share %{url} on Twitter":"Comparte %{url} en Twitter"
    },
    ja:{
        ",":",",
        K:"千",
        "Twitter For Websites: Tweet Button":"WEBサイト向けTwitter: ツイートボタン",
        Tweet:"ツイートする",
        "The URL %{url} has been shared %{tweets} times.View these Tweets.":"%{url}のURLは、%{tweets}回共有されました。これらのツイートを見る。",
        "Share %{url} on Twitter":"%{url}をTwitterで共有"
    }
};

function _(D,B){
    var A={},C;
    function E(G,F){
        if(F){
            for(var H in F){
                if(!A[H]){
                    A[H]=new RegExp("\\%\\{"+H+"\\}","gi")
                    }
                    G=G.replace(A[H],F[H])
                }
            }
            return G
    }
    if(twttr.i18n){
    C=twttr.i18n[D];
    if(C){
        D=C
        }
    }
return E(D,B)
};