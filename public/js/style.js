if (!CSS.supports("selector(:has(*))")) {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("table.bordered").forEach(table => {
      const hasTfoot = table.querySelector("tfoot");
      const hasTbody = table.querySelector("tbody");
      let rows = [];

      if (!hasTfoot && hasTbody) {
        rows = table.querySelectorAll("tbody tr");
      } else if (!hasTfoot && !hasTbody) {
        rows = table.querySelectorAll("tr");
      }

      if (rows.length) {
        rows[rows.length - 1].classList.add("last-row");
      }
    });
  });
}