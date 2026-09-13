const API_URL = "api/showcase/posts.php";
const LIKE_URL = "api/showcase/like.php";

function escapeHtml(value) {
  const element = document.createElement("div");
  element.textContent = value;
  return element.innerHTML;
}

function renderMedia(post) {
  if (post.media_type === "video") {
    return `
      <video
        class="showcase-post-media"
        controls
        preload="metadata"
        src="${escapeHtml(post.media_url)}"
      ></video>
    `;
  }

  return `
    <img
      class="showcase-post-media"
      src="${escapeHtml(post.media_url)}"
      alt="Gameplay dari ${escapeHtml(post.member_name)}"
      loading="lazy"
    >
  `;
}

function renderPost(post) {
  return `
    <article class="showcase-post">
      <div class="showcase-post-media-wrap">
        ${renderMedia(post)}
      </div>

      <div class="showcase-post-content">
        <div class="showcase-post-author">
          <strong>@${escapeHtml(post.member_name)}</strong>
        </div>

        <p>${escapeHtml(post.caption)}</p>

        <div class="showcase-post-actions">
          <button
            type="button"
            class="showcase-action"
            data-showcase-like="${post.id}"
          >
            ♡
            <span>${Number(post.likes) || 0}</span>
          </button>

          <button
            type="button"
            class="showcase-action"
            data-showcase-share="${post.id}"
          >
            ↗ Share
          </button>
        </div>
      </div>
    </article>
  `;
}

async function loadShowcase() {
  const container = document.querySelector("[data-showcase-posts]");

  if (!container) {
    return;
  }

  try {
    const response = await fetch(API_URL);
    const data = await response.json();

    if (!data.success || !Array.isArray(data.posts)) {
      throw new Error("Invalid showcase response.");
    }

    if (data.posts.length === 0) {
      container.innerHTML = `
        <p class="showcase-empty">
          Belum ada gameplay dari komunitas.
        </p>
      `;

      return;
    }

    container.innerHTML = data.posts.map(renderPost).join("");
  } catch {
    container.innerHTML = `
      <p class="showcase-empty">
        Showcase belum dapat dimuat.
      </p>
    `;
  }
}

async function likePost(id, button) {
  const formData = new FormData();

  formData.append("id", id);

  button.disabled = true;

  try {
    await fetch(LIKE_URL, {
      method: "POST",
      body: formData,
    });
  } finally {
    button.disabled = false;
  }
}

async function sharePost(id) {
  const url = `${window.location.origin}${window.location.pathname}#showcase-${id}`;

  if (navigator.share) {
    await navigator.share({
      title: "KG Survival Gameplay",
      url,
    });

    return;
  }

  await navigator.clipboard.writeText(url);
}

function initShowcase() {
  const container = document.querySelector("[data-showcase-posts]");

  if (!container) {
    return;
  }

  container.addEventListener("click", async (event) => {
    const likeButton = event.target.closest(
      "[data-showcase-like]"
    );

    if (likeButton) {
      await likePost(
        likeButton.dataset.showcaseLike,
        likeButton
      );

      return;
    }

    const shareButton = event.target.closest(
      "[data-showcase-share]"
    );

    if (shareButton) {
      await sharePost(
        shareButton.dataset.showcaseShare
      );
    }
  });

  loadShowcase();
}

export { initShowcase };