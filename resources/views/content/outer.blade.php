<style>
    @import url("https://fonts.googleapis.com/css?family=Raleway:900&display=swap");
    :root{--accent-color:var(--boray-text, #e2e2e3);--base-color:var(--boray-gold, #ffc640)}
    .hamburg{position:absolute;width:40px;height:auto;padding:.6rem;background:linear-gradient(180deg,var(--boray-gold, #ffc640),var(--boray-gold-2, #f9bd22));border:1px solid rgba(255,223,159,.7);border-radius:12px;z-index:80;box-shadow:0 10px 24px rgba(255,198,64,.22)}
    .ard-sosmed{display:block;cursor:pointer;position:fixed;bottom:12%;left:10px;font-family:"Times New Roman",sans-serif;z-index:79}
    .ard-sosmed ul{margin:0;padding:0}
    .ard-sosmed ul li{position:absolute;text-decoration:none;list-style:none;transform:translate(0,0) rotate(360deg);transition:all .5s ease;opacity:0}
    .ard-sosmed.open ul li:nth-child(1){transform:translateY(-65px);transition-delay:.20s;opacity:1}
    .ard-sosmed.open ul li:nth-child(2){transform:translate(0px,-130px);transition-delay:.16s;opacity:1}
    .ard-sosmed.open ul li:nth-child(3){transform:translate(0px,-195px);transition-delay:.12s;opacity:1}
    .ard-sosmed ul li a img{width:100%;height:auto}
    .ard-sosmed ul li a{display:flex;width:55px;height:55px;border:solid 1px var(--boray-line, rgba(255,255,255,.1));border-radius:12px;justify-content:center;align-items:center;background:rgba(18,20,21,.92)}
    .bar1,.bar2,.bar3{width:80%;height:5px;background-color:#261a00;margin:6px auto;transition:.4s;position:relative;transform:translateY(-1px)}
    .open .bar1{transform:translate(0,10px) rotate(-225deg)}
    .open .bar2{opacity:0;transform:translate(0,-6px) rotate(-225deg)}
    .open .bar3{transform:translate(0,-12px) rotate(-315deg)}
    .ard-sosmed ul li div{position:absolute;transition:all .3s ease;opacity:0;scale:.1;font-family:var(--boray-font-body, Inter),sans-serif;font-size:14px;font-weight:800;background:rgba(18,20,21,.96);color:var(--boray-text, #e2e2e3);text-align:center;text-wrap:nowrap;border:1px solid var(--base-color);padding:6px 10px;border-radius:999px}
    .ard-sosmed ul li:hover div{opacity:1;scale:1}
    .ard-sosmed ul li:nth-child(1) div{transform:translateY(-130px)}
    .ard-sosmed ul li:nth-child(1):hover div{transform:translate(70px,-40px)}
    .ard-sosmed ul li:nth-child(2) div{transform:translateY(-130px)}
    .ard-sosmed ul li:nth-child(2):hover div{transform:translate(70px,-40px)}
    .ard-sosmed ul li:nth-child(3) div{transform:translateY(-130px)}
    .ard-sosmed ul li:nth-child(3):hover div{transform:translate(70px,-40px)}
    .attention{
        position:relative;
        -webkit-clip-path:polygon(0% 0,100% 0,100% 75%,49% 75%,22% 100%,22% 75%,0% 75%);
        clip-path:polygon(0% 0,100% 0,100% 75%,49% 75%,22% 100%,22% 75%,0% 75%);
        width:65px;
        text-wrap:nowrap;
        height:30px;
        margin-bottom:5px;
        left:15px;
        background-color:var(--base-color);
        cursor:default;
        color:#261a00;
        display:flex;
        justify-content:center;
        align-items:center;
        padding-bottom:5px;
        opacity:0
    }
    .whore{animation:flicker .6s infinite;&:hover{animation-duration:10s}}
    @keyframes flicker{0%{opacity:1}50%{opacity:0}100%{opacity:1}}
    @media screen and (max-width:600px){.ard-sosmed{bottom:130px;left:5px}}
</style>
<div class="outer" style=" z-index: 1;">
    <div class="ard-sosmed">
        <div class="attention whore">KLIK DISINI!!!!!</div>
        <div class="hamburg" onclick="ardFunction()">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <ul>
            <li><a href="https://wa.me/{{ $setting->wa }}" target="_blank" rel="noopener noreferrer"> <img src="https://i.ibb.co.com/SfRfx70/giphy.webp" alt="WA"> </a><div>WA</div></li>
            <li><a href="https://t.me/{{ $setting->tele }}" target="_blank" rel="noopener noreferrer"> <img alt="Telegram" src="https://media.tenor.com/9ZsRZ-PXPlwAAAAi/telegram-gif.gif"> </a><div>Telegram</div></li>
            <li><a href="{{ url('/slots') }}" target="_blank" rel="noopener noreferrer"> <img src="https://media.tenor.com/byjlKOzpG7UAAAAj/rtp-gacor.gif" alt="RTP GACOR"> </a><div>RTP GACOR</div></li>
        </ul>
    </div>
    <script>
    const ard=document.querySelector('.ard-sosmed');
    const attention_whore=document.querySelector('.attention.whore');
    function ardFunction(){ard.classList.toggle("open");attention_whore.classList.remove("whore");}
    </script>    
</div>

<!-- Start of LiveChat (www.livechat.com) code -->
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = 19357991; // Ganti dengan ID lisensi Anda
        window.__lc.integration_name = "manual_channels";
        window.__lc.product_name = "livechat";
        ;(function(n,t,c) {
            function i(n) { return e._h ? e._h.apply(null,n) : e._q.push(n) }
            var e = { _q: [], _h: null, _v: "2.0", on: function() { i(["on", c.call(arguments)]) }, once: function() { i(["once", c.call(arguments)]) }, off: function() { i(["off", c.call(arguments)]) }, get: function() { if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load."); return i(["get", c.call(arguments)]) }, call: function() { i(["call", c.call(arguments)]) }, init: function() { var n = t.createElement("script"); n.async = !0; n.type = "text/javascript"; n.src = "https://cdn.livechatinc.com/tracking.js"; t.head.appendChild(n) } };
            !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
        }(window, document, [].slice));
    </script>
