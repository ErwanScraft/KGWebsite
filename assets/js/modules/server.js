const CONFIG_URL = "assets/data/server.json";
const STATUS_URL = "api/server-status.php";

const DEFAULT_STATUS = {
  online: false,
  players: {
    online: 0,
    max: 0
  }
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

  return response.json();
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

  return response.json();
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

  const online = status.online === true;

  stateElement.textContent = online
    ? "ONLINE"
    : "OFFLINE";

  playerCountElement.textContent =
    online
      ? status.players?.online ?? 0
      : 0;

  playerMaxElement.textContent =
    online
      ? status.players?.max ?? 0
      : 0;

  ipElement.textContent = address;
}

async function updateServerStatus(address) {
  try {
    const status = await fetchServerStatus();

    renderServerStatus(
      status,
      address
    );
  } catch (error) {
    console.error("Server status:", error);

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