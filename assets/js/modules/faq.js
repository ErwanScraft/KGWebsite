export function initFaq() {
  const list = document.querySelector("[data-faq]");
  if (!list) return;

  list.querySelectorAll("details").forEach((item) => {
    item.addEventListener("toggle", () => {
      if (!item.open) return;
      list.querySelectorAll("details[open]").forEach((other) => {
        if (other !== item) other.open = false;
      });
    });
  });
}
