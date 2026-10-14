(function () {
  var button = document.querySelector(".am-nav-toggle");
  var nav = document.getElementById("am-nav");
  var backdrop = document.querySelector(".am-nav-backdrop");
  if (!button || !nav) return;

  function setOpen(open) {
    nav.classList.toggle("is-open", open);
    document.body.classList.toggle("am-nav-open", open);
    button.setAttribute("aria-expanded", open ? "true" : "false");
    button.setAttribute("aria-label", open ? "סגירת תפריט" : "פתיחת תפריט");
    if (backdrop) backdrop.hidden = !open;
  }

  button.addEventListener("click", function () {
    setOpen(button.getAttribute("aria-expanded") !== "true");
  });
  nav.addEventListener("click", function (event) {
    if (event.target.closest("a")) setOpen(false);
  });
  if (backdrop) {
    backdrop.addEventListener("click", function () {
      setOpen(false);
    });
  }
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && button.getAttribute("aria-expanded") === "true") {
      setOpen(false);
      button.focus();
    }
  });
})();

(function () {
  var menu = document.querySelector("#am-nav .am-menu");
  if (!menu) return;
  var parents = menu.querySelectorAll(":scope > .menu-item-has-children");
  if (!parents.length) return;
  menu.classList.add("has-toggles");
  Array.prototype.forEach.call(parents, function (li, i) {
    var link = li.querySelector(":scope > a");
    var sub = li.querySelector(":scope > .sub-menu");
    if (!link || !sub) return;
    sub.id = sub.id || "am-sub-" + i;
    var toggle = document.createElement("button");
    toggle.type = "button";
    toggle.className = "am-sub-toggle";
    toggle.setAttribute("aria-expanded", "false");
    toggle.setAttribute("aria-controls", sub.id);
    toggle.setAttribute("aria-label", "תת־תפריט: " + link.textContent.trim());
    li.insertBefore(toggle, sub);
    toggle.addEventListener("click", function () {
      var open = toggle.getAttribute("aria-expanded") !== "true";
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      li.classList.toggle("is-expanded", open);
    });
  });
})();

(function () {
  var bar = document.querySelector(".am-mobile-cta");
  if (!bar) return;
  var threshold = 160;
  var mq = window.matchMedia("(max-width: 980px)");

  function sync() {
    var show = mq.matches && window.scrollY > threshold;
    bar.classList.toggle("is-visible", show);
    if (show) bar.removeAttribute("inert");
    else bar.setAttribute("inert", "");
  }

  window.addEventListener("scroll", sync, { passive: true });
  if (mq.addEventListener) mq.addEventListener("change", sync);
  else if (mq.addListener) mq.addListener(sync);
  sync();
})();

(function () {
  var root = document.querySelector(".am-letters");
  if (!root) return;
  var track = root.querySelector(".am-letters-track");
  var notes = track ? Array.prototype.slice.call(track.querySelectorAll(".am-note")) : [];
  var dots = Array.prototype.slice.call(root.querySelectorAll(".am-letters-dots button"));
  var prev = root.querySelector('.am-letters-btn[data-dir="-1"]');
  var next = root.querySelector('.am-letters-btn[data-dir="1"]');
  if (!track || !notes.length) return;

  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)");
  var current = 0;
  var animating = false;

  function nearest() {
    var box = track.getBoundingClientRect();
    var mid = box.left + box.width / 2;
    var best = 0;
    var bestDist = Infinity;
    notes.forEach(function (note, i) {
      var noteBox = note.getBoundingClientRect();
      var dist = Math.abs(noteBox.left + noteBox.width / 2 - mid);
      if (dist < bestDist) {
        bestDist = dist;
        best = i;
      }
    });
    return best;
  }

  function paint(index) {
    dots.forEach(function (dot, n) {
      if (n === index) dot.setAttribute("aria-current", "true");
      else dot.removeAttribute("aria-current");
    });
    if (prev) prev.disabled = index <= 0;
    if (next) next.disabled = index >= notes.length - 1;
  }

  function align(index, immediate) {
    var note = notes[index];
    if (!note) return;
    var trackBox = track.getBoundingClientRect();
    var noteBox = note.getBoundingClientRect();
    var delta = (noteBox.left + noteBox.width / 2) - (trackBox.left + trackBox.width / 2);
    track.scrollBy({ left: delta, behavior: immediate || reduce.matches ? "auto" : "smooth" });
  }

  function go(index) {
    current = Math.max(0, Math.min(notes.length - 1, index));
    animating = true;
    align(current);
    paint(current);
    window.setTimeout(function () {
      animating = false;
      current = nearest();
      paint(current);
    }, reduce.matches ? 0 : 480);
  }

  root.addEventListener("click", function (event) {
    var btn = event.target.closest(".am-letters-btn");
    if (btn && !btn.disabled) {
      go(current + Number(btn.getAttribute("data-dir") || 0));
      return;
    }
    var dot = event.target.closest(".am-letters-dots button");
    if (!dot) return;
    var index = dots.indexOf(dot);
    if (index >= 0) go(index);
  });

  root.addEventListener("keydown", function (event) {
    var inCarousel = event.target.closest(".am-letters-track, .am-letters-navs, .am-letters-dots");
    if (!inCarousel) return;
    if (event.key === "ArrowLeft") go(current + 1);
    else if (event.key === "ArrowRight") go(current - 1);
    else if (event.key === "Home") go(0);
    else if (event.key === "End") go(notes.length - 1);
    else return;
    event.preventDefault();
  });

  track.addEventListener("scroll", function () {
    if (animating) return;
    current = nearest();
    paint(current);
  }, { passive: true });

  current = 0;
  align(0, true);
  paint(current);
})();

(function () {
  var links = document.querySelectorAll("a[data-lightbox]");
  if (!links.length) return;
  var box = document.createElement("div");
  box.className = "am-lightbox";
  box.setAttribute("role", "dialog");
  box.setAttribute("aria-modal", "true");
  box.setAttribute("aria-label", "תצוגת תעודה");
  box.innerHTML = '<button class="am-lightbox-close" type="button" aria-label="סגירה">×</button><figure><img alt=""><figcaption></figcaption></figure>';
  document.body.appendChild(box);
  var img = box.querySelector("img");
  var caption = box.querySelector("figcaption");
  var closeBtn = box.querySelector(".am-lightbox-close");
  var opener = null;

  function close() {
    box.classList.remove("is-open");
    document.body.classList.remove("am-lightbox-open");
    img.removeAttribute("src");
    if (opener) opener.focus();
  }

  Array.prototype.forEach.call(links, function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      opener = link;
      var thumb = link.querySelector("img");
      img.src = link.getAttribute("href");
      img.width = Number(link.getAttribute("data-w")) || 0;
      img.height = Number(link.getAttribute("data-h")) || 0;
      img.alt = thumb ? thumb.alt : "";
      caption.textContent = link.getAttribute("data-caption") || "";
      box.classList.add("is-open");
      document.body.classList.add("am-lightbox-open");
      closeBtn.focus();
    });
  });

  box.addEventListener("click", function (event) {
    if (event.target === box || event.target === closeBtn) close();
  });
  document.addEventListener("keydown", function (event) {
    if (!box.classList.contains("is-open")) return;
    if (event.key === "Escape") close();
    if (event.key === "Tab") {
      event.preventDefault();
      closeBtn.focus();
    }
  });
})();
