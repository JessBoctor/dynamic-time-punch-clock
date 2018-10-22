var summary_updated, document_ready, calendar_ready;
summary_updated = document_ready = calendar_ready = 0;
var df_date = new Date,
    weekday = new Array(7);
weekday[0] = "Sun", weekday[1] = "Mon", weekday[2] = "Tue", weekday[3] = "Wed", weekday[4] = "Thu", weekday[5] = "Fri", weekday[6] = "Sat";
var pay_sum, pay_bonus, lock_period, month = new Array(12);

function set_opacity(e) {
    document.getElementById("dyt_form") && (document.getElementById("dyt_form").style.opacity = e), document.getElementById("dyt_nav") && (document.getElementById("dyt_nav").style.opacity = e), document.getElementById("dyt_cal") && (document.getElementById("dyt_cal").style.opacity = e)
}

function show_save(e) {
    var t = document.getElementById("input_saved"),
        d = document.getElementById("dyt_form");
    if (0 != e) {
        if (set_opacity(.3), -1 == e) return void d.submit();
        if (t.style.opacity = 1, t.style.display = "block", -3 == e && (t.innerHTML = "Dynamic Time<br>&#9888; Setup Incomplete<br><br><input type='submit' onclick='window.location.href=setup_path' value='Settings'>"), -2 == e) return t.innerHTML = "Submitting...<br><progress></progress>", void d.submit();
        1 == e && (t.innerHTML = "Saved"), 2 == e && (t.innerHTML = "Sent")
    } else t.style.opacity = 0, setTimeout(function() {
        t.style.display = "none"
    }, 200)
}

