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

  <title>Share Gameplay — KGSMP</title>

  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/sections.css">
</head>

<body>

  <main class="showcase-submit-page">

    <div class="container">

      <a
        class="button button--ghost"
        href="index.php"
      >
        ← Back
      </a>

      <div class="showcase-submit-header">

        <p class="eyebrow">
          COMMUNITY SHOWCASE
        </p>

        <h1>
          SHARE YOUR <span>GAMEPLAY</span>
        </h1>

        <p class="section-copy">
          Bagikan momen terbaikmu di KGSMP.
          Semua submission akan diperiksa admin sebelum
          ditampilkan di website.
        </p>

      </div>

      <form
        class="showcase-form"
        data-showcase-form
        enctype="multipart/form-data"
      >

        <label>
          <span>Minecraft Username</span>

          <input
            type="text"
            name="member_name"
            maxlength="32"
            required
            autocomplete="off"
            placeholder="ErwanScraft"
          >
        </label>

        <label>
          <span>Caption</span>

          <textarea
            name="caption"
            maxlength="500"
            rows="5"
            required
            placeholder="Ceritakan sedikit tentang gameplay ini..."
          ></textarea>
        </label>

        <label>
          <span>Photo / Video</span>

          <input
            type="file"
            name="media"
            accept="image/jpeg,image/png,image/webp,video/mp4,video/webm"
            required
          >

          <small>
            Foto maksimal 8 MB. Video maksimal 50 MB.
          </small>
        </label>

        <button
          class="button button--primary"
          type="submit"
        >
          Submit Showcase
        </button>

        <p
          class="showcase-form-message"
          data-showcase-form-message
          aria-live="polite"
        ></p>

      </form>

    </div>

  </main>

  <script type="module">
    const form = document.querySelector("[data-showcase-form]");
    const message = document.querySelector(
      "[data-showcase-form-message]"
    );

    form.addEventListener("submit", async (event) => {
      event.preventDefault();

      const button = form.querySelector("button");
      const formData = new FormData(form);

      button.disabled = true;
      message.textContent = "Mengirim submission...";

      try {
        const response = await fetch(
          "api/showcase/upload.php",
          {
            method: "POST",
            body: formData,
          }
        );

        const data = await response.json();

        if (!data.success) {
          throw new Error(
            data.message || "Upload gagal."
          );
        }

        form.reset();

        message.textContent =
          "Submission berhasil dikirim. Tunggu persetujuan admin.";
      } catch (error) {
        message.textContent =
          error.message || "Terjadi kesalahan.";
      } finally {
        button.disabled = false;
      }
    });
  </script>

</body>
</html>