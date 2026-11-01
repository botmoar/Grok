function fbcCalc() {
  var g = function (id) {
    var el = document.getElementById(id);
    return el ? parseFloat(el.value) || 0 : 0;
  };
  var income = g("fbc-i1") + g("fbc-i2") + g("fbc-i3");
  var fixed = g("fbc-e1") + g("fbc-e2") + g("fbc-e3") + g("fbc-e4") + g("fbc-e5");
  var variable = g("fbc-v1") + g("fbc-v2") + g("fbc-v3") + g("fbc-v4") + g("fbc-v5");
  var out = fixed + variable;
  var balance = income - out;
  var pct = income > 0 ? Math.min(100, Math.round((out / income) * 100)) : 0;
  var fmt = function (n) {
    return "₪" + Math.round(n).toLocaleString("he-IL");
  };
  document.getElementById("fbc-total-in").textContent = fmt(income);
  document.getElementById("fbc-total-out").textContent = fmt(out);
  var bEl = document.getElementById("fbc-balance");
  bEl.textContent = fmt(balance);
  bEl.style.color = balance >= 0 ? "#0F6E56" : "#A32D2D";
  var bar = document.getElementById("fbc-bar");
  bar.style.width = pct + "%";
  bar.style.background = pct > 90 ? "#A32D2D" : pct > 75 ? "#BA7517" : "#0F6E56";
  document.getElementById("fbc-pct-lbl").textContent = pct + "% מההכנסות מוצאות";
  document.getElementById("fbc-save-lbl").textContent = balance >= 0 ? "חיסכון: " + fmt(balance) : "גירעון: " + fmt(Math.abs(balance));
}
document.addEventListener("DOMContentLoaded", fbcCalc);
