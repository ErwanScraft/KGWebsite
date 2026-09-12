const CHAT_URL = "api/chat/messages.php";
const POLL_INTERVAL = 2000;
const MAX_MESSAGES = 30;

let lastMessageId = 0;
let pollTimer = null;

function createMessageElement(message) {
  const article = document.createElement("article");

  article.className = "live-chat-message";

  const header = document.createElement("div");

  header.className = "live-chat-message-header";

  const player = document.createElement("strong");

  player.textContent = message.player_name;

  const time = document.createElement("time");

  time.dateTime = message.created_at;
  time.textContent = formatTime(message.created_at);

  const text = document.createElement("p");

  text.textContent = message.message;

  header.append(player, time);
  article.append(header, text);

  return article;
}

function formatTime(value) {
  const date = new Date(value);

  if (Number.isNaN(date.getTime())) {
    return "";
  }

  return date.toLocaleTimeString("id-ID", {
    hour: "2-digit",
    minute: "2-digit",
  });
}

function renderMessages(messages) {
  const container = document.querySelector(
    "[data-chat-messages]"
  );

  const empty = document.querySelector(
    "[data-chat-empty]"
  );

  if (!container) {
    return;
  }

  if (messages.length === 0) {
    if (empty) {
      empty.hidden = false;
    }

    return;
  }

  if (empty) {
    empty.remove();
  }

  for (const message of messages) {
    container.append(
      createMessageElement(message)
    );

    lastMessageId = Math.max(
      lastMessageId,
      Number(message.id)
    );
  }

  while (
    container.children.length > MAX_MESSAGES
  ) {
    container.firstElementChild.remove();
  }

  container.scrollTop = container.scrollHeight;
}

async function loadMessages() {
  const status = document.querySelector(
    "[data-chat-status]"
  );

  try {
    const response = await fetch(
      `${CHAT_URL}?after=${lastMessageId}`,
      {
        cache: "no-store",
      }
    );

    if (!response.ok) {
      throw new Error(
        `HTTP ${response.status}`
      );
    }

    const data = await response.json();

    renderMessages(
      Array.isArray(data.messages)
        ? data.messages
        : []
    );

    if (status) {
      status.textContent = "TERHUBUNG";
    }
  } catch (error) {
    console.error("Live chat:", error);

    if (status) {
      status.textContent = "TERPUTUS";
    }
  } finally {
    pollTimer = window.setTimeout(
      loadMessages,
      POLL_INTERVAL
    );
  }
}

export function initChat() {
  loadMessages();
}