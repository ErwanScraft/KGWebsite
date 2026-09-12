const CONFIG_URL = "../../data/server.json";
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
  const online = status.online === true;

  const players = online
    ? status.players?.online ?? 0
    : 0;

  const maxPlayers = online
    ? status.players?.max ?? 0
    : 0;

  document.querySelectorAll("[data-server-state]").forEach(
    (element) => {
      element.textContent = online
        ? "ONLINE"
        : "OFFLINE";
    }
  );

  document.querySelectorAll("[data-player-count]").forEach(
    (element) => {
      element.textContent = players;
    }
  );

  document.querySelectorAll("[data-player-max]").forEach(
    (element) => {
      element.textContent = maxPlayers;
    }
  );

  document.querySelectorAll("[data-server-ip]").forEach(
    (element) => {
      element.textContent = address;
    }
  );
}

async function updateServerStatus(config) {
  try {
    const status = await fetchServerStatus();

    renderServerStatus(
      status,
      config.server.address
    );
  } catch (error) {
    console.error("Server status:", error);

    renderServerStatus(
      DEFAULT_STATUS,
      config.server.address
    );
  }
}

export async function initServerStatus() {
  try {
    const config = await loadConfig();

    await updateServerStatus(config);

    setInterval(
      () => updateServerStatus(config),
      config.refresh
    );
  } catch (error) {
    console.error("Server configuration:", error);
  }
}