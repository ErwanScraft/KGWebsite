import { initNavigation } from "./modules/navigation.js";
import { initServerStatus } from "./modules/server.js";
import { initClipboard } from "./modules/clipboard.js";
import { initFaq } from "./modules/faq.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavigation();
  initServerStatus();
  initClipboard();
  initFaq();
});