function add_week(e) {
    0 < input_saved && 0 == document_ready && show_save(input_saved), document.getElementById("Reg").value = "", document.getElementById("PTO").value = "", document.getElementById("OT").value = "", document.getElementById("Bonus").value = "", document.getElementById("period_note").value = "", document.getElementById("TOT").value = "", document.getElementById("TOTamt").value = "", period_days = period, null !== localStorage.getItem("df_date") && (df_date = new Date(parseInt(localStorage.getItem("df_date")))), (period <= 7 || 14 == period && .1 == Math.abs(e)) && (e < 0 && df_date.setTime(df_date.getTime() - 6048e5), 0 < e && df_date.setTime(df_date.getTime() + 6912e5)), 14 == period && .1 != Math.abs(e) && (e < 0 && df_date.setTime(df_date.getTime() - 12096e5), 0 < e && df_date.setTime(df_date.getTime() + 12096e5)), 15 == period && (e < 0 && df_date.setTime(df_date.getTime() - 12096e5), 0 < e && df_date.setTime(df_date.getTime() + 14688e5)), 30 == period && (e < 0 && df_date.setTime(df_date.getTime() - 24192e5), 0 < e && df_date.setTime(df_date.getTime() + 27648e5));
    var t = 0;
    if (period <= 14)
        for (var d = df_date.getDay(); d != weekbegin;) df_date.setDate(df_date.getDate() - 1), d = df_date.getDay();
    if (15 == period) {
        for (; 15 != df_date.getDate() && 1 != df_date.getDate();) df_date.setDate(df_date.getDate() - 1);
        15 == df_date.getDate() && (thismonth = new Date(df_date.getFullYear(), df_date.getMonth() + 1, 0), period_days = thismonth.getDate() - 15, t = 1)
    }
    30 == period && (df_date.setDate(1), thismonth = new Date(df_date.getFullYear(), df_date.getMonth() + 1, 0), period_days = thismonth.getDate()), 0 < summary_updated && (set_opacity(.3), document.getElementById("dyt_save").click());
    var n = new Date(df_date),
        a = Math.floor(n.getTime() / 864e5);
    n.setDate(n.getDate() + t);
    for (var o = document.createElement("week"), i = document.getElementById("period_disp"), m = 0, s = 1, l = begin_day = end_day = "", r = -2; m < period_days;) wk_day = weekday[n.getDay()],month_name = month[n.getMonth()],0 === m ? (begin_day = month_name + " " + n.getDate(),l = parseInt(n.getTime() / 864e5)) : m > period_days - 2 && (end_day = month_name + " " + n.getDate(),i.innerHTML = "<span style='cursor:pointer'><span title='Previous' onclick='add_week(-.1);'>" + begin_day + "</span> - <span title='Next' onclick='add_week(.1);'>" + end_day + "</span></span>"),weekbegin == weekday.indexOf(wk_day) ? (s++, wk_break = "<br>") : wk_break = "",wk_class = s % 2 == 0 ? "dyt_light" : "dyt_dark",a = Math.floor(n.getTime() / 864e5),day_name = "<div class='dyt_dayname'>" + wk_day + "</div>",wk_date_string = "<div class='dyt_datename'>" + month_name + " " + n.getDate() + ", " + n.getFullYear() + "</div>",input_day = "<div id='day" + a + "' class='dyt_day " + wk_class + "'>",input_row = "<div id='row" + a + "' class='dyt_row'>",day_date = "<input name='date[]' type='hidden' value='" + a + "'>",day_hrs = "<input name='hours[]' readonly id='ttot" + a + "' onfocusin='show_time(this.id,this.parentNode.id);' class='dyt_hours' type='number' step='.01' min='0' max='24' onchange='sum_time(this.parentNode.id,-2); sumrows();'>",day_type = "<select name='hourtype[]' class='dyt_hourtype' onchange='summary_updated=1; sumrows();'><option selected value='Reg'>Reg<option value='PTO'>PTO</select>",time_div = "<div id='tdiv" + a + "' class='dyt_pop noprint'>",prompt < 1 && (time_div += "<div style='display:none'>"),time_div = time_div + "<a class='punch' title='click to punch in' id='pcin" + a + "' onclick='punch(this.id);'>in</a><input type='time' title='in' name='time_in[]' id='tmin" + a + "' value='09:00:00' step='60' onchange='sum_time(this.id,0);'>",time_div += "<a class='stepup' onclick=\"step('up',this.previousSibling.id)\"></a><a class='stepdown' onclick=\"step('down',this.previousSibling.previousSibling.id)\"></a><br>",time_div = time_div + "<a class='punch' title='click to punch out' id='pout" + a + "' onclick='punch(this.id);'>out</a><input type='time' title='out' name='time_out[]' id='tout" + a + "' value='17:00:00' step='60' onchange='sum_time(this.id,0);'>",time_div += "<a class='stepup' onclick=\"step('up',this.previousSibling.id)\"></a><a class='stepdown' onclick=\"step('down',this.previousSibling.previousSibling.id)\"></a><br>",prompt < 1 && (time_div += "</div>"),time_div += "<span class='punch' id='siteid" + a + "'>Site</span><input type='number' name='site[]' id='tsite" + a + "'></input><br><input type='text' name='sitename[]' class='entry-desc' readonly></input><br>",time_div += "<span class='punch' id='postid" + a + "'>Post</span><input type='number' name='post[]' id='tpost" + a + "'></input><br><input type='text' name='postname[]' class='entry-desc' readonly></input><br>",time_div += "<textarea ", notes < 1 && (time_div += " style='display:none' "),time_div = time_div + "name='note[]' id='tnote" + a + "' placeholder='note' onchange='summary_updated=1;'></textarea><br>", prompt < 1 && (time_div += "<div style='display:none'>"), time_div = time_div + "<input type='button' id='tclr" + a + "' value='Clear' onclick='sum_time(this.id,-3);'>", time_div = time_div + "<input type='button' id='trst" + a + "' value='Default' onclick='sum_time(this.id,-1);'>", prompt < 1 && (time_div += "</div>"), time_div = time_div + "<input type='button' id='toky" + a + "' value='OK' onclick='sum_time(this.id,1);'></div>", p = "<a class='dyt_delete dyt_hide' onclick=\"delrow('" + a + "');\">&#10008;</a>", y = "<a class='dyt_add ' onclick=\"addrow('" + a + "',0);\">&#10010;</a></div>", o.innerHTML = o.innerHTML + wk_break + input_day + day_name + wk_date_string + input_row + day_date + day_hrs + day_type + time_div + p + y + "</div>", n.setDate(n.getDate() + 1), (0 <= (r = period_end.indexOf(a.toString())) || 0 == m) && set_period(r), m++;
    document.getElementById("dyt_send") && (document.getElementById("dyt_approve") || l + period / 2 < parseInt(Date.now() / 864e5) ? document.getElementById("dyt_send").classList.remove("pre_lock_btn") : document.getElementById("dyt_send").classList.add("pre_lock_btn")), "<br>" == o.innerHTML.substring(0, 4) && (o.innerHTML = o.innerHTML.substring(4, 99999));
    var u = document.getElementById("dyt_cal");

    function y(e) {
        return !1
    }

    function p(e) {
        return !1
    }
    set_opacity(.3), setTimeout(function() {
        u.innerHTML = o.innerHTML
    }, 200), window.localStorage.df_date = df_date.getTime(), 1 == document_ready && setTimeout(function() {
        poprow()
    }, 700), calendar_ready = 1
}
month[0] = "Jan", month[1] = "Feb", month[2] = "Mar", month[3] = "Apr", month[4] = "May", month[5] = "Jun", month[6] = "Jul", month[7] = "Aug", month[8] = "Sep", month[9] = "Oct", month[10] = "Nov", month[11] = "Dec", pay_sum = pay_bonus = lock_period = 0;
var pay_rate = rate;

