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
      `Config HTTP ${response.status}`
    );
  }

  const config = await response.json();

  if (!config.server?.address) {
    throw new Error(
      "Server address is missing"
    );
  }

  if (
    !Number.isFinite(config.refresh) ||
    config.refresh < 1000
  ) {
    throw new Error(
      "Invalid refresh interval"
    );
  }

  return config;
}

async function fetchServerStatus() {
  const response = await fetch(
    `${STATUS_URL}?t=${Date.now()}`,
    {
      cache: "no-store"
    }
  );

  const text = await response.text();

  if (!response.ok) {
    throw new Error(
      `Status API HTTP ${response.status}: ${text}`
    );
  }

  let status;

  try {
    status = JSON.parse(text);
  } catch {
    throw new Error(
      `Status API returned invalid JSON: ${text}`
    );
  }

  if (typeof status.online !== "boolean") {
    throw new Error(
      "Status API returned invalid online value"
    );
  }

  return status;
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
    console.error(
      "Server status elements not found"
    );

    return;
  }

  const online = status.online === true;

  stateElement.textContent = online
    ? "ONLINE"
    : "OFFLINE";

  playerCountElement.textContent = online
    ? String(status.players?.online ?? 0)
    : "0";

  playerMaxElement.textContent = online
    ? String(status.players?.max ?? 0)
    : "0";

  ipElement.textContent = address;
}

function renderServerError(address) {
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

  if (stateElement) {
    stateElement.textContent = "ERROR";
  }

  if (playerCountElement) {
    playerCountElement.textContent = "—";
  }

  if (playerMaxElement) {
    playerMaxElement.textContent = "—";
  }

  if (ipElement) {
    ipElement.textContent = address;
  }
}

async function updateServerStatus(address) {
  try {
    const status = await fetchServerStatus();

    console.log(
      "Server status:",
      status
    );

    renderServerStatus(
      status,
      address
    );
  } catch (error) {
    console.error(
      "Server status API:",
      error
    );

    renderServerError(
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