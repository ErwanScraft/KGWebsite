import { initNavigation } from "./modules/navigation.js";
import { initServerStatus } from "./modules/server.js";
import { initClipboard } from "./modules/clipboard.js";
import { initFaq } from "./modules/faq.js";
import { initChat } from "./modules/chat.js";
import { initShowcase } from "./modules/showcase.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavigation();
  initServerStatus();
  initClipboard();
  initFaq();
  initChat();
  initShowcase();
});
