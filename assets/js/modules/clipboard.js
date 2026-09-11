export function initClipboard() {
  const button = document.querySelector("[data-copy-ip]");
  const ipElement = document.querySelector("[data-server-ip]");
  const feedback = document.querySelector("[data-copy-feedback]");

  if (!button || !ipElement) return;

  button.addEventListener("click", async () => {
    try {
      await navigator.clipboard.writeText(ipElement.textContent.trim());
      if (feedback) feedback.textContent = "IP copied.";
    } catch {
      if (feedback) feedback.textContent = "Copy failed.";
    }

    window.setTimeout(() => {
      if (feedback) feedback.textContent = "";
    }, 1800);
  });
}
