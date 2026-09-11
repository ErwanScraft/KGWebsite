const DEFAULT_STATUS = {
  state: "ONLINE",
  players: 127,
  maxPlayers: 500,
  ip: "play.kgsmp.net"
};

export function initServerStatus(config = DEFAULT_STATUS) {
  document.querySelectorAll("[data-server-state]").forEach((element) => {
    element.textContent = config.state;
  });

  document.querySelectorAll("[data-player-count]").forEach((element) => {
    element.textContent = config.players;
  });

  document.querySelectorAll("[data-server-ip]").forEach((element) => {
    element.textContent = config.ip;
  });
}