function set_period(e) {
    pay_bonus = 0;
    var t = document.getElementById("dyt_cal"),
        d = document.getElementById("dyt_sum");
    if (e < 0 && pay_sum && (d.innerHTML = pay_sum, rate = pay_rate, t.classList.remove("lock"), lock_period = 0), !(e < 0)) {
        pay_sum || (pay_sum = document.getElementById("dyt_sum").innerHTML), pay_rate || (pay_rate = rate), 0 < period_rate[e] && (rate = period_rate[e]), period_bonus[e] && (pay_bonus = period_bonus[e]), period_note[e] && (document.getElementById("period_note").value = period_note[e]);
        var n = document.getElementById("Bonus"),
            a = (document.getElementById("period_note"), document.getElementById("dyt_save")),
            o = document.getElementById("dyt_send"),
            i = document.getElementById("dyt_approve"),
            m = document.getElementById("dyt_process");
        submitted[e] && o && (o.classList.add("lock_btn"), o.value = "Submitted " + submitted[e], 0 < submitter[e].length && (o.value = o.value + " by " + submitter[e]), i && i.classList.remove("pre_lock_btn")), approved[e] && (lock_period = 1, t.classList.add("lock"), a.style.display = "none", i ? (i.classList.add("lock_btn"), i.value = "Approved " + approved[e] + " by " + approver[e], m && m.classList.remove("pre_lock_btn")) : o.value = "Approved " + approved[e] + " by " + approver[e]), processed[e] && m && (n.style.pointerEvents = "none", m.classList.add("lock_btn"), m.value = "Processed " + processed[e])
    }
}

function punch(e) {
    field = document.getElementById(e);
    var t = new Date,
        d = ("00" + t.getHours()).slice(-2) + ":" + ("00" + t.getMinutes()).slice(-2) + ":00";
    field.nextSibling.value = d, sum_time(e, 0), action.value = "save", show_save(-1), document.getElementById("dyt_form").submit()
}

function step(e, t) {
    var d = -15;
    "up" == e && (d *= -1), document.getElementById(t).stepUp(d), sum_time(t, 0)
}

function show_time(e, t) {
    if (0 == prompt && 1 != lock_period && document.getElementById(e) && (document.getElementById(e).readOnly = !1), !(prompt + notes < 1))
        for (times = document.getElementsByClassName("dyt_pop"), i = 0; i < times.length; i++) times[i].parentNode.id == t ? times[i].style.display = "block" : times[i].style.display = "none"
}

function sum_time(e, t) {
    e = e.replace(/([a-zA-Z ])/g, "");
    var d = document.getElementById("row" + e);
    row_content = d.childNodes, hours = row_content[1], 0 < prompt && (-1 == t && (document.getElementById("tmin" + e).value = "09:00:00", document.getElementById("tout" + e).value = "17:00:00"), -3 == t && (document.getElementById("ttot" + e).value = "", document.getElementById("tmin" + e).value = "", document.getElementById("tout" + e).value = "", document.getElementById("tnote" + e).value = ""), 0 <= t && (tmin = document.getElementById("tmin" + e).value.split(":"), tout = document.getElementById("tout" + e).value.split(":"), parseFloat(tout[0]) < parseFloat(tmin[0]) ? time = 24 - parseFloat(tmin[0]) + parseFloat(tout[0]) : time = parseFloat(tout[0]) - parseFloat(tmin[0]), time = (parseFloat(time) + (parseFloat(tout[1]) / 60 - parseFloat(tmin[1]) / 60)).toFixed(2), 0 < time && (hours.value = time))), 0 == hours.value.length && (hours.style.backgroundColor = "#FFF"), summary_updated = 1, sumrows(), 0 < t && (document.getElementById("tdiv" + e).style.display = "none")
}

