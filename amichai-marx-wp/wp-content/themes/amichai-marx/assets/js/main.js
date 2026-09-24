(function () {
  var button = document.querySelector(".am-nav-toggle");
  var nav = document.getElementById("am-nav");
  if (!button || !nav) return;
  button.addEventListener("click", function () {
    var open = nav.classList.toggle("is-open");
    button.setAttribute("aria-expanded", open ? "true" : "false");
  });
})();
