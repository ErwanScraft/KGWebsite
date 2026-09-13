<?php

declare(strict_types=1);
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >

  <meta
    name="theme-color"
    content="#08080a"
  >

  <title>Showcase Moderation — KGSMP</title>

  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <link rel="stylesheet" href="../assets/css/sections.css">
</head>

<body>

  <main class="showcase-admin">

    <div class="container">

      <header class="showcase-admin-header">

        <p class="eyebrow">
          ADMIN
        </p>

        <h1>
          SHOWCASE <span>MODERATION</span>
        </h1>

      </header>

      <form
        class="showcase-admin-login"
        data-admin-login
      >
        <label>
          <span>Admin Key</span>

          <input
            type="password"
            data-admin-key
            autocomplete="off"
            required
          >
        </label>

        <button
          class="button button--primary"
          type="submit"
        >
          Load Submissions
        </button>
      </form>

      <div
        class="showcase-admin-list"
        data-admin-list
      ></div>

    </div>

  </main>

  <script>
    const loginForm = document.querySelector(
      "[data-admin-login]"
    );

    const list = document.querySelector(
      "[data-admin-list]"
    );

    let adminKey = "";

    function escapeHtml(value) {
      const element = document.createElement("div");

      element.textContent = value;

      return element.innerHTML;
    }

    function renderPost(post) {
      const media =
        post.media_type === "video"
          ? `
            <video
              controls
              preload="metadata"
              src="../storage/${escapeHtml(post.media_path)}"
            ></video>
          `
          : `
            <img
              src="../storage/${escapeHtml(post.media_path)}"
              alt=""
            >
          `;

      return `
        <article class="showcase-admin-post">

          <div class="showcase-admin-media">
            ${media}
          </div>

          <div class="showcase-admin-content">

            <strong>
              @${escapeHtml(post.member_name)}
            </strong>

            <p>
              ${escapeHtml(post.caption)}
            </p>

            <small>
              ${escapeHtml(post.created_at)}
            </small>

            <div class="showcase-admin-actions">

              <button
                class="button button--primary"
                data-action="approve"
                data-id="${post.id}"
              >
                Approve
              </button>

              <button
                class="button button--ghost"
                data-action="reject"
                data-id="${post.id}"
              >
                Reject
              </button>

            </div>

          </div>

        </article>
      `;
    }

    async function loadPosts() {
      const response = await fetch(
        "../api/showcase/admin/posts.php",
        {
          headers: {
            "X-Showcase-Admin-Key": adminKey,
          },
        }
      );

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(
          data.message || "Unauthorized."
        );
      }

      if (data.posts.length === 0) {
        list.innerHTML = `
          <p>
            Tidak ada submission yang menunggu review.
          </p>
        `;

        return;
      }

      list.innerHTML = data.posts
        .map(renderPost)
        .join("");
    }

    async function moderate(action, id) {
      const formData = new FormData();

      formData.append("id", id);

      const response = await fetch(
        `../api/showcase/admin/${action}.php`,
        {
          method: "POST",
          headers: {
            "X-Showcase-Admin-Key": adminKey,
          },
          body: formData,
        }
      );

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(
          data.message || "Action failed."
        );
      }

      await loadPosts();
    }

    loginForm.addEventListener(
      "submit",
      async (event) => {
        event.preventDefault();

        adminKey = document.querySelector(
          "[data-admin-key]"
        ).value;

        try {
          await loadPosts();
          loginForm.hidden = true;
        } catch (error) {
          alert(error.message);
          adminKey = "";
        }
      }
    );

    list.addEventListener(
      "click",
      async (event) => {
        const button = event.target.closest(
          "[data-action]"
        );

        if (!button) {
          return;
        }

        const action = button.dataset.action;
        const id = button.dataset.id;

        if (
          action === "reject" &&
          !confirm(
            "Tolak submission ini? Data dan file akan dihapus permanen."
          )
        ) {
          return;
        }

        button.disabled = true;

        try {
          await moderate(action, id);
        } catch (error) {
          alert(error.message);
          button.disabled = false;
        }
      }
    );
  </script>

</body>
</html>