function addrow(e, t) {
	console.log( 'We found the pop row!' );
	console.log( e );
	console.log( t );
    if (show_time(0, 0), document.getElementById("day" + e)) {
        var d = document.getElementById("day" + e),
            n = document.getElementById("row" + e),
            a = Math.floor(1e3 * Math.random() + 1),
            o = document.createElement("div");
        o.setAttribute("id", "row" + e + a), o.setAttribute("class", "dyt_row"), o.style.opacity = "0", o.innerHTML = n.innerHTML.replace("'" + e + "'", "'" + e + a + "'"), o.innerHTML = o.innerHTML.replace("ttot" + e, "ttot" + e + a), o.innerHTML = o.innerHTML.replace("tdiv" + e, "tdiv" + e + a), o.innerHTML = o.innerHTML.replace("dyt_delete dyt_hide", "dyt_delete"), o.innerHTML = o.innerHTML.replace("dyt_add ", "dyt_add dyt_hide"), d.appendChild(o), o.style.backgroundColor = "#0F0";
        var i = document.getElementById("tdiv" + e + a);
        i.innerHTML = i.innerHTML.replace(new RegExp(e, "g"), e + a), setTimeout(function() {
            o.style.opacity = "1"
        }, 10), setTimeout(function() {
            o.style.backgroundColor = "transparent"
        }, 200), 0 == t && show_time(0, "row" + e + a)
    }
}

function delrow(e) {
    if (document.getElementById("row" + e)) {
        var t = document.getElementById("row" + e);
        setTimeout(function() {
            t.style.backgroundColor = "#F00"
        }, 10), setTimeout(function() {
            t.style.opacity = "0"
        }, 200), setTimeout(function() {
            t.parentNode.removeChild(t)
        }, 500), setTimeout(function() {
            sumrows()
        }, 500)
    }
}

function sumrows() {
    var e, t, d, n, a, o, i, m, s, l, r, u, y, p;
    e = t = d = n = a = o = i = m = s = 0, l = r = u = y = p = "";
    var _, c, g = document.getElementById("Reg"),
        v = document.getElementById("PTO"),
        h = document.getElementById("pto_row"),
        f = document.getElementById("OT"),
        b = document.getElementById("ot_row"),
        w = document.getElementById("Bonus"),
        E = document.getElementById("TOT"),
        B = document.getElementById("TOTamt"),
        k = document.getElementsByName("hours[]"),
        T = document.getElementsByName("date[]"),
        I = rate,
        F = 0;
    if (exempt <= 0 && 15 <= period) {
        var M = parseInt(T[0].value),
            x = new Date(864e5 * M);
        for (c = weekday[x.getDay()]; weekbegin != weekday.indexOf(c);) c = weekday[x.getDay()], x.setDate(x.getDate() - 1);
        for (x /= 864e5; db_date[F] < x;) F++;
        if (M - 7 < x)
            for (; db_date[F] < M;) "Reg" == db_hourtype[F] && (m = parseFloat(db_hours[F]), db_date[F + 1] ? next_entry = db_date[F + 1] : next_entry = db_date[F] + 1, db_date[F] == next_entry ? s += m : (m += s, s = 0), 0 == s && (i = exempt < 0 && 8 < m ? 8 : parseFloat(m), a = (parseFloat(a) + i).toFixed(2))), F++, x++;
        i = m = s = 0
    }
    for (F = 0; F < T.length;) 0 < k[F].value && (k[F].style.backgroundColor = "#555", k[F].style.color = "#FFF", m = parseFloat(k[F].value), p = k[F].nextSibling.value, next_entry = 0, exempt <= 0 && "Reg" == p && (T[F + 1] && (next_entry = T[F + 1].value), T[F].value == next_entry && "Reg" == k[F + 1].nextSibling.value ? s += m : (m += s, s = 0)), 0 == s && ("Reg" == p && (i = exempt < 0 && 8 < m ? parseFloat(m) - 8 : 0, exempt < 0 && (n = (parseFloat(n) + i).toFixed(2)), exempt <= 0 && (a = (parseFloat(a) + m - i).toFixed(2))), exempt < 0 && 0 < n && (d = (parseFloat(d) + parseFloat(n)).toFixed(2), n = 0), "Reg" == p && (e = (parseFloat(e) + m).toFixed(2)), "PTO" == p && (t = (parseFloat(t) + m).toFixed(2)), o = (parseFloat(o) + m).toFixed(2))), 0 == s && exempt <= 0 && (_ = (c = new Date(864e5 * (parseInt(T[F].value) + 2))).getDay(), weekbegin != _ && T[F + 1] || (40 < a && (d = (parseFloat(d) + (parseFloat(a) - 40)).toFixed(2)), a = 0)), F++;
    0 < (e = (parseFloat(e) - parseFloat(d)).toFixed(2)) && (l = 1 < e ? " hrs" : " hr"), 0 < t ? (r = 1 < t ? " hrs" : " hr", h.style.display = "table-row") : h.style.display = "none", 0 < d ? (u = 1 < d ? " hrs" : " hr", b.style.display = "table-row") : b.style.display = "none", 0 < o && (y = 1 < o ? " hrs" : " hr"), g.value = e + l, v.value = t + r, f.value = d + u, E.value = o + y, w.value = 0 < pay_bonus ? currency + pay_bonus : 0, 0 < I && (B.value = (parseFloat(o) * parseFloat(I)).toFixed(2), B.value = currency + (parseFloat(B.value) + parseFloat(pay_bonus) + parseFloat(d) * (1.5 * parseFloat(I))).toFixed(2)), 0 === summary_updated && set_opacity(1), show_save(0)
}

