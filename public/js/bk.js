window.addEventListener("load", function () {
    var t,
        e = "inline-block",
        n = null,
        o = 25e5,
        a = 2e7,
        l = 3e6,
        s = document.getElementsByClassName("bk-btn"),
        r = '<div class="bk-btn-box">',
        m = document.getElementById("bk-modal"),
        p = "",
        d = "https://pc.baokim.vn/",
        c = "https://pg.baokim.vn/",
        g = "https://ws.baokim.vn/payment-services",
        b = window.location.hostname;
    "m." == (b = b.replace("www.", "")).substring(0, 2) && (b = b.substring(2));
    var u = window.location.protocol;
    function v() {
        var e = document.getElementsByClassName("bk-product-name"),
            o = document.getElementsByClassName("bk-product-price"),
            a = document.getElementsByClassName("bk-product-qty"),
            l = document.getElementsByClassName("bk-product-image"),
            s = document.getElementsByClassName("bk-product-property"),
            r = [],
            m = [],
            p = [],
            d = [],
            c = "";
        for (maxLoop = e.length, i = 0; i < maxLoop; i++) {
            r.push(e[i].innerHTML);
            var v = V(o[i].innerHTML);
            (v = o[i].firstElementChild && o[i].firstElementChild.innerHTML.match(/\d+/g) ? V(o[i].firstElementChild.innerHTML) : V(o[i].innerHTML)), m.push(v);
            var y = null;
            l[i] &&
            (l[i].hasAttribute("data-src") ? (y = l[i].getAttribute("data-src")) : l[i].hasAttribute("src") ? (y = l[i].getAttribute("src")) : l[i].hasAttribute("data-o_src") && (y = l[i].getAttribute("data-o_src")),
            y && !1 === y.includes("//") && (y = u + "//" + b + "/" + y)),
                d.push(y),
                void 0 !== a[i] && a[i].value ? p.push(a[i].value) : p.push(1);
        }
        var h = "undefined" != typeof variant_id_pro ? variant_id_pro : null;
        if (!h) {
            var k = document.querySelectorAll('.js-variant-option-container > input[type="hidden"]');
            if (k.length > 0) {
                var f = (k = document.querySelectorAll('.js-variant-option-container > input[type="hidden"]')[0]).value;
                if (f) (h = JSON.parse(f).variant_id), console.log(h);
            }
            var _ = document.getElementById("product-selectors");
            _ && (h = _.value);
            var w = document.getElementById("product-select");
            w && (h = w.value);
            var x = document.querySelectorAll("[name=variantId]");
            x.length > 0 && (h = x[0].value);
            var N = document.getElementById("productSelect");
            N && (h = N.value);
        }
        var E = null,
            C = "undefined" != typeof pro_id ? pro_id : null;
        C && (E = parseInt(C));
        var L = s.length;
        if (L > 0)
            for (i = 0; i < L; i++) {
                var T = s[i];
                h || ((h = Math.ceil(T.value)), isNaN(h) && (h = null)),
                    "input" == T.tagName.toLowerCase() ? (c += T.value + " - ") : "select" == T.tagName.toLowerCase() ? (c += T.options[T.selectedIndex].text + " - ") : (c += T.innerHTML + " ");
            }
        var H = [];
        for (i = 0; i < maxLoop; i++) {
            "undefined" != typeof meta && void 0 !== meta.product && (E = meta.product.id);
            var B = { name: r[i], image: d[i], quantity: p[i], price: m[i], platform_product_id: E, platform_variant_id: h };
            H.push(B);
        }
        var I = { products: H, domain: b, merchantLogo: t.logo, productProperty: c };
        console.log(I);
        var A = q("POST", g + "api/v1/order-temporary/store", JSON.stringify(I));
        A && (n = A.token);
    }
    console.log(b),
        (function () {
            var n = q("GET", d + "api/plus/get-merchant?domain=" + b, null);
            if (!n) return;
            if (200 != n.code) return;
            var i = n.meta;
            if (!i) return;
            if (null == (t = i.data)) return (y.style.display = "none"), (h.style.display = "none"), (k.style.display = "none"), (f.style.display = "none"), (_.style.display = "none"), void (w.style.display = "none");
            var c = t.config,
                g = c.payment,
                u = c.installment,
                v = c.installment_amigo;
            m &&
            (3 == n.meta.data.display_version_paynow || 3 == n.meta.data.display_version_installment || 3 == n.meta.data.display_version_insta_installment
             ? (p += '<div id="bk-modal-payment" class="bk-modal bk-v3">')
             : (p += '<div id="bk-modal-payment" class="bk-modal">'),
                (p += '<div class="bk-modal-content" id="bk-modal-content-style">'),
                (p += '     <div id="bk-modal-pop" class="bk-modal-header">'),
                3 == n.meta.data.display_version_paynow || 3 == n.meta.data.display_version_installment || 3 == n.meta.data.display_version_insta_installment
                ? ((p += '         <div class="bk-container-fluid position-relative" style="box-sizing: border-box; height: 0 !important;">'),
                    (p += '             <div class="bk-row bk-close-v3">'),
                    (p += '                 <div class="bk-col-4 bk-col-lg-3 bk-text-right" style="box-sizing: border-box">'),
                    (p += '                     <button type="button" id="bk-modal-close">&times;</button>'),
                    (p += "                 </div>"),
                    (p += "             </div>"),
                    (p += "</div>"))
                : ((p += '         <div class="bk-container-fluid position-relative" style="box-sizing: border-box">'),
                    (p += '             <div class="bk-row bk-popup-header">'),
                    (p += '                 <div class="bk-col-5 bk-col-lg-3" style="box-sizing: border-box" id="bk-logo">'),
                    (p += "                 </div>"),
                    (p += '                 <div class="bk-col-3 bk-col-lg-6" style="box-sizing: border-box">'),
                    (p += "                 </div>"),
                    (p += '                 <div class="bk-col-4 bk-col-lg-3 bk-text-right" style="box-sizing: border-box">'),
                    (p += '                     <button type="button" id="bk-modal-close">&times;</button>'),
                    (p += "                 </div>"),
                    (p += "             </div>"),
                    (p += "         </div>")),
                (p += "</div>"),
                (p += '<div class="bk-modal-body">'),
                (p += '<iframe width="100%" height="100%" id="iframe" src=""></iframe>'),
                (p += "</div>"),
                (p += "</div>"),
                (p += "</div>"),
                (p += '<div id="bk-modal-notify" class="bk-modal">'),
                (p += '<div class="bk-modal-content" id="bk-modal-content-notify">'),
                (p += '<div class="bk-modal-header">'),
                (p += '<div class="bk-container-fluid">'),
                (p += '<div class="bk-row bk-popup-header">'),
                (p += '<div class="bk-col-3" id="bk-logo">'),
                (p += "</div>"),
                (p += '<div class="bk-col-6">'),
                (p += "</div>"),
                (p += '<div class="bk-col-3 bk-text-right">'),
                (p += '<button type="button" id="bk-modal-close">&times;</button>'),
                (p += "</div>"),
                (p += "</div>"),
                (p += "</div>"),
                (p += "</div>"),
                (p += '<div class="bk-modal-body">'),
                (p += '<p class="text-center">Sáº£n pháº©m Ä‘Ă£ háº¿t hĂ ng, khĂ´ng thá»ƒ thanh toĂ¡n</p>'),
                (p += '<button type="button" class="bk-modal-notify-close bk-btn-notify-close">ÄĂ³ng</button>'),
                (p += "</div>"),
                (p += "</div>"),
                (p += "</div>"),
                (m.innerHTML = p));
            if (g.enable) {
                var N = document.getElementsByClassName("bk-product-price"),
                    E = !0,
                    C = N.length;
                for (I = 0; I < C; I++) {
                    var L = N[I].innerHTML;
                    if ("LIĂN Há»†" === L.toUpperCase() || "Äáº¶T HĂ€NG" === L.toUpperCase()) return void (E = !1);
                    if (void 0 === (L = N[I].firstElementChild && N[I].firstElementChild.innerHTML.match(/\d+/g) ? V(N[I].firstElementChild.innerHTML) : V(N[I].innerHTML))) return void (E = !1);
                }
                if (E) {
                    let n = "Mua ngay";
                    var T = "Giao táº­n nÆ¡i hoáº·c nháº­n táº¡i cá»­a hĂ ng",
                        H = "#e00",
                        B = "#fff";
                    if (null != t.style_popup) {
                        const e = t.style_popup;
                        for (var I = 0; I < e.length; I++)
                            1 == e[I].type &&
                            1 == e[I].status &&
                            (null != e[I].txt_btn_integrated && (n = e[I].txt_btn_integrated),
                            null != e[I].note_btn_integrated && (T = e[I].note_btn_integrated),
                            null != e[I].bg_color_btn_payment && (H = e[I].bg_color_btn_payment),
                            null != e[I].tx_color_btn_payment && (B = e[I].tx_color_btn_payment));
                    }
                    (r += '<button class="bk-btn-paynow" style="display: ' + e + ";background-color: " + H + " !important;color: " + B + ' !important" type="button">'),
                        (r += "<strong>" + n + "</strong>"),
                        (r += "<span>" + T + "</span>"),
                        (r += "</button>");
                }
            }
            if (u.enable) {
                var A = U(),
                    M = !1;
                "donghoduyanh.com" == b && (l = 5e6),
                A >= l && (M = !0),
                ("demo-bkplus.baokim.vn" != b && "devtest.baokim.vn:9405" != b && "devtest.baokim.vn" != b && "bkplus.myharavan.com" != b) || (M = !0),
                    console.log("Total: " + A + " - instalment value: " + l);
                let n = "Tráº£ gĂ³p qua tháº»";
                var z = "Visa, Master, JCB",
                    O = "#288ad6",
                    S = "#fff";
                if (null != t.style_popup) {
                    const e = t.style_popup;
                    for (I = 0; I < e.length; I++)
                        2 == e[I].type &&
                        1 == e[I].status &&
                        (null != e[I].txt_btn_integrated && (n = e[I].txt_btn_integrated),
                        null != e[I].note_btn_integrated && (z = e[I].note_btn_integrated),
                        null != e[I].bg_color_btn_installment && (O = e[I].bg_color_btn_installment),
                        null != e[I].tx_color_btn_installment && (S = e[I].tx_color_btn_installment));
                }
                M &&
                ((r += '<button class="bk-btn-installment" style="display: ' + e + ";background-color: " + O + " !important;color: " + S + ' !important" type="button">'),
                    (r += "<strong>" + n + "</strong>"),
                    (r += "<span>" + z + "</span>"),
                    (r += "</button>"));
            }
            if (v.enable) {
                A = U();
                var j = !1;
                v.hasOwnProperty("min_order_amount") && (o = v.min_order_amount),
                v.hasOwnProperty("max_order_amount") && (a = v.max_order_amount),
                A >= o && A <= a && (j = !0),
                ("demo-bkplus.baokim.vn" != b && "devtest.baokim.vn:9405" != b && "devtest.baokim.vn" != b && "bkplus.myharavan.com" != b) || (j = !0),
                    console.log(A);
                let t = "Mua ngay - tráº£ sau",
                    e = n.meta.data.user.amigo,
                    i = n.meta.data.user.kredivo,
                    l = n.meta.data.user.hcvn,
                    s = n.meta.data.user.atome,
                    m = "#f1eb1f",
                    p = "#235d97";
                if (null != n.meta.data.style_popup) {
                    const e = n.meta.data.style_popup;
                    for (let n = 0; n < e.length; n++)
                        3 == e[n].type &&
                        1 == e[n].status &&
                        (null != e[n].txt_btn_integrated && (t = e[n].txt_btn_integrated), null != e[n].bg_color_btn_insta && (m = e[n].bg_color_btn_insta), null != e[n].tx_color_btn_insta && (p = e[n].tx_color_btn_insta));
                }
                if (j) {
                    var G = '<div class="bk-insta-content">';
                    (G += "homebest.vn" == b ? '<strong style="color: #ffffff !important">TRáº¢ GĂ“P QUA CMT</strong>' : "<strong>" + t + "</strong>"),
                        "donghoduyanh.com" == b
                        ? (G += '<span style="color: ' + p + ' !important">KhĂ´ng cáº§n tháº» - XĂ©t duyá»‡t qua CCCD trong 20 giĂ¢y</span>')
                        : "taozinsaigon.com" == b
                          ? (G += '<span style="color: ' + p + ' !important">PhĂª duyá»‡t trong 20 giĂ¢y</span>')
                          : "homebest.vn" == b
                            ? (G += '<span style="color: #ffffff !important">Duyá»‡t nhanh qua Ä‘iá»‡n thoáº¡i</span>')
                            : ((G += "<span>"),
                                1 == i &&
                                (1 == n.meta.data.config.installment_amigo.promotion_kredivo
                                 ? (G += '<img src="https://pc.baokim.vn/platform/img/kredivo-ngang-small.svg" alt="" style="height: 20px !important;">')
                                 : (G += '<img src="https://pc.baokim.vn/platform/img/icon-kredivo.svg" alt="">')),
                                1 == s && (G += '<img src="https://pc.baokim.vn/platform/img/icon-atome.svg" alt="" style="margin-left: 5px;">'),
                                1 == l && (G += '<img src="https://pc.baokim.vn/platform/img/home-paylater-ngang-small.svg" alt="" style="margin-left: 5px; height: 20px !important;">'),
                                1 == e && (G += '<img src="https://pc.baokim.vn/platform/img/icon-insta.svg" alt="" style="margin-left: 5px;">'),
                                    (G += "</span>")),
                        (r +=
                            "homebest.vn" == b
                            ? '<button class="bk-btn-installment-amigo" style="display: flex;background-color: #0a0 !important; color: #ffffff !important;" type="button">'
                            : '<button class="bk-btn-installment-amigo" style="display: flex;background-color: ' + m + " !important;color: " + p + ' !important" type="button">'),
                        (r += G += "</div>"),
                        (r += "</button>");
                }
            }
            r += "</div>";
            let P = n.meta.data.user.kredivo,
                J = n.meta.data.user.hcvn;
            1 == n.meta.data.config.installment_amigo.promotion_kredivo && 1 == n.meta.data.config.installment_amigo.promotion_hcvn
            ? ((r += '<div class="bk-promotion">'),
                (r += '    <div class="bk-promotion-title">'),
                (r += "        <p>Æ¯U ÄĂƒI KHI THANH TOĂN</p>"),
                (r += '        <img src="https://pc.baokim.vn/platform/img/kredivo-ngang-small.svg" style="height: 20px !important;" alt="">'),
                (r +=
                    '        <a href="https://www.homepaylater.vn/?utm_source=" style="cursor: pointer" target="_blank"><img src="https://pc.baokim.vn/platform/img/home-paylater-ngang-small.svg" style="height: 20px !important;" alt=""></a>'),
                (r += "    </div>"),
                (r += '    <div class="bk-promotion-content">'),
                (r += "        <ul>"),
            1 == J &&
            ((r += "            <li>"),
                (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/home-paylater-vuong-small.svg" alt="">'),
                (r += "                <div>"),
                (r += "                    <p>Giáº£m 10% tá»‘i Ä‘a 1.000.000 VNÄ cho Ä‘Æ¡n hĂ ng tá»« 6.000.000 VNÄ</p>"),
                (r += '                    <p style="font-size: 12px;">(Nháº­p Sá»‘ Ä‘iá»‡n thoáº¡i Ä‘á»ƒ nháº­n Æ°u Ä‘Ă£i)</p>'),
                (r += "                </div>"),
                (r += '                <span><img style="margin-right: 4px;" src="https://pc.baokim.vn/platform/img/fire-promotion.svg" alt="">Æ¯U ÄĂƒI HOT</span>'),
                (r += "            </li>"),
                (r += "            <li>"),
                (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/home-paylater-vuong-small.svg" alt="">'),
                (r += "                <div>"),
                (r += "                    <p>Giáº£m 5% tá»‘i Ä‘a 500.000 VNÄ cho Ä‘Æ¡n hĂ ng tá»« 200.000 VNÄ</p>"),
                (r += '                    <p style="font-size: 12px;">(Nháº­p Sá»‘ Ä‘iá»‡n thoáº¡i Ä‘á»ƒ nháº­n Æ°u Ä‘Ă£i)</p>'),
                (r += "                </div>"),
                (r += '                <span><img style="margin-right: 4px;" src="https://pc.baokim.vn/platform/img/fire-promotion.svg" alt="">Æ¯U ÄĂƒI HOT</span>'),
                (r += "            </li>")),
            1 == P &&
            ((r += "            <li>"),
                (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/kredivo-vuong-small.svg" alt="">'),
                (r += "                <p>Giáº£m ngay 5% tá»‘i Ä‘a 500.000Ä‘ khi thanh toĂ¡n tráº£ gĂ³p 6/12 thĂ¡ng</p>"),
                (r += '                <span style="background: none !important;"></span>'),
                (r += "            </li>"),
                (r += "            <li>"),
                (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/kredivo-vuong-small.svg" alt="">'),
                (r += "                <p>Giáº£m 50% tá»‘i Ä‘a 100.000Ä‘ khi thanh toĂ¡n láº§n Ä‘áº§u</p>"),
                (r += '                <span style="background: none !important;"></span>'),
                (r += "            </li>")),
                (r += "        </ul>"),
                (r += '        <div class="bk-promotion-footer">'),
                (r += "            <p>Powered by</p>"),
                (r += '            <img src="https://pc.baokim.vn/platform/img/bk-logo-promotion.svg" alt="">'),
                (r += "        </div>"),
                (r += "    </div>"),
                (r += "</div>"))
            : 1 == n.meta.data.config.installment_amigo.promotion_kredivo
              ? ((r += '<div class="bk-promotion">'),
                    (r += '    <div class="bk-promotion-title">'),
                    (r += "        <p>Æ¯U ÄĂƒI KHI THANH TOĂN</p>"),
                    (r += '        <img src="https://pc.baokim.vn/platform/img/kredivo-ngang-small.svg" style="height: 20px !important;" alt="">'),
                    (r += "    </div>"),
                    (r += '    <div class="bk-promotion-content">'),
                    (r += "        <ul>"),
                1 == P &&
                ((r += "            <li>"),
                    (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/kredivo-vuong-small.svg" alt="">'),
                    (r += "                <p>Giáº£m ngay 5% tá»‘i Ä‘a 500.000Ä‘ khi thanh toĂ¡n tráº£ gĂ³p 6/12 thĂ¡ng</p>"),
                    (r += '                <span style="background: none !important;"></span>'),
                    (r += "            </li>"),
                    (r += "            <li>"),
                    (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/kredivo-vuong-small.svg" alt="">'),
                    (r += "                <p>Giáº£m 50% tá»‘i Ä‘a 100.000Ä‘ khi thanh toĂ¡n láº§n Ä‘áº§u</p>"),
                    (r += '                <span style="background: none !important;"></span>'),
                    (r += "            </li>")),
                    (r += "        </ul>"),
                    (r += '        <div class="bk-promotion-footer">'),
                    (r += "            <p>Powered by</p>"),
                    (r += '            <img src="https://pc.baokim.vn/platform/img/bk-logo-promotion.svg" alt="">'),
                    (r += "        </div>"),
                    (r += "    </div>"),
                    (r += "</div>"))
              : 1 == n.meta.data.config.installment_amigo.promotion_hcvn &&
                  ((r += '<div class="bk-promotion">'),
                      (r += '    <div class="bk-promotion-title">'),
                      (r += "        <p>Æ¯U ÄĂƒI KHI THANH TOĂN</p>"),
                      (r +=
                          '        <a href="https://www.homepaylater.vn/?utm_source=" style="cursor: pointer" target="_blank"><img src="https://pc.baokim.vn/platform/img/home-paylater-ngang-small.svg" style="height: 20px !important;" alt=""></a>'),
                      (r += "    </div>"),
                      (r += '    <div class="bk-promotion-content">'),
                      (r += "        <ul>"),
                  1 == J &&
                  ((r += "            <li>"),
                      (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/home-paylater-vuong-small.svg" alt="">'),
                      (r += "                <div>"),
                      (r += "                    <p>Giáº£m 10% tá»‘i Ä‘a 1.000.000 VNÄ cho Ä‘Æ¡n hĂ ng tá»« 6.000.000 VNÄ</p>"),
                      (r += '                    <p style="font-size: 12px;">(Nháº­p Sá»‘ Ä‘iá»‡n thoáº¡i Ä‘á»ƒ nháº­n Æ°u Ä‘Ă£i)</p>'),
                      (r += "                </div>"),
                      (r += '                <span><img style="margin-right: 4px;" src="https://pc.baokim.vn/platform/img/fire-promotion.svg" alt="">Æ¯U ÄĂƒI HOT</span>'),
                      (r += "            </li>"),
                      (r += "            <li>"),
                      (r += '                <img style="margin-top: 6px; width: 35px !important;" src="https://pc.baokim.vn/platform/img/home-paylater-vuong-small.svg" alt="">'),
                      (r += "                <div>"),
                      (r += "                    <p>Giáº£m 5% tá»‘i Ä‘a 500.000 VNÄ cho Ä‘Æ¡n hĂ ng tá»« 200.000 VNÄ</p>"),
                      (r += '                    <p style="font-size: 12px;">(Nháº­p Sá»‘ Ä‘iá»‡n thoáº¡i Ä‘á»ƒ nháº­n Æ°u Ä‘Ă£i)</p>'),
                      (r += "                </div>"),
                      (r += '                <span><img style="margin-right: 4px;" src="https://pc.baokim.vn/platform/img/fire-promotion.svg" alt="">Æ¯U ÄĂƒI HOT</span>'),
                      (r += "            </li>")),
                      (r += "        </ul>"),
                      (r += '        <div class="bk-promotion-footer">'),
                      (r += "            <p>Powered by</p>"),
                      (r += '            <img src="https://pc.baokim.vn/platform/img/bk-logo-promotion.svg" alt="">'),
                      (r += "        </div>"),
                      (r += "    </div>"),
                      (r += "</div>"));
            for (x in s) s[x].innerHTML = r;
        })(),
        (window.mobileCheck = function () {
            let t = !1;
            var e;
            return (
                (e = navigator.userAgent || navigator.vendor || window.opera),
                (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
                        e
                    ) ||
                    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
                        e.substr(0, 4)
                    )) &&
                (t = !0),
                    t
            );
        });
    var y = document.getElementById("bk-btn-paynow"),
        h = document.getElementsByClassName("bk-btn-paynow"),
        k = document.getElementById("bk-btn-installment"),
        f = document.getElementsByClassName("bk-btn-installment"),
        _ = document.getElementById("bk-btn-installment-amigo"),
        w = document.getElementsByClassName("bk-btn-installment-amigo"),
        N = document.getElementsByClassName("bk-btn-paynow-list"),
        E = document.getElementsByClassName("bk-btn-installment-list"),
        C = document.getElementById("bk-modal-payment"),
        L = document.getElementById("bk-modal-notify"),
        T = document.getElementById("bk-modal-close"),
        H = document.getElementsByClassName("bk-modal-notify-close"),
        B = document.getElementById("iframe"),
        I = document.getElementById("bk-modal-pop"),
        A = document.getElementById("bk-modal-content-style");
    if (h.length > 0)
        for (x = 0; x < h.length; x++)
            h[x].addEventListener("click", function () {
                M(this);
            });
    if (f.length > 0)
        for (x = 0; x < f.length; x++)
            f[x].addEventListener("click", function () {
                M(this, "/installment");
            });
    if (w.length > 0)
        for (x = 0; x < w.length; x++)
            w[x].addEventListener("click", function () {
                M(this, "/bnpl/installment");
            });
    function M(e, i = "") {
        var o = q("GET", d + "api/plus/get-merchant?domain=" + b, null);
        if ("bk-btn-paynow" == e.className) {
            var a = "#006d9c";
            if (null != t.style_popup) {
                const e = t.style_popup;
                for (var l = 0; l < e.length; l++)
                    1 == e[l].type &&
                    1 == e[l].status &&
                    (null != e[l].bg_color_mdl_payment && ((a = e[l].bg_color_mdl_payment), (I.style.backgroundColor = a)),
                    2 == e[l].display_mode_popup && ((A.style.width = "100%"), (A.style.margin = "0px"), (A.style.height = "100%")));
            }
        }
        if ("bk-btn-installment" == e.className) {
            var s = "#006d9c";
            if (null != t.style_popup) {
                const e = t.style_popup;
                for (l = 0; l < e.length; l++)
                    2 == e[l].type &&
                    1 == e[l].status &&
                    (null != e[l].bg_color_mdl_installment && ((s = e[l].bg_color_mdl_installment), (I.style.backgroundColor = s)),
                    2 == e[l].display_mode_popup && ((A.style.width = "100%"), (A.style.margin = "0px"), (A.style.height = "100%")));
            }
        }
        if ("bk-btn-installment-amigo" == e.className) {
            var r = "#006d9c";
            if (null != t.style_popup) {
                const e = t.style_popup;
                for (l = 0; l < e.length; l++)
                    3 == e[l].type &&
                    1 == e[l].status &&
                    (null != e[l].bg_color_mdl_insta && ((r = e[l].bg_color_mdl_insta), (I.style.backgroundColor = r)), 2 == e[l].display_mode_popup && ((A.style.width = "100%"), (A.style.margin = "0px"), (A.style.height = "100%")));
            }
        }
        var m = document.getElementsByClassName("bk-check-out-of-stock"),
            p = !1;
        if (m.length > 0)
            for (l = 0; l < m.length; l++) {
                if ("Háº¿t hĂ ng" === m[l].value) return (p = !0), null;
                if ("LiĂªn há»‡" === m[l].value) return (p = !0), null;
            }
        if (p) L.css({ display: "block" }), L.removeClass("hide");
        else {
            var c = navigator.vendor && navigator.vendor.indexOf("Apple") > -1 && navigator.userAgent && -1 == navigator.userAgent.indexOf("CriOS") && -1 == navigator.userAgent.indexOf("FxiOS");
            n || v();
            var g = S(i);
            if (0 == c)
                if (window.mobileCheck())
                    ("bk-btn-paynow" == e.className && 3 == o.meta.data.display_version_paynow) ||
                    ("bk-btn-installment" == e.className && 3 == o.meta.data.display_version_installment) ||
                    ("bk-btn-installment-amigo" == e.className && 3 == o.meta.data.display_version_insta_installment)
                    ? window.open(g)
                    : (B.setAttribute("src", g), (C.style.display = "block"), C.classList.remove("hide"), G());
                else if ("bk-btn-paynow" == e.className && 2 == o.meta.data.display_version_paynow)
                    try {
                        window.open(g, "_blank");
                    } catch (t) {
                        window.location.href = g;
                    }
                else if ("bk-btn-installment" == e.className && 2 == o.meta.data.display_version_installment)
                    try {
                        window.open(g, "_blank");
                    } catch (t) {
                        window.location.href = g;
                    }
                else if ("bk-btn-installment-amigo" == e.className && 2 == o.meta.data.display_version_insta_installment)
                    try {
                        window.open(g, "_blank");
                    } catch (t) {
                        window.location.href = g;
                    }
                else B.setAttribute("src", g), (C.style.display = "block"), C.classList.remove("hide"), G();
            else window.open(g);
        }
    }
    if (
        (document.addEventListener("keydown", (t) => {
            "Escape" === t.key && ((C.style.display = "none"), P());
        }),
        T &&
        T.addEventListener("click", function () {
            (C.style.display = "none"), P();
        }),
        H.length > 0)
    )
        for (j = 0; j < H.length; j++)
            H[j].addEventListener("click", function () {
                (L.style.display = "none"), P();
            });
    if (N.length > 0)
        for (i = 0; i < N.length; i++)
            N[i].addEventListener("click", function () {
                z(this);
            });
    if (E.length > 0)
        for (i = 0; i < E.length; i++)
            E[i].addEventListener("click", function () {
                z(this, "/installment");
            });
    function z(t, e = "") {
        var n = {},
            i = [],
            o = [],
            a = [];
        o.push(t.getAttribute("data-price")), a.push(t.getAttribute("data-image")), i.push(t.getAttribute("data-name")), (n.productPrices = o), (n.productNames = i), (n.productImages = a), console.log(n), O(n);
        var l = S(e);
        B.setAttribute("src", l);
    }
    var O = function (e) {
        (C.style.display = "block"), C.classList.remove("hide");
        var o = ["1"];
        maxLoopList = e.productNames.length;
        var a = [];
        for (i = 0; i < maxLoopList; i++) {
            var l = { name: e.productNames[i], image: e.productImages[i], quantity: o[i], price: e.productPrices[i] };
            a.push(l);
        }
        var s = { products: a, domain: b, merchantLogo: t.logo, productProperty: "" },
            r = q("POST", g + "api/v1/order-temporary/store", JSON.stringify(s));
        r && (n = r.token);
    };
    function q(t, e, n, i = !1) {
        var o = new XMLHttpRequest();
        o.open(t, e, i);
        var a = null;
        try {
            o.setRequestHeader("Content-Type", "application/json"), o.send(n), (a = o.response), (a = JSON.parse(a)), console.log(a);
        } catch (t) {
            console.log("Request failed"), console.log(t);
        }
        return a;
    }
    function S(t = "") {
        return c + t + "?token=" + n;
    }
    function G() {
        var t = document.getElementsByTagName("body")[0],
            e = t.offsetWidth;
        (t.style.overflow = "hidden"), (t.style.width = e);
    }
    function P() {
        var t = document.getElementsByTagName("body")[0];
        (t.style.overflow = "auto"), (t.style.width = "auto");
    }
    function V(t) {
        return (
            (price = t.replace("VNÄ", "")),
                (price = t.replace("VND", "")),
                (price = t.replace(/[\[\]&]+/g, "")),
                (price = t.split(".").join("")),
                (price = price.split(",").join("")),
                (price = price.split(" ").join("")),
                (price = t.replace(/[^0-9]/g, "")),
                (price = parseInt(price, 10)),
                price
        );
    }
    function U() {
        var t = 0,
            e = document.getElementsByClassName("bk-product-price"),
            n = document.getElementsByClassName("bk-product-qty"),
            o = e.length;
        for (console.log("length: " + o), i = 0; i < o; i++) {
            V(e[i].innerHTML);
            var a = 1;
            n[i] && (a = n[i].value), (t += (e[i].firstElementChild && e[i].firstElementChild.innerHTML.match(/\d+/g) ? V(e[i].firstElementChild.innerHTML) : V(e[i].innerHTML)) * a);
        }
        return t;
    }
    "undefined" != typeof meta && console.log(meta);
});
