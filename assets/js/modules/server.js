const CONFIG_URL = "../../data/server.json";

const DEFAULT_STATUS = {
  state: "OFFLINE",
  players: 0,
  maxPlayers: 0,
  ip: "—"
};

async function loadConfig() {
  const response = await fetch(CONFIG_URL, {
    cache: "no-store"
  });

  if (!response.ok) {
    throw new Error(`Failed to load server config: ${response.status}`);
  }

  return response.json();
}

async function fetchServerStatus(config) {
  const controller = new AbortController();
  const timeout = setTimeout(
    () => controller.abort(),
    config.api.timeout
  );

  try {
    const endpoint =
      `${config.api.baseUrl}/${encodeURIComponent(config.server.address)}`;

    const response = await fetch(endpoint, {
      signal: controller.signal,
      cache: "no-store"
    });

    if (!response.ok) {
      throw new Error(`API request failed: ${response.status}`);
    }

    return await response.json();
  } finally {
    clearTimeout(timeout);
  }
}

function renderServerStatus(status, fallbackAddress) {
  const online = status.online === true;

  const state = online ? "ONLINE" : "OFFLINE";
  const players = online ? (status.players?.online ?? 0) : 0;
  const maxPlayers = online ? (status.players?.max ?? 0) : 0;

  document.querySelectorAll("[data-server-state]").forEach((element) => {
    element.textContent = state;
  });

  document.querySelectorAll("[data-player-count]").forEach((element) => {
    element.textContent = players;
  });

  document.querySelectorAll("[data-player-max]").forEach((element) => {
    element.textContent = maxPlayers;
  });

  document.querySelectorAll("[data-server-ip]").forEach((element) => {
    element.textContent =
      status.hostname ||
      fallbackAddress;
  });
}

export async function initServerStatus() {
  try {
    const config = await loadConfig();
    const status = await fetchServerStatus(config);

    renderServerStatus(
      status,
      config.server.address
    );

    setTimeout(
      initServerStatus,
      config.refresh
    );
  } catch (error) {
    console.error("Server status:", error);

    renderServerStatus(
      DEFAULT_STATUS,
      DEFAULT_STATUS.ip
    );
  }
}