function poprow() {
    var e, t = document.getElementsByName("date[]"),
        d = document.getElementsByName("hours[]"),
        n = document.getElementsByName("hourtype[]"),
        a = document.getElementsByName("time_in[]"),
        o = document.getElementsByName("time_out[]"),
        sid = document.getElementsByName("site[]"),
        sname = document.getElementsByName("sitename[]"), 
        pid = document.getElementsByName("post[]"),
        pname = document.getElementsByName("postname[]"),
        m = document.getElementsByName("note[]");
    for (e = 0; e < db_date.length; e++) {
        var s;
        for (s = 0; s < t.length; s++) db_date[e] == t[s].value && "" == d[s].value ? (d[s].value = db_hours[e], n[s].value = db_hourtype[e], a[s].value = db_time_in[e], o[s].value = db_time_out[e], sid[s].value = db_site_id[e], sname[s].value = db_site_name[e], pid[s].value = db_post_id[e], pname[s].value = db_post_name[e], m[s].value = db_note[e]) : db_date[e] == t[s].value && (s++, addrow(db_date[e], 1), t = document.getElementsByName("date[]"), d = document.getElementsByName("hours[]"), n = document.getElementsByName("hourtype[]"), a = document.getElementsByName("time_in[]"), o = document.getElementsByName("time_out[]"), sid = document.getElementsByName("site[]"), sname = document.getElementsByName("sitename[]"), pid = document.getElementsByName("post[]"), pname = document.getElementsByName("postname[]"), m = document.getElementsByName("note[]"), "" == d[s].value && (d[s].value = db_hours[e], n[s].value = db_hourtype[e], a[s].value = db_time_in[e], o[s].value = db_time_out[e], sid[s].value = db_site_id[e], sname[s].value = db_site_name[e], pid[s].value = db_post_id[e], pname[s].value = db_post_name[e], m[s].value = db_note[e]))
    }
    for (del = document.getElementsByClassName("dyt_delete"), i = 0; i < del.length; i++) rowhours = del[i].previousSibling.previousSibling, 0 == rowhours.value && 8 < del[i].parentElement.id.length && (delrow = del[i].parentElement).parentNode.removeChild(delrow);
    sumrows(), summary_updated = 0
}

function dyt_load() {
    if (input_saved <= -3) return show_save(input_saved), !1;
    setTimeout(function() {
        add_week(0)
    }, 100);
    var e = setInterval(function() {
        1 == calendar_ready && (clearInterval(e), setTimeout(function() {
            document_ready = 1, poprow()
        }, 500))
    }, 200)
}// JavaScript Document