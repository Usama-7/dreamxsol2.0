(function () {
  "use strict";

  document.addEventListener("click", function (e) {
    var toggle = e.target.closest(".dx-nav-toggle");
    if (toggle) {
      e.preventDefault();
      var nav = toggle.closest(".dx-nav");
      if (!nav) return;
      var open = nav.classList.toggle("dx-nav-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      return;
    }

    var ddTrigger = e.target.closest(".dx-dd > span");
    if (ddTrigger && window.innerWidth <= 768) {
      e.preventDefault();
      e.stopPropagation();
      var dd = ddTrigger.parentElement;
      dd.classList.toggle("dx-dd-open");
      return;
    }

    if (e.target.closest(".dx-nav-menu a")) {
      document.querySelectorAll(".dx-nav-open").forEach(function (nav) {
        nav.classList.remove("dx-nav-open");
        var t = nav.querySelector(".dx-nav-toggle");
        if (t) t.setAttribute("aria-expanded", "false");
      });
    }
  });

  window.addEventListener("resize", function () {
    if (window.innerWidth > 768) {
      document.querySelectorAll(".dx-nav-open").forEach(function (nav) {
        nav.classList.remove("dx-nav-open");
        var t = nav.querySelector(".dx-nav-toggle");
        if (t) t.setAttribute("aria-expanded", "false");
      });
      document.querySelectorAll(".dx-dd-open").forEach(function (dd) {
        dd.classList.remove("dx-dd-open");
      });
    }
  });
})();
