document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".btn-iframe-click");
  const iframe = document.getElementById("mainFrame");

  function updateActiveButton(selectedSrc) {
    buttons.forEach((btn) => {
      btn.classList.toggle(
        "active",
        btn.getAttribute("data-src") === selectedSrc
      );
    });
  }
  function setFrame(src, forceUpdate = false) {
    if (forceUpdate || iframe.src !== src) {
      iframe.src = src;
      localStorage.setItem("selectedFrameSrc", src);
    }
    updateActiveButton(src);
  }

  const savedSrc = localStorage.getItem("selectedFrameSrc") || "dashboard.php";
  setFrame(savedSrc, true);

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      setFrame(this.getAttribute("data-src"));
    });
  });

  function handleResize() {
    const currentSrc =
      localStorage.getItem("selectedFrameSrc") || "dashboard.php";
    if (iframe.src !== currentSrc) {
      setFrame(currentSrc);
    }
  }

  window.addEventListener("resize", handleResize);
  handleResize();
});
