const CONFIG_URL = "assets/data/server.json";
const STATUS_URL = "api/server-status.php";

const DEFAULT_STATUS = {
  online: false,
  players: {
    online: 0,
    max: 0
  },
  hostname: "",
  port: null,
  version: null,
  gamemode: null,
  motd: ""
};

async function loadConfig() {
  const response = await fetch(CONFIG_URL, {
    cache: "no-store"
  });

  if (!response.ok) {
    throw new Error(
      `Failed to load server config: ${response.status}`
    );
  }

  const config = await response.json();

  if (
    !config.server?.address ||
    !Number.isFinite(config.refresh) ||
    config.refresh < 1000
  ) {
    throw new Error(
      "Invalid server configuration"
    );
  }

  return config;
}

async function fetchServerStatus() {
  const response = await fetch(STATUS_URL, {
    cache: "no-store"
  });

  if (!response.ok) {
    throw new Error(
      `Server status request failed: ${response.status}`
    );
  }

  const status = await response.json();

  if (typeof status.online !== "boolean") {
    throw new Error(
      "Invalid server status response"
    );
  }

  return {
    ...DEFAULT_STATUS,
    ...status,

    players: {
      ...DEFAULT_STATUS.players,
      ...status.players
    }
  };
}

function renderServerStatus(status, address) {
  const stateElement = document.querySelector(
    "[data-server-state]"
  );

  const playerCountElement = document.querySelector(
    "[data-player-count]"
  );

  const playerMaxElement = document.querySelector(
    "[data-player-max]"
  );

  const ipElement = document.querySelector(
    "[data-server-ip]"
  );

  if (
    !stateElement ||
    !playerCountElement ||
    !playerMaxElement ||
    !ipElement
  ) {
    return;
  }

  const online = status.online === true;

  const players = online
    ? status.players.online
    : 0;

  const maxPlayers = online
    ? status.players.max
    : 0;

  stateElement.textContent = online
    ? "ONLINE"
    : "OFFLINE";

  playerCountElement.textContent =
    String(players);

  playerMaxElement.textContent =
    String(maxPlayers);

  ipElement.textContent =
    address;
}

async function updateServerStatus(address) {
  try {
    const status = await fetchServerStatus();

    renderServerStatus(
      status,
      address
    );
  } catch (error) {
    console.error(
      "Server status:",
      error
    );

    renderServerStatus(
      DEFAULT_STATUS,
      address
    );
  }
}

async function refreshServerStatus(config) {
  await updateServerStatus(
    config.server.address
  );

  setTimeout(
    () => refreshServerStatus(config),
    config.refresh
  );
}

export async function initServerStatus() {
  try {
    const config = await loadConfig();

    await refreshServerStatus(config);
  } catch (error) {
    console.error(
      "Server configuration:",
      error
    );
  }
}