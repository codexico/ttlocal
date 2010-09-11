(function(){
    var G,W=document.getElementById("count"),H=document.getElementById("btn");
    var B=(function(X){
        var Y=document.createElement("div");
        return("innerText" in Y)?function(Z){
            Y.innerHTML=Z;
            return Y.innerText
            }:function(Z){
            Y.innerHTML=Z;
            return Y.textContent
            }
        }());
function F(Y,Z){
    for(var X in Z){
        Y[X]=Z[X]
        }
        return Y
    }
    function Q(X){
    return encodeURIComponent(X).replace(/\+/g,"%2B")
    }
    function C(X){
    return decodeURIComponent(X).replace("+"," ")
    }
    function J(Z){
    var Y=[];
    for(var X in Z){
        if(Z[X]!==null&&typeof Z[X]!=="undefined"){
            Y.push(Q(X)+"="+Q(Z[X]))
            }
        }
    return Y.sort().join("&")
    }
    function O(a){
    var c={},Z,b,Y,X;
    if(a){
        Z=a.split("&");
        for(X=0;(Y=Z[X]);X++){
            b=Y.split("=");
            if(b.length==2){
                c[C(b[0])]=B(C(b[1]))
                }
            }
        }
    return c
}
function M(X){
    X=X.replace(/\b:80\b|\b:443\b/,"").replace(/#(.*)/,"");
    var c,a=X.split("?"),b=a[0],d=a[1],Z=O(d),Y="http://";
    if(b.indexOf(Y)===-1){
        b=Y+b
        }
        b=b.replace(/^https?\:\/\/[\.a-z0-9\-]+$/,function(g){
        return g+"/"
        });
    b=b.replace(/\/[a-z0-9\-_%]+$/,function(g){
        return g+"/"
        });
    for(var f in Z){
        if(f.indexOf("utm_")!==-1){
            delete Z[f]
        }
    }
    var e=J(Z);
c=e?(b+"?"+e):b;
return c
}
function I(a){
    var Y,X=parseInt(a,10),Z=new RegExp("^"+_(","));
    if(X<10000){
        return X.toString().split("").reverse().join("").replace(/(\d{3})/g,"$1"+_(",")).split("").reverse().join("").replace(Z,"")
        }else{
        if(X<100000){
            Y=(X/1000).toString();
            return Y.replace(/^(\d+\.\d?)\d*$/,"$1"+_("K"))
            }else{
            return"100K+"
            }
        }
}
function R(X){
    G=X;
    W.innerHTML=I(G)
    }
    function D(){
    var Y,X=document.getElementById("btn");
    if((Y=_(document.title))){
        document.title=Y
        }
        if((Y=_(X.innerHTML))){
        X.innerHTML=Y
        }
    }
window.incrementCount=function(){
    R(G+1)
    };

twttr.config=F({
    countURL:"http://urls.api.twitter.com/1/urls/count.json",
    shareURL:"http://twitter.com/share"
},twttr.config||{});
document.domain="twitter.com";
var V=O(window.location.search.substr(1));
twttr.i18n=twttr.languages[V.lang]||{};

D();
var L={
    vertical:"vcount",
    horizontal:"hcount",
    none:"ncount"
};

var T=L[V.count]||"hcount";
if(V.lang!=="en"){
    T+=(" "+V.lang+" "+T+"-"+V.lang)
    }
    document.body.className=T;
delete V.lang;
if(!V.status_id){
    if(!V.url&&document.referrer){
        V.url=document.referrer
        }
    }
var P=M(V.counturl||V.url);
var E=M(V.url);
V.original_referer=document.referrer;
twttr.receiveCount=function(X){
    R(X.count);
    document.body.className+=" show-count";
    A(W,_("The URL %{url} has been shared %{tweets} times.View these Tweets.",{
        url:E,
        tweets:X.count
        }))
    };
(function S(){
    if(V.url){
        var X=document.createElement("script");
        X.type="text/javascript";
        X.src=twttr.config.countURL+"?url="+P+"&callback=twttr.receiveCount";
        document.body.appendChild(X)
        }
    }());
function U(){
    var Y=this.getElementsByTagName("button")[0];
    var X;
    if(Y.fireEvent){
        Y.fireEvent("onclick")
        }else{
        if(Y.dispatchEvent){
            X=document.createEvent("HTMLEvents");
            X.initEvent("click",true,true);
            Y.dispatchEvent(X)
            }
        }
}
function A(X,Z){
    var Y=document.createElement("p"),a=(X.id+"-desc");
    Y.id=a;
    Y.innerHTML=Z;
    Y.className="offscreen";
    document.body.appendChild(Y);
    X.setAttribute("aria-describedby",a)
    }
    A(H,_("Share %{url} on Twitter",{
    url:E
}));
H.parentNode.onclick=U;
W.parentNode.onclick=U;
document.body.setAttribute("role","application");
function K(X){
    if(X&&X.stopPropagation){
        X.stopPropagation()
        }else{
        window.event.cancelBubble=true
        }
    }
function N(X){
    return function(){
        var Y=this.parentNode,Z=Y.className;
        Y.className=Z+" "+X;
        function a(){
            Y.className=Z
            }
            this.onblur=a
        }
    }
H.onfocus=N("tb-focus");
W.onfocus=N("t-count-focus");
H.onclick=function(d){
    var Y=550,g=450;
    var b=screen.height;
    var a=screen.width;
    var Z=Math.round((a/2)-(Y/2));
    var f=0;
    var X=twttr.config.shareURL+"?"+J(V);
    if(b>g){
        f=Math.round((b/2)-(g/2))
        }
        var c=window.open(X,"twitter_tweet","left="+Z+",top="+f+",width="+Y+",height="+g+",personalbar=no,toolbar=no,scrollbars=yes,location=yes,resizable=yes");
    if(c){
        c.focus()
        }else{
        window.location.href=X
        }
        K(d)
    };

W.onclick=function(Z){
    var Y=[V.url];
    var X=V.url.split("?")[0];
    if(X!=V.url){
        Y.push(X)
        }
        window.open("http://twitter.com/#search?q="+escape(Y.join(" OR ")));
    K(Z)
    }
}());